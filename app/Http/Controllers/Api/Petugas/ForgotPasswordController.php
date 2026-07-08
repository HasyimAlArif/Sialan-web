<?php

namespace App\Http\Controllers\Api\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Mail\ResetPasswordOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Mengirimkan OTP 6-digit ke email petugas.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $petugas = Petugas::where('email', $request->email)->first();

        if (!$petugas) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak terdaftar.'
            ], 404);
        }

        // Generate 6-digit OTP
        $otp = sprintf("%06d", mt_rand(1, 999999));

        // Simpan ke tabel password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $otp,
                'created_at' => Carbon::now()
            ]
        );

        // Kirim email
        try {
            Mail::to($request->email)->send(new ResetPasswordOtpMail($otp, $petugas->nama));
            Log::info('OTP Sent to: ' . $request->email);
            
            return response()->json([
                'success' => true,
                'message' => 'Kode OTP telah dikirim ke email Anda.'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email OTP.'
            ], 500);
        }
    }

    /**
     * Memverifikasi kode OTP yang diinput.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6'
        ]);

        $resetData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$resetData) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP tidak valid atau salah.'
            ], 400);
        }

        // Cek apakah OTP sudah kadaluarsa (lebih dari 15 menit)
        $createdAt = Carbon::parse($resetData->created_at);
        if (Carbon::now()->diffInMinutes($createdAt) > 15) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP sudah kadaluarsa.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP valid.'
        ]);
    }

    /**
     * Mereset password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|min:8|confirmed'
        ]);

        // Verifikasi ulang OTP untuk keamanan sebelum reset
        $resetData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$resetData) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP tidak valid atau salah.'
            ], 400);
        }

        $createdAt = Carbon::parse($resetData->created_at);
        if (Carbon::now()->diffInMinutes($createdAt) > 15) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP sudah kadaluarsa.'
            ], 400);
        }

        $petugas = Petugas::where('email', $request->email)->first();
        if (!$petugas) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan.'
            ], 404);
        }

        // Update password
        $petugas->password = Hash::make($request->password);
        $petugas->save();

        // Hapus token yang sudah terpakai
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah. Silakan login dengan password baru.'
        ]);
    }
}
