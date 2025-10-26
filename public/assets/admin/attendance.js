class AttendanceCamera {
    constructor() {
        this.video = document.getElementById('video');
        this.canvas = document.getElementById('canvas');
        this.captureBtn = document.getElementById('capture-btn');
        this.submitBtn = document.getElementById('submit-btn');
        this.retakeBtn = document.getElementById('retake-btn');
        this.switchCameraBtn = document.getElementById('switch-camera-btn');
        this.previewContainer = document.getElementById('preview-container');
        this.previewImage = document.getElementById('preview-image');
        this.cameraContainer = document.getElementById('camera-container');
        this.scheduleText = document.getElementById('schedule-text');
        this.scheduleType = document.getElementById('schedule-type');
        this.startTime = document.getElementById('start-time');
        this.attendanceStatus = document.getElementById('attendance-status');
        this.errorMessage = document.getElementById('error-message');
        this.currentStream = null;
        this.currentFacingMode = 'environment';
        this.photoBlob = null;
        this.currentPosition = null;
        this.watchId = null;
        this.schedule = null;
        this.init();
    }

    async init() {
        this.setupEventListeners();
        this.updateTime();
        setInterval(() => this.updateTime(), 1000);
        await this.requestPermissions();
        await this.checkSchedule();
        this.startCamera();
        this.watchPosition();
    }

    setupEventListeners() {
        this.captureBtn.addEventListener('click', () => this.capturePhoto());
        this.submitBtn.addEventListener('click', () => this.submitAttendance());
        this.retakeBtn.addEventListener('click', () => this.retakePhoto());
        this.switchCameraBtn.addEventListener('click', () => this.switchCamera());
    }

    updateTime() {
        const now = new Date();
        const timeStr = now.toLocaleString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('current-time').textContent = timeStr;
        this.updateAttendanceStatus();
    }

    async requestPermissions() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: this.currentFacingMode } });
            stream.getTracks().forEach(track => track.stop());
            return true;
        } catch (error) {
            this.showError('Akses kamera diperlukan untuk absensi.');
            return false;
        }
    }

    async startCamera() {
        if (this.currentStream) this.currentStream.getTracks().forEach(track => track.stop());
        try {
            this.currentStream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: this.currentFacingMode, width: { ideal: 1280 }, height: { ideal: 720 } }
            });
            this.video.srcObject = this.currentStream;
            this.video.onloadedmetadata = () => {
                this.captureBtn.disabled = false;
                this.switchCameraBtn.disabled = false;
            };
        } catch (error) {
            this.showError('Gagal mengakses kamera: ' + error.message);
        }
    }

    async switchCamera() {
        this.currentFacingMode = this.currentFacingMode === 'environment' ? 'user' : 'environment';
        await this.startCamera();
    }

    capturePhoto() {
        const context = this.canvas.getContext('2d');
        this.canvas.width = this.video.videoWidth;
        this.canvas.height = this.video.videoHeight;
        context.drawImage(this.video, 0, 0);
        this.canvas.toBlob((blob) => {
            this.photoBlob = blob;
            this.previewImage.src = URL.createObjectURL(blob);
            this.cameraContainer.style.display = 'none';
            this.previewContainer.style.display = 'block';
            this.submitBtn.disabled = !this.photoBlob || !this.currentPosition || !this.schedule;
        }, 'image/jpeg', 0.9);
    }

    retakePhoto() {
        this.cameraContainer.style.display = 'block';
        this.previewContainer.style.display = 'none';
        if (this.previewImage.src) URL.revokeObjectURL(this.previewImage.src);
        this.photoBlob = null;
        this.submitBtn.disabled = true;
    }

    watchPosition() {
        if (!navigator.geolocation) {
            this.showError('GPS tidak didukung oleh perangkat ini.');
            return;
        }
        this.watchId = navigator.geolocation.watchPosition(
            (pos) => this.onPositionSuccess(pos),
            (err) => this.onPositionError(err),
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 30000 }
        );
    }

    onPositionSuccess(position) {
        this.currentPosition = position;
        const accuracy = Math.round(position.coords.accuracy);
        document.getElementById('accuracy-value').textContent = accuracy + ' m';
        document.getElementById('lat-value').textContent = position.coords.latitude.toFixed(6);
        document.getElementById('lng-value').textContent = position.coords.longitude.toFixed(6);
        const statusEl = document.getElementById('gps-status');
        const textEl = document.getElementById('gps-text');
        textEl.textContent = accuracy <= 10 ? 'GPS Sangat Akurat' :
                             accuracy <= 50 ? 'GPS Akurat' :
                             accuracy <= 100 ? 'GPS Cukup Akurat' :
                             'GPS Kurang Akurat. Pindah ke lokasi terbuka untuk akurasi <100 meter.';
        statusEl.className = 'gps-status p-2 mb-2 rounded text-white ' +
                            (accuracy <= 10 ? 'bg-success' : accuracy <= 50 ? 'bg-info' : accuracy <= 100 ? 'bg-warning' : 'bg-danger');
        if (accuracy > 100) {
            this.showError('Akurasi GPS terlalu rendah (' + accuracy + ' m). Pindah ke lokasi terbuka.');
        }
        this.submitBtn.disabled = !this.photoBlob || !this.schedule;
    }

    onPositionError(error) {
        this.showError('GPS error: ' + error.message);
        document.getElementById('gps-text').textContent = 'GPS error: ' + error.message;
        document.getElementById('gps-status').className = 'gps-status p-2 mb-2 rounded text-white bg-danger';
        this.submitBtn.disabled = true;
    }

    showError(message) {
        this.errorMessage.textContent = message;
        this.errorMessage.classList.remove('hidden');
        setTimeout(() => {
            this.errorMessage.classList.add('hidden');
        }, 5000);
    }

    async checkSchedule() {
        try {
            const response = await fetch('{{ route("attendance.check-schedule") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const data = await response.json();
            if (data.success) {
                this.schedule = data.schedule;
                this.scheduleText.textContent = 'Jadwal ditemukan untuk hari ini.';
                this.scheduleType.textContent = data.schedule.is_fulltime ? 'Full-Time' : 'Shift';
                this.startTime.textContent = data.schedule.start_time;
                this.updateAttendanceStatus();
            } else {
                this.showError(data.message || 'Tidak ada jadwal untuk hari ini. Hubungi admin.');
                this.scheduleText.textContent = data.message || 'Tidak ada jadwal untuk hari ini. Hubungi admin.';
                this.scheduleType.textContent = '-';
                this.startTime.textContent = '-';
                this.attendanceStatus.textContent = '-';
                this.attendanceStatus.className = '';
                this.submitBtn.disabled = true;
            }
        } catch (err) {
            this.showError('Gagal memeriksa jadwal: ' + err.message);
            this.scheduleText.textContent = 'Gagal memeriksa jadwal. Hubungi admin.';
            this.scheduleType.textContent = '-';
            this.startTime.textContent = '-';
            this.attendanceStatus.textContent = '-';
            this.attendanceStatus.className = '';
            this.submitBtn.disabled = true;
        }
    }

    updateAttendanceStatus() {
        if (!this.schedule) {
            this.attendanceStatus.textContent = '-';
            return;
        }
        const now = new Date();
        const startTime = new Date();
        const [hours, minutes] = this.schedule.start_time.split(':');
        startTime.setHours(parseInt(hours), parseInt(minutes), 0);
        const diffMinutes = Math.max(0, (now - startTime) / 1000 / 60);
        let status = '';
        let statusClass = '';
        if (diffMinutes < 15) {
            status = 'Hadir';
            statusClass = 'text-green-600';
        } else if (diffMinutes >= 15 && diffMinutes <= 30) {
            status = 'Terlambat';
            statusClass = 'text-yellow-600';
        } else {
            status = 'Absen';
            statusClass = 'text-red-600';
        }
        this.attendanceStatus.textContent = status;
        this.attendanceStatus.className = 'font-bold ' + statusClass;
    }

    async submitAttendance() {
        
        if (!this.photoBlob) return this.showError('Ambil foto terlebih dahulu');
        if (!this.currentPosition) return this.showError('GPS belum tersedia');
        if (!this.schedule) return this.showError('Tidak ada jadwal untuk hari ini');
        this.submitBtn.disabled = true;
        this.submitBtn.querySelector('.loading-spinner').style.display = 'inline-block';
        try {
            const formData = new FormData();
            formData.append('photo', this.photoBlob, 'attendance.jpg');
            formData.append('latitude', String(this.currentPosition.coords.latitude));
            formData.append('longitude', String(this.currentPosition.coords.longitude));
            formData.append('accuracy', String(this.currentPosition.coords.accuracy));
            formData.append('_token', '{{ csrf_token() }}');
            const response = await fetch('{{ route("attendance.camera.submit") }}', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            if (!data.success) {
                this.showError('Error: ' + data.message);
            } else {
                alert('Absensi berhasil: ' + data.message + ' (Status: ' + data.attendance_status + ')');
                this.retakePhoto();
                await this.checkSchedule();
            }
        } catch (err) {
            this.showError('Terjadi error saat submit absensi: ' + err.message);
        } finally {
            this.submitBtn.disabled = !this.photoBlob || !this.currentPosition || !this.schedule;
            this.submitBtn.querySelector('.loading-spinner').style.display = 'none';
        }
    }

    destroy() {
        if (this.currentStream) this.currentStream.getTracks().forEach(track => track.stop());
        if (this.watchId) navigator.geolocation.clearWatch(this.watchId);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.attendanceCamera = new AttendanceCamera();
});
window.addEventListener('beforeunload', () => {
    if (window.attendanceCamera) window.attendanceCamera.destroy();
});
