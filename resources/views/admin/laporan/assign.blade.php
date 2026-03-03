<x-admin-layout>
    <h1 class="text-xl font-bold mb-4">Tugaskan Petugas</h1>

    @if(session('error'))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {{ session('error') }}
    </div>
    @endif

    <div class="bg-white p-6 rounded shadow">
        <div class="mb-4">
            <p class="text-gray-600">Laporan:</p>
            <p class="font-bold">{{ $laporan->judul }}</p>
        </div>

        <form method="POST" action="{{ route('laporan.assign.store', $laporan->id) }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Pilih Petugas</label>
                <select name="petugas_id" class="w-full border p-2 rounded" required>
                    <option value="">-- Pilih Petugas --</option>
                    @foreach($petugas as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->nama }} - {{ $p->wilayah }}
                        </option>
                    @endforeach
                </select>
                @error('petugas_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Penugasan</label>
                <input type="date" 
                       name="tanggal_tugas" 
                       class="w-full border p-2 rounded"
                       min="{{ date('Y-m-d') }}"
                       value="{{ date('Y-m-d') }}"
                       required>
                @error('tanggal_tugas')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Tugaskan
                </button>
                <a href="{{ route('laporan.show', $laporan->id) }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>