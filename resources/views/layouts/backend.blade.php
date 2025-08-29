<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>AttendPro - Dashboard Karyawan</title>
        <link
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
            rel="stylesheet"
        />
        <link
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
            rel="stylesheet"
        />
         <link rel="stylesheet" href="{{ asset('assets/pegawai/style.css') }}" />
    </head>
    <body>
        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner"></div>
        </div>

        <!-- Notification Container -->
        <div class="notification-container" id="notificationContainer"></div>

        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <div class="container">
            @include('component.pegawai.sidebar')
             <div class="sidebar-overlay" id="sidebarOverlay"></div>
            <!-- Main Content -->
            <main class="main-content">
                @include('component.pegawai.navbar')
                 @yield('content')
            </main>
        </div>
         <!-- Include JavaScript (if needed) -->
    <script src="{{ asset('assets/pegawai/app.js') }}"></script>
    </body>
</html>
