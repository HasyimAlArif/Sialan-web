<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;

class LaporanPetugasController extends Controller
{
    /**
     * LIST LAPORAN MILIK PETUGAS
     */
    public function index()
    {
        $petugasId = Auth::guard('petugas')->id();

        $laporans = Laporan::where('petugas_id', $petugasId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $laporans
        ]);
    }

    /**
     * DETAIL LAPORAN
     */
    public function show($id)
    {
        $petugasId = Auth::guard('petugas')->id();

        $laporan = Laporan::where('id', $id)
            ->where('petugas_id', $petugasId)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $laporan
        ]);
    }

    /**
     * UPDATE STATUS LAPORAN (selesai)
     */
    public function updateStatus($id)
    {
        $petugasId = Auth::guard('petugas')->id();

        $laporan = Laporan::where('id', $id)
            ->where('petugas_id', $petugasId)
            ->firstOrFail();

        $laporan->update([
            'status' => 'selesai'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan diselesaikan'
        ]);
    }
}
