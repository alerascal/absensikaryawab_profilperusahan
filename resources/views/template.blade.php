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