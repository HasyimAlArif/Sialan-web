<?php

namespace App\Http\Controllers\Api\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Penugasan;
use App\Models\Perbaikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PerbaikanController extends Controller
{
    /**
     * Submit perbaikan
     * POST /api/petugas/perbaikan
     * 
     * Body (multipart/form-data):
     * - penugasan_id (required)
     * - tindakan (required)
     * - tanggal_perbaikan (required, format: Y-m-d)
     * - foto_sebelum (optional, image)
     * - foto_sesudah (optional, image)
     */
    public function store(Request $request)
    {
        $petugas = $request->user();

        $validator = Validator::make($request->all(), [
            'penugasan_id' => 'required|exists:penugasans,id',
            'tindakan' => 'required|string',
            'tanggal_perbaikan' => 'required|date',
            'foto_sebelum' => 'nullable|image|max:5120', // max 5MB
            'foto_sesudah' => 'nullable|image|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Cek apakah penugasan milik petugas ini
        $penugasan = Penugasan::where('id', $request->penugasan_id)
            ->where('petugas_id', $petugas->id)
            ->first();

        if (!$penugasan) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ditemukan',
            ], 404);
        }

        // Cek apakah sudah ada perbaikan
        if ($penugasan->laporan->perbaikan) {
            return response()->json([
                'success' => false,
                'message' => 'Perbaikan sudah pernah disubmit',
            ], 400);
        }

        try {
            DB::beginTransaction();

            $data = [
                'laporan_id' => $penugasan->laporan_id,
                'petugas_id' => $petugas->id,
                'tindakan' => $request->tindakan,
                'tanggal_perbaikan' => $request->tanggal_perbaikan,
                'status' => 'selesai',
            ];

            // Upload foto sebelum
            if ($request->hasFile('foto_sebelum')) {
                $fotoSebelum = $request->file('foto_sebelum');
                $namaSebelum = 'sebelum_' . time() . '_' . $fotoSebelum->getClientOriginalName();
                $data['foto_sebelum'] = $fotoSebelum->storeAs('perbaikan', $namaSebelum, 'public');
            }

            // Upload foto sesudah
            if ($request->hasFile('foto_sesudah')) {
                $fotoSesudah = $request->file('foto_sesudah');
                $namaSesudah = 'sesudah_' . time() . '_' . $fotoSesudah->getClientOriginalName();
                $data['foto_sesudah'] = $fotoSesudah->storeAs('perbaikan', $namaSesudah, 'public');
            }

            // Simpan perbaikan
            $perbaikan = Perbaikan::create($data);

            // Update status penugasan
            $penugasan->update(['status' => 'selesai']);

            // Update status laporan
            $penugasan->laporan->update(['status' => 'selesai']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Laporan perbaikan berhasil disimpan. Menunggu ACC dari admin.',
                'data' => [
                    'id' => $perbaikan->id,
                    'tindakan' => $perbaikan->tindakan,
                    'tanggal_perbaikan' => $perbaikan->tanggal_perbaikan->format('Y-m-d'),
                    'foto_sebelum' => $perbaikan->foto_sebelum 
                        ? asset('storage/' . $perbaikan->foto_sebelum) 
                        : null,
                    'foto_sesudah' => $perbaikan->foto_sesudah 
                        ? asset('storage/' . $perbaikan->foto_sesudah) 
                        : null,
                    'status' => $perbaikan->status,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan perbaikan: ' . $e->getMessage(),
            ], 500);
        }
    }
}