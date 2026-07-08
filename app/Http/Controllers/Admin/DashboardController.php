<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Petugas;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Existing Stats ---
        $totalLaporan   = Laporan::count();
        $laporanSelesai = Laporan::where('status', 'selesai')->count();
        $totalPetugas   = Petugas::count();

        // --- Chart 1: Kerusakan per Jenis (Donut Chart) ---
        $kerusakanPerJenis = Laporan::select('judul', DB::raw('count(*) as total'))
            ->groupBy('judul')
            ->orderByDesc('total')
            ->get();

        $jenisLabels  = $kerusakanPerJenis->pluck('judul')->map(fn($j) => $j ?: 'Lainnya')->values()->toArray();
        $jenisCounts  = $kerusakanPerJenis->pluck('total')->values()->toArray();

        // --- Chart 2: Laporan per Bulan (Bar/Line Chart) - 6 bulan terakhir ---
        $months = collect();
        $monthLabels  = [];
        $monthCounts  = [];

        for ($i = 5; $i >= 0; $i--) {
            $date  = Carbon::now()->subMonths($i);
            $count = Laporan::whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)
                            ->count();
            $monthLabels[] = $date->translatedFormat('M Y');
            $monthCounts[] = $count;
        }

        return view('admin.dashboard', compact(
            'totalLaporan', 'laporanSelesai', 'totalPetugas',
            'jenisLabels', 'jenisCounts',
            'monthLabels', 'monthCounts'
        ));
    }
}