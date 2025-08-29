<header class="top-bar animate-slide-up">
    <div class="page-title">
        <h1 id="pageTitle">Dashboard Absensi</h1>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> / @yield('breadcrumb')
            <span id="breadcrumbCurrent">Dashboard</span>
        </div>
    </div>

    <div class="top-actions">
        <div class="search-box">
            <i class="fas fa-search search-icon"></i>
            <input
                type="text"
                class="search-input"
                placeholder="Cari karyawan, laporan..."
                id="searchInput"
            />
        </div>

        <button class="notification-btn" onclick="showNotifications()">
            <i class="fas fa-bell"></i>
            <span class="notification-badge">5</span>
        </button>

        <button class="profile-btn" onclick="showProfile()">
            {{ auth()->user()->name ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'AM' }}
        </button>
    </div>
</header>