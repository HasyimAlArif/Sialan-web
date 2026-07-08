<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-600 mt-1">Ringkasan data dan statistik sistem</p>
    </div>

    {{-- ============ STAT CARDS ============ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <!-- Total Laporan Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform transition hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Laporan</p>
                    <h2 class="text-4xl font-bold">{{ $totalLaporan }}</h2>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Laporan Selesai Card -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform transition hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-1">Laporan Selesai</p>
                    <h2 class="text-4xl font-bold">{{ $laporanSelesai }}</h2>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Petugas Card -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform transition hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Total Petugas</p>
                    <h2 class="text-4xl font-bold">{{ $totalPetugas }}</h2>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ CHARTS SECTION ============ --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- Chart 1: Donut - Sebaran Jenis Kerusakan --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-800">Sebaran Jenis Kerusakan</h3>
                <p class="text-xs text-gray-500 mt-0.5">Distribusi berdasarkan jenis kerusakan jalan</p>
            </div>
            @if(count($jenisLabels) > 0)
                <div class="flex-1 flex items-center justify-center" style="min-height: 260px;">
                    <canvas id="donutChart"></canvas>
                </div>
            @else
                <div class="flex-1 flex flex-col items-center justify-center text-gray-400 py-8">
                    <svg class="w-14 h-14 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    <p class="text-sm">Belum ada data laporan</p>
                </div>
            @endif
        </div>

        {{-- Chart 2: Bar - Laporan per Bulan --}}
        <div class="lg:col-span-3 bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-800">Tren Laporan 6 Bulan Terakhir</h3>
                <p class="text-xs text-gray-500 mt-0.5">Jumlah laporan masuk per bulan</p>
            </div>
            <div class="flex-1" style="min-height: 260px; position: relative;">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ============ CHART.JS CDN ============ --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // ─── Color palette (matching damage type colors used in maps) ────
        var damageColors = [
            '#8B4513', // Retak Kulit Buaya - Brown
            '#DC143C', // Lubang - Crimson
            '#FF8C00', // Retak Tepi - Orange
            '#696969', // Tambalan - Gray
            '#DAA520', // Pelepasan Butir - Goldenrod
            '#3B82F6', // default Blue
        ];

        // ─── Donut Chart: Sebaran Jenis Kerusakan ────────────────────────
        @if(count($jenisLabels) > 0)
        var ctxDonut = document.getElementById('donutChart').getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: @json($jenisLabels),
                datasets: [{
                    data: @json($jenisCounts),
                    backgroundColor: damageColors.slice(0, {{ count($jenisLabels) }}),
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 10,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            boxHeight: 12,
                            borderRadius: 6,
                            useBorderRadius: true,
                            padding: 14,
                            font: { size: 11.5 },
                            color: '#4B5563',
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                var total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                var pct   = ((ctx.raw / total) * 100).toFixed(1);
                                return '  ' + ctx.label.split(' (')[0] + ': ' + ctx.raw + ' (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });
        @endif

        // ─── Line Chart: Laporan per Bulan (Smooth Area) ─────────────────
        var ctxBar = document.getElementById('barChart').getContext('2d');

        // Gradient fill di bawah garis
        var gradient = ctxBar.createLinearGradient(0, 0, 0, 280);
        gradient.addColorStop(0,   'rgba(99,102,241,0.25)');
        gradient.addColorStop(0.6, 'rgba(99,102,241,0.06)');
        gradient.addColorStop(1,   'rgba(99,102,241,0.00)');

        new Chart(ctxBar, {
            type: 'line',
            data: {
                labels: @json($monthLabels),
                datasets: [
                    {
                        label: 'Jumlah Laporan',
                        data: @json($monthCounts),
                        borderColor: '#6366F1',
                        backgroundColor: gradient,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#6366F1',
                        pointBorderWidth: 2.5,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointHoverBackgroundColor: '#6366F1',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 2,
                        tension: 0.45,
                        fill: true,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: '#9CA3AF',
                            font: { size: 11 },
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)',
                            drawBorder: false,
                        },
                        border: { dash: [4, 4], display: false },
                    },
                    x: {
                        ticks: { color: '#9CA3AF', font: { size: 11 } },
                        grid: { display: false },
                        border: { display: false },
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(17,24,39,0.9)',
                        titleColor: '#F9FAFB',
                        bodyColor: '#D1D5DB',
                        padding: 12,
                        borderRadius: 8,
                        callbacks: {
                            label: function(ctx) {
                                return '  ' + ctx.raw + ' laporan';
                            }
                        }
                    }
                }
            }
        });
    });
    </script>
</x-admin-layout>