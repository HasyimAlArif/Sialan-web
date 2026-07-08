<x-admin-layout>
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('pesan.index') }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Kembali">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Detail Pesan</h1>
                <p class="text-sm text-gray-500 mt-1">Membaca kritik & saran dari pengguna</p>
            </div>
        </div>
        
        <form action="{{ route('pesan.destroy', $pesan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-red-200 text-red-600 hover:bg-red-50 hover:border-red-300 rounded-lg text-sm font-medium transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Hapus Pesan
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <div class="p-6 md:p-8 border-b border-gray-100 bg-gray-50/50">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-xl shadow-sm">
                        {{ strtoupper(substr($pesan->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">{{ $pesan->nama }}</h2>
                        <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                            <a href="mailto:{{ $pesan->email }}" class="hover:text-blue-600 transition-colors flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $pesan->email }}
                            </a>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span class="flex items-center gap-1.5" title="{{ $pesan->created_at->format('d M Y, H:i:s') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $pesan->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6 md:p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">{{ $pesan->subjek }}</h3>
            <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $pesan->pesan }}</div>
        </div>
        
        <div class="p-6 bg-gray-50/50 border-t border-gray-100 flex gap-3">
            <a href="mailto:{{ $pesan->email }}?subject=RE: {{ rawurlencode($pesan->subjek) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                Balas via Email
            </a>
        </div>
    </div>
</x-admin-layout>
