<?php

namespace App\Http\Controllers\Api\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        
        try {
            Log::info('Login attempt', ['email' => $request->email]);

            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $petugas = Petugas::where('email', $request->email)->first();
            
            if (!$petugas) {
                Log::warning('Petugas not found', ['email' => $request->email]);
                return response()->json([
                    'success' => false,
                    'message' => 'Email tidak terdaftar',
                ], 401);
            }

            if (!Hash::check($request->password, $petugas->password)) {
                Log::warning('Invalid password', ['email' => $request->email]);
                return response()->json([
                    'success' => false,
                    'message' => 'Password salah',
                ], 401);
            }

            // Hapus token lama
            $petugas->tokens()->delete();

            // Buat token baru
            $deviceName = $request->input('device_name', 'mobile-app');
            $token = $petugas->createToken($deviceName)->plainTextToken;

            Log::info('Login success', ['petugas_id' => $petugas->id]);

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'data' => [
                    'petugas' => [
                        'id' => $petugas->id,
                        'nama' => $petugas->nama,
                        'email' => $petugas->email,
                        'no_hp' => $petugas->no_hp,
                        'wilayah' => $petugas->wilayah,
                    ],
                    'token' => $token,
                ],
            ], 200);

        } catch (\Exception $e) {
            Log::error('Login error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Logout error', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        try {
            $petugas = $request->user();

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $petugas->id,
                    'nama' => $petugas->nama,
                    'email' => $petugas->email,
                    'no_hp' => $petugas->no_hp,
                    'wilayah' => $petugas->wilayah,
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Profile error', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}