@extends('layouts.app')

@section('title', 'Absensi Kamera')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-600 text-white p-4">
            <h1 class="text-2xl font-bold">📸 Absensi dengan Kamera</h1>
            <p class="text-blue-100 mt-1">Ambil foto dan pastikan lokasi GPS aktif</p>
        </div>

        <div class="p-6">
            <!-- Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm font-medium text-green-800">Status GPS</p>
                    <p class="text-lg font-bold text-green-900" id="gps-status">Menunggu...</p>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm font-medium text-blue-800">Akurasi GPS</p>
                    <p class="text-lg font-bold text-blue-900" id="gps-accuracy">-</p>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <p class="text-sm font-medium text-purple-800">Waktu</p>
                    <p class="text-lg font-bold text-purple-900" id="current-time">{{ now()->format('H:i:s') }}</p>
                </div>
            </div>

            <!-- Camera Section -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6 text-center">
                <div class="relative inline-block">
                    <video id="video" autoplay playsinline class="w-full max-w-md rounded-lg shadow-lg bg-gray-800 hidden"></video>
                    <canvas id="canvas" class="hidden"></canvas>
                    <img id="photo-preview" class="w-full max-w-md rounded-lg shadow-lg hidden" alt="Preview foto" />

                    <div id="camera-placeholder" class="w-full max-w-md h-64 bg-gray-200 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-400 mx-auto">
                        <p class="text-gray-500">Klik tombol untuk mengaktifkan kamera</p>
                    </div>
                </div>

                <div class="mt-6 space-x-4">
                    <button id="start-camera" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">📹 Aktifkan Kamera</button>
                    <button id="capture-photo" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold hidden">📸 Ambil Foto</button>
                    <button id="retake-photo" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-semibold hidden">🔄 Foto Ulang</button>
                </div>
            </div>

            <!-- Location Info -->
            <div id="location-info" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6 hidden">
                <h3 class="font-semibold text-yellow-800 mb-2">📍 Informasi Lokasi</h3>
                <div id="location-details" class="text-sm text-yellow-700"></div>
            </div>

            <!-- Submit -->
            <div class="text-center">
                <button id="submit-attendance" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-lg font-bold text-lg disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    ✅ Kirim Absensi
                </button>
                <p class="text-sm text-gray-500 mt-2">Pastikan foto dan lokasi GPS sudah sesuai sebelum mengirim</p>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loading-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-xl text-center max-w-sm mx-4">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600 mx-auto mb-4"></div>
        <p class="text-lg font-semibold">Sedang memproses absensi...</p>
        <p class="text-sm text-gray-500 mt-2">Mohon tunggu sebentar</p>
    </div>
</div>

<!-- Success Modal -->
<div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-xl text-center max-w-md mx-4">
        <div class="text-6xl mb-4">✅</div>
        <h2 class="text-2xl font-bold text-green-600 mb-4">Absensi Berhasil!</h2>
        <div id="success-details" class="text-gray-700 mb-6"></div>
        <button onclick="window.location.reload()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
            OK
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
class AttendanceCamera {
    constructor() {
        this.stream = null;
        this.video = document.getElementById("video");
        this.canvas = document.getElementById("canvas");
        this.photoPreview = document.getElementById("photo-preview");
        this.cameraPlaceholder = document.getElementById("camera-placeholder");
        this.photoBlob = null;
        this.currentPosition = null;
        this.isProcessing = false;

        this.initializeElements();
        this.updateTime();
        setInterval(() => this.updateTime(), 1000);
    }

    initializeElements() {
        document.getElementById("start-camera").addEventListener("click", () => {
            this.startCamera();
            this.requestLocation();
        });
        document.getElementById("capture-photo").addEventListener("click", () => this.capturePhoto());
        document.getElementById("retake-photo").addEventListener("click", () => this.retakePhoto());
        document.getElementById("submit-attendance").addEventListener("click", () => this.submitAttendance());
    }

    updateTime() {
        const now = new Date();
        document.getElementById("current-time").textContent = now.toLocaleTimeString("id-ID");
    }

