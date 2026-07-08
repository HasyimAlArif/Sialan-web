@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
            z-index: 1;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 0.5rem;
            overflow: hidden;
            padding: 0;
        }

        .leaflet-popup-content {
            margin: 0;
            width: 260px !important;
        }

        .custom-popup .popup-image {
            width: 100%;
            height: 140px;
            object-fit: cover;
        }

        .custom-popup .popup-info {
            padding: 12px;
        }
    </style>
@endpush

@section('content')
    <header class="relative w-full">
        <div class="h-64 w-full overflow-hidden relative">
            <img src="assets/img/banner_baru.png" alt="Jalan Raya" class="w-full h-full object-cover" />
        </div>

        <div class="max-w-5xl mx-auto px-4 relative -mt-32 z-10">
            <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-10 text-center border-t-8 border-blue-600">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    Sistem Informasi Kelayakan Jalan
                </h1>
                <p class="text-base md:text-lg text-gray-600 leading-relaxed">
                    <span class="font-bold text-blue-600">SiALAN</span> dirancang untuk
                    memantau dan mengelola kondisi jalan, serta memetakan kerusakan
                    jalan secara efektif menggunakan teknologi GIS untuk membantu
                    pengambilan keputusan perbaikan.
                </p>
            </div>
        </div>
    </header>

    <section id="pelaporan" class="py-20 bg-[#E2E8F0] overflow-hidden">
        <div class="w-full max-w-5xl mx-auto px-4 md:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800">Galeri Pemantauan</h2>
                <p class="text-gray-500 mt-2">Dokumentasi kondisi jalan terkini</p>
            </div>

            @php
                $galeriLaporans = $laporans->filter(fn($l) => $l->tampil_galeri && $l->foto)->values();
                $totalGaleri = $galeriLaporans->count();
            @endphp

            @if ($totalGaleri > 0)
                <div class="carousel-container">
                    <div class="carousel-track" id="carouselTrack">
                        @foreach ($galeriLaporans as $laporan)
                            <div class="carousel-slide">
                                <div
                                    class="bg-gray-200 rounded-xl overflow-hidden shadow-lg h-[300px] md:h-[300px] relative group">
                                    <img src="{{ $laporan->foto }}"
                                        class="w-full h-full object-cover transition transform group-hover:scale-110 duration-500"
                                        alt="{{ $laporan->judul }}"
                                        onerror="this.src='https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?auto=format&fit=crop&w=800&q=80'" />
                                    {{-- Overlay info saat hover --}}
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-4">
                                        <span
                                            class="text-white font-bold text-sm md:text-base leading-snug line-clamp-2 mb-1">
                                            {{ $laporan->judul }}
                                        </span>
                                        <span class="text-gray-200 text-xs flex items-center gap-1">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="line-clamp-1">{{ $laporan->alamat_lokasi }}</span>
                                        </span>
                                    </div>
                                    {{-- Badge status --}}
                                    @php
                                        $statusColor = match ($laporan->status) {
                                            'selesai', 'acc' => 'bg-green-500',
                                            'proses', 'ditugaskan' => 'bg-blue-500',
                                            'diverifikasi' => 'bg-yellow-500',
                                            'ditolak' => 'bg-red-500',
                                            default => 'bg-gray-500',
                                        };
                                        $statusLabel = match ($laporan->status) {
                                            'menunggu' => 'Menunggu',
                                            'diverifikasi' => 'Diverifikasi',
                                            'ditolak' => 'Ditolak',
                                            'ditugaskan' => 'Ditugaskan',
                                            'proses' => 'Dalam Proses',
                                            'selesai' => 'Selesai',
                                            'acc' => 'ACC',
                                            default => ucfirst($laporan->status),
                                        };
                                    @endphp
                                    <span
                                        class="absolute top-3 right-3 {{ $statusColor }} text-white text-[10px] font-semibold px-2 py-0.5 rounded-full shadow">
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Dots navigasi dinamis --}}
                <div class="flex justify-center space-x-3 mt-8" id="carouselDots">
                    @foreach ($galeriLaporans as $i => $laporan)
                        <button
                            class="w-4 h-4 rounded-full transition carousel-dot {{ $i === 0 ? 'bg-blue-600 ring-2 ring-blue-300' : 'bg-gray-300 hover:bg-blue-400' }}"
                            data-index="{{ $i }}"></button>
                    @endforeach
                </div>
            @else
                {{-- Fallback jika belum ada laporan dengan foto --}}
                <div class="text-center py-16 bg-white rounded-2xl shadow">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-400 font-medium">Belum ada foto laporan tersedia</p>
                    <p class="text-gray-300 text-sm mt-1">Foto akan muncul setelah ada laporan masuk</p>
                </div>
            @endif
        </div>
    </section>

    <section id="peta-sebaran" class="py-16 bg-[#E2E8F0]">
        <div class="max-w-6xl mx-auto px-4">
            <div
                class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200 transform hover:scale-[1.01] transition duration-500">
                <div class="bg-blue-700 py-4 px-6 flex justify-between items-center">
                    <h2 class="text-white font-bold text-lg md:text-xl tracking-wide flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 7m0 13V7">
                            </path>
                        </svg>
                        Peta Sebaran Kerusakan
                    </h2>
                    <span class="text-blue-100 text-sm hidden md:inline-block">Update Terakhir: 2026</span>
                </div>

                <div class="relative w-full h-[500px] bg-gray-100 group rounded-b-2xl overflow-hidden z-0">
                    <div id="map" class="w-full h-full"></div>

                    <div
                        class="absolute bottom-4 left-4 bg-white/95 p-3 rounded-lg shadow-lg border border-gray-100 backdrop-blur-sm z-[1000]">
                        <p class="text-[11px] font-bold text-gray-500 uppercase mb-2">
                            Legenda Kerusakan
                        </p>
                        <div class="space-y-1.5">
                            <div class="flex items-center text-[11px] text-gray-700">
                                <span class="w-3 h-3 rounded-full mr-2 shadow-sm" style="background-color: #8B4513;"></span>
                                Retak Kulit Buaya
                            </div>
                            <div class="flex items-center text-[11px] text-gray-700">
                                <span class="w-3 h-3 rounded-full mr-2 shadow-sm" style="background-color: #FF8C00;"></span>
                                Retak Tepi
                            </div>
                            <div class="flex items-center text-[11px] text-gray-700">
                                <span class="w-3 h-3 rounded-full mr-2 shadow-sm" style="background-color: #696969;"></span>
                                Tambalan & Galian
                            </div>
                            <div class="flex items-center text-[11px] text-gray-700">
                                <span class="w-3 h-3 rounded-full mr-2 shadow-sm" style="background-color: #DC143C;"></span>
                                Lubang (Potholes)
                            </div>
                            <div class="flex items-center text-[11px] text-gray-700">
                                <span class="w-3 h-3 rounded-full mr-2 shadow-sm" style="background-color: #DAA520;"></span>
                                Pelepasan Butir
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="py-20 bg-[#E2E8F0]">
        <div class="max-w-4xl mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-blue-700 py-4 text-center">
                    <h2 class="text-white font-semibold text-xl">Hubungi Kami</h2>
                </div>

                <div class="p-8 md:p-10">
                    @if (session('success_pesan'))
                        <div
                            class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm">{{ session('success_pesan') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pesan.store') }}" id="contactForm" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-600">Nama</label>
                                <input type="text" name="nama" required placeholder="Masukkan nama anda"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-600">Email</label>
                                <input type="email" name="email" required placeholder="contoh@email.com"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-600">Subjek</label>
                            <input type="text" name="subjek" required placeholder="Perihal laporan"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" />
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-600">Pesan</label>
                            <textarea name="pesan" required placeholder="Tuliskan detail laporan atau pesan anda disini..." rows="5"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 resize-none transition"></textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.js"></script>
    <script>
        // Initialize Map
        document.addEventListener('DOMContentLoaded', function() {
            // Default center (Sidoarjo/Surabaya area usually, but will fit bounds)
            var map = L.map('map').setView([-7.4478, 112.7183], 13);

            var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });
            var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });
            var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });
            var googleTerrain = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });

            var esriSat = L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: '&copy; <a href="http://www.esri.com/">Esri</a>, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
                    maxZoom: 18
                });

            googleStreets.addTo(map);
            L.control.layers({
                'Streets': googleStreets,
                'Hybrid': googleHybrid,
                'Google Satellite': googleSat,
                'Esri Satellite': esriSat,
                'Terrain': googleTerrain
            }, {}, {
                position: 'topright'
            }).addTo(map);

            var geocoder = L.Control.geocoder({
                    defaultMarkGeocode: false,
                    placeholder: "Cari lokasi...",
                    errorMessage: "Lokasi tidak ditemukan"
                })
                .on('markgeocode', function(e) {
                    var latlng = e.geocode.center;
                    map.setView(latlng, 15);
                })
                .addTo(map);

            var reports = @json($laporans);
            var markers = [];

            var damageColors = {
                'Retak Kulit Buaya (Alligator Cracking)': '#8B4513',
                'Retak Tepi (Edge Cracking)': '#FF8C00',
                'Tambalan dan Galian Utilitas': '#696969',
                'Lubang (Potholes)': '#DC143C',
                'Pelepasan Butir (Weathering/Raveling)': '#DAA520'
            };

            function getMarkerIcon(color) {
                return L.divIcon({
                    className: '',
                    html: '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="42" viewBox="0 0 38 52" style="filter:drop-shadow(0 3px 4px rgba(0,0,0,0.3));">' +
                        '<path d="M19 0C8.507 0 0 8.507 0 19c0 14.25 19 33 19 33S38 33.25 38 19C38 8.507 29.493 0 19 0z" fill="' +
                        color + '"/>' +
                        '<circle cx="19" cy="19" r="8" fill="#fff"/>' +
                        '</svg>',
                    iconSize: [30, 42],
                    iconAnchor: [15, 42],
                    popupAnchor: [0, -44],
                });
            }

            reports.forEach(report => {
                if (report.latitude && report.longitude) {
                    var popupContent = `
                    <div class="custom-popup">
                        <img src="${report.foto}" class="popup-image" alt="${report.judul}" onerror="this.src='https://via.placeholder.com/300x150?text=No+Image'">
                        <div class="popup-info">
                            <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2">${report.judul}</h3>
                            <p class="text-xs text-gray-500 mb-3 flex items-start">
                                <svg class="w-3 h-3 mr-1 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="line-clamp-2">${report.alamat_lokasi}</span>
                            </p>
                            <a href="https://www.google.com/maps/dir/?api=1&destination=${report.latitude},${report.longitude}" 
                               target="_blank" 
                               class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium py-2 rounded transition flex items-center justify-center">
                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Navigasi Google Maps
                            </a>
                        </div>
                    </div>
                `;

                    var markerColor = damageColors[report.judul] || '#3B82F6';
                    var marker = L.marker([report.latitude, report.longitude], {
                            icon: getMarkerIcon(markerColor)
                        })
                        .addTo(map)
                        .bindPopup(popupContent);

                    markers.push(marker);
                }
            });

            // Fit bounds if markers exist
            if (markers.length > 0) {
                var group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        });

        // Carousel Functionality Updated
        const track = document.getElementById("carouselTrack");
        const dots = document.querySelectorAll(".carousel-dot");

        if (track && dots.length > 0) {
            let currentIndex = 0;
            const totalSlides = dots.length;

            function updateCarousel(index) {
                // Logic responsif: Mobile geser 100%, Desktop geser 33.33%
                const isMobile = window.innerWidth < 1024;
                const slideWidth = isMobile ? 100 : 33.3333;

                // Loop logic (agar tidak lewat batas)
                if (index < 0) index = totalSlides - 1;
                if (index >= totalSlides) index = 0;

                currentIndex = index;

                // Apply Transform
                track.style.transform = `translateX(-${currentIndex * slideWidth}%)`;

                // Update Dots
                dots.forEach((dot, i) => {
                    if (i === currentIndex) {
                        dot.classList.remove("bg-gray-300", "hover:bg-blue-400");
                        dot.classList.add("bg-blue-600", "ring-2", "ring-blue-300");
                    } else {
                        dot.classList.add("bg-gray-300", "hover:bg-blue-400");
                        dot.classList.remove("bg-blue-600", "ring-2", "ring-blue-300");
                    }
                });
            }

            // Click Event for Dots
            dots.forEach((dot) => {
                dot.addEventListener("click", (e) => {
                    const index = parseInt(e.target.dataset.index);
                    updateCarousel(index);
                });
            });

            // Auto Play
            let autoPlayInterval = setInterval(() => {
                updateCarousel(currentIndex + 1);
            }, 5000);

            // Pause on Hover (UX Enhancement)
            track.addEventListener("mouseenter", () =>
                clearInterval(autoPlayInterval),
            );
            track.addEventListener("mouseleave", () => {
                autoPlayInterval = setInterval(() => {
                    updateCarousel(currentIndex + 1);
                }, 5000);
            });

            // Handle Resize (Reset position to avoid layout break)
            window.addEventListener("resize", () => {
                updateCarousel(currentIndex);
            });
        }

        // Smooth Scroll Fix
        document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
            anchor.addEventListener("click", function(e) {
                e.preventDefault();
                const targetId = this.getAttribute("href");
                const target = document.querySelector(targetId);
                if (target) {
                    target.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
                }
            });
        });

        // Form validation for UX (Submit logic is handled by standard POST now)
        document.getElementById("contactForm").addEventListener("submit", () => {
            const btn = document.querySelector('button[type="submit"]');
            btn.innerText = 'Mengirim...';
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
        });
    </script>
@endpush
