<!-- Topbar -->
<header class="top-bar animate__animated animate__fadeInDown">
    <div class="page-title">
        <h1 id="pageTitle" class="text-lg font-bold text-gray-800">
            Dashboard Absensi
        </h1>
        <div class="breadcrumb text-sm text-gray-600">
            <a
                href="{{ route('admin.dashboard-admin') }}"
                class="hover:underline"
            >
                <i class="fas fa-home mr-1"></i> Dashboard
            </a>
            / @yield('breadcrumb')
            <span id="breadcrumbCurrent" class="ml-1 font-medium text-gray-800"
                >Dashboard</span
            >
        </div>
    </div>

    <div class="top-actions flex items-center gap-4">
      <!-- Profile Button -->
<div class="relative" id="profileMenuWrapper">
    <button 
        id="profileBtn"
        class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition"
    >
        {{ auth()->user()->name ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'AM' }}
    </button>

    <!-- Dropdown Menu -->
    <div 
        id="profileMenu"
        class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg py-2 z-50"
    >
        <a href="{{ route('settings.index') }}" 
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
           <i class="fas fa-cog mr-2"></i> Pengaturan
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
            </button>
        </form>
    </div>
</div>

<!-- Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const profileBtn = document.getElementById("profileBtn");
        const profileMenu = document.getElementById("profileMenu");
        const wrapper = document.getElementById("profileMenuWrapper");

        // Toggle menu on button click
        profileBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            profileMenu.classList.toggle("hidden");
        });

        // Close menu if clicked outside
        document.addEventListener("click", function (e) {
            if (!wrapper.contains(e.target)) {
                profileMenu.classList.add("hidden");
            }
        });
    });
</script>    
</header>
