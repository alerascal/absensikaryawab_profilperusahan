@extends('layouts.backend')
 @section('content')
                <!-- Dashboard Section -->
                <div id="dashboard-section" class="content-section">
                    <!-- Check-in/Check-out Card -->
                    <div class="checkin-card animate-slide-up">
                        <div class="current-time" id="currentTime">
                            14:25:30
                        </div>
                        <div class="current-date" id="currentDate">
                            Kamis, 28 Agustus 2025
                        </div>

                        <div class="checkin-actions">
                            <button
                                class="checkin-btn"
                                id="checkinBtn"
                                onclick="checkIn()"
                            >
                                <i class="fas fa-sign-in-alt"></i>
                                Check In
                            </button>
                            <button
                                class="checkin-btn"
                                id="checkoutBtn"
                                onclick="checkOut()"
                                style="display: none"
                            >
                                <i class="fas fa-sign-out-alt"></i>
                                Check Out
                            </button>
                        </div>

                        <div class="status-info">
                            <div class="status-item">
                                <div class="status-value" id="checkInTime">
                                    --:--
                                </div>
                                <div class="status-label">Jam Masuk</div>
                            </div>
                            <div class="status-item">
                                <div class="status-value" id="checkOutTime">
                                    --:--
                                </div>
                                <div class="status-label">Jam Keluar</div>
                            </div>
                            <div class="status-item">
                                <div class="status-value" id="workDuration">
                                    0:00
                                </div>
                                <div class="status-label">Total Kerja</div>
                            </div>
                            <div class="status-item">
                                <div class="status-value" id="currentStatus">
                                    Belum Absen
                                </div>
                                <div class="status-label">Status</div>
                            </div>
                        </div>
                    </div>

                    <!-- Today Stats -->
                    <div class="today-stats animate-fade-in">
                        <div class="stat-card work-hours">
                            <div class="stat-header">
                                <div
                                    class="stat-icon"
                                    style="background: var(--success-gradient)"
                                >
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="stat-number">8.5</div>
                            <div class="stat-label">Jam Kerja Hari Ini</div>
                        </div>

                        <div class="stat-card overtime">
                            <div class="stat-header">
                                <div
                                    class="stat-icon"
                                    style="background: var(--warning-gradient)"
                                >
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                            </div>
                            <div class="stat-number">1.5</div>
                            <div class="stat-label">Jam Lembur</div>
                        </div>

                        <div class="stat-card break-time">
                            <div class="stat-header">
                                <div
                                    class="stat-icon"
                                    style="background: var(--info-gradient)"
                                >
                                    <i class="fas fa-coffee"></i>
                                </div>
                            </div>
                            <div class="stat-number">1:00</div>
                            <div class="stat-label">Waktu Istirahat</div>
                        </div>

                        <div class="stat-card location">
                            <div class="stat-header">
                                <div
                                    class="stat-icon"
                                    style="background: var(--accent-purple)"
                                >
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                            </div>
                            <div class="stat-number">Kantor</div>
                            <div class="stat-label">Lokasi Kerja</div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions animate-slide-up">
                        <div class="section-title">Aksi Cepat</div>
                        <div class="section-subtitle">
                            Akses fitur yang sering digunakan
                        </div>

                        <div class="actions-grid">
                            <a
                                href="#schedule"
                                class="action-card schedule"
                                onclick="showSection('schedule')"
                            >
                                <div
                                    class="action-icon"
                                    style="background: var(--success-gradient)"
                                >
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="action-title">Jadwal Kerja</div>
                                <div class="action-desc">
                                    Lihat jadwal kerja minggu ini
                                </div>
                            </a>

                            <a
                                href="#history"
                                class="action-card history"
                                onclick="showSection('history')"
                            >
                                <div
                                    class="action-icon"
                                    style="background: var(--info-gradient)"
                                >
                                    <i class="fas fa-history"></i>
                                </div>
                                <div class="action-title">Riwayat Absensi</div>
                                <div class="action-desc">
                                    Cek kehadiran bulan lalu
                                </div>
                            </a>

                            <a
                                href="#leave"
                                class="action-card leave"
                                onclick="showSection('leave')"
                            >
                                <div
                                    class="action-icon"
                                    style="background: var(--warning-gradient)"
                                >
                                    <i class="fas fa-calendar-times"></i>
                                </div>
                                <div class="action-title">Ajukan Cuti</div>
                                <div class="action-desc">
                                    Buat pengajuan cuti baru
                                </div>
                            </a>

                            <a
                                href="#payroll"
                                class="action-card payroll"
                                onclick="showSection('payroll')"
                            >
                                <div
                                    class="action-icon"
                                    style="background: var(--accent-orange)"
                                >
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                                <div class="action-title">Slip Gaji</div>
                                <div class="action-desc">
                                    Download slip gaji terbaru
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="activity-panel animate-fade-in">
                        <div class="section-title">Aktivitas Terbaru</div>
                        <div class="section-subtitle">
                            Ringkasan aktivitas absensi Anda
                        </div>

                        <ul class="activity-list">
                            <li class="activity-item">
                                <div
                                    class="activity-icon"
                                    style="background: var(--success-gradient)"
                                >
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">
                                        Check-in berhasil
                                    </div>
                                    <div class="activity-desc">
                                        Anda telah check-in pada pukul 08:00 WIB
                                    </div>
                                </div>
                                <div class="activity-time">2 jam lalu</div>
                            </li>

                            <li class="activity-item">
                                <div
                                    class="activity-icon"
                                    style="background: var(--warning-gradient)"
                                >
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">
                                        Pengajuan cuti disetujui
                                    </div>
                                    <div class="activity-desc">
                                        Cuti tanggal 30-31 Agustus telah
                                        disetujui
                                    </div>
                                </div>
                                <div class="activity-time">1 hari lalu</div>
                            </li>

                            <li class="activity-item">
                                <div
                                    class="activity-icon"
                                    style="background: var(--info-gradient)"
                                >
                                    <i class="fas fa-file-download"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">
                                        Slip gaji tersedia
                                    </div>
                                    <div class="activity-desc">
                                        Slip gaji bulan Juli 2025 telah tersedia
                                    </div>
                                </div>
                                <div class="activity-time">3 hari lalu</div>
                            </li>

                            <li class="activity-item">
                                <div
                                    class="activity-icon"
                                    style="background: var(--accent-purple)"
                                >
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">
                                        Lembur disetujui
                                    </div>
                                    <div class="activity-desc">
                                        Lembur tanggal 25 Agustus (2 jam)
                                        disetujui
                                    </div>
                                </div>
                                <div class="activity-time">5 hari lalu</div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Attendance Section -->
                <div
                    id="attendance-section"
                    class="content-section"
                    style="display: none"
                >
                    <div class="activity-panel animate-slide-up">
                        <div class="section-title">Absensi Saya</div>
                        <div class="section-subtitle">
                            Status kehadiran dan informasi absensi
                        </div>

                        <div class="today-stats">
                            <div class="stat-card">
                                <div class="stat-header">
                                    <div
                                        class="stat-icon"
                                        style="
                                            background: var(--success-gradient);
                                        "
                                    >
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                                <div class="stat-number">22</div>
                                <div class="stat-label">
                                    Hari Hadir Bulan Ini
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-header">
                                    <div
                                        class="stat-icon"
                                        style="
                                            background: var(--warning-gradient);
                                        "
                                    >
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                <div class="stat-number">3</div>
                                <div class="stat-label">Keterlambatan</div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-header">
                                    <div
                                        class="stat-icon"
                                        style="
                                            background: var(--danger-gradient);
                                        "
                                    >
                                        <i class="fas fa-times"></i>
                                    </div>
                                </div>
                                <div class="stat-number">1</div>
                                <div class="stat-label">Hari Absen</div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-header">
                                    <div
                                        class="stat-icon"
                                        style="background: var(--info-gradient)"
                                    >
                                        <i class="fas fa-home"></i>
                                    </div>
                                </div>
                                <div class="stat-number">5</div>
                                <div class="stat-label">Work From Home</div>
                            </div>
                        </div>

                        <div
                            style="
                                text-align: center;
                                padding: 2rem;
                                color: var(--text-secondary);
                            "
                        >
                            <i
                                class="fas fa-calendar-alt"
                                style="
                                    font-size: 3rem;
                                    opacity: 0.3;
                                    margin-bottom: 1rem;
                                "
                            ></i>
                            <div>
                                Kalender absensi detail akan ditampilkan di sini
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other sections with placeholder content -->
                <div
                    id="schedule-section"
                    class="content-section"
                    style="display: none"
                >
                    <div class="activity-panel animate-slide-up">
                        <div class="section-title">Jadwal Kerja</div>
                        <div class="section-subtitle">
                            Jadwal kerja minggu ini dan bulan mendatang
                        </div>
                        <div
                            style="
                                text-align: center;
                                padding: 3rem;
                                color: var(--text-secondary);
                            "
                        >
                            <i
                                class="fas fa-calendar-week"
                                style="
                                    font-size: 3rem;
                                    opacity: 0.3;
                                    margin-bottom: 1rem;
                                "
                            ></i>
                            <div>Fitur jadwal kerja akan segera tersedia</div>
                        </div>
                    </div>
                </div>

                <div
                    id="history-section"
                    class="content-section"
                    style="display: none"
                >
                    <div class="activity-panel animate-slide-up">
                        <div class="section-title">Riwayat Absensi</div>
                        <div class="section-subtitle">
                            Lihat riwayat kehadiran bulan sebelumnya
                        </div>
                        <div
                            style="
                                text-align: center;
                                padding: 3rem;
                                color: var(--text-secondary);
                            "
                        >
                            <i
                                class="fas fa-history"
                                style="
                                    font-size: 3rem;
                                    opacity: 0.3;
                                    margin-bottom: 1rem;
                                "
                            ></i>
                            <div>
                                Fitur riwayat absensi akan segera tersedia
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    id="leave-section"
                    class="content-section"
                    style="display: none"
                >
                    <div class="activity-panel animate-slide-up">
                        <div class="section-title">Pengajuan Cuti</div>
                        <div class="section-subtitle">
                            Ajukan cuti dan lihat status persetujuan
                        </div>
                        <div
                            style="
                                text-align: center;
                                padding: 3rem;
                                color: var(--text-secondary);
                            "
                        >
                            <i
                                class="fas fa-calendar-times"
                                style="
                                    font-size: 3rem;
                                    opacity: 0.3;
                                    margin-bottom: 1rem;
                                "
                            ></i>
                            <div>Fitur pengajuan cuti akan segera tersedia</div>
                        </div>
                    </div>
                </div>

                <div
                    id="overtime-section"
                    class="content-section"
                    style="display: none"
                >
                    <div class="activity-panel animate-slide-up">
                        <div class="section-title">Lembur</div>
                        <div class="section-subtitle">
                            Ajukan lembur dan lihat riwayat
                        </div>
                        <div
                            style="
                                text-align: center;
                                padding: 3rem;
                                color: var(--text-secondary);
                            "
                        >
                            <i
                                class="fas fa-clock"
                                style="
                                    font-size: 3rem;
                                    opacity: 0.3;
                                    margin-bottom: 1rem;
                                "
                            ></i>
                            <div>Fitur lembur akan segera tersedia</div>
                        </div>
                    </div>
                </div>

                <div
                    id="payroll-section"
                    class="content-section"
                    style="display: none"
                >
                    <div class="activity-panel animate-slide-up">
                        <div class="section-title">Slip Gaji</div>
                        <div class="section-subtitle">
                            Download dan lihat slip gaji bulanan
                        </div>
                        <div
                            style="
                                text-align: center;
                                padding: 3rem;
                                color: var(--text-secondary);
                            "
                        >
                            <i
                                class="fas fa-file-invoice-dollar"
                                style="
                                    font-size: 3rem;
                                    opacity: 0.3;
                                    margin-bottom: 1rem;
                                "
                            ></i>
                            <div>Fitur slip gaji akan segera tersedia</div>
                        </div>
                    </div>
                </div>

                <div
                    id="profile-section"
                    class="content-section"
                    style="display: none"
                >
                    <div class="activity-panel animate-slide-up">
                        <div class="section-title">Profil Saya</div>
                        <div class="section-subtitle">
                            Kelola informasi profil dan pengaturan akun
                        </div>
                        <div
                            style="
                                text-align: center;
                                padding: 3rem;
                                color: var(--text-secondary);
                            "
                        >
                            <i
                                class="fas fa-user"
                                style="
                                    font-size: 3rem;
                                    opacity: 0.3;
                                    margin-bottom: 1rem;
                                "
                            ></i>
                            <div>Fitur profil akan segera tersedia</div>
                        </div>
                    </div>
                </div>

                <div
                    id="notifications-section"
                    class="content-section"
                    style="display: none"
                >
                    <div class="activity-panel animate-slide-up">
                        <div class="section-title">Notifikasi</div>
                        <div class="section-subtitle">
                            Kelola notifikasi dan pengingat
                        </div>
                        <div
                            style="
                                text-align: center;
                                padding: 3rem;
                                color: var(--text-secondary);
                            "
                        >
                            <i
                                class="fas fa-bell"
                                style="
                                    font-size: 3rem;
                                    opacity: 0.3;
                                    margin-bottom: 1rem;
                                "
                            ></i>
                            <div>Fitur notifikasi akan segera tersedia</div>
                        </div>
                    </div>
                </div>

                <div
                    id="help-section"
                    class="content-section"
                    style="display: none"
                >
                    <div class="activity-panel animate-slide-up">
                        <div class="section-title">Bantuan</div>
                        <div class="section-subtitle">
                            Panduan penggunaan dan FAQ
                        </div>
                        <div
                            style="
                                text-align: center;
                                padding: 3rem;
                                color: var(--text-secondary);
                            "
                        >
                            <i
                                class="fas fa-question-circle"
                                style="
                                    font-size: 3rem;
                                    opacity: 0.3;
                                    margin-bottom: 1rem;
                                "
                            ></i>
                            <div>Halaman bantuan akan segera tersedia</div>
                        </div>
                    </div>
                </div>
                @endsection
     