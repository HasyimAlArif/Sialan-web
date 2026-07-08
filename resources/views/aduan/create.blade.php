<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SiALAN - Form Aduan Masyarakat</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        .custom-input::placeholder {
            color: #60a5fa;
            opacity: 0.8;
        }
        
        .upload-area {
            background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='8' ry='8' stroke='%233B82F6FF' stroke-width='2' stroke-dasharray='10%2c 10' stroke-dashoffset='0' stroke-linecap='square'/%3e%3c/svg%3e");
            transition: all 0.3s;
        }
        .upload-area:hover {
            background-color: #eff6ff;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #1e40af;
        }

        .preview-container {
            position: relative;
            display: inline-block;
        }
        
        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body class="bg-[#E2E8F0] text-gray-800 min-h-screen flex flex-col justify-between">

    <nav class="bg-blue-600 text-white shadow-md">
        <div class="max-w-[1920px] mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="text-xl font-normal tracking-wide">
                    Si<span class="font-bold">ALAN</span>
                </div>
            </div>
            
            <div class="hidden md:flex space-x-8 text-base font-medium">
                <a href="/" class="hover:text-blue-200 transition">Beranda</a>
                <a href="/#peta-sebaran" class="hover:text-blue-200 transition">Peta Sebaran</a>
                <a href="{{ route('aduan.create') }}" class="text-blue-200 font-bold border-b-2 border-blue-200 pb-1">Form Aduan</a>
                <a href="/#contact" class="hover:text-blue-200 transition">Contact</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow w-full max-w-6xl mx-auto px-4 py-8">
        
        <h1 class="text-2xl font-bold text-blue-600 mb-6 pl-1">Form Aduan Masyarakat</h1>

        <!-- Alert Success -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        <!-- Alert Errors -->
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-200">
            
            <div class="bg-[#1D4ED8] py-3 text-center">
                <h2 class="text-white font-medium text-lg">Pelaporan</h2>
            </div>

            <form action="{{ route('aduan.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="space-y-4">
                        <div>
                            <label for="nama_pelapor" class="form-label">Nama*</label>
                            <input 
                                type="text" 
                                id="nama_pelapor" 
                                name="nama_pelapor"
                                value="{{ old('nama_pelapor') }}"
                                placeholder="Nama Lengkap" 
                                class="custom-input w-full border border-blue-500 rounded px-4 py-3 text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white"
                                required>
                        </div>

                        <div>
                            <label for="no_hp" class="form-label">No HP*</label>
                            <input 
                                type="text" 
                                id="no_hp" 
                                name="no_hp"
                                value="{{ old('no_hp') }}"
                                placeholder="08xxxxxxxxxx" 
                                class="custom-input w-full border border-blue-500 rounded px-4 py-3 text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white"
                                required>
                        </div>

                        <div>
                            <label for="judul" class="form-label">Jenis Kerusakan*</label>
                            <select 
                                id="judul" 
                                name="judul"
                                class="custom-input w-full border border-blue-500 rounded px-4 py-3 text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white cursor-pointer"
                                required>
                                <option value="" disabled {{ old('judul') ? '' : 'selected' }}>-- Pilih Jenis Kerusakan --</option>
                                <option value="Retak Kulit Buaya (Alligator Cracking)" {{ old('judul') == 'Retak Kulit Buaya (Alligator Cracking)' ? 'selected' : '' }}>Retak Kulit Buaya (Alligator Cracking)</option>
                                <option value="Retak Tepi (Edge Cracking)" {{ old('judul') == 'Retak Tepi (Edge Cracking)' ? 'selected' : '' }}>Retak Tepi (Edge Cracking)</option>
                                <option value="Tambalan dan Galian Utilitas" {{ old('judul') == 'Tambalan dan Galian Utilitas' ? 'selected' : '' }}>Tambalan dan Galian Utilitas</option>
                                <option value="Lubang (Potholes)" {{ old('judul') == 'Lubang (Potholes)' ? 'selected' : '' }}>Lubang (Potholes)</option>
                                <option value="Pelepasan Butir (Weathering/Raveling)" {{ old('judul') == 'Pelepasan Butir (Weathering/Raveling)' ? 'selected' : '' }}>Pelepasan Butir (Weathering/Raveling)</option>
                            </select>
                        </div>

                        <div>
                            <label for="deskripsi" class="form-label">Deskripsi*</label>
                            <textarea 
                                id="deskripsi" 
                                name="deskripsi"
                                placeholder="Jelaskan detail kerusakan..." 
                                rows="4" 
                                class="custom-input w-full border border-blue-500 rounded px-4 py-3 text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white resize-none h-32"
                                required>{{ old('deskripsi') }}</textarea>
                        </div>

                        <div>
                            <label for="alamat_lokasi" class="form-label">Alamat Lokasi*
                                <span id="alamat-loading" style="font-size:11px;color:#60a5fa;font-weight:normal;" class="hidden">⏳ Mencari alamat...</span>
                            </label>
                            <textarea 
                                id="alamat_lokasi" 
                                name="alamat_lokasi"
                                placeholder="Akan terisi otomatis saat memilih lokasi di peta" 
                                rows="2" 
                                class="custom-input w-full border border-blue-500 rounded px-4 py-3 text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white resize-none"
                                required>{{ old('alamat_lokasi') }}</textarea>
                        </div>

                        <div class="relative w-full">
                            <input type="file" id="foto" name="foto" class="hidden" accept="image/*">
                            <label for="foto" class="upload-area w-full h-40 flex flex-col items-center justify-center cursor-pointer rounded-lg">
                                <span id="upload-text" class="text-blue-500 font-medium text-center leading-tight">
                                    Upload<br>Image
                                </span>
                            </label>
                            <div id="preview" class="mt-2 hidden">
                                <div class="preview-container">
                                    <img id="preview-image" class="max-w-full h-40 rounded-lg border border-blue-300" alt="Preview">
                                    <span class="remove-image" onclick="removeImage()">×</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 flex flex-col h-full">
                        <div>
                            <label for="latitude" class="form-label">Latitude*</label>
                            <input 
                                type="text" 
                                id="latitude"
                                name="latitude"
                                value="{{ old('latitude') }}"
                                placeholder="latitude" 
                                class="custom-input w-full border border-blue-500 rounded px-4 py-3 text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white"
                                readonly
                                required>
                        </div>

                        <div>
                            <label for="longitude" class="form-label">Longitude*</label>
                            <input 
                                type="text" 
                                id="longitude"
                                name="longitude"
                                value="{{ old('longitude') }}"
                                placeholder="longitude" 
                                class="custom-input w-full border border-blue-500 rounded px-4 py-3 text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white"
                                readonly
                                required>
                        </div>

                        <div class="flex-grow w-full min-h-[250px] border border-blue-500 rounded-lg overflow-hidden relative">
                            <div id="map" class="w-full h-full"></div>
                        </div>
                        
                        <div class="text-sm text-gray-600">
                            <p>💡 Tips: Geser marker biru untuk memilih lokasi yang tepat</p>
                        </div>
                    </div>

                </div>

                <div class="mt-8 flex justify-center">
                    <button type="submit" class="bg-gradient-to-b from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium py-2 px-12 rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>

    </main>

    <footer class="bg-[#1e3a8a] text-white py-8 text-center border-t-4 border-blue-500">
        <p class="text-sm font-light tracking-wide">Copyright © 2026 by SEEMZ-DEV - All Rights Reserved.</p>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.js"></script>

    <script>
        // Preview image
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview').classList.remove('hidden');
                    document.getElementById('upload-text').textContent = file.name;
                }
                reader.readAsDataURL(file);
            }
        });

        function removeImage() {
            document.getElementById('foto').value = '';
            document.getElementById('preview').classList.add('hidden');
            document.getElementById('upload-text').innerHTML = 'Upload<br>Image';
        }

        // Inisialisasi peta
        var map = L.map('map').setView([-7.55, 112.6], 10);

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

        var userMarker;
        var searchMarker;

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

        var judulSelect = document.getElementById('judul');
        
        function getCurrentColor() {
            var selected = judulSelect ? judulSelect.value : null;
            return damageColors[selected] || defaultColor;
        }

        function updateMarkerColor() {
            var color = getCurrentColor();
            if (userMarker) userMarker.setIcon(getMarkerIcon(color));
            if (searchMarker) searchMarker.setIcon(getMarkerIcon(color));
        }

        if (judulSelect) {
            judulSelect.addEventListener('change', updateMarkerColor);
        }

        function updateInputs(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
            reverseGeocode(lat, lng);
        }

        function reverseGeocode(lat, lng) {
            var alamatInput  = document.getElementById('alamat_lokasi');
            var loadingLabel = document.getElementById('alamat-loading');
            if (!alamatInput) return;
            if (loadingLabel) loadingLabel.classList.remove('hidden');
            
            // Menggunakan ArcGIS (Esri) Reverse Geocoding - Sangat akurat seperti Google & Gratis tanpa API Key
            // Perhatikan parameter location untuk ArcGIS adalah: longitude,latitude
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

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;

                map.setView([lat, lng], 15);

                userMarker = L.marker([lat, lng], {
                    icon: getMarkerIcon(getCurrentColor()),
                    draggable: true
                }).addTo(map)
                .bindPopup("📍 Lokasi Anda (Geser untuk menyesuaikan)")
                .openPopup();

                updateInputs(lat, lng);

                userMarker.on('dragend', function(e) {
                    var posBaru = e.target.getLatLng();
                    updateInputs(posBaru.lat, posBaru.lng);
                });

            }, function(error) {
                console.warn("Gagal mendeteksi lokasi: " + error.message);
            });
        }

        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: "Cari alamat...",
            errorMessage: "Alamat tidak ditemukan"
        })
        .on('markgeocode', function(e) {
            var latlng = e.geocode.center;

            map.setView(latlng, 16);

            if (userMarker) map.removeLayer(userMarker);
            if (searchMarker) map.removeLayer(searchMarker);

            searchMarker = L.marker(latlng, {
                icon: getMarkerIcon(getCurrentColor()),
                draggable: true
            }).addTo(map)
            .bindPopup("📍 " + e.geocode.name + "<br><small>(Geser untuk menyesuaikan)</small>")
            .openPopup();

            updateInputs(latlng.lat, latlng.lng);

            searchMarker.on('dragend', function(e) {
                var posBaru = e.target.getLatLng();
                updateInputs(posBaru.lat, posBaru.lng);
            });
        })
        .addTo(map);

        map.on('click', function(e) {
            var latlng = e.latlng;

            if (userMarker) map.removeLayer(userMarker);
            if (searchMarker) map.removeLayer(searchMarker);

            userMarker = L.marker(latlng, {
                icon: getMarkerIcon(getCurrentColor()),
                draggable: true
            }).addTo(map)
            .bindPopup("📍 Lokasi terpilih<br><small>(Geser untuk menyesuaikan)</small>")
            .openPopup();

            updateInputs(latlng.lat, latlng.lng);

            userMarker.on('dragend', function(e) {
                var posBaru = e.target.getLatLng();
                updateInputs(posBaru.lat, posBaru.lng);
            });
        });
    </script>
</body>
</html>