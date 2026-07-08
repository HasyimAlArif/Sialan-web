<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function create()
    {
        return view('admin.laporan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'no_hp'        => 'nullable|string|max:20',
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'alamat_lokasi'=> 'nullable|string|max:500',
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
            'status'       => 'required|in:menunggu,diverifikasi,ditolak,ditugaskan,proses,selesai',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->storeOnCloudinary('sialan/laporans')->getSecurePath();
        }

        Laporan::create($validated);

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function show(Laporan $laporan)
    {
        $laporan->load(['admin', 'petugas', 'verifikasi.admin', 'penugasan.petugas', 'perbaikan']);
        return view('admin.laporan.show', compact('laporan'));
    }

    public function edit(Laporan $laporan)
    {
        return view('admin.laporan.edit', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'no_hp'        => 'nullable|string|max:20',
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'alamat_lokasi'=> 'nullable|string|max:500',
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
            'status'       => 'required|in:menunggu,diverifikasi,ditolak,ditugaskan,proses,selesai',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama di Cloudinary tidak dilakukan otomatis di sini
            $validated['foto'] = $request->file('foto')->storeOnCloudinary('sialan/laporans')->getSecurePath();
        }

        $laporan->update($validated);

        return redirect()->route('laporan.show', $laporan->id)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan)
    {
        // Hapus foto jika ada (Catatan: Hapus manual di Cloudinary dashboard)

        $laporan->delete();

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:laporans,id',
        ]);

        $laporans = Laporan::whereIn('id', $request->ids)->get();

        foreach ($laporans as $laporan) {
            // (Catatan: Hapus manual di Cloudinary dashboard)
            $laporan->delete();
        }

        return redirect()->route('laporan.index')
            ->with('success', count($request->ids) . ' laporan berhasil dihapus.');
    }

    public function verifikasi(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'catatan' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request, $laporan) {
            $newStatus = $request->status == 'diterima' ? 'diverifikasi' : 'ditolak';

            $laporan->update([
                'status'   => $newStatus,
                'admin_id' => Auth::guard('admin')->id(),
            ]);

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

    public function toggleGaleri(Laporan $laporan)
    {
        // Hanya laporan dengan foto yang bisa di-post ke galeri
        if (!$laporan->foto) {
            return back()->with('error', 'Laporan ini tidak memiliki foto, tidak dapat diposting ke galeri.');
        }

        $laporan->update([
            'tampil_galeri' => !$laporan->tampil_galeri,
        ]);

        $pesan = $laporan->tampil_galeri
            ? 'Laporan berhasil diposting ke Galeri Pemantauan.'
            : 'Laporan berhasil dihapus dari Galeri Pemantauan.';

        return back()->with('success', $pesan);
    }
}