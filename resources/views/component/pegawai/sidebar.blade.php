<!-- Enhanced Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="logo-section">
        <div class="logo">
            <i class="fas fa-fingerprint"></i>
            AttendPro
        </div>
    </div>

    <div class="user-profile animate-fade-in">
        <div class="user-avatar">JD</div>
        <div class="user-name">John Doe</div>
        <div class="user-role">Software Developer</div>
        <div class="user-id">EMP001</div>
    </div>

    <ul class="nav-menu">
        <li class="nav-section">
            <div class="nav-section-title">Menu Utama</div>
            <ul>
                <li class="nav-item">
                    <a href="{{ route('pegawai.dashboard') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        href="#attendance"
                        class="nav-link"
                        onclick="showSection('attendance')"
                    >
                        <i class="fas fa-calendar-check"></i>
                        Absensi Saya
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="#schedule"
                        class="nav-link"
                        onclick="showSection('schedule')"
                    >
                        <i class="fas fa-clock"></i>
                        Jadwal Kerja
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="#history"
                        class="nav-link"
                        onclick="showSection('history')"
                    >
                        <i class="fas fa-history"></i>
                        Riwayat Absensi
                        <span class="nav-badge">New</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-section">
            <div class="nav-section-title">Layanan</div>
            <ul>
                <li class="nav-item">
                    <a
                        href="#leave"
                        class="nav-link"
                        onclick="showSection('leave')"
                    >
                        <i class="fas fa-calendar-times"></i>
                        Pengajuan Cuti
                        <span class="nav-badge">3</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="#overtime"
                        class="nav-link"
                        onclick="showSection('overtime')"
                    >
                        <i class="fas fa-clock"></i>
                        Lembur
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="#payroll"
                        class="nav-link"
                        onclick="showSection('payroll')"
                    >
                        <i class="fas fa-money-bill-wave"></i>
                        Slip Gaji
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-section">
            <div class="nav-section-title">Pengaturan</div>
            <ul>
                <li class="nav-item">
                    <a
                        href="#profile"
                        class="nav-link"
                        onclick="showSection('profile')"
                    >
                        <i class="fas fa-user"></i>
                        Profil Saya
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="#notifications"
                        class="nav-link"
                        onclick="showSection('notifications')"
                    >
                        <i class="fas fa-bell"></i>
                        Notifikasi
                        <span class="nav-badge">5</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="#help"
                        class="nav-link"
                        onclick="showSection('help')"
                    >
                        <i class="fas fa-question-circle"></i>
                        Bantuan
                    </a>
                </li>
                <li class="nav-item">
                    <form
                        id="logout-form"
                        action="{{ route('logout') }}"
                        method="POST"
                        style="display: none"
                    >
                        @csrf
                    </form>
                    <a
                        href="#"
                        class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    >
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
