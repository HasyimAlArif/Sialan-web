<x-admin-layout>
    <div class="mb-4">
        <a href="{{ route('laporan.index') }}" class="text-blue-600 hover:underline">
            ← Kembali ke Daftar Laporan
        </a>
    </div>

    <h1 class="text-xl font-bold mb-4">Detail Laporan</h1>

    <div class="bg-white p-6 rounded shadow">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Nama Pelapor</p>
                <p class="font-bold">{{ $laporan->nama_pelapor }}</p>
            </div>

            <div>
                <p class="text-gray-600 text-sm">No HP</p>
                <p class="font-bold">{{ $laporan->no_hp }}</p>
            </div>

            <div>
                <p class="text-gray-600 text-sm">Email</p>
                <p class="font-bold">{{ $laporan->email ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-600 text-sm">Alamat</p>
                <p class="font-bold">{{ $laporan->alamat_lokasi ?? '-' }}</p>
            </div>

            <div class="col-span-2">
                <p class="text-gray-600 text-sm">Judul Laporan</p>
                <p class="font-bold text-lg">{{ $laporan->judul }}</p>
            </div>

            <div class="col-span-2">
                <p class="text-gray-600 text-sm">Deskripsi</p>
                <p>{{ $laporan->deskripsi }}</p>
            </div>

            <div>
                <p class="text-gray-600 text-sm">Status</p>
                <span class="px-3 py-1 rounded text-white text-sm
                {{ $laporan->status == 'menunggu' ? 'bg-gray-500' :
                   ($laporan->status == 'diverifikasi' ? 'bg-blue-600' :
                   ($laporan->status == 'ditugaskan' ? 'bg-yellow-500' :
                   ($laporan->status == 'proses' ? 'bg-purple-600' :
                   ($laporan->status == 'ditolak' ? 'bg-red-600' :
                   'bg-green-600')))) }}">
                   {{ ucfirst($laporan->status) }}
                </span>
            </div>

            <div>
                <p class="text-gray-600 text-sm">Tanggal Laporan</p>
                <p class="font-bold">{{ $laporan->created_at->format('d/m/Y H:i') }}</p>
            </div>

            @if($laporan->foto)
            <div class="col-span-2">
                <p class="text-gray-600 text-sm mb-2">Foto Kerusakan</p>
                <img src="{{ asset('storage/' . $laporan->foto) }}" 
                     alt="Foto Kerusakan" 
                     class="max-w-md rounded shadow">
            </div>
            @endif
        </div>

        <!-- Info Verifikasi -->
        @if($laporan->verifikasi)
        <div class="mt-6 p-4 bg-blue-50 rounded border border-blue-200">
            <h3 class="font-bold mb-2">Informasi Verifikasi</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-600">Status Verifikasi</p>
                    <p class="font-bold">{{ ucfirst($laporan->verifikasi->status) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Tanggal Verifikasi</p>
                    <p class="font-bold">{{ $laporan->verifikasi->tanggal_verifikasi->format('d/m/Y H:i') }}</p>
                </div>
                @if($laporan->verifikasi->catatan)
                <div class="col-span-2">
                    <p class="text-gray-600">Catatan Admin</p>
                    <p>{{ $laporan->verifikasi->catatan }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Info Penugasan -->
        @if($laporan->penugasan)
        <div class="mt-6 p-4 bg-yellow-50 rounded border border-yellow-200">
            <h3 class="font-bold mb-2">Informasi Penugasan</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-600">Petugas</p>
                    <p class="font-bold">{{ $laporan->penugasan->petugas->nama }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Tanggal Tugas</p>
                    <p class="font-bold">{{ $laporan->penugasan->tanggal_tugas->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Status Penugasan</p>
                    <span class="px-2 py-1 rounded text-white text-xs
                    {{ $laporan->penugasan->status == 'ditugaskan' ? 'bg-yellow-500' :
                       ($laporan->penugasan->status == 'proses' ? 'bg-purple-600' : 'bg-green-600') }}">
                        {{ ucfirst($laporan->penugasan->status) }}
                    </span>
                </div>
            </div>
        </div>
        @endif

        <!-- Info Perbaikan -->
        @if($laporan->perbaikan)
        <div class="mt-6 p-4 bg-green-50 rounded border border-green-200">
            <h3 class="font-bold mb-2">Informasi Perbaikan</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-600">Tindakan</p>
                    <p class="font-bold">{{ $laporan->perbaikan->tindakan }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Tanggal Perbaikan</p>
                    <p class="font-bold">{{ $laporan->perbaikan->tanggal_perbaikan->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Status</p>
                    <span class="px-2 py-1 rounded text-white text-xs
                    {{ $laporan->perbaikan->status == 'selesai' ? 'bg-yellow-500' : 'bg-green-600' }}">
                        {{ $laporan->perbaikan->status == 'selesai' ? 'Menunggu ACC' : 'Sudah di-ACC' }}
                    </span>
                </div>
                <div class="col-span-2">
                    <a href="{{ route('perbaikan.show', $laporan->perbaikan->id) }}" 
                       class="text-blue-600 hover:underline font-bold">
                        → Lihat Detail Perbaikan
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Form Verifikasi (Hanya untuk status menunggu) -->
        @if($laporan->status == 'menunggu')
        <form method="POST" action="{{ route('laporan.verifikasi', $laporan->id) }}" class="mt-6">
            @csrf
            <h3 class="font-bold mb-3">Verifikasi Laporan</h3>
            
            <select name="status" class="border p-2 rounded w-full mb-3" required>
                <option value="">-- Pilih Status --</option>
                <option value="diterima">Terima</option>
                <option value="ditolak">Tolak</option>
            </select>

            <textarea name="catatan" 
                      placeholder="Catatan (opsional)" 
                      rows="3"
                      class="border p-2 rounded w-full mb-3"></textarea>

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Submit Verifikasi
            </button>
        </form>
        @endif

        <!-- Tombol Aksi -->
        <div class="mt-6 flex gap-2">
            @if($laporan->status == 'diverifikasi')
                <a href="{{ route('laporan.assign', $laporan->id) }}" 
                   class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 inline-block">
                    Tugaskan Petugas
                </a>
            @endif

            @if($laporan->perbaikan && $laporan->perbaikan->status == 'selesai')
                <a href="{{ route('perbaikan.show', $laporan->perbaikan->id) }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 inline-block">
                    ACC Perbaikan
                </a>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
    @endif
</x-admin-layout>