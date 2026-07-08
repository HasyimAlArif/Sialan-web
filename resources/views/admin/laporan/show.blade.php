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

        </div>

        {{-- ===================== MEDIA & LOKASI ===================== --}}
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Foto --}}
            @if($laporan->foto)
            <div class="flex flex-col">
                <h3 class="font-bold mb-3 text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z" />
                    </svg>
                    Foto Kerusakan
                </h3>
                <div class="flex-1 overflow-hidden rounded-xl shadow-md border border-gray-200">
                    <img src="{{ asset('storage/' . $laporan->foto) }}"
                         alt="Foto Kerusakan"
                         class="w-full h-full object-cover"
                         style="min-height: 360px; max-height: 360px;">
                </div>
            </div>
            @endif

            {{-- Lokasi / Map --}}
            @if($laporan->latitude && $laporan->longitude)
            <div class="flex flex-col {{ !$laporan->foto ? 'lg:col-span-2' : '' }}">
                <h3 class="font-bold mb-3 text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
                    </svg>
                    Lokasi Kejadian
                </h3>
                
                {{-- Map Container --}}
                <div class="flex-1 rounded-xl shadow-md border border-gray-200 overflow-hidden relative" style="min-height: 360px;">
                    <div id="laporan-map" class="absolute inset-0 w-full h-full"></div>
                </div>

                {{-- Koordinat & Actions --}}
                <div class="flex flex-wrap gap-3 mt-4">
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2">
                        <span class="text-[11px] text-gray-500 font-medium">LAT</span>
                        <span class="font-mono font-bold text-gray-800 text-sm">{{ $laporan->latitude }}</span>
                    </div>
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2">
                        <span class="text-[11px] text-gray-500 font-medium">LNG</span>
                        <span class="font-mono font-bold text-gray-800 text-sm">{{ $laporan->longitude }}</span>
                    </div>
                </div>
            </div>
            @endif

        </div>
        {{-- =================== END MEDIA & LOKASI =================== --}}

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

        <!-- Form Verifikasi -->
        @if($laporan->status == 'menunggu')
        <form method="POST" action="{{ route('laporan.verifikasi', $laporan->id) }}" class="mt-6">
            @csrf
            <h3 class="font-bold mb-3">Verifikasi Laporan</h3>
            <select name="status" class="border p-2 rounded w-full mb-3" required>
                <option value="">-- Pilih Status --</option>
                <option value="diterima">Terima</option>
                <option value="ditolak">Tolak</option>
            </select>
            <textarea name="catatan" placeholder="Catatan (opsional)" rows="3"
                      class="border p-2 rounded w-full mb-3"></textarea>
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Submit Verifikasi
            </button>
        </form>
        @endif

        <!-- Tombol Aksi -->
        <div class="mt-6 flex flex-wrap gap-3 items-center">
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

            {{-- ===== TOMBOL POST GALERI ===== --}}
            @if($laporan->foto)
                <form method="POST" action="{{ route('laporan.toggle-galeri', $laporan->id) }}">
                    @csrf
                    @if($laporan->tampil_galeri)
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2 rounded-lg shadow transition"
                            onclick="return confirm('Hapus laporan ini dari Galeri Pemantauan?')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus dari Galeri
                        </button>
                    @else
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Post ke Galeri
                        </button>
                    @endif
                </form>
                {{-- Indikator status galeri --}}
                @if($laporan->tampil_galeri)
                    <span class="inline-flex items-center gap-1.5 text-sm text-indigo-700 bg-indigo-50 border border-indigo-200 px-3 py-1.5 rounded-full font-medium">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        Tampil di Galeri
                    </span>
                @endif
            @else
                <span class="text-sm text-gray-400 italic">Tidak ada foto – tidak dapat diposting ke galeri</span>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded flex items-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded flex items-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- ============ LEAFLET MAP ============ --}}
    @if($laporan->latitude && $laporan->longitude)
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>


    <style>
        /* Override Leaflet popup → Google Maps style */
        #laporan-map .leaflet-popup-content-wrapper {
            padding: 0 !important;
            border-radius: 8px !important;
            overflow: hidden !important;
            box-shadow: 0 4px 24px rgba(0,0,0,0.3), 0 0 0 1px rgba(0,0,0,0.06) !important;
            width: 280px !important;
            font-family: 'Google Sans', Roboto, Arial, sans-serif !important;
        }
        #laporan-map .leaflet-popup-content {
            margin: 0 !important;
            width: 280px !important;
        }
        #laporan-map .leaflet-popup-tip {
            background: #fff !important;
            box-shadow: none !important;
        }
        #laporan-map .leaflet-popup-close-button {
            top: 8px !important;
            right: 8px !important;
            width: 28px !important;
            height: 28px !important;
            border-radius: 50% !important;
            background: rgba(255,255,255,0.92) !important;
            box-shadow: 0 1px 4px rgba(0,0,0,.25) !important;
            font-size: 18px !important;
            color: #444 !important;
            line-height: 28px !important;
            text-align: center !important;
            z-index: 10 !important;
        }
        #laporan-map .leaflet-popup-close-button:hover {
            background: #f1f3f4 !important;
        }
        .gm-popup-photo {
            width: 100%; height: 150px;
            object-fit: cover; display: block;
        }
        .gm-popup-nophoto {
            width: 100%; height: 110px;
            background: #f1f3f4;
            display: flex; align-items: center; justify-content: center;
        }
        .gm-popup-body { padding: 14px 16px 16px; }
        .gm-popup-title {
            font-size: 17px; font-weight: 700;
            color: #1a1a1a; margin: 0 0 8px; line-height: 1.3;
        }
        .gm-popup-address {
            display: flex; align-items: flex-start;
            gap: 6px; font-size: 13px; color: #5f6368;
            margin-bottom: 14px; line-height: 1.4;
        }
        .gm-popup-address svg { flex-shrink: 0; margin-top: 2px; }
        .gm-popup-btn {
            display: block; width: 100%; padding: 10px;
            background: #1a73e8; color: #fff !important;
            text-align: center; border-radius: 6px;
            text-decoration: none !important;
            font-size: 14px; font-weight: 600;
            box-sizing: border-box; transition: background .15s;
        }
        .gm-popup-btn:hover { background: #1557b0 !important; }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function initLeafletMap() {
            // Tunggu sampai library Leaflet selesai diload browser
            if (typeof L === 'undefined') {
                setTimeout(initLeafletMap, 100);
                return;
            }

            try {
                var lat    = {{ (float)$laporan->latitude }};
                var lng    = {{ (float)$laporan->longitude }};
                var foto   = @json($laporan->foto ? asset('storage/' . $laporan->foto) : null);
                var judul  = @json($laporan->judul);
                var alamat = @json($laporan->alamat_lokasi ?? '-');
                var navUrl = 'https://www.google.com/maps/dir/?api=1&destination=' + lat + ',' + lng;

                var map = L.map('laporan-map', {
                    center: [lat, lng],
                    zoom: 16,
                    scrollWheelZoom: false,
                });

                var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
                    maxZoom: 20,
                    subdomains:['mt0','mt1','mt2','mt3']
                });
                var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
                    maxZoom: 20,
                    subdomains:['mt0','mt1','mt2','mt3']
                });
                var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
                    maxZoom: 20,
                    subdomains:['mt0','mt1','mt2','mt3']
                });
                var googleTerrain = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{
                    maxZoom: 20,
                    subdomains:['mt0','mt1','mt2','mt3']
                });

                var esriSat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
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
                }, {}, { position: 'topright' }).addTo(map);

                var damageColors = {
                    'Retak Kulit Buaya (Alligator Cracking)': '#8B4513',
                    'Retak Tepi (Edge Cracking)': '#FF8C00',
                    'Tambalan dan Galian Utilitas': '#696969',
                    'Lubang (Potholes)': '#DC143C',
                    'Pelepasan Butir (Weathering/Raveling)': '#DAA520'
                };
                var markerColor = damageColors[judul] || '#ea4335';

                var markerIcon = L.divIcon({
                    className: '',
                    html: '<svg xmlns="http://www.w3.org/2000/svg" width="38" height="52" viewBox="0 0 38 52">'
                        + '<path d="M19 0C8.507 0 0 8.507 0 19c0 14.25 19 33 19 33S38 33.25 38 19C38 8.507 29.493 0 19 0z" fill="' + markerColor + '"/>'
                        + '<circle cx="19" cy="19" r="8" fill="#fff"/>'
                        + '</svg>',
                    iconSize:    [38, 52],
                    iconAnchor:  [19, 52],
                    popupAnchor: [0, -56],
                });

                var marker = L.marker([lat, lng], { icon: markerIcon }).addTo(map);

                var photoHtml = foto
                    ? '<img src="' + foto + '" class="gm-popup-photo" alt="Foto">'
                    : '<div class="gm-popup-nophoto"><span style="color:#bbb;font-size:12px;">Tidak ada foto</span></div>';

                var popupHtml = photoHtml
                    + '<div class="gm-popup-body">'
                    + '<p class="gm-popup-title">' + judul + '</p>'
                    + '<div class="gm-popup-address">'
                    +   '<span style="font-size:16px;">📍</span>'
                    +   '<span>' + alamat + '</span>'
                    + '</div>'
                    + '<a href="' + navUrl + '" target="_blank" class="gm-popup-btn">Buka di Google Maps</a>'
                    + '</div>';

                marker.bindPopup(popupHtml, {
                    maxWidth: 280,
                    minWidth: 280,
                    closeButton: true,
                }).openPopup();

                // Pastikan map dirender ukurannya dengan benar
                setTimeout(function() {
                    map.invalidateSize();
                }, 500);

            } catch (e) {
                console.error("Error initializing map: ", e);
                document.getElementById('laporan-map').innerHTML = '<div style="padding:20px;text-align:center;color:red;">Gagal memuat peta. Silakan refresh halaman.</div>';
            }
        }

        // Mulai proses load
        initLeafletMap();
    });
    </script>
    @endif
    {{-- =========== END LEAFLET MAP =========== --}}
</x-admin-layout>