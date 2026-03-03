<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Petugas;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalLaporan'     => Laporan::count(),
            'laporanSelesai'   => Laporan::where('status', 'selesai')->count(),
            'totalPetugas'     => Petugas::count(),
        ]);
    }
}