<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiALAN') - Sistem Informasi Kelayakan Jalan</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
      body {
        font-family: "Inter", sans-serif;
      }

      /* Utility Scrollbar */
      .no-scrollbar::-webkit-scrollbar {
        display: none;
      }
      .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
      }

      /* Carousel Logic */
      .carousel-container {
        position: relative;
        overflow: hidden;
        width: 100%;
      }

      .carousel-track {
        display: flex;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1); /* Transisi lebih smooth */
        width: 100%;
      }

      /* Slide Logic: Mobile 100%, Desktop 33.33% */
      .carousel-slide {
        min-width: 100%;
        padding: 0 10px;
        box-sizing: border-box;
      }

      @media (min-width: 1024px) {
        .carousel-slide {
          min-width: 33.3333%; /* 3 Gambar per slide di desktop */
        }
      }
    </style>
    @stack('styles')
</head>
<body class="bg-[#E2E8F0] text-gray-800 flex flex-col min-h-screen">

    <nav class="bg-blue-600 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-[1920px] mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-white text-blue-600 rounded-full w-10 h-10 flex items-center justify-center font-bold text-sm shadow-md">
                    Logo
                </div>
                <span class="text-2xl font-bold tracking-wide">SiALAN</span>
            </div>
            
            <div class="hidden md:flex space-x-8 text-base font-medium">
                {{-- Menggunakan Route::has untuk mengecek apakah route ada agar tidak error --}}
                <a href="{{ Route::has('home') ? route('home') : '/' }}" class="hover:text-blue-200 transition">Beranda</a>
                <a href="{{ Route::has('home') ? route('home').'#peta-sebaran' : '#' }}" class="hover:text-blue-200 transition">Peta Sebaran</a>
                <a href="{{ Route::has('aduan.create') ? route('aduan.create') : '/aduan' }}" class="text-blue-200 border-b-2 border-blue-200 pb-1 font-bold">Form Aduan</a>
                <a href="{{ Route::has('home') ? route('home').'#contact' : '#' }}" class="hover:text-blue-200 transition">Contact</a>
            </div>
            
            <button class="md:hidden focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    @stack('scripts')

    <footer class="bg-blue-800 text-white py-8 text-center text-sm border-t-4 border-blue-500 mt-auto">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <span class="font-bold text-lg">SiALAN</span>
                <p class="text-blue-200 text-xs mt-1">Sistem Informasi Kelayakan Jalan</p>
            </div>
            <p class="text-blue-200">Copyright © {{ date('Y') }} by SEEMZ-DEV - All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>