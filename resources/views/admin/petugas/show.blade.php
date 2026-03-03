<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Petugas</h1>
            <p class="text-gray-500 text-sm mt-1">Informasi lengkap petugas.</p>
        </div>
        <a href="{{ route('petugas.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm flex items-center transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                <p class="text-lg text-gray-800 font-medium">{{ $petugas->nama }}</p>
            </div>

            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-500 mb-1">Alamat Email</label>
                <p class="text-lg text-gray-800">{{ $petugas->email }}</p>
            </div>

            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-500 mb-1">Nomor HP/WhatsApp</label>
                <p class="text-lg text-gray-800">{{ $petugas->no_hp }}</p>
            </div>

            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-500 mb-1">Wilayah Tugas</label>
                <p class="text-lg text-gray-800">{{ $petugas->wilayah }}</p>
            </div>

            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-500 mb-1">Terdaftar Sejak</label>
                <p class="text-lg text-gray-800">{{ $petugas->created_at->format('d M Y, H:i') }}</p>
            </div>

        </div>

        <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
            <a href="{{ route('petugas.edit', $petugas) }}" class="px-6 py-2.5 rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-md transition font-medium text-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Petugas
            </a>
        </div>
    </div>
</x-admin-layout>
