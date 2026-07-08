<x-admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Kritik & Saran</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola pesan dan masukan dari pengguna</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                        <th class="px-6 py-4 font-medium">Pengirim</th>
                        <th class="px-6 py-4 font-medium">Subjek</th>
                        <th class="px-6 py-4 font-medium">Tanggal</th>
                        <th class="px-6 py-4 font-medium text-center">Status</th>
                        <th class="px-6 py-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pesans as $pesan)
                    <tr class="hover:bg-gray-50/50 transition-colors {{ !$pesan->is_read ? 'bg-blue-50/30' : '' }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($pesan->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 {{ !$pesan->is_read ? 'font-bold' : '' }}">{{ $pesan->nama }}</p>
                                    <p class="text-xs text-gray-500">{{ $pesan->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-800 {{ !$pesan->is_read ? 'font-bold' : '' }}">{{ $pesan->subjek }}</p>
                            <p class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($pesan->pesan, 50) }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $pesan->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($pesan->is_read)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Dibaca
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Baru
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('pesan.show', $pesan->id) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Baca Pesan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <form action="{{ route('pesan.destroy', $pesan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pesan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Pesan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <p>Belum ada pesan yang masuk.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pesans->hasPages())
        <div class="p-4 border-t border-gray-100 bg-gray-50/50">
            {{ $pesans->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>
