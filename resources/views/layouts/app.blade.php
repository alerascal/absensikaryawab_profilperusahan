<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>ABSENKUYYYY</title>
        <link
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
            rel="stylesheet"
        />
        <link
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
            rel="stylesheet"
        />
        <!-- Bootstrap CSS -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
        />

        <link rel="stylesheet" href="{{ asset('assets/admin/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/admin/app.css') }}" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        />
        <link
            href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
            rel="stylesheet"
        />
    </head>
    <body>
        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner"></div>
        </div>
        <!-- Overlay (penting untuk mobile toggle) -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Notification Container -->
        <div class="notification-container" id="notificationContainer"></div>

        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Overlay (penting untuk mobile toggle) -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <div class="container">
            @if(Auth::user()->role === 'admin')
            @include('component.admin.sidebar') @else
            @include('component.pegawai.sidebar') @endif

            <main class="main-content">
                @if(Auth::user()->role === 'admin')
                @include('component.admin.topbar') @else
                @include('component.pegawai.topbar') @endif @yield('content')
            </main>
        </div>
        <!-- Include JavaScript (if needed) -->
        <script src="{{ asset('assets/admin/app.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>
