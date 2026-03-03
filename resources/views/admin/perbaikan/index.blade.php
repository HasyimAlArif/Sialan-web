<x-admin-layout>
    <h1 class="text-xl font-bold mb-4">Data Perbaikan</h1>

    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
    @endif

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Laporan</th>
                <th class="p-2 border">Petugas</th>
                <th class="p-2 border">Tindakan</th>
                <th class="p-2 border">Tanggal</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perbaikans as $p)
            <tr class="border-t">
                <td class="p-2 border">{{ $p->laporan->judul }}</td>
                <td class="p-2 border">{{ $p->petugas->nama }}</td>
                <td class="p-2 border">{{ Str::limit($p->tindakan, 50) }}</td>
                <td class="p-2 border">{{ $p->tanggal_perbaikan->format('d/m/Y') }}</td>
                <td class="p-2 border">
                    <span class="px-2 py-1 rounded text-white text-xs
                    {{ $p->status == 'selesai' ? 'bg-yellow-500' : 'bg-green-600' }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </td>
                <td class="p-2 border">
                    <a href="{{ route('perbaikan.show', $p->id) }}" 
                       class="text-blue-600 hover:underline">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-4 text-center text-gray-500">
                    Belum ada data perbaikan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $perbaikans->links() }}
    </div>
</x-admin-layout>