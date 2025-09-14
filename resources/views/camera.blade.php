@extends('layouts.app')

@section('title', 'Absensi Kamera')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold flex items-center gap-2">
                        📸 Absensi dengan Kamera
                    </h1>
                    <p class="text-blue-100 mt-1">Ambil foto dan pastikan lokasi GPS aktif sebelum mengirim absensi.</p>
                </div>
                <a href="{{ route('admin.dashboard-admin') }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    ← Kembali
                </a>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Status GPS dan Waktu -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-gray-50 p-4 rounded-lg">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span id="gps-status" class="font-medium text-gray-600 flex items-center">
                            <span class="inline-block w-3 h-3 rounded-full bg-gray-400 mr-2"></span>
                            Menunggu GPS...
                        </span>
                    </div>
                    <div class="text-sm text-gray-600">
                        Akurasi: <span id="gps-accuracy" class="font-medium">-- m</span>
                    </div>
                </div>
                <div class="text-gray-600 font-medium">
                    <span id="current-time">{{ now()->format('H:i:s') }}</span>
                </div>
            </div>

            <!-- Kamera Preview -->
            <div class="text-center">
                <div class="relative bg-gray-100 rounded-lg overflow-hidden w-full max-w-md mx-auto" style="aspect-ratio: 4/3;">
                    <video id="video" autoplay muted playsinline class="w-full h-full object-cover"></video>
                    <canvas id="canvas" class="hidden"></canvas>
                    <div id="photo-preview" class="absolute inset-0 flex items-center justify-center bg-black/70 text-white text-lg font-bold hidden">
                        📷 Foto siap dikirim
                    </div>
                    <div id="camera-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 bg-gray-200">
                        <svg class="w-16 h-16 mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586l-.707-.707A1 1 0 0013 4H7a1 1 0 00-.707.293L5.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                        <p>Menunggu kamera...</p>
                    </div>
                </div>

                <!-- Pesan Error Kamera -->
                <div id="camera-error" class="hidden bg-red-50 border border-red-200 p-4 rounded-lg mt-4 text-left">
                    <h3 class="font-semibold text-red-800 mb-2">🚫 Masalah Kamera</h3>
                    <ul class="list-disc pl-5 space-y-1 text-red-700">
                        <li>Pastikan perangkat Anda memiliki kamera yang aktif</li>
                        <li>Berikan izin kamera pada browser Anda</li>
                        <li>Coba refresh halaman</li>
                        <li>Pastikan halaman diakses melalui HTTPS</li>
                    </ul>
                    <button id="retry-camera-btn" class="mt-3 text-blue-600 hover:text-blue-800 underline font-medium">
                        🔄 Coba lagi
                    </button>
                </div>

                <!-- Tombol Ambil Foto -->
                <button id="take-photo-btn" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg mt-4 transition-colors duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                    📸 Ambil Foto
                </button>
            </div>

            <!-- Informasi Lokasi -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                    📍 Informasi Lokasi
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p><span class="text-gray-600">Koordinat:</span> <span id="user-coordinates" class="font-mono">--, --</span></p>
                        <p><span class="text-gray-600">Akurasi:</span> <span id="user-accuracy" class="font-medium">--</span></p>
                        <p><span class="text-gray-600">Kualitas GPS:</span> <span id="gps-quality-text" class="font-medium">--</span></p>
                    </div>
                    <div>
                        <p><span class="text-gray-600">Altitude:</span> <span id="user-altitude">--</span></p>
                        <p><span class="text-gray-600">Heading:</span> <span id="user-heading">--</span></p>
                        <p><span class="text-gray-600">Kecepatan:</span> <span id="user-speed">--</span></p>
                    </div>
                </div>
            </div>

            <!-- Tips GPS -->
            <div id="gps-tips" class="hidden bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                <h3 class="font-semibold text-yellow-800 mb-2">💡 Tips untuk GPS yang Lebih Baik</h3>
                <ul id="gps-tips-list" class="list-disc pl-5 space-y-1 text-yellow-700"></ul>
            </div>

            <!-- Tombol Kirim Absensi -->
            <button id="submit-attendance-btn" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 rounded-lg transition-colors duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                <span id="submit-btn-text">✅ Kirim Absensi</span>
            </button>

            <!-- Pesan Status -->
            <div id="attendance-message" class="text-center font-medium min-h-[24px]"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const photoPreview = document.getElementById('photo-preview');
    const takePhotoBtn = document.getElementById('take-photo-btn');
    const submitBtn = document.getElementById('submit-attendance-btn');
    const submitBtnText = document.getElementById('submit-btn-text');
    const coordinatesEl = document.getElementById('user-coordinates');
    const accuracyEl = document.getElementById('user-accuracy');
    const altitudeEl = document.getElementById('user-altitude');
    const headingEl = document.getElementById('user-heading');
    const speedEl = document.getElementById('user-speed');
    const gpsStatusEl = document.getElementById('gps-status');
    const gpsQualityTextEl = document.getElementById('gps-quality-text');
    const currentTimeEl = document.getElementById('current-time');
    const attendanceMessage = document.getElementById('attendance-message');
    const gpsTips = document.getElementById('gps-tips');
    const gpsTipsList = document.getElementById('gps-tips-list');
    const cameraError = document.getElementById('camera-error');
    const cameraPlaceholder = document.getElementById('camera-placeholder');
    const retryCameraBtn = document.getElementById('retry-camera-btn');

    let photoBlob = null;
    let currentPosition = null;
    let stream = null;
    let watchId = null;

    // GPS Quality function
    function determineGpsQuality(accuracy) {
        if (accuracy <= 5) return { quality: 'excellent', text: 'Sangat Baik', color: 'text-green-600' };
        if (accuracy <= 10) return { quality: 'very_good', text: 'Baik Sekali', color: 'text-green-500' };
        if (accuracy <= 20) return { quality: 'good', text: 'Baik', color: 'text-blue-600' };
        if (accuracy <= 50) return { quality: 'fair', text: 'Cukup', color: 'text-yellow-600' };
        if (accuracy <= 100) return { quality: 'poor', text: 'Buruk', color: 'text-orange-600' };
        return { quality: 'very_poor', text: 'Sangat Buruk', color: 'text-red-600' };
    }

    // Start camera
    async function startCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            video.srcObject = null;
        }

        try {
            // Try front camera first
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: 'user', width: 640, height: 480 } 
            });
            video.srcObject = stream;
            cameraPlaceholder.classList.add('hidden');
            cameraError.classList.add('hidden');
            takePhotoBtn.disabled = false;
            console.log('Front camera started successfully');
        } catch (err) {
            console.error('Front camera error:', err);
            // Try back camera as fallback
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { facingMode: 'environment', width: 640, height: 480 } 
                });
                video.srcObject = stream;
                cameraPlaceholder.classList.add('hidden');
                cameraError.classList.add('hidden');
                takePhotoBtn.disabled = false;
                console.log('Back camera started successfully');
            } catch (fallbackErr) {
                console.error('All camera attempts failed:', fallbackErr);
                cameraPlaceholder.classList.remove('hidden');
                cameraError.classList.remove('hidden');
                showMessage('Kamera tidak tersedia. Silakan periksa pengaturan browser Anda.', 'error');
                takePhotoBtn.disabled = true;
            }
        }
    }

    // Retry camera
    retryCameraBtn.addEventListener('click', startCamera);

    // Take photo
    takePhotoBtn.addEventListener('click', () => {
        if (!stream) {
            showMessage('Kamera tidak tersedia. Silakan aktifkan kamera terlebih dahulu.', 'error');
            return;
        }

        canvas.width = video.videoWidth || 640;
        canvas.height = video.videoHeight || 480;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        canvas.toBlob(blob => {
            if (blob.size > 5 * 1024 * 1024) {
                showMessage('Ukuran foto terlalu besar (maksimal 5MB).', 'error');
                return;
            }
            
            photoBlob = blob;
            photoPreview.classList.remove('hidden');
            updateSubmitButton();
            showMessage('Foto berhasil diambil!', 'success');
        }, 'image/jpeg', 0.8);
    });

    // Update time
    function updateTime() {
        const now = new Date();
        currentTimeEl.textContent = now.toLocaleTimeString('id-ID', { hour12: false });
    }
    updateTime();
    setInterval(updateTime, 1000);

    // Get location
    function startLocationTracking() {
        if (!navigator.geolocation) {
            showGpsError('GPS tidak didukung pada perangkat ini.');
            return;
        }

        const options = {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 30000
        };

        // Get current position first
        navigator.geolocation.getCurrentPosition(
            updateLocationDisplay,
            handleLocationError,
            options
        );

        // Then watch position for updates
        watchId = navigator.geolocation.watchPosition(
            updateLocationDisplay,
            handleLocationError,
            { ...options, timeout: 30000, maximumAge: 60000 }
        );
    }

    function updateLocationDisplay(position) {
        currentPosition = position.coords;
        
        coordinatesEl.textContent = `${position.coords.latitude.toFixed(6)}, ${position.coords.longitude.toFixed(6)}`;
        accuracyEl.textContent = `${position.coords.accuracy.toFixed(2)} m`;
        altitudeEl.textContent = position.coords.altitude ? `${position.coords.altitude.toFixed(2)} m` : '--';
        headingEl.textContent = position.coords.heading ? `${position.coords.heading.toFixed(2)}°` : '--';
        speedEl.textContent = position.coords.speed ? `${position.coords.speed.toFixed(2)} m/s` : '--';

        const gpsQuality = determineGpsQuality(position.coords.accuracy);
        gpsStatusEl.innerHTML = `<span class="inline-block w-3 h-3 rounded-full bg-green-600 mr-2"></span>GPS Aktif`;
        gpsStatusEl.className = 'font-medium text-green-600 flex items-center';
        
        gpsQualityTextEl.textContent = gpsQuality.text;
        gpsQualityTextEl.className = `font-medium ${gpsQuality.color}`;

        document.getElementById('gps-accuracy').textContent = `${position.coords.accuracy.toFixed(2)} m`;

        updateSubmitButton();
        
        // Show tips if accuracy is poor
        if (position.coords.accuracy > 100) {
            showGpsTips([
                'Pindah ke area terbuka untuk GPS yang lebih akurat',
                'Aktifkan mode "High Accuracy" di pengaturan lokasi',
                'Tunggu beberapa saat agar GPS lebih stabil'
            ]);
        } else {
            gpsTips.classList.add('hidden');
        }
    }

    function handleLocationError(error) {
        console.error('Location error:', error);
        let message = 'Gagal mendapatkan lokasi GPS.';
        
        switch(error.code) {
            case error.PERMISSION_DENIED:
                message = 'Izin lokasi ditolak. Silakan aktifkan GPS dan berikan izin.';
                break;
            case error.POSITION_UNAVAILABLE:
                message = 'Lokasi tidak tersedia. Pastikan GPS aktif.';
                break;
            case error.TIMEOUT:
                message = 'Waktu habis mendapatkan lokasi. Coba lagi.';
                break;
        }
        
        showGpsError(message);
        showGpsTips([
            'Pastikan GPS diaktifkan di perangkat Anda',
            'Berikan izin lokasi pada browser',
            'Pindah ke area terbuka',
            'Refresh halaman dan coba lagi'
        ]);
    }

    function showGpsError(message) {
        gpsStatusEl.innerHTML = '<span class="inline-block w-3 h-3 rounded-full bg-red-600 mr-2"></span>GPS Error';
        gpsStatusEl.className = 'font-medium text-red-600 flex items-center';
        showMessage(message, 'error');
        currentPosition = null;
        updateSubmitButton();
    }

    function showGpsTips(tips) {
        gpsTips.classList.remove('hidden');
        gpsTipsList.innerHTML = tips.map(tip => `<li>${tip}</li>`).join('');
    }

    function updateSubmitButton() {
        const hasPhoto = photoBlob !== null;
        const hasLocation = currentPosition !== null;
        
        submitBtn.disabled = !(hasPhoto && hasLocation);
        
        if (!hasPhoto && !hasLocation) {
            submitBtnText.textContent = '⏳ Ambil foto dan tunggu GPS...';
        } else if (!hasPhoto) {
            submitBtnText.textContent = '📸 Ambil foto terlebih dahulu';
        } else if (!hasLocation) {
            submitBtnText.textContent = '📍 Menunggu GPS...';
        } else {
            submitBtnText.textContent = '✅ Kirim Absensi';
        }
    }

    function showMessage(message, type = 'info') {
        attendanceMessage.textContent = message;
        attendanceMessage.className = `text-center font-medium min-h-[24px] ${
            type === 'success' ? 'text-green-600' : 
            type === 'error' ? 'text-red-600' : 
            type === 'warning' ? 'text-yellow-600' : 
            'text-blue-600'
        }`;
    }

    // Submit attendance
    submitBtn.addEventListener('click', async () => {
        if (!photoBlob) {
            showMessage('Silakan ambil foto terlebih dahulu.', 'error');
            return;
        }
        
        if (!currentPosition) {
            showMessage('GPS belum tersedia. Tunggu hingga lokasi terdeteksi.', 'error');
            return;
        }

        submitBtn.disabled = true;
        submitBtnText.textContent = '⏳ Mengirim...';

        const formData = new FormData();
        formData.append('photo', photoBlob, 'attendance.jpg');
        formData.append('latitude', currentPosition.latitude);
        formData.append('longitude', currentPosition.longitude);
        formData.append('accuracy', currentPosition.accuracy);
        
        if (currentPosition.altitude) formData.append('altitude', currentPosition.altitude);
        if (currentPosition.heading) formData.append('heading', currentPosition.heading);
        if (currentPosition.speed) formData.append('speed', currentPosition.speed);

        try {
            const response = await fetch('{{ route("attendance.camera.submit") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                showMessage(result.message || 'Absensi berhasil dicatat!', 'success');
                
                // Reset form
                photoPreview.classList.add('hidden');
                photoBlob = null;
                
                // Stop camera
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    video.srcObject = null;
                }
                
                // Stop location tracking
                if (watchId) {
                    navigator.geolocation.clearWatch(watchId);
                }
                
                // Show additional info if outside location
                if (result.location_info && !result.location_info.is_valid_location) {
                    showMessage(
                        result.message + ' Anda berada di luar area yang ditentukan, namun absensi tetap tercatat.', 
                        'warning'
                    );
                }
                
                // Redirect after delay
                setTimeout(() => {
                    window.location.href = '{{ route("admin.dashboard-admin") }}';
                }, 3000);
                
            } else {
                showMessage(result.message || 'Gagal mengirim absensi. Silakan coba lagi.', 'error');
                
                if (result.errors) {
                    const firstError = Object.values(result.errors)[0];
                    if (Array.isArray(firstError)) {
                        showMessage('Error: ' + firstError[0], 'error');
                    } else {
                        showMessage('Error: ' + firstError, 'error');
                    }
                }
            }
        } catch (error) {
            console.error('Submit error:', error);
            showMessage('Terjadi kesalahan jaringan. Periksa koneksi internet Anda.', 'error');
        } finally {
            updateSubmitButton();
        }
    });

    // Initialize
    startCamera();
    startLocationTracking();
    updateSubmitButton();

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        if (watchId) {
            navigator.geolocation.clearWatch(watchId);
        }
    });
});
</script>
@endpush
@endsection