<?php

namespace App\Http\Controllers\Api\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Penugasan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     * GET /api/petugas/dashboard
     */
    public function index(Request $request)
    {
        $petugas = $request->user();

        $stats = [
            'total_tugas' => Penugasan::where('petugas_id', $petugas->id)->count(),
            'tugas_ditugaskan' => Penugasan::where('petugas_id', $petugas->id)
                ->where('status', 'ditugaskan')->count(),
            'tugas_proses' => Penugasan::where('petugas_id', $petugas->id)
                ->where('status', 'proses')->count(),
            'tugas_selesai' => Penugasan::where('petugas_id', $petugas->id)
                ->where('status', 'selesai')->count(),
        ];

        // Tugas terbaru (5 terakhir)
        $tugas_terbaru = Penugasan::with(['laporan'])
            ->where('petugas_id', $petugas->id)
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($penugasan) {
                return [
                    'id' => $penugasan->id,
                    'laporan_id' => $penugasan->laporan_id,
                    'judul' => $penugasan->laporan->judul,
                    'lokasi' => $penugasan->laporan->alamat_lokasi, // Sertakan alamat_lokasi
                    'status' => $penugasan->status,
                    'tanggal_tugas' => $penugasan->tanggal_tugas->format('Y-m-d'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'statistik' => $stats,
                'tugas_terbaru' => $tugas_terbaru,
            ],
        ], 200);
    }
}