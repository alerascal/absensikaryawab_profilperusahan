@extends('layouts.app')

@section('breadcrumb')
    Dashboard
@endsection

@section('content')
                <!-- Dashboard Section -->
                <div id="dashboard-section" class="content-section">
                    <!-- Live Status Card -->
                    <div class="status-card animate-slide-up">
                        <div class="live-clock" id="liveClock">14:25:30</div>
                        <div class="live-date" id="liveDate">
                            Kamis, 28 Agustus 2025
                        </div>

                        <div class="status-info">
                            <div class="status-item">
                                <div class="status-value">08:00</div>
                                <div class="status-label">Jam Masuk</div>
                            </div>
                            <div class="status-item">
                                <div class="status-value">17:00</div>
                                <div class="status-label">Jam Pulang</div>
                            </div>
                            <div class="status-item">
                                <div class="status-value">Online</div>
                                <div class="status-label">Status Sistem</div>
                            </div>
                            <div class="status-item">
                                <div class="status-value">145</div>
                                <div class="status-label">Karyawan Aktif</div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="stats-grid animate-fade-in">
                        <div class="stat-card">
                            <div class="stat-header">
                                <div
                                    class="stat-icon"
                                    style="background: var(--success-gradient)"
                                >
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="stat-number">127</div>
                            <div class="stat-label">Hadir Hari Ini</div>
                            <div class="stat-trend trend-up">
                                <i class="fas fa-arrow-up"></i>
                                +12% dari kemarin
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-header">
                                <div
                                    class="stat-icon"
                                    style="background: var(--warning-gradient)"
                                >
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="stat-number">18</div>
                            <div class="stat-label">Terlambat</div>
                            <div class="stat-trend trend-down">
                                <i class="fas fa-arrow-down"></i>
                                -5% dari kemarin
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-header">
                                <div
                                    class="stat-icon"
                                    style="background: var(--danger-gradient)"
                                >
                                    <i class="fas fa-user-times"></i>
                                </div>
                            </div>
                            <div class="stat-number">8</div>
                            <div class="stat-label">Tidak Hadir</div>
                            <div class="stat-trend trend-up">
                                <i class="fas fa-arrow-up"></i>
                                +2% dari kemarin
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-header">
                                <div
                                    class="stat-icon"
                                    style="
                                        background: var(--secondary-gradient);
                                    "
                                >
                                    <i class="fas fa-home"></i>
                                </div>
                            </div>
                            <div class="stat-number">12</div>
                            <div class="stat-label">Work From Home</div>
                            <div class="stat-trend trend-up">
                                <i class="fas fa-arrow-up"></i>
                                +8% dari kemarin
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Panel -->
                    <div class="quick-panel animate-slide-up">
                        <div class="panel-header">
                            <div>
                                <div class="panel-title">Aksi Cepat</div>
                                <div class="panel-subtitle">
                                    Kelola absensi dengan mudah
                                </div>
                            </div>
                        </div>

                        <div class="actions-grid">
                            <button
                                class="action-btn success"
                                onclick="markAttendance()"
                            >
                                <i class="fas fa-check-circle"></i>
                                <div class="btn-text">Tandai Hadir</div>
                                <div class="btn-desc">
                                    Tandai kehadiran manual
                                </div>
                            </button>

                            <button
                                class="action-btn warning"
                                onclick="viewReports()"
                            >
                                <i class="fas fa-file-alt"></i>
                                <div class="btn-text">Buat Laporan</div>
                                <div class="btn-desc">
                                    Generate laporan absensi
                                </div>
                            </button>

                            <button
                                class="action-btn secondary"
                                onclick="addEmployee()"
                            >
                                <i class="fas fa-user-plus"></i>
                                <div class="btn-text">Tambah Karyawan</div>
                                <div class="btn-desc">
                                    Daftarkan karyawan baru
                                </div>
                            </button>

                            <button
                                class="action-btn danger"
                                onclick="exportData()"
                            >
                                <i class="fas fa-download"></i>
                                <div class="btn-text">Export Data</div>
                                <div class="btn-desc">
                                    Download data Excel/PDF
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Analytics Grid -->
                    <div class="analytics-grid animate-fade-in">
                        <div class="chart-panel">
                            <div class="chart-header">
                                <div>
                                    <div class="panel-title">
                                        Grafik Kehadiran Mingguan
                                    </div>
                                    <div class="panel-subtitle">
                                        Tren kehadiran 7 hari terakhir
                                    </div>
                                </div>
                                <select class="filter-select">
                                    <option>Minggu Ini</option>
                                    <option>Minggu Lalu</option>
                                    <option>Bulan Ini</option>
                                </select>
                            </div>
                            <div class="chart-container">
                                <i
                                    class="fas fa-chart-line"
                                    style="
                                        font-size: 3rem;
                                        opacity: 0.3;
                                        margin-right: 1rem;
                                    "
                                ></i>
                                Grafik akan ditampilkan di sini
                            </div>
                        </div>

                        <div class="chart-panel">
                            <div class="chart-header">
                                <div>
                                    <div class="panel-title">
                                        Departemen Terbaik
                                    </div>
                                    <div class="panel-subtitle">
                                        Berdasarkan tingkat kehadiran
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 1rem 0">
                                <div
                                    style="
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                        padding: 1rem 0;
                                        border-bottom: 1px solid
                                            rgba(0, 0, 0, 0.1);
                                    "
                                >
                                    <div>
                                        <div
                                            style="
                                                font-weight: 600;
                                                color: var(--text-primary);
                                            "
                                        >
                                            IT Development
                                        </div>
                                        <div
                                            style="
                                                font-size: 0.8rem;
                                                color: var(--text-secondary);
                                            "
                                        >
                                            25 karyawan
                                        </div>
                                    </div>
                                    <div
                                        style="
                                            font-size: 1.2rem;
                                            font-weight: 700;
                                            color: #10b981;
                                        "
                                    >
                                        98%
                                    </div>
                                </div>
                                <div
                                    style="
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                        padding: 1rem 0;
                                        border-bottom: 1px solid
                                            rgba(0, 0, 0, 0.1);
                                    "
                                >
                                    <div>
                                        <div
                                            style="
                                                font-weight: 600;
                                                color: var(--text-primary);
                                            "
                                        >
                                            Marketing
                                        </div>
                                        <div
                                            style="
                                                font-size: 0.8rem;
                                                color: var(--text-secondary);
                                            "
                                        >
                                            18 karyawan
                                        </div>
                                    </div>
                                    <div
                                        style="
                                            font-size: 1.2rem;
                                            font-weight: 700;
                                            color: #10b981;
                                        "
                                    >
                                        95%
                                    </div>
                                </div>
                                <div
                                    style="
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                        padding: 1rem 0;
                                        border-bottom: 1px solid
                                            rgba(0, 0, 0, 0.1);
                                    "
                                >
                                    <div>
                                        <div
                                            style="
                                                font-weight: 600;
                                                color: var(--text-primary);
                                            "
                                        >
                                            Finance
                                        </div>
                                        <div
                                            style="
                                                font-size: 0.8rem;
                                                color: var(--text-secondary);
                                            "
                                        >
                                            12 karyawan
                                        </div>
                                    </div>
                                    <div
                                        style="
                                            font-size: 1.2rem;
                                            font-weight: 700;
                                            color: #f59e0b;
                                        "
                                    >
                                        92%
                                    </div>
                                </div>
                                <div
                                    style="
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                        padding: 1rem 0;
                                    "
                                >
                                    <div>
                                        <div
                                            style="
                                                font-weight: 600;
                                                color: var(--text-primary);
                                            "
                                        >
                                            HR
                                        </div>
                                        <div
                                            style="
                                                font-size: 0.8rem;
                                                color: var(--text-secondary);
                                            "
                                        >
                                            8 karyawan
                                        </div>
                                    </div>
                                    <div
                                        style="
                                            font-size: 1.2rem;
                                            font-weight: 700;
                                            color: #ef4444;
                                        "
                                    >
                                        89%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Section -->
                <div
                    id="attendance-section"
                    class="content-section"
                    style="display: none"
                >
                    <div class="attendance-panel animate-slide-up">
                        <div class="table-controls">
                            <div>
                                <div class="panel-title">Absensi Hari Ini</div>
                                <div class="panel-subtitle">
                                    Daftar kehadiran karyawan hari ini
                                </div>
                            </div>
                            <div class="filter-group">
                                <select class="filter-select">
                                    <option>Semua Departemen</option>
                                    <option>IT Development</option>
                                    <option>Marketing</option>
                                    <option>Finance</option>
                                    <option>HR</option>
                                </select>
                                <select class="filter-select">
                                    <option>Semua Status</option>
                                    <option>Hadir</option>
                                    <option>Terlambat</option>
                                    <option>Tidak Hadir</option>
                                    <option>WFH</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-container">
                            <table class="attendance-table">
                                <thead>
                                    <tr>
                                        <th>Karyawan</th>
                                        <th>Departemen</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Status</th>
                                        <th>Lokasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="employee-info">
                                                <div class="employee-avatar">
                                                    JD
                                                </div>
                                                <div class="employee-details">
                                                    <h4>John Doe</h4>
                                                    <span>ID: EMP001</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>IT Development</td>
                                        <td>
                                            <span class="time-badge"
                                                >08:00</span
                                            >
                                        </td>
                                        <td>
                                            <span class="time-badge"
                                                >17:30</span
                                            >
                                        </td>
                                        <td>
                                            <span
                                                class="status-badge status-present"
                                                ><i class="fas fa-check"></i>
                                                Hadir</span
                                            >
                                        </td>
                                        <td>
                                            <span class="location-badge"
                                                ><i
                                                    class="fas fa-map-marker-alt"
                                                ></i>
                                                Kantor Pusat</span
                                            >
                                        </td>
                                        <td>
                                            <button
                                                class="action-btn"
                                                style="
                                                    padding: 0.5rem;
                                                    font-size: 0.8rem;
                                                    min-height: auto;
                                                "
                                                onclick="viewDetails('EMP001')"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="employee-info">
                                                <div class="employee-avatar">
                                                    JS
                                                </div>
                                                <div class="employee-details">
                                                    <h4>Jane Smith</h4>
                                                    <span>ID: EMP002</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Marketing</td>
                                        <td>
                                            <span class="time-badge"
                                                >08:15</span
                                            >
                                        </td>
                                        <td>
                                            <span class="time-badge">-</span>
                                        </td>
                                        <td>
                                            <span
                                                class="status-badge status-late"
                                                ><i class="fas fa-clock"></i>
                                                Terlambat</span
                                            >
                                        </td>
                                        <td>
                                            <span class="location-badge"
                                                ><i
                                                    class="fas fa-map-marker-alt"
                                                ></i>
                                                Kantor Pusat</span
                                            >
                                        </td>
                                        <td>
                                            <button
                                                class="action-btn"
                                                style="
                                                    padding: 0.5rem;
                                                    font-size: 0.8rem;
                                                    min-height: auto;
                                                "
                                                onclick="viewDetails('EMP002')"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="employee-info">
                                                <div class="employee-avatar">
                                                    MB
                                                </div>
                                                <div class="employee-details">
                                                    <h4>Mike Brown</h4>
                                                    <span>ID: EMP003</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Finance</td>
                                        <td>
                                            <span class="time-badge"
                                                >07:45</span
                                            >
                                        </td>
                                        <td>
                                            <span class="time-badge">-</span>
                                        </td>
                                        <td>
                                            <span
                                                class="status-badge status-remote"
                                                ><i class="fas fa-home"></i>
                                                WFH</span
                                            >
                                        </td>
                                        <td>
                                            <span class="location-badge"
                                                ><i class="fas fa-home"></i>
                                                Remote</span
                                            >
                                        </td>
                                        <td>
                                            <button
                                                class="action-btn"
                                                style="
                                                    padding: 0.5rem;
                                                    font-size: 0.8rem;
                                                    min-height: auto;
                                                "
                                                onclick="viewDetails('EMP003')"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="employee-info">
                                                <div class="employee-avatar">
                                                    SW
                                                </div>
                                                <div class="employee-details">
                                                    <h4>Sarah Wilson</h4>
                                                    <span>ID: EMP004</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>HR</td>
                                        <td>
                                            <span class="time-badge">-</span>
                                        </td>
                                        <td>
                                            <span class="time-badge">-</span>
                                        </td>
                                        <td>
                                            <span
                                                class="status-badge status-absent"
                                                ><i class="fas fa-times"></i>
                                                Tidak Hadir</span
                                            >
                                        </td>
                                        <td>
                                            <span class="location-badge"
                                                ><i class="fas fa-question"></i>
                                                -</span
                                            >
                                        </td>
                                        <td>
                                            <button
                                                class="action-btn"
                                                style="
                                                    padding: 0.5rem;
                                                    font-size: 0.8rem;
                                                    min-height: auto;
                                                "
                                                onclick="viewDetails('EMP004')"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="employee-info">
                                                <div class="employee-avatar">
                                                    TJ
                                                </div>
                                                <div class="employee-details">
                                                    <h4>Tom Johnson</h4>
                                                    <span>ID: EMP005</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>IT Development</td>
                                        <td>
                                            <span class="time-badge"
                                                >08:05</span
                                            >
                                        </td>
                                        <td>
                                            <span class="time-badge">-</span>
                                        </td>
                                        <td>
                                            <span
                                                class="status-badge status-present"
                                                ><i class="fas fa-check"></i>
                                                Hadir</span
                                            >
                                        </td>
                                        <td>
                                            <span class="location-badge"
                                                ><i
                                                    class="fas fa-map-marker-alt"
                                                ></i>
                                                Kantor Pusat</span
                                            >
                                        </td>
                                        <td>
                                            <button
                                                class="action-btn"
                                                style="
                                                    padding: 0.5rem;
                                                    font-size: 0.8rem;
                                                    min-height: auto;
                                                "
                                                onclick="viewDetails('EMP005')"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Other Sections (Hidden by default) -->
                <div
                    id="employees-section"
                    class="content-section"
                    style="display: none"
                >
                    <div class="quick-panel animate-slide-up">
                        <div class="panel-header">
                            <div>
                                <div class="panel-title">
                                    Manajemen Karyawan
                                </div>
                                <div class="panel-subtitle">
                                    Kelola data karyawan perusahaan
                                </div>
                            </div>
                        </div>
                        <div class="chart-container">
                            <i
                                class="fas fa-users"
                                style="
                                    font-size: 3rem;
                                    opacity: 0.3;
                                    margin-right: 1rem;
                                "
                            ></i>
                            Fitur manajemen karyawan dalam pengembangan
                        </div>
                    </div>
                </div>

                <div
                    id="reports-section"
                    class="content-section"
                    style="display: none"
                >
                    <div class="quick-panel animate-slide-up">
                        <div class="panel-header">
                            <div>
                                <div class="panel-title">Laporan Absensi</div>
                                <div class="panel-subtitle">
                                    Generate dan export laporan absensi
                                </div>
                            </div>
                        </div>
                        <div class="chart-container">
                            <i
                                class="fas fa-chart-bar"
                                style="
                                    font-size: 3rem;
                                    opacity: 0.3;
                                    margin-right: 1rem;
                                "
                            ></i>
                            Fitur laporan dalam pengembangan
                        </div>
                    </div>
                </div>

                <div
                    id="settings-section"
                    class="content-section"
                    style="display: none"
                >
                    <div class="quick-panel animate-slide-up">
                        <div class="panel-header">
                            <div>
                                <div class="panel-title">Pengaturan Sistem</div>
                                <div class="panel-subtitle">
                                    Konfigurasi sistem absensi
                                </div>
                            </div>
                        </div>
                        <div class="chart-container">
                            <i
                                class="fas fa-cog"
                                style="
                                    font-size: 3rem;
                                    opacity: 0.3;
                                    margin-right: 1rem;
                                "
                            ></i>
                            Fitur pengaturan dalam pengembangan
                        </div>
                    </div>
                </div>
            </main>
        </div>
        @endsection