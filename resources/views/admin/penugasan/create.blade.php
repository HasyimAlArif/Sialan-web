<x-admin-layout>
<h1 class="text-xl font-bold mb-4">Assign Petugas</h1>

<div class="mb-3">
    <p><b>Laporan:</b> {{ $laporan->judul }}</p>
    <p><b>Lokasi:</b> {{ $laporan->alamat_lokasi }}</p>
</div>

<form method="POST" action="{{ route('laporan.assign.store', $laporan->id) }}">
    @csrf
    <select name="petugas_id" required>
        <option value="">-- Pilih Petugas --</option>
        @foreach($petugas as $p)
            <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->wilayah }})</option>
        @endforeach
    </select>

    <input type="date" name="tanggal_tugas" required>

    <button type="submit">Simpan Penugasan</button>
</form>

</x-admin-layout>
