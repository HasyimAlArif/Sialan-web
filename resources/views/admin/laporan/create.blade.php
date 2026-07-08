<x-admin-layout>
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('laporan.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Laporan</h1>
            <p class="text-gray-600 mt-1">Buat laporan kerusakan baru</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        <ul class="list-disc pl-5 text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6 md:p-8 w-full">
        <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                {{-- KIRI: Informasi Data Laporan --}}
                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pelapor <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_pelapor" value="{{ old('nama_pelapor') }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="Masukkan nama pelapor">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">No. HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="Contoh: 08123456789">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kerusakan <span class="text-red-500">*</span></label>
                        <select name="judul" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                            <option value="" disabled {{ old('judul') ? '' : 'selected' }}>-- Pilih Jenis Kerusakan --</option>
                            @foreach([
                                'Retak Kulit Buaya (Alligator Cracking)',
                                'Retak Tepi (Edge Cracking)',
                                'Tambalan dan Galian Utilitas',
                                'Lubang (Potholes)',
                                'Pelepasan Butir (Weathering/Raveling)'
                            ] as $jenis)
                                <option value="{{ $jenis }}" {{ (old('judul') == $jenis) ? 'selected' : '' }}>
                                    {{ $jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="5"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                  placeholder="Jelaskan detail kerusakan yang terjadi...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat / Lokasi
                            <span id="alamat-loading" class="text-xs text-blue-400 font-normal hidden">⏳ Mencari alamat...</span>
                        </label>
                        <textarea name="alamat_lokasi" id="alamat-input" rows="2"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                               placeholder="Akan terisi otomatis saat memilih lokasi di peta">{{ old('alamat_lokasi') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="menunggu" {{ old('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diverifikasi" {{ old('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                            <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="ditugaskan" {{ old('status') == 'ditugaskan' ? 'selected' : '' }}>Ditugaskan</option>
                            <option value="proses" {{ old('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                </div>

                {{-- KANAN: Koordinat, Peta & Foto --}}
                <div class="space-y-5 flex flex-col h-full">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Latitude</label>
                            <input type="text" name="latitude" id="lat-input" value="{{ old('latitude') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-gray-50"
                                   placeholder="-6.200000" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Longitude</label>
                            <input type="text" name="longitude" id="lng-input" value="{{ old('longitude') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-gray-50"
                                   placeholder="106.800000" readonly>
                        </div>
                    </div>

                    {{-- Map --}}
                    <div class="flex-grow w-full border border-blue-400 rounded-lg overflow-hidden relative shadow-sm min-h-[260px]">
                        <div id="create-map" class="absolute inset-0 w-full h-full z-10"></div>
                    </div>
                    <p class="text-[13px] text-gray-500 -mt-2">💡 Geser pin biru atau klik pada peta untuk mengatur koordinat.</p>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Kerusakan</label>
                        <div class="border-2 border-dashed border-blue-300 bg-blue-50 rounded-lg p-3 text-center hover:bg-blue-100 transition cursor-pointer"
                             onclick="document.getElementById('foto-input').click()">
                            <span id="upload-text" class="text-sm font-medium text-blue-600">Klik di sini untuk upload foto</span>
                            <input id="foto-input" type="file" name="foto" accept="image/*" class="hidden"
                                   onchange="previewImage(this)">
                        </div>
                        <img id="foto-preview" src="" alt="" class="mt-3 max-h-32 rounded-lg shadow hidden">
                    </div>

                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-200">
                <a href="{{ route('laporan.index') }}"
                   class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-8 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition shadow-sm hover:shadow-md">
                    Simpan Laporan
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('foto-preview');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    {{-- ============ LEAFLET MAP SCRIPTS ============ --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function initCreateMap() {
            if (typeof L === 'undefined') {
                setTimeout(initCreateMap, 100);
                return;
            }

            var latInput = document.getElementById('lat-input');
            var lngInput = document.getElementById('lng-input');

            // Set default location to center of Java (or anywhere) if inputs are empty
            var startLat = latInput.value ? parseFloat(latInput.value) : -7.55;
            var startLng = lngInput.value ? parseFloat(lngInput.value) : 112.60;

            var map = L.map('create-map', {
                center: [startLat, startLng],
                zoom: 10, // zoomed out a bit for default
                scrollWheelZoom: true,
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
            var defaultColor = '#3B82F6';

            function getMarkerIcon(color) {
                return L.divIcon({
                    className: '',
                    html: '<svg xmlns="http://www.w3.org/2000/svg" width="38" height="52" viewBox="0 0 38 52" style="filter:drop-shadow(0 4px 6px rgba(0,0,0,0.3)); cursor:grab;">'
                        + '<path d="M19 0C8.507 0 0 8.507 0 19c0 14.25 19 33 19 33S38 33.25 38 19C38 8.507 29.493 0 19 0z" fill="' + color + '"/>'
                        + '<circle cx="19" cy="19" r="8" fill="#fff"/>'
                        + '</svg>',
                    iconSize:    [38, 52],
                    iconAnchor:  [19, 52],
                });
            }

            var marker = L.marker([startLat, startLng], {
                icon: getMarkerIcon(defaultColor),
                draggable: true 
            }).addTo(map);

            var judulSelect = document.querySelector('select[name="judul"]');
            function updateMarkerColor() {
                var selected = judulSelect ? judulSelect.value : null;
                var color = damageColors[selected] || defaultColor;
                marker.setIcon(getMarkerIcon(color));
            }

            if (judulSelect) {
                judulSelect.addEventListener('change', updateMarkerColor);
                updateMarkerColor(); // initial color setup
            }

            var geocoder = L.Control.geocoder({
                defaultMarkGeocode: false,
                placeholder: "Cari alamat...",
                errorMessage: "Alamat tidak ditemukan"
            })
            .on('markgeocode', function(e) {
                var latlng = e.geocode.center;
                map.setView(latlng, 16);
                marker.setLatLng(latlng);
                updateInputs(latlng.lat, latlng.lng);
            })
            .addTo(map);

            // Populate inputs initially if we want default
            if (!latInput.value) {
                latInput.value = startLat.toFixed(7);
                lngInput.value = startLng.toFixed(7);
            }

            // Get user's actual location if possible
            if (navigator.geolocation && !oldHasValues()) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;
                    
                    map.setView([userLat, userLng], 15);
                    marker.setLatLng([userLat, userLng]);
                    updateInputs(userLat, userLng);
                });
            }

            function oldHasValues() {
                // Check if user submitted form but hit validation error so old() has values
                return !!(document.getElementById('lat-input').getAttribute('value'));
            }

            function updateInputs(lat, lng) {
                latInput.value = lat.toFixed(7);
                lngInput.value = lng.toFixed(7);
                reverseGeocode(lat, lng);
            }

            function reverseGeocode(lat, lng) {
                var alamatInput   = document.getElementById('alamat-input');
                var loadingLabel  = document.getElementById('alamat-loading');
                if (!alamatInput) return;
                if (loadingLabel) loadingLabel.classList.remove('hidden');
                
                var url = 'https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode?location=' + lng + ',' + lat + '&f=pjson';
                
                fetch(url)
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data && data.address) {
                        var addr = data.address;
                        var jalan = addr.Address || addr.Match_addr || '';
                        var desa = addr.Neighborhood || '';
                        var kec = addr.District || '';
                        var kab = addr.City || addr.Subregion || '';
                        
                        var components = [];
                        if (jalan) components.push(jalan);
                        if (desa && components.join(', ').indexOf(desa) === -1) components.push(desa);
                        if (kec && components.join(', ').indexOf(kec) === -1) components.push(kec);
                        if (kab && components.join(', ').indexOf(kab) === -1) components.push(kab);
                        
                        alamatInput.value = components.join(', ') || addr.LongLabel || '';
                    }
                    if (loadingLabel) loadingLabel.classList.add('hidden');
                })
                .catch(function() {
                    if (loadingLabel) loadingLabel.classList.add('hidden');
                });
            }

            marker.on('dragend', function (e) {
                var position = marker.getLatLng();
                updateInputs(position.lat, position.lng);
                map.panTo(position);
            });

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                updateInputs(e.latlng.lat, e.latlng.lng);
            });

            setTimeout(function() { map.invalidateSize(); }, 500);
        }

        initCreateMap();
    });
    </script>
</x-admin-layout>
