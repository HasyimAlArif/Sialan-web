<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
{
    $query = Laporan::with(['petugas', 'penugasan']);
    
    if ($request->status) {
        $query->where('status', $request->status);
    }
    
    $laporans = $query->latest()->paginate(10);
    
    return view('admin.laporan.index', compact('laporans'));
}
    public function show(Laporan $laporan)
{
   $laporan->load(['admin', 'petugas', 'verifikasi.admin', 'penugasan.petugas', 'perbaikan']);
    return view('admin.laporan.show', compact('laporan'));
}

    public function verifikasi(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'catatan' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request, $laporan) {
            // Update status laporan
            $newStatus = $request->status == 'diterima' ? 'diverifikasi' : 'ditolak';
            
            $laporan->update([
                'status'   => $newStatus,
                'admin_id' => Auth::guard('admin')->id(),
            ]);

            // Simpan ke tabel verifikasis
            Verifikasi::create([
                'laporan_id' => $laporan->id,
                'admin_id' => Auth::guard('admin')->id(),
                'status' => $request->status,
                'catatan' => $request->catatan,
                'tanggal_verifikasi' => now(),
            ]);
        });

        return redirect()
            ->route('laporan.show', $laporan->id)
            ->with('success', 'Laporan berhasil diverifikasi');
    }
}