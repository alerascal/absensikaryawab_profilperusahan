<nav class="sidebar bg-white shadow-md min-h-screen" id="sidebar">
    <!-- Logo -->
    <div class="logo-section p-4 border-b">
        <div class="logo text-xl font-bold flex items-center gap-2">
            <i class="fas fa-fingerprint text-blue-600"></i>
            Absenkuyy
        </div>
    </div>

    <!-- User Info -->
    <div class="user-welcome text-center p-4">
        <div
            class="user-avatar-large bg-green-600 text-white mx-auto mb-2 rounded-full flex items-center justify-center"
            style="width: 60px; height: 60px; font-size: 1.2rem"
        >
            {{ auth()->user()->name ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'PG' }}
        </div>
        <div class="font-semibold text-lg">
            Halo, {{ auth()->user()->name ?? 'Pegawai' }}
        </div>
        <div class="text-sm opacity-80">Pegawai</div>
    </div>

    <!-- Menu -->
    <ul class="nav-menu px-3 space-y-1">
        <!-- Dashboard -->
        <li class="nav-item">
            <a
                href="{{ route('pegawai.dashboard') }}"
                class="nav-link flex items-center gap-2 p-2 rounded {{ request()->routeIs('pegawai.dashboard') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}"
            >
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Jadwal Kerja -->
        <li class="nav-item">
            <a
                href="{{ route('pegawai.schedules.show', auth()->id()) }}"
                class="nav-link flex items-center gap-2 p-2 rounded {{ request()->routeIs('pegawai.schedules.*') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}"
            >
                <i class="fas fa-clock"></i>
                <span>Jadwal Kerja</span>
            </a>
        </li>

        <!-- Absensi Kamera -->
        <li class="nav-item">
            <a
                href="{{ route('attendance.camera.page') }}"
                class="nav-link flex items-center gap-2 p-2 rounded {{ request()->routeIs('attendance.camera.page') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}"
            >
                <i class="fas fa-camera"></i>
                <span>Absensi</span>
            </a>
        </li>

        <!-- Riwayat Absensi -->
        <li class="nav-item">
            <a
                href="{{ route('pegawai.attendance.index') }}"
                class="nav-link flex items-center gap-2 p-2 rounded {{ request()->routeIs('pegawai.attendance.index') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}"
            >
                <i class="fas fa-calendar-check"></i>
                <span>Riwayat Absensi</span>
            </a>
        </li>

        <!-- Pengajuan Izin / Sakit -->
        <li class="nav-item">
            <a
                href="{{ route('pegawai.pengajuan.index') }}"
                class="nav-link flex items-center gap-2 p-2 rounded {{ request()->routeIs('pegawai.pengajuan.*') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}"
            >
                <i class="fas fa-file-alt"></i>
                <span>Pengajuan Izin / Sakit</span>
            </a>
        </li>

        <!-- Panduan -->
        <li class="nav-item">
            <a
                href="{{ route('guide.index') }}"
                class="nav-link flex items-center gap-2 p-2 rounded {{ request()->routeIs('guide.index') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}"
            >
                <i class="fas fa-book"></i>
                <span>Panduan</span>
            </a>
        </li>

        <!-- Logout -->
        <li class="nav-item">
            <a
                href="#"
                class="nav-link flex items-center gap-2 p-2 rounded text-red-600 hover:bg-red-100"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            >
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
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
</nav>
