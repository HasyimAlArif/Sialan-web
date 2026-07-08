<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Profile & Pengaturan</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola informasi akun dan pengaturan keamanan Anda.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 rounded-r shadow-sm">
        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="text-green-800 font-medium text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Form Edit Profile --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Informasi Profil</h3>
                <p class="text-sm text-gray-500 mt-1">Perbarui nama dan alamat email Anda.</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $admin->name) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Form Ubah Password --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Ubah Password</h3>
                <p class="text-sm text-gray-500 mt-1">Pastikan akun Anda menggunakan password yang panjang dan acak untuk menjaga keamanan.</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('current_password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                        <input type="password" name="password" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 transition">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
