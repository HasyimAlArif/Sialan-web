<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Petugas;
use App\Models\Penugasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LaporanAssignController extends Controller
{
    public function create(Laporan $laporan)
    {
        $petugas = Petugas::all();
        return view('admin.laporan.assign', compact('laporan', 'petugas'));
    }

    public function store(Request $request, Laporan $laporan)
    {
        // Debug: Lihat data yang masuk
        Log::info('Request Data:', $request->all());
        
        $request->validate([
            'petugas_id' => 'required|exists:petugas,id',
            'tanggal_tugas' => 'required|date|after_or_equal:today',
        ]);

        try {
            DB::transaction(function () use ($request, $laporan) {
                // Update status laporan dan petugas_id
                $laporan->update([
                    'petugas_id' => $request->petugas_id,
                    'status'     => 'ditugaskan',
                ]);

                Log::info('Laporan Updated:', $laporan->toArray());

                // Simpan ke tabel penugasans
                $penugasan = Penugasan::create([
                    'laporan_id' => $laporan->id,
                    'petugas_id' => $request->petugas_id,
                    'tanggal_tugas' => $request->tanggal_tugas,
                    'status' => 'ditugaskan',
                ]);

                Log::info('Penugasan Created:', $penugasan->toArray());
            });

            return redirect()
                ->route('laporan.show', $laporan->id)
                ->with('success', 'Petugas berhasil ditugaskan');
                
        } catch (\Exception $e) {
            Log::error('Error assigning petugas: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Gagal menugaskan petugas: ' . $e->getMessage());
        }
    }
}