    async startCamera() {
        try {
            this.stream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: 'user' } // Gunakan kamera depan untuk selfie
            });
            this.video.srcObject = this.stream;
            this.video.classList.remove("hidden");
            this.cameraPlaceholder.classList.add("hidden");
            document.getElementById("start-camera").classList.add("hidden");
            document.getElementById("capture-photo").classList.remove("hidden");
        } catch (error) {
            console.error('Camera error:', error);
            this.showAlert("Gagal mengakses kamera. Pastikan izin kamera sudah diberikan.", "error");
        }
    }

    capturePhoto() {
        const ctx = this.canvas.getContext("2d");
        this.canvas.width = this.video.videoWidth;
        this.canvas.height = this.video.videoHeight;
        ctx.drawImage(this.video, 0, 0);
        
        this.canvas.toBlob((blob) => {
            this.photoBlob = blob;
            this.photoPreview.src = URL.createObjectURL(blob);
            this.photoPreview.classList.remove("hidden");
            this.video.classList.add("hidden");
            document.getElementById("capture-photo").classList.add("hidden");
            document.getElementById("retake-photo").classList.remove("hidden");
            
            // Stop camera stream untuk menghemat resource
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
            }
            
            this.checkSubmitReady();
        }, "image/jpeg", 0.8);
    }

    retakePhoto() {
        this.photoPreview.classList.add("hidden");
        this.photoBlob = null;
        document.getElementById("retake-photo").classList.add("hidden");
        
        // Restart camera
        this.startCamera();
        document.getElementById("capture-photo").classList.remove("hidden");
        this.checkSubmitReady();
    }

    requestLocation() {
        if (!navigator.geolocation) {
            this.showAlert("Browser tidak mendukung GPS.", "error");
            return;
        }

        document.getElementById("gps-status").textContent = "🔄 Mencari lokasi...";
        
        navigator.geolocation.getCurrentPosition(
            (pos) => this.handleLocationSuccess(pos),
            (err) => this.handleLocationError(err),
            { 
                enableHighAccuracy: true, 
                timeout: 30000,
                maximumAge: 300000 // 5 menit cache
            }
        );
    }

    handleLocationSuccess(position) {
        this.currentPosition = position;
        const accuracy = Math.round(position.coords.accuracy);
        
        document.getElementById("gps-status").textContent = "✅ GPS Aktif";
        document.getElementById("gps-accuracy").textContent = `${accuracy}m`;
        
        document.getElementById("location-details").innerHTML = `
            <p><strong>Koordinat:</strong> ${position.coords.latitude.toFixed(6)}, ${position.coords.longitude.toFixed(6)}</p>
            <p><strong>Akurasi:</strong> ${accuracy} meter</p>
            <p><strong>Waktu:</strong> ${new Date(position.timestamp).toLocaleString('id-ID')}</p>
        `;
        
        document.getElementById("location-info").classList.remove("hidden");
        this.checkSubmitReady();
    }

    handleLocationError(error) {
        document.getElementById("gps-status").textContent = "❌ GPS Error";
        
        let errorMessage = "Tidak bisa mendapatkan lokasi: ";
        switch(error.code) {
            case error.PERMISSION_DENIED:
                errorMessage += "Izin lokasi ditolak. Aktifkan izin lokasi di browser.";
                break;
            case error.POSITION_UNAVAILABLE:
                errorMessage += "Informasi lokasi tidak tersedia.";
                break;
            case error.TIMEOUT:
                errorMessage += "Permintaan lokasi timeout.";
                break;
            default:
                errorMessage += error.message;
                break;
        }
        
        this.showAlert(errorMessage, "error");
    }

    checkSubmitReady() {
        const isReady = this.photoBlob && this.currentPosition && !this.isProcessing;
        document.getElementById("submit-attendance").disabled = !isReady;
    }

    async submitAttendance() {
        if (!this.photoBlob || !this.currentPosition || this.isProcessing) return;

        this.isProcessing = true;
        this.checkSubmitReady();
        
        const coords = this.currentPosition.coords;
        const formData = new FormData();
        
        formData.append("photo", this.photoBlob, "attendance.jpg");
        formData.append("latitude", coords.latitude);
        formData.append("longitude", coords.longitude);
        formData.append("accuracy", coords.accuracy);
        
        // Optional GPS data
        if (coords.altitude) formData.append("altitude", coords.altitude);
        if (coords.heading) formData.append("heading", coords.heading);
        if (coords.speed) formData.append("speed", coords.speed);

        this.showLoading(true);

        try {
            const response = await fetch('{{ route("attendance.camera") }}', {
                method: "POST",
                body: formData,
                headers: { 
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json"
                }
            });

            const data = await response.json();
            
            if (data.success) {
                this.showSuccessModal(data);
            } else {
                // Handle different types of errors
                if (response.status === 422) {
                    // Validation or business logic errors
                    this.showAlert(data.message || "Gagal memproses absensi", "error");
                    
                    // Show additional info if available
                    if (data.data && data.data.existing_attendance) {
                        this.showAlert(`Anda sudah absen hari ini dengan status: ${data.data.existing_attendance.status}`, "warning");
                    }
                } else {
                    this.showAlert(data.message || "Terjadi kesalahan sistem", "error");
                }
            }
            
        } catch (error) {
            console.error('Submit error:', error);
            this.showAlert("Terjadi error koneksi: " + error.message, "error");
        } finally {
            this.showLoading(false);
            this.isProcessing = false;
            this.checkSubmitReady();
        }
    }

    showSuccessModal(data) {
        const modal = document.getElementById("success-modal");
        const details = document.getElementById("success-details");
        
        let detailsHtml = `<p class="font-semibold">Status: ${data.data?.attendance?.status || 'Berhasil'}</p>`;
        
        if (data.data?.status_gps) {
            detailsHtml += `<p>${data.data.status_gps}</p>`;
        }
        
        if (data.data?.accuracy_status) {
            detailsHtml += `<p>${data.data.accuracy_status}</p>`;
        }
        
        if (data.data?.location) {
            detailsHtml += `<p>Lokasi: ${data.data.location}</p>`;
        }
        
        if (data.data?.time) {
            detailsHtml += `<p>Waktu: ${data.data.time}</p>`;
        }
        
        details.innerHTML = detailsHtml;
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    }

    showLoading(show) {
        const modal = document.getElementById("loading-modal");
        if (show) {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        } else {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }
    }

    showAlert(message, type = "info") {
        const alertDiv = document.createElement("div");
        const colors = {
            success: "bg-green-600",
            error: "bg-red-600", 
            warning: "bg-yellow-600",
            info: "bg-blue-600"
        };
        
        alertDiv.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white shadow-lg z-50 max-w-sm ${colors[type] || colors.info}`;
        alertDiv.innerHTML = `
            <div class="flex items-center">
                <span class="flex-1">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                    ✕
                </button>
            </div>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
    
    // Cleanup method
    destroy() {
        if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
        }
    }
}

// Initialize camera when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    const cameraApp = new AttendanceCamera();
    
    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        cameraApp.destroy();
    });
});
</script>
@endpush