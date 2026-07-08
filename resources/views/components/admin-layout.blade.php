<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased" x-data="{ sidebarOpen: false }">

<div class="flex h-screen overflow-hidden">

    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden" x-cloak></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-blue-900 text-white flex flex-col transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 shadow-xl">
        
        <div class="h-16 flex items-center justify-center border-b border-blue-800 bg-blue-950 px-4">
            <div class="flex items-center gap-2 font-bold text-lg tracking-wide">
                <img src="{{ asset('Assets/logo.png') }}" alt="SiALAN Logo" class="w-8 h-8 rounded-full shadow-md object-cover bg-white p-0.5">
                <span>Admin<span class="text-blue-400">Panel</span></span>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            @php
                $activeClass = 'bg-blue-800 text-white shadow-md';
                $inactiveClass = 'text-blue-100 hover:bg-blue-800 hover:text-white';
            @endphp

            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>

            <a href="{{ route('petugas.index') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('petugas.*') ? $activeClass : $inactiveClass }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Petugas
            </a>

            <a href="{{ route('laporan.index') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('laporan.*') ? $activeClass : $inactiveClass }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Laporan
            </a>


            <a href="{{ route('perbaikan.index') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('perbaikan.*') ? $activeClass : $inactiveClass }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Perbaikan
            </a>

            <a href="{{ route('pesan.index') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('pesan.*') ? $activeClass : $inactiveClass }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Kritik & Saran
            </a>
        </nav>

        <div class="p-4 border-t border-blue-800 bg-blue-950">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="w-full flex items-center justify-center px-4 py-2 text-sm text-red-200 bg-red-900/20 hover:bg-red-900/40 hover:text-white rounded-lg transition-all duration-200 group">
                    <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout System
                </button>
            </form>
        </div>
    </aside>


    <div class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">
        
        <header class="h-16 bg-white border-b border-gray-200 shadow-sm flex items-center justify-between px-6 z-10">
            
            <div class="flex items-center">
                <button @click="sidebarOpen = true" class="md:hidden p-1 mr-4 text-gray-500 hover:text-blue-600 focus:outline-none transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h2 class="text-xl font-bold text-gray-800 tracking-tight">
                    Admin Dashboard
                </h2>
            </div>

            <div class="flex items-center gap-6">
                @php
                    $laporanTerbaru = \App\Models\Laporan::where('status', 'menunggu')->orderBy('created_at', 'desc')->take(5)->get();
                    $adaLaporanBaru = $laporanTerbaru->count() > 0;
                @endphp

                <div class="relative" x-data="{ notifOpen: false }">
                    <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="relative p-2 text-gray-400 hover:text-blue-600 transition-colors rounded-full hover:bg-gray-100 focus:outline-none">
                        @if($adaLaporanBaru)
                        <span class="absolute top-2 right-2 flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                        </span>
                        @endif
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </button>

                    <div x-show="notifOpen" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100" 
                         x-cloak>
                        <div class="px-4 py-3 border-b border-gray-50 flex justify-between items-center">
                            <h3 class="text-sm font-bold text-gray-800">Laporan Terbaru</h3>
                            @if($adaLaporanBaru)
                            <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded-full">{{ $laporanTerbaru->count() }} Baru</span>
                            @endif
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            @forelse($laporanTerbaru as $notif)
                            <a href="{{ route('laporan.show', $notif->id) }}" class="block px-4 py-3 hover:bg-blue-50 border-b border-gray-50 transition group">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-sm font-semibold text-gray-800 truncate group-hover:text-blue-600 transition">{{ $notif->judul }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5 truncate">Oleh: {{ $notif->nama_pelapor }}</p>
                                        <p class="text-[10px] text-gray-400 mt-1 font-medium">{{ $notif->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <div class="px-4 py-8 text-center flex flex-col items-center">
                                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500">Belum ada laporan baru</p>
                                <p class="text-xs text-gray-400 mt-1">Semua laporan sudah diproses</p>
                            </div>
                            @endforelse
                        </div>
                        <div class="px-4 py-2 border-t border-gray-50 text-center bg-gray-50/50">
                            <a href="{{ route('laporan.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition">Lihat Semua Laporan</a>
                        </div>
                    </div>
                </div>

                <div class="h-8 w-px bg-gray-200"></div>

                <div class="relative" x-data="{ userOpen: false }">
                    <button @click="userOpen = !userOpen" @click.away="userOpen = false" class="flex items-center gap-3 cursor-pointer group focus:outline-none">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition">{{ Auth::guard('admin')->check() ? Auth::guard('admin')->user()->name : 'Administrator' }}</p>
                            <p class="text-xs text-gray-500">Super Admin</p>
                        </div>
                        
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-blue-600 border-2 border-white shadow-md flex items-center justify-center text-white font-bold overflow-hidden">
                                <span>{{ Auth::guard('admin')->check() ? strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) : 'A' }}</span>
                            </div>
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                        </div>

                        <svg :class="userOpen ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="userOpen" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100" 
                         x-cloak>
                        <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600">Pengaturan</a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                        </form>
                    </div>
                </div>

            </div>
        </header>


        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-8">
            {{-- <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">{{ $header ?? 'Dashboard' }}</h1>
            </div> --}}

            {{ $slot }}
        </main>
        
    </div>

</div>

</body>
</html>