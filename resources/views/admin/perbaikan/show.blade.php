<x-admin-layout>
    <div class="mb-4">
        <a href="{{ route('perbaikan.index') }}" class="text-blue-600 hover:underline">
            ← Kembali ke Daftar Perbaikan
        </a>
    </div>

    <h1 class="text-xl font-bold mb-4">Detail Perbaikan</h1>

    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {{ session('error') }}
    </div>
    @endif

    <div class="bg-white p-6 rounded shadow">
        <!-- Info Laporan -->
        <div class="mb-6 p-4 bg-gray-50 rounded">
            <h3 class="font-bold mb-2">Informasi Laporan</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-600">Judul</p>
                    <p class="font-bold">{{ $perbaikan->laporan->judul }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Pelapor</p>
                    <p class="font-bold">{{ $perbaikan->laporan->nama_pelapor }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-gray-600">Deskripsi</p>
                    <p>{{ $perbaikan->laporan->deskripsi }}</p>
                </div>
                @if($perbaikan->laporan->foto)
                <div class="col-span-2">
                    <p class="text-gray-600 mb-2">Foto Laporan</p>
                    <img src="{{ $perbaikan->laporan->foto }}" 
                         alt="Foto Laporan" 
                         class="max-w-md rounded shadow">
                </div>
                @endif
            </div>
        </div>

        <!-- Info Perbaikan -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-gray-600 text-sm">Petugas</p>
                <p class="font-bold">{{ $perbaikan->petugas->nama }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Tanggal Perbaikan</p>
                <p class="font-bold">{{ $perbaikan->tanggal_perbaikan->format('d/m/Y') }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-600 text-sm">Tindakan yang Dilakukan</p>
                <p>{{ $perbaikan->tindakan }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Status</p>
                <span class="px-3 py-1 rounded text-white text-sm
                {{ $perbaikan->status == 'selesai' ? 'bg-yellow-500' : 'bg-green-600' }}">
                    {{ $perbaikan->status == 'selesai' ? 'Menunggu ACC' : 'Sudah di-ACC' }}
                </span>
            </div>
        </div>

        <!-- Foto Perbaikan -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            @if($perbaikan->foto_sebelum)
            <div>
                <p class="text-gray-600 text-sm mb-2">Foto Sebelum Perbaikan</p>
                <img src="{{ $perbaikan->foto_sebelum }}" 
                     alt="Foto Sebelum" 
                     class="w-full rounded shadow">
            </div>
            @endif

            @if($perbaikan->foto_sesudah)
            <div>
                <p class="text-gray-600 text-sm mb-2">Foto Sesudah Perbaikan</p>
                <img src="{{ $perbaikan->foto_sesudah }}" 
                     alt="Foto Sesudah" 
                     class="w-full rounded shadow">
            </div>
            @endif
        </div>

        <!-- Tombol ACC -->
        @if($perbaikan->status == 'selesai')
        <form method="POST" action="{{ route('perbaikan.acc', $perbaikan->id) }}" class="mt-6">
            @csrf
            <button class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 font-bold">
                ✓ ACC Perbaikan
            </button>
        </form>
        @else
        <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded">
            <p class="text-green-700">✓ Perbaikan sudah di-ACC</p>
        </div>
        @endif
    </div>
</x-admin-layout>