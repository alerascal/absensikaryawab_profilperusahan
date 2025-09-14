document.addEventListener('DOMContentLoaded', () => {
    console.log("App Initialized");

    // DOM Elements
    const elements = {
        loadingOverlay: document.getElementById("loadingOverlay"),
        clockElement: document.getElementById("liveClock"),
        dateElement: document.getElementById("liveDate"),
        sidebar: document.getElementById("sidebar"),
        sidebarOverlay: null, // Will be created dynamically
        searchInput: document.getElementById("searchInput")
    };

    // Initialize Application
    function initializeApp() {
        hideLoadingOverlay();
        initializeClock();
        initializeSearch();
        initializeTooltips();
        createSidebarOverlay();
        showNotification("Selamat datang di AttendPro!", "success");
    }

    // Loading Overlay
    function hideLoadingOverlay() {
        if (elements.loadingOverlay) {
            console.log("Hiding overlay...");
            setTimeout(() => {
                elements.loadingOverlay.style.opacity = "0";
                setTimeout(() => {
                    elements.loadingOverlay.style.display = "none";
                }, 500);
            }, 1000);
        }
    }

    // Clock Functionality
    function initializeClock() {
        updateClock();
        setInterval(updateClock, 1000);
    }

    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString("id-ID", {
            hour12: false,
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit"
        });
        const dateString = now.toLocaleDateString("id-ID", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric"
        });

        if (elements.clockElement) elements.clockElement.textContent = timeString;
        if (elements.dateElement) elements.dateElement.textContent = dateString;
    }

    // Sidebar Functions
    function createSidebarOverlay() {
        elements.sidebarOverlay = document.createElement('div');
        elements.sidebarOverlay.className = 'sidebar-overlay';
        elements.sidebarOverlay.id = 'sidebarOverlay';
        elements.sidebarOverlay.addEventListener('click', closeSidebar);
        document.body.appendChild(elements.sidebarOverlay);
    }

    function toggleSidebar() {
        if (elements.sidebar && elements.sidebarOverlay) {
            if (elements.sidebar.classList.contains("active")) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }
    }

    function openSidebar() {
        if (elements.sidebar && elements.sidebarOverlay) {
            elements.sidebar.classList.add("active");
            elements.sidebarOverlay.classList.add("active");
            document.body.style.overflow = "hidden";
        }
    }

    function closeSidebar() {
        if (elements.sidebar && elements.sidebarOverlay) {
            elements.sidebar.classList.remove("active");
            elements.sidebarOverlay.classList.remove("active");
            document.body.style.overflow = "";
        }
    }

    // Navigation - Sesuai dengan controller routes
    function showSection(sectionName) {
        document.querySelectorAll(".content-section").forEach(section => {
            section.style.display = "none";
        });

        const targetSection = document.getElementById(`${sectionName}-section`);
        if (targetSection) {
            targetSection.style.display = "block";
        }

        document.querySelectorAll(".nav-link").forEach(link => {
            link.classList.remove("active");
        });

        const titles = {
            dashboard: "Dashboard Absensi",
            attendance: "Absensi Hari Ini", // Sesuai AttendanceController@index
            employees: "Manajemen Karyawan", // Sesuai AttendanceController@users
            reports: "Laporan Absensi", // Sesuai AttendanceController@showAttendancePage
            settings: "Pengaturan Sistem",
            schedule: "Jadwal Kerja",
            notifications: "Notifikasi",
            help: "Bantuan",
            locations: "Lokasi Absensi" // Sesuai AttendanceController@locations
        };

        const pageTitle = document.getElementById("pageTitle");
        const breadcrumbCurrent = document.getElementById("breadcrumbCurrent");
        
        if (pageTitle) pageTitle.textContent = titles[sectionName] || "AttendPro";
        if (breadcrumbCurrent) breadcrumbCurrent.textContent = titles[sectionName] || "Dashboard";

        if (window.innerWidth <= 768) {
            closeSidebar();
        }
    }

    // Search Functionality
    function initializeSearch() {
        if (elements.searchInput) {
            elements.searchInput.addEventListener("input", e => {
                const searchTerm = e.target.value.toLowerCase();
                debouncedSearch(searchTerm);
            });
        }
    }

    const debouncedSearch = debounce((searchTerm) => {
        console.log("Performing search for:", searchTerm);
        // Implementasi pencarian bisa disesuaikan dengan kebutuhan
    }, 300);

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Notification System
    function showNotification(message, type = "success") {
        let container = document.getElementById("notificationContainer");
        if (!container) {
            container = document.createElement("div");
            container.id = "notificationContainer";
            container.className = "notification-container";
            document.body.appendChild(container);
        }

        const notification = document.createElement("div");
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div style="font-weight: 600; margin-bottom: 0.5rem;">
                ${type === "success" ? "Berhasil!" : 
                  type === "error" ? "Error!" : 
                  type === "warning" ? "Peringatan!" : "Info!"}
            </div>
            <div>${message}</div>
        `;

        container.appendChild(notification);
        setTimeout(() => notification.classList.add("show"), 100);
        setTimeout(() => {
            notification.classList.remove("show");
            setTimeout(() => {
                if (container.contains(notification)) {
                    container.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }

    // Tooltips
    function initializeTooltips() {
        document.querySelectorAll('[data-tooltip]').forEach(element => {
            element.addEventListener('mouseenter', showTooltip);
            element.addEventListener('mouseleave', hideTooltip);
        });

        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('mouseenter', () => btn.style.transform = 'scale(1.1)');
            btn.addEventListener('mouseleave', () => btn.style.transform = 'scale(1)');
        });
    }

    function showTooltip(e) {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = e.target.getAttribute('data-tooltip');
        tooltip.style.cssText = `
            position: absolute;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
            pointer-events: none;
            z-index: 1000;
        `;
        document.body.appendChild(tooltip);

        const rect = e.target.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
        
        e.target._tooltip = tooltip;
    }

    function hideTooltip(e) {
        if (e.target._tooltip) {
            document.body.removeChild(e.target._tooltip);
            delete e.target._tooltip;
        }
    }

    // Business Logic Functions - Sesuai dengan Controller Methods
    function markAttendance() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");
        if (!csrfToken) {
            showNotification("CSRF token tidak tersedia", "error");
            return;
        }

        // Sesuai dengan AttendanceController@store
        fetch("/admin/attendance", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ status: "Hadir" })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`${data.message}`, "success");
                } else {
                    showNotification("Gagal menandai absensi", "error");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                showNotification("Terjadi error saat request", "error");
            });
    }

    function viewReports() {
        // Sesuai dengan AttendanceController@showAttendancePage
        showSection("reports");
        showNotification("Navigasi ke halaman laporan", "success");
    }

    function addEmployee() {
        // Sesuai dengan AttendanceController@users
        showNotification("Fitur tambah karyawan akan segera tersedia!", "success");
    }

    function exportData() {
        // Sesuai dengan AttendanceController@downloadPdf atau monthlyPdf
        showNotification("Fitur export data akan segera tersedia!", "success");
    }

    function viewDetails(employeeId) {
        // Sesuai dengan AttendanceController@show
        showNotification(`Detail karyawan ${employeeId} akan ditampilkan`, "success");
    }

    function showNotifications() {
        showNotification("Anda memiliki 5 notifikasi baru", "success");
    }

    function showProfile() {
        showNotification("Profil pengguna akan segera tersedia!", "success");
    }

    function logout() {
        if (confirm("Apakah Anda yakin ingin keluar?")) {
            showNotification("Logout berhasil. Sampai jumpa!", "success");
            setTimeout(() => {
                const logoutForm = document.querySelector('form[action*="logout"]');
                if (logoutForm) {
                    logoutForm.submit();
                } else {
                    window.location.href = '/logout';
                }
            }, 1000);
        }
    }

    // Event Listeners
    function setupEventListeners() {
        document.addEventListener("click", e => {
            if (e.target.matches('a[href^="#"]')) {
                e.preventDefault();
                const target = document.querySelector(e.target.getAttribute("href"));
                if (target) {
                    target.scrollIntoView({ behavior: "smooth", block: "start" });
                }
            }

            const menuBtn = document.querySelector(".mobile-menu-btn");
            if (
                window.innerWidth <= 768 &&
                elements.sidebar &&
                menuBtn &&
                !elements.sidebar.contains(e.target) &&
                !menuBtn.contains(e.target) &&
                elements.sidebar.classList.contains("active")
            ) {
                closeSidebar();
            }
        });

        window.addEventListener("resize", () => {
            if (window.innerWidth > 768 && elements.sidebar) {
                closeSidebar();
            }
        });

        document.addEventListener("keydown", e => {
            if (e.key === "Escape" && window.innerWidth <= 768) {
                closeSidebar();
            }
            if ((e.ctrlKey || e.metaKey) && e.key === "k") {
                e.preventDefault();
                if (elements.searchInput) {
                    elements.searchInput.focus();
                }
            }
        });
    }

    // Expose functions globally for HTML onclick handlers
    window.toggleSidebar = toggleSidebar;
    window.showSection = showSection;
    window.markAttendance = markAttendance;
    window.viewReports = viewReports;
    window.addEmployee = addEmployee;
    window.exportData = exportData;
    window.viewDetails = viewDetails;
    window.showNotifications = showNotifications;
    window.showProfile = showProfile;
    window.logout = logout;
    window.showNotification = showNotification;

    // Start Application
    initializeApp();
    setupEventListeners();
});
