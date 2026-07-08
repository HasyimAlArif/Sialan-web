<?php

namespace App\Http\Controllers\Api\Robot;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LaporanController extends Controller
{
    /**
     * POST /api/robot/laporans
     * Membuat laporan baru dari robot/IoT/sistem otomatis.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelapor'  => 'required|string|max:255',
            'no_hp'         => 'required|string|max:20',
            'judul'         => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'latitude'      => 'required|numeric|between:-90,90',
            'longitude'     => 'required|numeric|between:-180,180',
            'alamat_lokasi' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporans', 'public');
        }

        $laporan = Laporan::create([
            'nama_pelapor'  => $request->nama_pelapor,
            'no_hp'         => $request->no_hp,
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'foto'          => $fotoPath,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'alamat_lokasi' => $request->alamat_lokasi,
            'status'        => 'menunggu',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dibuat.',
            'data'    => $laporan,
        ], 201);
    }
}
