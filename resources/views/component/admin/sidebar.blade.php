<!-- Modified Sidebar with New Navlink -->
<nav class="sidebar bg-white shadow-md" id="sidebar">
    <!-- Logo -->
    <div class="logo-section p-4 border-b">
        <div class="logo text-xl font-bold flex items-center gap-2">
            <i class="fas fa-fingerprint text-blue-600"></i>
            Absenkuyy
        </div>
    </div>

    <!-- User Info -->
    <div class="user-welcome text-center p-4 animate__animated animate__fadeIn">
        <div
            class="user-avatar-large bg-blue-800 text-white mx-auto mb-2 rounded-full flex items-center justify-center"
            style="width: 60px; height: 60px; font-size: 1.2rem"
        >
            {{ auth()->user()->name ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'AM' }}
        </div>
        <div class="font-semibold text-lg">
            Selamat Datang, {{ auth()->user()->name ?? 'Admin' }}
        </div>
        <div class="text-sm opacity-80">Manager Sistem</div>
    </div>

    <!-- Menu -->
    <ul class="nav-menu px-3">
        <!-- Menu Utama -->
        <li class="nav-section">
            <div
                class="nav-section-title text-blue-800 uppercase text-sm font-bold mb-2 tracking-wide"
            >
                Menu Utama
            </div>
            <ul>
                <li class="nav-item">
                    <a
                        href="{{ route('admin.dashboard-admin') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard-admin') ? 'active' : '' }}"
                    >
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('admin.locations.index') }}"
                        class="nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}"
                    >
                        <i class="fas fa-map-marker-alt"></i> Lokasi Absensi
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('attendance.camera.page') }}"
                        class="nav-link {{ request()->routeIs('attendance.camera.page') ? 'active' : '' }}"
                    >
                        <i class="fas fa-camera"></i> Absensi
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('admin.attendance.index') }}"
                        class="nav-link {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}"
                    >
                        <i class="fas fa-calendar-check"></i> Data Absensi
                        <span class="nav-badge">{{ $attendanceCount ?? 0 }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('employees.index') }}"
                        class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}"
                    >
                        <i class="fas fa-users"></i> Karyawan
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('admin.departments.index') }}"
                        class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}"
                    >
                        <i class="fas fa-building"></i> Departemen
                    </a>
                </li>
                <!-- New Daftar Pengajuan Navlink -->
                <li class="nav-item">
                    <a
                        href="{{ route('admin.pengajuan.index') }}"
                        class="nav-link {{ request()->routeIs('admin.pengajuan.*') ? 'active' : '' }}"
                    >
                        <i class="fas fa-file-alt"></i> Daftar Pengajuan
                    </a>
                </li>
                <!-- Laporan (submenu) -->
                <li class="nav-item">
                    <a
                        class="nav-link d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse"
                        href="#reportsMenu"
                        role="button"
                        aria-expanded="{{ request()->routeIs('reports.*') ? 'true' : 'false' }}"
                        aria-controls="reportsMenu"
                    >
                        <span><i class="fas fa-chart-bar"></i> Laporan</span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul
                        class="collapse list-unstyled ps-3 {{ request()->routeIs('reports.*') ? 'show' : '' }}"
                        id="reportsMenu"
                    >
                        <li>
                            <a
                                href="{{ route('reports.attendance') }}"
                                class="nav-link {{ request()->routeIs('reports.attendance') ? 'active' : '' }}"
                            >
                                <i class="fas fa-list"></i> Kehadiran Harian
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route('reports.monthly') }}"
                                class="nav-link {{ request()->routeIs('reports.monthly') ? 'active' : '' }}"
                            >
                                <i class="fas fa-calendar"></i> Rekap Bulanan
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route('reports.other') }}"
                                class="nav-link {{ request()->routeIs('reports.other') ? 'active' : '' }}"
                            >
                                <i class="fas fa-briefcase"></i> Lembur & Cuti
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <!-- Pengaturan -->
        <li class="nav-section mt-4">
            <div
                class="nav-section-title text-blue-800 uppercase text-xs font-semibold mb-2"
            >
                Pengaturan
            </div>
            <ul>
                <li class="nav-item">
                    <a
                        href="{{ route('settings.index') }}"
                        class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}"
                    >
                        <i class="fas fa-cog"></i> Profil
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('admin.shifts.index') }}"
                        class="nav-link {{ request()->routeIs('admin.shifts.*') ? 'active' : '' }}"
                    >
                        <i class="fas fa-user-clock"></i> Shift
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('admin.schedules.index') }}"
                        class="nav-link {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}"
                    >
                        <i class="fas fa-clock"></i> Jadwal Kerja
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('guide.index') }}"
                        class="nav-link {{ request()->routeIs('guide.index') ? 'active' : '' }}"
                    >
                        <i class="fas fa-book"></i> Panduan
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="#"
                        class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    >
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                    <form
                        id="logout-form"
                        action="{{ route('logout') }}"
                        method="POST"
                        style="display: none"
                    >
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
