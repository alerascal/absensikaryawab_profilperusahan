<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="logo-section">
        <div class="logo">
            <i class="fas fa-fingerprint"></i>
            AttendPro
        </div>
    </div>

    <div class="user-welcome animate-fade-in">
        <div class="user-avatar-large">
            {{ auth()->user()->name ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'AM' }}
        </div>
        <div style="font-weight: 600; font-size: 1.1rem; margin-bottom: 0.5rem;">
            Selamat Datang, {{ auth()->user()->name ?? 'Admin' }}
        </div>
        <div style="opacity: 0.9; font-size: 0.9rem">
            Manager Sistem
        </div>
    </div>

    <ul class="nav-menu">
        <li class="nav-section">
            <div class="nav-section-title">Menu Utama</div>
            <ul>
                <li class="nav-item">
                    <a href="#dashboard" class="nav-link active" onclick="showSection('dashboard')">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#attendance" class="nav-link" onclick="showSection('attendance')">
                        <i class="fas fa-calendar-check"></i>
                        Absensi Hari Ini
                        <span class="nav-badge">12</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#employees" class="nav-link" onclick="showSection('employees')">
                        <i class="fas fa-users"></i>
                        Karyawan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#reports" class="nav-link" onclick="showSection('reports')">
                        <i class="fas fa-chart-bar"></i>
                        Laporan
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-section">
            <div class="nav-section-title">Pengaturan</div>
            <ul>
                <li class="nav-item">
                    <a href="#settings" class="nav-link" onclick="showSection('settings')">
                        <i class="fas fa-cog"></i>
                        Pengaturan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#schedule" class="nav-link" onclick="showSection('schedule')">
                        <i class="fas fa-clock"></i>
                        Jadwal Kerja
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#notifications" class="nav-link" onclick="showSection('notifications')">
                        <i class="fas fa-bell"></i>
                        Notifikasi
                        <span class="nav-badge">3</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-section">
            <div class="nav-section-title">Lainnya</div>
            <ul>
                <li class="nav-item">
                    <a href="#help" class="nav-link" onclick="showSection('help')">
                        <i class="fas fa-question-circle"></i>
                        Bantuan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<!-- Overlay (penting untuk mobile toggle) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>
