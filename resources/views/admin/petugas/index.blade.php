<x-admin-layout>
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Petugas</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola akun petugas lapangan dan wilayah kerjanya.</p>
        </div>
        
        <a href="{{ route('petugas.create') }}"
           class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Petugas
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 rounded-r shadow-sm">
        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="text-green-800 font-medium text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Petugas</th>
                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontak</th>
                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Wilayah Tugas</th>
                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($petugas as $p)
                    <tr class="hover:bg-blue-50/50 transition duration-150 group">
                        
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold shadow-sm">
                                    {{ substr($p->nama, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $p->nama }}</div>
                                    <div class="text-xs text-gray-400">ID: #{{ $p->id }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="p-4">
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-700 flex items-center gap-2">
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    {{ $p->email }}
                                </span>
                                <span class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    {{ $p->no_hp }}
                                </span>
                            </div>
                        </td>

                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $p->wilayah }}
                            </span>
                        </td>

                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('petugas.edit', $p->id) }}" 
                                   class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition tooltip" 
                                   title="Edit Petugas">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('petugas.destroy', $p->id) }}" method="POST" class="inline-block">
                                    @csrf 
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin menghapus data petugas {{ $p->nama }}?')" 
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                            title="Hapus Petugas">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <p>Belum ada data petugas.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>