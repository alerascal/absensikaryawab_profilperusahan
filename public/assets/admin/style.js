document.addEventListener('DOMContentLoaded', () => {
    console.log("Camera Attendance Module Initialized");

    // DOM Elements for Camera Attendance
    const elements = {
        video: document.getElementById('video'),
        canvas: document.getElementById('canvas'),
        captureBtn: document.getElementById('captureBtn'),
        photoInput: document.getElementById('photoInput'),
        photoPreview: document.getElementById('photoPreview'),
        statusMessage: document.getElementById('statusMessage'),
        submitBtn: document.getElementById('submitBtn'),
        form: document.getElementById('attendanceForm')
    };

    // State for Camera and Location
    let state = {
        stream: null,
        cameraReady: false,
        locationReady: false,
        photoCaptured: false
    };

    // Initialize Camera and Location if elements exist
    function initializeCameraAttendance() {
        if (elements.video && elements.canvas) {
            initializeCameraAndLocation();
            setupCameraEventListeners();
        }
    }

    // Camera Functions - Sesuai dengan AttendanceController@cameraAttendance
    function startCamera() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            if (elements.statusMessage) {
                elements.statusMessage.innerHTML = "❌ Browser tidak mendukung kamera!";
            }
            state.cameraReady = false;
            updateButtonStates();
            return;
        }

        // Prevent starting camera if stream is already active
        if (state.stream) {
            console.log("Camera stream already active, skipping...");
            return;
        }

        if (elements.statusMessage) {
            elements.statusMessage.innerHTML = "🔄 Meminta akses kamera...";
        }
        
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } })
            .then(mediaStream => {
                if (!elements.video) {
                    if (elements.statusMessage) {
                        elements.statusMessage.innerHTML = "❌ Elemen video tidak ditemukan!";
                    }
                    state.cameraReady = false;
                    updateButtonStates();
                    return;
                }

                // Ensure no existing stream is active
                if (elements.video.srcObject) {
                    elements.video.srcObject.getTracks().forEach(track => track.stop());
                }

                state.stream = mediaStream;
                elements.video.srcObject = mediaStream;

                // Tunggu metadata loaded sebelum play untuk mencegah AbortError
                elements.video.addEventListener('loadedmetadata', () => {
                    elements.video.play().then(() => {
                        state.cameraReady = true;
                        if (elements.statusMessage) {
                            elements.statusMessage.innerHTML = "✅ Kamera aktif, siap mengambil foto!";
                        }
                        updateButtonStates();
                    }).catch(err => {
                        console.error('Video play error:', err);
                        if (elements.statusMessage) {
                            elements.statusMessage.innerHTML = `❌ Gagal memutar video: ${err.message}`;
                        }
                        state.cameraReady = false;
                        updateButtonStates();
                        stopCamera();
                    });
                }, { once: true }); // Listener hanya sekali
            })
            .catch(err => {
                console.error('Gagal mengakses kamera:', err);
                if (elements.statusMessage) {
                    elements.statusMessage.innerHTML = `❌ Gagal mengakses kamera: ${err.message}`;
                }
                state.cameraReady = false;
                updateButtonStates();
            });
    }

    function stopCamera() {
        if (state.stream) {
            state.stream.getTracks().forEach(track => track.stop());
            state.stream = null;
            if (elements.video) {
                elements.video.srcObject = null;
            }
        }
    }

    // Location Functions - Sesuai dengan location validation di controller
    function getLocation() {
        if (!navigator.geolocation) {
            if (elements.statusMessage) {
                elements.statusMessage.innerHTML = "❌ Browser tidak mendukung geolocation! Silakan gunakan perangkat yang mendukung.";
            }
            state.locationReady = false;
            updateButtonStates();
            return;
        }

        if (elements.statusMessage) {
            elements.statusMessage.innerHTML = "🔄 Meminta akses lokasi...";
        }
        
        navigator.geolocation.getCurrentPosition(
            position => {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                const accuracy = position.coords.accuracy;
                console.log(`Latitude: ${lat}, Longitude: ${lon}, Accuracy: ${accuracy} meters`);
                
                const latInput = document.getElementById('latitude');
                const lonInput = document.getElementById('longitude');
                
                if (latInput) latInput.value = lat;
                if (lonInput) lonInput.value = lon;
                
                state.locationReady = true;
                if (elements.statusMessage) {
                    elements.statusMessage.innerHTML = `✅ Lokasi berhasil didapatkan! (Akurasi: ${accuracy.toFixed(1)} meter)`;
                }
                updateButtonStates();
            },
            error => {
                console.error('Geolocation error:', error);
                let errMsg = `❌ Gagal mendapatkan lokasi: ${error.message}`;
                
                if (error.code === error.PERMISSION_DENIED) {
                    errMsg = `❌ Izin lokasi ditolak. Silakan aktifkan izin lokasi di pengaturan browser. <button onclick="getLocation()" class="btn btn-sm btn-primary">Coba Lagi</button>`;
                } else if (error.code === error.POSITION_UNAVAILABLE) {
                    errMsg = `❌ Lokasi tidak tersedia. Pastikan GPS aktif dan coba di area terbuka. <button onclick="getLocation()" class="btn btn-sm btn-primary">Coba Lagi</button>`;
                } else if (error.code === error.TIMEOUT) {
                    errMsg = `❌ Waktu habis untuk mendapatkan lokasi. Coba lagi. <button onclick="getLocation()" class="btn btn-sm btn-primary">Coba Lagi</button>`;
                }
                
                if (elements.statusMessage) {
                    elements.statusMessage.innerHTML = errMsg;
                }
                state.locationReady = false;
                updateButtonStates();
            },
            { 
                enableHighAccuracy: true, 
                timeout: 15000, 
                maximumAge: 0 
            }
        );
    }

    // Button States Management
    function updateButtonStates() {
        if (elements.captureBtn) {
            elements.captureBtn.disabled = !(state.cameraReady && state.locationReady);
        }
        if (elements.submitBtn) {
            elements.submitBtn.disabled = !(state.cameraReady && state.locationReady && state.photoCaptured);
        }
    }

    // Capture Photo Function
    function handleCapture() {
        if (!elements.canvas || !elements.video) return;

        elements.canvas.width = elements.video.videoWidth;
        elements.canvas.height = elements.video.videoHeight;
        elements.canvas.getContext('2d').drawImage(elements.video, 0, 0, elements.canvas.width, elements.canvas.height);

        elements.canvas.toBlob(blob => {
            const file = new File([blob], 'attendance.png', { type: 'image/png' });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            
            if (elements.photoInput) {
                elements.photoInput.files = dataTransfer.files;
            }

            if (elements.photoPreview) {
                elements.photoPreview.src = URL.createObjectURL(file);
                elements.photoPreview.style.display = 'block';
            }
            
            state.photoCaptured = true;
            updateButtonStates();
            
            if (elements.statusMessage) {
                elements.statusMessage.innerHTML = "✅ Foto berhasil diambil!";
            }
            stopCamera();
        }, 'image/png', 0.8);
    }

    // Form Submission - Sesuai dengan AttendanceController@cameraAttendance
    function handleFormSubmit(e) {
        e.preventDefault();
        
        if (!state.photoCaptured) {
            if (elements.statusMessage) {
                elements.statusMessage.innerHTML = "❌ Harap ambil foto terlebih dahulu!";
            }
            return;
        }

        const formData = new FormData(elements.form);
        
        // Debug: Log form data
        console.log('Form Data:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
        
        // Get CSRF token from meta tag or Laravel object
        const csrfToken = window.Laravel?.csrfToken || 
                         document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (!csrfToken) {
            console.error('CSRF token tidak tersedia!');
            if (elements.statusMessage) {
                elements.statusMessage.innerHTML = "❌ CSRF token tidak tersedia. Silakan muat ulang halaman.";
            }
            if (elements.submitBtn) elements.submitBtn.disabled = false;
            return;
        }

        formData.append('_token', csrfToken);

        if (elements.submitBtn) elements.submitBtn.disabled = true;
        if (elements.statusMessage) {
            elements.statusMessage.innerHTML = "⏳ Mengirim absensi...";
        }

        // Route sesuai dengan AttendanceController@cameraAttendance
        const url = window.Laravel?.attendanceRoute || '/attendance/camera';

        fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Pastikan Laravel mengembalikan JSON
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                // Store response status for later use
                const responseStatus = response.status;
                
                // Check if response is actually JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error(`Server mengembalikan ${contentType} bukan JSON. Status: ${response.status}`);
                }
                
                return response.json().then(data => {
                    // Add status to data object
                    data._responseStatus = responseStatus;
                    return data;
                });
            })
            .then(data => {
                console.log('Response data:', data);
                
                if (data.success) {
                    if (elements.statusMessage) {
                        elements.statusMessage.innerHTML = `✅ ${data.message}`;
                    }
                    // Show success notification if available
                    if (window.showNotification) {
                        window.showNotification(data.message, "success");
                    }
                    setTimeout(() => location.reload(), 2000);
                } else {
                    let errMsg = data.message || 'Gagal mencatat absensi. Pastikan Anda berada di lokasi yang valid.';
                    
                    // Handle validation errors (422)
                    if (data.errors) {
                        console.error('Validation errors:', data.errors);
                        errMsg = Object.values(data.errors).flat().join('<br>');
                    }
                    
                    // Handle location errors (403)
                    if (data._responseStatus === 403) {
                        console.error('Location validation failed');
                        errMsg += '<br><br><strong>Tips:</strong><ul>';
                        errMsg += '<li>Pastikan GPS aktif dan akurat</li>';
                        errMsg += '<li>Coba di area terbuka</li>';
                        errMsg += '<li>Periksa pengaturan lokasi browser</li>';
                        errMsg += '</ul>';
                    }
                    
                    if (elements.statusMessage) {
                        elements.statusMessage.innerHTML = `❌ ${errMsg} <button onclick="getLocation()" class="btn btn-sm btn-primary">Coba Lokasi Lagi</button>`;
                    }
                    if (elements.submitBtn) elements.submitBtn.disabled = false;
                    
                    // Show error notification if available
                    if (window.showNotification) {
                        window.showNotification(errMsg.replace(/<[^>]*>/g, ''), "error");
                    }
                }
            })
            .catch(err => {
                console.error('Fetch error:', err);
                
                let errorMsg = 'Terjadi kesalahan saat mengirim absensi';
                
                if (err.message.includes('JSON')) {
                    errorMsg = 'Server error - mungkin route tidak ditemukan atau CSRF token invalid';
                } else if (err.message.includes('NetworkError') || err.message.includes('Failed to fetch')) {
                    errorMsg = 'Masalah koneksi internet - coba lagi';
                }
                
                if (elements.statusMessage) {
                    elements.statusMessage.innerHTML = `❌ ${errorMsg}. <button onclick="location.reload()" class="btn btn-sm btn-primary">Muat Ulang</button>`;
                }
                if (elements.submitBtn) elements.submitBtn.disabled = false;
                
                // Show error notification if available
                if (window.showNotification) {
                    window.showNotification(errorMsg, "error");
                }
            });
    }

    // Event Listeners for Camera Attendance
    function setupCameraEventListeners() {
        if (elements.captureBtn) {
            elements.captureBtn.addEventListener('click', handleCapture);
        }

        if (elements.form) {
            elements.form.addEventListener('submit', handleFormSubmit);
        }

        // Cleanup camera stream when leaving page
        window.addEventListener('beforeunload', stopCamera);
    }

    // Initialize Camera and Location
    function initializeCameraAndLocation() {
        getLocation();
        startCamera();
    }

    // Expose functions globally for HTML onclick handlers
    window.getLocation = getLocation;
    window.startCamera = startCamera;
    window.stopCamera = stopCamera;

    // Auto-initialize if we're on camera attendance page
    initializeCameraAttendance();
});