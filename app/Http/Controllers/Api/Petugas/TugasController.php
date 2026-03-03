<?php

namespace App\Http\Controllers\Api\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Penugasan;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    /**
     * Get list tugas
     * GET /api/petugas/tugas?status=ditugaskan
     */
    public function index(Request $request)
{
    $petugas = $request->user();
    
    $query = Penugasan::with(['laporan', 'laporan.perbaikan'])
        ->where('petugas_id', $petugas->id);

    if ($request->has('status')) {
        $query->where('status', $request->status);
    }

    $penugasans = $query->latest()->paginate(10);

    $data = $penugasans->map(function ($penugasan) {
        return [
            'id' => $penugasan->id,
            'laporan' => [
                'id' => $penugasan->laporan->id,
                'judul' => $penugasan->laporan->judul,
                'deskripsi' => $penugasan->laporan->deskripsi,
                'nama_pelapor' => $penugasan->laporan->nama_pelapor,
                'no_hp' => $penugasan->laporan->no_hp,
                'alamat' => $penugasan->laporan->alamat_lokasi, // Kirim alamat_lokasi
                'foto' => $penugasan->laporan->foto 
                    ? asset('storage/' . $penugasan->laporan->foto) 
                    : null,
                'status' => $penugasan->laporan->status,
                'latitude' => $penugasan->laporan->latitude,
                'longitude' => $penugasan->laporan->longitude,
            ],
            'tanggal_tugas' => $penugasan->tanggal_tugas->format('Y-m-d'),
            'status' => $penugasan->status,
            'has_perbaikan' => $penugasan->laporan->perbaikan ? true : false,
            'created_at' => $penugasan->created_at->format('Y-m-d H:i:s'),
        ];
    });

    return response()->json([
        'success' => true,
        'data' => $data,
        'pagination' => [
            'current_page' => $penugasans->currentPage(),
            'last_page' => $penugasans->lastPage(),
            'per_page' => $penugasans->perPage(),
            'total' => $penugasans->total(),
        ],
    ], 200);
}

    /**
     * Get detail tugas
     * GET /api/petugas/tugas/{id}
     */
    public function show(Request $request, $id)
{
    $petugas = $request->user();
    
    $penugasan = Penugasan::with(['laporan', 'laporan.perbaikan'])
        ->where('id', $id)
        ->where('petugas_id', $petugas->id)
        ->first();

    if (!$penugasan) {
        return response()->json([
            'success' => false,
            'message' => 'Tugas tidak ditemukan',
        ], 404);
    }

    $data = [
        'id' => $penugasan->id,
        'laporan' => [
            'id' => $penugasan->laporan->id,
            'judul' => $penugasan->laporan->judul,
            'deskripsi' => $penugasan->laporan->deskripsi,
            'nama_pelapor' => $penugasan->laporan->nama_pelapor,
            'no_hp' => $penugasan->laporan->no_hp,
            'alamat' => $penugasan->laporan->alamat_lokasi, // Ubah ke 'alamat' untuk konsistensi
            'latitude' => $penugasan->laporan->latitude,
            'longitude' => $penugasan->laporan->longitude,
            'foto' => $penugasan->laporan->foto 
                ? asset('storage/' . $penugasan->laporan->foto) 
                : null,
            'status' => $penugasan->laporan->status,
            'created_at' => $penugasan->laporan->created_at->format('Y-m-d H:i:s'),
        ],
        'tanggal_tugas' => $penugasan->tanggal_tugas->format('Y-m-d'),
        'status' => $penugasan->status,
        'has_perbaikan' => $penugasan->laporan->perbaikan ? true : false, // Tambahkan ini
        'perbaikan' => $penugasan->laporan->perbaikan ? [
            'id' => $penugasan->laporan->perbaikan->id,
            'tindakan' => $penugasan->laporan->perbaikan->tindakan,
            'tanggal_perbaikan' => $penugasan->laporan->perbaikan->tanggal_perbaikan->format('Y-m-d'),
            'foto_sebelum' => $penugasan->laporan->perbaikan->foto_sebelum 
                ? asset('storage/' . $penugasan->laporan->perbaikan->foto_sebelum) 
                : null,
            'foto_sesudah' => $penugasan->laporan->perbaikan->foto_sesudah 
                ? asset('storage/' . $penugasan->laporan->perbaikan->foto_sesudah) 
                : null,
            'status' => $penugasan->laporan->perbaikan->status,
        ] : null,
        'created_at' => $penugasan->created_at->format('Y-m-d H:i:s'), // Tambahkan ini
    ];

    return response()->json([
        'success' => true,
        'data' => $data,
    ], 200);
}

    /**
     * Update status to 'proses'
     * POST /api/petugas/tugas/{id}/proses
     */
    public function updateStatus(Request $request, $id)
    {
        $petugas = $request->user();
        
        $penugasan = Penugasan::where('id', $id)
            ->where('petugas_id', $petugas->id)
            ->first();

        if (!$penugasan) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ditemukan',
            ], 404);
        }

        if ($penugasan->status !== 'ditugaskan') {
            return response()->json([
                'success' => false,
                'message' => 'Status tugas tidak dapat diubah',
            ], 400);
        }

        // Update status
        $penugasan->update(['status' => 'proses']);
        $penugasan->laporan->update(['status' => 'proses']);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah menjadi "Proses"',
            'data' => [
                'id' => $penugasan->id,
                'status' => $penugasan->status,
            ],
        ], 200);
    }
}