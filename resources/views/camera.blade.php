@extends('layouts.app')
@section('title', 'Absensi Kamera')
@section('content')

<style>
/* Custom Styles for Attendance Camera */
.attendance-wrapper {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1.5rem;
}

.attendance-container {
    max-width: 1000px;
    margin: 0 auto;
}

/* Header Card */
.header-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    padding: 2rem;
    margin-bottom: 1.5rem;
    text-align: center;
    animation: slideDown 0.5s ease-out;
}

.header-icon-wrapper {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.header-icon-wrapper svg {
    width: 35px;
    height: 35px;
    color: white;
}

.header-title {
    font-size: 2rem;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.header-subtitle {
    color: #6b7280;
    font-size: 0.95rem;
}

/* Time Card */
.time-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.time-card:hover {
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.time-display {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.time-icon {
    width: 24px;
    height: 24px;
    color: #667eea;
}

.time-text {
    font-size: 1.1rem;
    font-weight: 700;
    color: #374151;
}

/* Status Card */
.status-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.status-card:hover {
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.status-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.status-icon-box {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.status-icon-box svg {
    width: 24px;
    height: 24px;
    color: #3b82f6;
}

.status-content {
    flex: 1;
}

.status-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.status-text {
    color: #6b7280;
    font-size: 0.9rem;
}

.status-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 0.75rem;
}

.status-item {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    border: 1px solid #e5e7eb;
}

.status-label {
    font-size: 0.75rem;
    color: #6b7280;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.status-value {
    font-size: 1rem;
    font-weight: 700;
    color: #1f2937;
}

/* GPS Card */
.gps-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.gps-card:hover {
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.gps-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1rem;
}

.gps-icon-box {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.gps-icon-box svg {
    width: 24px;
    height: 24px;
    color: #059669;
}

.gps-content {
    flex: 1;
}

.gps-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.gps-status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.9rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.gps-status-text {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.gps-coordinates {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.coordinate-box {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border-radius: 10px;
    padding: 0.85rem;
    text-align: center;
}

.coordinate-label {
    font-size: 0.7rem;
    color: #1e40af;
    margin-bottom: 0.4rem;
    font-weight: 600;
}

.coordinate-value {
    font-size: 0.85rem;
    font-weight: 700;
    color: #1f2937;
}

/* Location Selector */
.location-selector {
    border-top: 2px solid #f3f4f6;
    padding-top: 1rem;
}

.location-selector-label {
    font-size: 0.85rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.6rem;
    display: block;
}

.location-select {
    width: 100%;
    padding: 0.85rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    color: #1f2937;
    background: white;
    transition: all 0.3s ease;
}

.location-select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.distance-info {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.5rem;
}

/* Camera Card */
.camera-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.camera-card:hover {
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
}

.camera-wrapper {
    position: relative;
    background: #000;
    border-radius: 16px 16px 0 0;
    overflow: hidden;
}

.camera-video {
    width: 100%;
    height: auto;
    display: block;
}

.camera-controls {
    position: absolute;
    bottom: 1.5rem;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 0.75rem;
    z-index: 10;
}

.btn-camera {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.85rem 1.5rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.9rem;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-camera:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
}

.btn-camera:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.btn-camera-secondary {
    background: rgba(255, 255, 255, 0.9);
    color: #374151;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.btn-camera-secondary:hover:not(:disabled) {
    background: white;
}

/* Preview Card */
.preview-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.preview-image {
    width: 100%;
    height: auto;
    display: block;
}

.preview-actions {
    padding: 1.25rem;
    display: flex;
    gap: 0.75rem;
}

.btn-action {
    flex: 1;
    padding: 0.85rem 1.5rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.9rem;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-retake {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
}

.btn-retake:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
}

.btn-submit {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    position: relative;
}

.btn-submit:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.loading-spinner {
    position: absolute;
    left: 1rem;
    width: 20px;
    height: 20px;
    border: 2px solid white;
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

/* Locations Card */
.locations-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.locations-card:hover {
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.locations-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.locations-icon-box {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.locations-icon-box svg {
    width: 24px;
    height: 24px;
    color: #6366f1;
}

.locations-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1f2937;
}

.locations-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.location-item {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 12px;
    padding: 1rem;
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
}

.location-item:hover {
    border-color: #667eea;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
}

.location-item.in-range {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border-color: #10b981;
}

.location-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
}

.location-info {
    flex: 1;
}

.location-name {
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.4rem;
    font-size: 0.95rem;
}

.location-coordinates {
    font-size: 0.75rem;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 0.3rem;
    margin-bottom: 0.3rem;
}

.location-distance-text {
    font-size: 0.75rem;
    color: #059669;
    font-weight: 600;
}

.location-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.4rem;
}

.location-radius-badge {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 1rem;
    backdrop-filter: blur(4px);
}

.modal-content {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    max-width: 480px;
    width: 100%;
    animation: modalSlide 0.3s ease-out;
}

.modal-header {
    padding: 1.75rem 1.75rem 1rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.modal-icon-box {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.modal-icon-box svg {
    width: 28px;
    height: 28px;
}

.modal-text {
    flex: 1;
}

.modal-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.modal-message {
    color: #6b7280;
    font-size: 0.95rem;
    line-height: 1.5;
}

.modal-close {
    background: none;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    padding: 0.25rem;
    transition: color 0.3s ease;
}

.modal-close:hover {
    color: #374151;
}

.modal-footer {
    padding: 1rem 1.75rem 1.75rem;
}

.btn-modal {
    width: 100%;
    padding: 0.95rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-modal:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

/* Animations */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes modalSlide {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .attendance-wrapper {
        padding: 1rem;
    }

    .header-card {
        padding: 1.5rem;
    }

    .header-title {
        font-size: 1.6rem;
    }

    .time-card,
    .status-card,
    .gps-card,
    .locations-card {
        padding: 1.25rem;
    }

    .status-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .gps-coordinates {
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
    }

    .coordinate-box {
        padding: 0.7rem;
    }

    .coordinate-label {
        font-size: 0.65rem;
    }

    .coordinate-value {
        font-size: 0.8rem;
    }

    .camera-controls {
        gap: 0.5rem;
        bottom: 1rem;
    }

    .btn-camera {
        padding: 0.7rem 1.2rem;
        font-size: 0.85rem;
    }

    .preview-actions {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .attendance-wrapper {
        padding: 0.75rem;
    }

    .header-card {
        padding: 1.25rem;
        margin-bottom: 1rem;
    }

    .header-icon-wrapper {
        width: 56px;
        height: 56px;
    }

    .header-icon-wrapper svg {
        width: 28px;
        height: 28px;
    }

    .header-title {
        font-size: 1.4rem;
    }

    .header-subtitle {
        font-size: 0.85rem;
    }

    .time-card,
    .status-card,
    .gps-card,
    .locations-card {
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .time-text {
        font-size: 0.95rem;
    }

    .status-grid {
        grid-template-columns: 1fr;
    }

    .gps-coordinates {
        gap: 0.4rem;
    }

    .coordinate-box {
        padding: 0.6rem;
    }

    .camera-controls {
        flex-direction: column;
        width: calc(100% - 2rem);
        gap: 0.5rem;
    }

    .btn-camera {
        width: 100%;
        justify-content: center;
    }

    .location-content {
        flex-direction: column;
    }

    .location-meta {
        align-items: flex-start;
        flex-direction: row;
        gap: 0.5rem;
    }

    .modal-content {
        margin: 1rem;
    }

    .modal-header {
        padding: 1.25rem;
    }

    .modal-title {
        font-size: 1.2rem;
    }

    .modal-footer {
        padding: 0 1.25rem 1.25rem;
    }
}
</style>

<div class="attendance-wrapper">
    <div class="attendance-container">
        <!-- Header -->
        <div class="header-card">
            <div class="header-icon-wrapper">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h1 class="header-title">Absensi Kamera</h1>
            <p class="header-subtitle">Pastikan kamera dan GPS aktif untuk melakukan absensi</p>
        </div>

        <!-- Current Time -->
        <div class="time-card">
            <div class="time-display">
                <svg class="time-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span id="current-time" class="time-text"></span>
            </div>
        </div>

        <!-- Schedule Status -->
        <div class="status-card">
            <div class="status-header">
                <div class="status-icon-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="status-content">
                    <h3 class="status-title">Status Jadwal</h3>
                    <p id="schedule-text" class="status-text">Memeriksa jadwal...</p>
                </div>
            </div>
            <div class="status-grid">
                <div class="status-item">
                    <p class="status-label">Jadwal</p>
                    <p id="schedule-type" class="status-value">Memuat...</p>
                </div>
                <div class="status-item">
                    <p class="status-label">Waktu Mulai</p>
                    <p id="start-time" class="status-value">Memuat...</p>
                </div>
                <div class="status-item">
                    <p class="status-label">Status</p>
                    <p id="attendance-status" class="status-value">Memuat...</p>
                </div>
            </div>
        </div>

        <!-- GPS & Location -->
        <div class="gps-card">
            <div class="gps-header">
                <div class="gps-icon-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div class="gps-content">
                    <h3 class="gps-title">Lokasi GPS</h3>
                    <div id="gps-status" class="gps-status-badge">Mendeteksi GPS...</div>
                    <p id="gps-text" class="gps-status-text">Menunggu GPS...</p>
                </div>
            </div>
            <div class="gps-coordinates">
                <div class="coordinate-box">
                    <p class="coordinate-label">Latitude</p>
                    <p id="lat-value" class="coordinate-value">0</p>
                </div>
                <div class="coordinate-box">
                    <p class="coordinate-label">Longitude</p>
                    <p id="lng-value" class="coordinate-value">0</p>
                </div>
                <div class="coordinate-box">
                    <p class="coordinate-label">Akurasi</p>
                    <p id="accuracy-value" class="coordinate-value">0 m</p>
                </div>
            </div>
            
            <!-- Location Selector -->
            <div id="location-selector" class="location-selector" style="display: none;">
                <label class="location-selector-label">Lokasi Absensi Terdekat</label>
                <select id="nearest-location" class="location-select">
                    <option value="">Pilih lokasi...</option>
                </select>
                <p id="distance-info" class="distance-info"></p>
            </div>
        </div>

        <!-- Camera -->
        <div id="camera-container" class="camera-card">
            <div class="camera-wrapper">
                <video id="video" autoplay playsinline class="camera-video"></video>
                <canvas id="canvas" style="display: none;"></canvas>
                <div class="camera-controls">
                    <button id="capture-btn" class="btn-camera" disabled>
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        </svg>
                        Ambil Foto
                    </button>
                    <button id="switch-camera-btn" class="btn-camera btn-camera-secondary" disabled>
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div id="preview-container" class="preview-card" style="display: none;">
            <img id="preview-image" class="preview-image" />
            <div class="preview-actions">
                <button id="retake-btn" class="btn-action btn-retake">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Ulangi Foto
                </button>
                <button id="submit-btn" class="btn-action btn-submit" disabled>
                    <span class="loading-spinner" style="display: none;"></span>
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Kirim Absensi
                </button>
            </div>
        </div>

        <!-- Registered Locations -->
        <div class="locations-card">
            <div class="locations-header">
                <div class="locations-icon-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h2 class="locations-title">Lokasi Absen Terdaftar</h2>
            </div>
            <div class="locations-list">
                @foreach ($attendanceLocations as $loc)
                <div class="location-item" data-location-id="{{ $loc->id }}" data-lat="{{ $loc->latitude }}" data-lng="{{ $loc->longitude }}" data-radius="{{ $loc->radius }}">
                    <div class="location-content">
                        <div class="location-info">
                            <h3 class="location-name">{{ $loc->name }}</h3>
                            <p class="location-coordinates">
                                <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                                {{ $loc->latitude }}, {{ $loc->longitude }}
                            </p>
                            <p class="location-distance-text" style="display: none;">
                                Jarak: <span class="distance-value"></span>
                            </p>
                        </div>
                        <div class="location-meta">
                            <span class="location-radius-badge">Radius {{ $loc->radius }}m</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="notification-modal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <div id="modal-icon" class="modal-icon-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="modal-text">
                <h2 id="modal-title" class="modal-title"></h2>
                <p id="modal-message" class="modal-message"></p>
            </div>
            <button id="close-modal" class="modal-close">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-footer">
            <button id="confirm-modal" class="btn-modal">OK</button>
        </div>
    </div>
</div>

<script>
class AttendanceCamera {
    constructor() {
        this.video = document.getElementById("video");
        this.canvas = document.getElementById("canvas");
        this.captureBtn = document.getElementById("capture-btn");
        this.submitBtn = document.getElementById("submit-btn");
        this.retakeBtn = document.getElementById("retake-btn");
        this.switchCameraBtn = document.getElementById("switch-camera-btn");
        this.previewContainer = document.getElementById("preview-container");
        this.previewImage = document.getElementById("preview-image");
        this.cameraContainer = document.getElementById("camera-container");
        this.scheduleText = document.getElementById("schedule-text");
        this.scheduleType = document.getElementById("schedule-type");
        this.startTime = document.getElementById("start-time");
        this.attendanceStatus = document.getElementById("attendance-status");
        this.notificationModal = document.getElementById("notification-modal");
        this.modalTitle = document.getElementById("modal-title");
        this.modalMessage = document.getElementById("modal-message");
        this.modalIcon = document.getElementById("modal-icon");
        this.closeModalBtn = document.getElementById("close-modal");
        this.confirmModalBtn = document.getElementById("confirm-modal");
        this.locationSelector = document.getElementById("location-selector");
        this.nearestLocationSelect = document.getElementById("nearest-location");
        this.distanceInfo = document.getElementById("distance-info");
        
        this.currentStream = null;
        this.currentFacingMode = "environment";
        this.photoBlob = null;
        this.currentPosition = null;
        this.watchId = null;
        this.schedule = null;
        this.attendanceLocations = [];
        this.selectedLocation = null;
        
        this.init();
    }

    async init() {
        this.loadLocations();
        this.setupEventListeners();
        this.updateTime();
        setInterval(() => this.updateTime(), 1000);
        await this.requestPermissions();
        await this.checkSchedule();
        this.startCamera();
        this.watchPosition();
    }

    loadLocations() {
        const locationElements = document.querySelectorAll('[data-location-id]');
        locationElements.forEach(el => {
            this.attendanceLocations.push({
                id: el.dataset.locationId,
                name: el.querySelector('.location-name').textContent,
                latitude: parseFloat(el.dataset.lat),
                longitude: parseFloat(el.dataset.lng),
                radius: parseFloat(el.dataset.radius),
                element: el
            });
        });
    }

    setupEventListeners() {
        this.captureBtn.addEventListener("click", () => this.capturePhoto());
        this.submitBtn.addEventListener("click", () => this.submitAttendance());
        this.retakeBtn.addEventListener("click", () => this.retakePhoto());
        this.switchCameraBtn.addEventListener("click", () => this.switchCamera());
        this.closeModalBtn.addEventListener("click", () => this.hideModal());
        this.confirmModalBtn.addEventListener("click", () => this.hideModal());
        this.nearestLocationSelect.addEventListener("change", (e) => {
            this.selectedLocation = this.attendanceLocations.find(loc => loc.id === e.target.value);
        });
    }

    updateTime() {
        const now = new Date();
        const timeStr = now.toLocaleString("id-ID", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
        });
        document.getElementById("current-time").textContent = timeStr;
        this.updateAttendanceStatus();
    }

    calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3;
        const φ1 = lat1 * Math.PI / 180;
        const φ2 = lat2 * Math.PI / 180;
        const Δφ = (lat2 - lat1) * Math.PI / 180;
        const Δλ = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) + Math.cos(φ1) * Math.cos(φ2) * Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    updateLocationDistances() {
        if (!this.currentPosition) return;

        const userLat = this.currentPosition.coords.latitude;
        const userLng = this.currentPosition.coords.longitude;

        const locationsWithDistance = this.attendanceLocations.map(loc => {
            const distance = this.calculateDistance(userLat, userLng, loc.latitude, loc.longitude);
            return { ...loc, distance };
        }).sort((a, b) => a.distance - b.distance);

        locationsWithDistance.forEach(loc => {
            const distanceEl = loc.element.querySelector('.location-distance-text');
            if (distanceEl) {
                distanceEl.style.display = 'block';
                const distanceText = loc.distance < 1000 
                    ? `${Math.round(loc.distance)} m`
                    : `${(loc.distance / 1000).toFixed(2)} km`;
                distanceEl.querySelector('.distance-value').textContent = distanceText;
                
                if (loc.distance <= loc.radius) {
                    loc.element.classList.add('in-range');
                } else {
                    loc.element.classList.remove('in-range');
                }
            }
        });

        this.nearestLocationSelect.innerHTML = '<option value="">Pilih lokasi...</option>';
        locationsWithDistance.forEach((loc, index) => {
            const option = document.createElement('option');
            option.value = loc.id;
            const distanceText = loc.distance < 1000 
                ? `${Math.round(loc.distance)} m`
                : `${(loc.distance / 1000).toFixed(2)} km`;
            option.textContent = `${loc.name} (${distanceText})`;
            if (index === 0) {
                option.selected = true;
                this.selectedLocation = loc;
            }
            this.nearestLocationSelect.appendChild(option);
        });

        this.locationSelector.style.display = 'block';

        if (locationsWithDistance.length > 0) {
            const nearest = locationsWithDistance[0];
            const distanceText = nearest.distance < 1000 
                ? `${Math.round(nearest.distance)} m`
                : `${(nearest.distance / 1000).toFixed(2)} km`;
            this.distanceInfo.textContent = `Lokasi terdekat: ${nearest.name} (${distanceText})`;
            
            if (nearest.distance > nearest.radius) {
                this.distanceInfo.style.color = '#ef4444';
                this.distanceInfo.textContent += ` - Di luar jangkauan (radius ${nearest.radius}m)`;
            } else {
                this.distanceInfo.style.color = '#059669';
            }
        }
    }

    async requestPermissions() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: this.currentFacingMode },
            });
            stream.getTracks().forEach((track) => track.stop());
            return true;
        } catch (error) {
            this.showModal("Error", "Akses kamera diperlukan untuk absensi.", "error");
            return false;
        }
    }

    async startCamera() {
        if (this.currentStream)
            this.currentStream.getTracks().forEach((track) => track.stop());
        try {
            this.currentStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: this.currentFacingMode,
                    width: { ideal: 1280 },
                    height: { ideal: 720 },
                },
            });
            this.video.srcObject = this.currentStream;
            this.video.onloadedmetadata = () => {
                this.captureBtn.disabled = false;
                this.switchCameraBtn.disabled = false;
            };
        } catch (error) {
            this.showModal("Error", "Gagal mengakses kamera: " + error.message, "error");
        }
    }

    async switchCamera() {
        this.currentFacingMode = this.currentFacingMode === "environment" ? "user" : "environment";
        await this.startCamera();
    }

    capturePhoto() {
        const context = this.canvas.getContext("2d");
        this.canvas.width = this.video.videoWidth;
        this.canvas.height = this.video.videoHeight;
        context.drawImage(this.video, 0, 0);
        this.canvas.toBlob(
            (blob) => {
                this.photoBlob = blob;
                this.previewImage.src = URL.createObjectURL(blob);
                this.cameraContainer.style.display = "none";
                this.previewContainer.style.display = "block";
                this.submitBtn.disabled = !this.photoBlob || !this.currentPosition || !this.schedule;
            },
            "image/jpeg",
            0.9
        );
    }

    retakePhoto() {
        this.cameraContainer.style.display = "block";
        this.previewContainer.style.display = "none";
        if (this.previewImage.src)
            URL.revokeObjectURL(this.previewImage.src);
        this.photoBlob = null;
        this.submitBtn.disabled = true;
    }

    watchPosition() {
        if (!navigator.geolocation) {
            this.showModal("Error", "GPS tidak didukung oleh perangkat ini.", "error");
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
        
        document.getElementById("accuracy-value").textContent = accuracy + " m";
        document.getElementById("lat-value").textContent = position.coords.latitude.toFixed(6);
        document.getElementById("lng-value").textContent = position.coords.longitude.toFixed(6);
        
        const statusEl = document.getElementById("gps-status");
        const textEl = document.getElementById("gps-text");
        
        if (accuracy <= 10) {
            textEl.textContent = "GPS Sangat Akurat - Siap untuk absensi";
            statusEl.style.background = "linear-gradient(135deg, #10b981 0%, #059669 100%)";
            statusEl.style.color = "white";
        } else if (accuracy <= 50) {
            textEl.textContent = "GPS Akurat - Siap untuk absensi";
            statusEl.style.background = "linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)";
            statusEl.style.color = "white";
        } else if (accuracy <= 100) {
            textEl.textContent = "GPS Cukup Akurat - Dapat digunakan untuk absensi";
            statusEl.style.background = "linear-gradient(135deg, #f59e0b 0%, #d97706 100%)";
            statusEl.style.color = "white";
        } else {
            textEl.textContent = "GPS Kurang Akurat - Pindah ke lokasi terbuka";
            statusEl.style.background = "linear-gradient(135deg, #ef4444 0%, #dc2626 100%)";
            statusEl.style.color = "white";
            this.showModal("Peringatan", "Akurasi GPS terlalu rendah (" + accuracy + " m). Pindah ke lokasi terbuka untuk hasil lebih baik.", "warning");
        }
        
        this.updateLocationDistances();
        this.submitBtn.disabled = !this.photoBlob || !this.schedule;
    }

    onPositionError(error) {
        this.showModal("Error", "GPS error: " + error.message, "error");
        document.getElementById("gps-text").textContent = "GPS error: " + error.message;
        const statusEl = document.getElementById("gps-status");
        statusEl.style.background = "linear-gradient(135deg, #ef4444 0%, #dc2626 100%)";
        statusEl.style.color = "white";
        this.submitBtn.disabled = true;
    }

    showModal(title, message, type = "info") {
        this.modalTitle.textContent = title;
        this.modalMessage.textContent = message;
        
        const iconHTML = {
            success: '<svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            error: '<svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            warning: '<svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
            info: '<svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        };
        
        const bgColor = {
            success: 'linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%)',
            error: 'linear-gradient(135deg, #fee2e2 0%, #fecaca 100%)',
            warning: 'linear-gradient(135deg, #fef3c7 0%, #fde68a 100%)',
            info: 'linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%)'
        };
        
        const iconColor = {
            success: '#059669',
            error: '#dc2626',
            warning: '#d97706',
            info: '#2563eb'
        };
        
        this.modalIcon.style.background = bgColor[type];
        this.modalIcon.innerHTML = iconHTML[type];
        this.modalIcon.querySelector('svg').style.color = iconColor[type];
        
        this.notificationModal.style.display = 'flex';
    }

    hideModal() {
        this.notificationModal.style.display = 'none';
    }

    async checkSchedule() {
        try {
            const response = await fetch('{{ route("attendance.check-schedule") }}', {
                method: "GET",
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
            });

            const data = await response.json();

            if (!data.success) {
                this.showModal("Peringatan", data.message || "Tidak ada jadwal untuk hari ini.", "warning");
                this.scheduleText.textContent = data.message || "Tidak ada jadwal untuk hari ini.";
                this.scheduleType.textContent = "-";
                this.startTime.textContent = "-";
                this.attendanceStatus.textContent = "-";
                this.submitBtn.disabled = true;
                return;
            }

            if (data.is_holiday) {
                this.scheduleText.textContent = "Hari ini adalah libur nasional / akhir pekan.";
                this.scheduleType.textContent = "-";
                this.startTime.textContent = "-";
                this.attendanceStatus.textContent = "LIBUR";
                this.attendanceStatus.style.color = "#3b82f6";
                this.showModal("Info", "Hari ini libur. Absensi tidak diperlukan.", "info");
                this.submitBtn.disabled = true;
                return;
            }

            if (data.approval && data.approval.status === "approved") {
                this.scheduleText.textContent = "Absensi otomatis berdasarkan pengajuan.";
                this.scheduleType.textContent = "-";
                this.startTime.textContent = "-";
                this.attendanceStatus.textContent = data.approval.type.toUpperCase();
                this.attendanceStatus.style.color = "#8b5cf6";
                this.showModal("Info", "Pengajuan anda sudah disetujui. Absensi otomatis tercatat.", "info");
                this.submitBtn.disabled = true;
                return;
            }

            if (data.has_attendance) {
                this.scheduleText.textContent = "Anda sudah absen hari ini.";
                this.scheduleType.textContent = "-";
                this.startTime.textContent = "-";
                this.attendanceStatus.textContent = data.attendance.status || "SUDAH ABSEN";
                this.attendanceStatus.style.color = "#6b7280";
                this.showModal("Info", "Anda sudah melakukan absensi hari ini.", "info");
                this.submitBtn.disabled = true;
                return;
            }

            this.schedule = data.schedule;
            this.scheduleText.textContent = "Jadwal ditemukan untuk hari ini. Silakan lakukan absensi.";
            this.scheduleType.textContent = data.schedule.is_fulltime ? "Full-Time" : "Shift";
            this.startTime.textContent = data.schedule.start_time;
            this.updateAttendanceStatus();
        } catch (err) {
            this.showModal("Error", "Gagal memeriksa jadwal: " + err.message, "error");
            this.scheduleText.textContent = "Gagal memeriksa jadwal. Hubungi admin.";
            this.scheduleType.textContent = "-";
            this.startTime.textContent = "-";
            this.attendanceStatus.textContent = "-";
            this.submitBtn.disabled = true;
        }
    }

    updateAttendanceStatus() {
        if (!this.schedule) {
            this.attendanceStatus.textContent = "-";
            return;
        }
        const now = new Date();
        const startTime = new Date();
        const [hours, minutes] = this.schedule.start_time.split(":");
        startTime.setHours(parseInt(hours), parseInt(minutes), 0);
        const diffMinutes = Math.max(0, (now - startTime) / 1000 / 60);
        let status = "";
        let statusColor = "";
        if (diffMinutes < 15) {
            status = "Hadir";
            statusColor = "#059669";
        } else if (diffMinutes >= 15 && diffMinutes <= 30) {
            status = "Terlambat";
            statusColor = "#f59e0b";
        } else {
            status = "Absen";
            statusColor = "#ef4444";
        }
        this.attendanceStatus.textContent = status;
        this.attendanceStatus.style.color = statusColor;
    }

    async submitAttendance() {
        if (!this.photoBlob)
            return this.showModal("Error", "Ambil foto terlebih dahulu", "error");
        if (!this.currentPosition)
            return this.showModal("Error", "GPS belum tersedia", "error");
        if (!this.schedule)
            return this.showModal("Error", "Tidak ada jadwal untuk hari ini", "error");
        if (!this.selectedLocation)
            return this.showModal("Error", "Pilih lokasi absensi terlebih dahulu", "error");
        
        const distance = this.calculateDistance(
            this.currentPosition.coords.latitude,
            this.currentPosition.coords.longitude,
            this.selectedLocation.latitude,
            this.selectedLocation.longitude
        );
        
        if (distance > this.selectedLocation.radius) {
            return this.showModal("Error", 
                `Anda berada di luar jangkauan lokasi ${this.selectedLocation.name}. Jarak: ${Math.round(distance)}m, Radius: ${this.selectedLocation.radius}m`, 
                "error"
            );
        }
        
        this.submitBtn.disabled = true;
        this.submitBtn.querySelector(".loading-spinner").style.display = "inline-block";
        
        try {
            const formData = new FormData();
            formData.append("photo", this.photoBlob, "attendance.jpg");
            formData.append("latitude", String(this.currentPosition.coords.latitude));
            formData.append("longitude", String(this.currentPosition.coords.longitude));
            formData.append("accuracy", String(this.currentPosition.coords.accuracy));
            formData.append("location_id", this.selectedLocation.id);
            formData.append("_token", "{{ csrf_token() }}");
            
            const response = await fetch('{{ route("attendance.camera.submit") }}', {
                method: "POST",
                body: formData,
            });
            
            const data = await response.json();
            
            if (!data.success) {
                this.showModal("Error", data.message, "error");
            } else {
                this.showModal(
                    "Sukses",
                    `Absensi berhasil di lokasi ${this.selectedLocation.name}! Status: ${data.attendance.status}`,
                    "success"
                );
                this.retakePhoto();
                await this.checkSchedule();
            }
        } catch (err) {
            this.showModal("Error", "Terjadi error saat submit absensi: " + err.message, "error");
        } finally {
            this.submitBtn.disabled = !this.photoBlob || !this.currentPosition || !this.schedule;
            this.submitBtn.querySelector(".loading-spinner").style.display = "none";
        }
    }

    destroy() {
        if (this.currentStream)
            this.currentStream.getTracks().forEach((track) => track.stop());
        if (this.watchId) 
            navigator.geolocation.clearWatch(this.watchId);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    window.attendanceCamera = new AttendanceCamera();
});

window.addEventListener("beforeunload", () => {
    if (window.attendanceCamera) 
        window.attendanceCamera.destroy();
});
</script>
@endsection