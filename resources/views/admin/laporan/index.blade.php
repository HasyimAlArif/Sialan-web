<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Data Laporan Kerusakan</h1>
        <p class="text-gray-600 mt-1">Kelola dan pantau semua laporan kerusakan</p>
    </div>

    {{-- Filter Status --}}
    <div class="mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm font-medium text-gray-700 mb-3">Filter Status:</p>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('laporan.index') }}" 
                   class="px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200
                   {{ !request('status') 
                      ? 'bg-blue-600 text-white shadow-md' 
                      : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        Semua
                    </span>
                </a>
                <a href="{{ route('laporan.index', ['status' => 'menunggu']) }}" 
                   class="px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200
                   {{ request('status') == 'menunggu' 
                      ? 'bg-gray-600 text-white shadow-md' 
                      : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Menunggu
                    </span>
                </a>
                <a href="{{ route('laporan.index', ['status' => 'diverifikasi']) }}" 
                   class="px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200
                   {{ request('status') == 'diverifikasi' 
                      ? 'bg-blue-600 text-white shadow-md' 
                      : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Diverifikasi
                    </span>
                </a>
                <a href="{{ route('laporan.index', ['status' => 'ditugaskan']) }}" 
                   class="px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200
                   {{ request('status') == 'ditugaskan' 
                      ? 'bg-yellow-600 text-white shadow-md' 
                      : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Ditugaskan
                    </span>
                </a>
                <a href="{{ route('laporan.index', ['status' => 'selesai']) }}" 
                   class="px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200
                   {{ request('status') == 'selesai' 
                      ? 'bg-green-600 text-white shadow-md' 
                      : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Selesai
                    </span>
                </a>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Pelapor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Judul</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Petugas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Tanggal Tugas</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($laporans as $l)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($l->nama_pelapor, 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $l->nama_pelapor }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900 font-medium">{{ $l->judul }}</p>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            {{ $l->status == 'menunggu' ? 'bg-gray-100 text-gray-800' :
                               ($l->status == 'diverifikasi' ? 'bg-blue-100 text-blue-800' :
                               ($l->status == 'ditolak' ? 'bg-red-100 text-red-800' :
                               ($l->status == 'ditugaskan' ? 'bg-yellow-100 text-yellow-800' :
                               ($l->status == 'proses' ? 'bg-purple-100 text-purple-800' :
                               'bg-green-100 text-green-800')))) }}">
                                <span class="w-2 h-2 rounded-full mr-2
                                {{ $l->status == 'menunggu' ? 'bg-gray-500' :
                                   ($l->status == 'diverifikasi' ? 'bg-blue-500' :
                                   ($l->status == 'ditolak' ? 'bg-red-500' :
                                   ($l->status == 'ditugaskan' ? 'bg-yellow-500' :
                                   ($l->status == 'proses' ? 'bg-purple-500' :
                                   'bg-green-500')))) }}"></span>
                                {{ ucfirst($l->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            @if($l->petugas)
                                <div class="flex items-center">
                                    <div class="h-8 w-8 flex-shrink-0 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                        {{ strtoupper(substr($l->petugas->nama, 0, 1)) }}
                                    </div>
                                    <span class="ml-2 text-sm text-gray-900">{{ $l->petugas->nama }}</span>
                                </div>
                            @else
                                <span class="text-sm text-gray-400 italic">Belum ditugaskan</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if($l->penugasan)
                                <div class="flex items-center text-sm text-gray-900">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $l->penugasan->tanggal_tugas->format('d/m/Y') }}
                                </div>
                            @else
                                <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('laporan.show', $l->id) }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-500 font-medium">Tidak ada data laporan</p>
                                <p class="text-gray-400 text-sm mt-1">Belum ada laporan yang tersedia saat ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $laporans->links() }}
    </div>
</x-admin-layout>