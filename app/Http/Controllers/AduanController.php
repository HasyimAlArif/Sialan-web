<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class AduanController extends Controller
{
    public function create()
    {
        return view('aduan.create');
    }
public function store(Request $request)
{
    $request->validate([
        'nama_pelapor' => 'required|string|max:255',
        'no_hp' => 'required|string|max:20',
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'foto' => 'nullable|image|max:2048',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'alamat_lokasi' => 'required|string',
    ]);

    $data = $request->all();
    
    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('laporan', 'public');
    }

    Laporan::create($data);

    return redirect()->route('aduan.create')->with('success', 'Laporan berhasil dikirim!');
}
}
