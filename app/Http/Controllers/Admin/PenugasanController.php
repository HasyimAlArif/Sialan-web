<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Petugas;
use App\Models\Penugasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanAssignController extends Controller
{
    public function create(Laporan $laporan)
    {
        $petugas = Petugas::all();
        return view('admin.laporan.assign', compact('laporan', 'petugas'));
    }

    public function store(Request $request, Laporan $laporan)
    {
        $request->validate([
            'petugas_id' => 'required|exists:petugas,id',
            'tanggal_tugas' => 'required|date|after_or_equal:today',
        ]);

        DB::transaction(function () use ($request, $laporan) {
            // Update status laporan dan petugas_id
            $laporan->update([
                'petugas_id' => $request->petugas_id,
                'status'     => 'ditugaskan',
            ]);

            // Simpan ke tabel penugasans
            Penugasan::create([
                'laporan_id' => $laporan->id,
                'petugas_id' => $request->petugas_id,
                'tanggal_tugas' => $request->tanggal_tugas,
                'status' => 'ditugaskan',
            ]);
        });

        return redirect()
            ->route('laporan.show', $laporan->id)
            ->with('success', 'Petugas berhasil ditugaskan');
    }
}