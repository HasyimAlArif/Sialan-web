<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::latest()->get();
        return view('admin.petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:petugas',
            'no_hp' => 'required',
            'wilayah' => 'required',
            'password' => 'required|min:6'
        ]);

        Petugas::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'wilayah' => $request->wilayah,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil ditambahkan');
    }

    public function show(Petugas $petugas)
    {
        return view('admin.petugas.show', compact('petugas'));
    }

    public function edit(Petugas $petugas)
{
    return view('admin.petugas.edit', compact('petugas'));
}

    public function update(Request $request, Petugas $petugas)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:petugas,email,' . $petugas->id,
            'no_hp' => 'required',
            'wilayah' => 'required',
        ]);

        $data = $request->only('nama', 'email', 'no_hp', 'wilayah');

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $petugas->update($data);

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil diperbarui');
    }

    public function destroy(Petugas $petugas)
    {
        $petugas->delete();
        return back()->with('success', 'Petugas berhasil dihapus');
    }
}

