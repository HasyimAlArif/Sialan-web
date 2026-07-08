<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index()
    {
        $pesans = \App\Models\Pesan::latest()->paginate(10);
        return view('admin.pesan.index', compact('pesans'));
    }

    public function show(\App\Models\Pesan $pesan)
    {
        if (!$pesan->is_read) {
            $pesan->update(['is_read' => true]);
        }
        return view('admin.pesan.show', compact('pesan'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        \App\Models\Pesan::create($validated);

        return redirect()->back()->with('success_pesan', 'Pesan berhasil dikirim! Terima kasih atas masukan Anda.');
    }

    public function destroy(\App\Models\Pesan $pesan)
    {
        $pesan->delete();
        return redirect()->route('pesan.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
