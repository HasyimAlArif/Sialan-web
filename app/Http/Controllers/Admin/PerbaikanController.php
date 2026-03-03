<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perbaikan;
use Illuminate\Http\Request;

class PerbaikanController extends Controller
{
    public function index()
    {
        $perbaikans = Perbaikan::with(['laporan', 'petugas'])
            ->latest()
            ->paginate(10);

        return view('admin.perbaikan.index', compact('perbaikans'));
    }

    public function show(Perbaikan $perbaikan)
    {
        $perbaikan->load(['laporan', 'petugas']);
        return view('admin.perbaikan.show', compact('perbaikan'));
    }

    public function acc(Perbaikan $perbaikan)
    {
        // Hanya perbaikan dengan status 'selesai' yang bisa di-ACC
        if ($perbaikan->status === 'acc') {
            return redirect()
                ->back()
                ->with('error', 'Perbaikan sudah di-ACC sebelumnya');
        }

        if ($perbaikan->status !== 'selesai') {
            return redirect()
                ->back()
                ->with('error', 'Perbaikan belum selesai, tidak bisa di-ACC');
        }

        $perbaikan->update(['status' => 'acc']);

        return redirect()
            ->route('perbaikan.show', $perbaikan->id)
            ->with('success', 'Perbaikan berhasil di-ACC');
    }
}