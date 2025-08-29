document.addEventListener("DOMContentLoaded", function () {
    console.log("App Initialized");

    const loadingOverlay = document.getElementById("loadingOverlay");
    console.log("Overlay found:", loadingOverlay);

    setTimeout(() => {
        if (loadingOverlay) {
            console.log("Hiding overlay...");
            loadingOverlay.style.opacity = "0";
            setTimeout(() => {
                loadingOverlay.style.display = "none";
            }, 500);
        }
    }, 1000);

    // Initialize clock
    updateClock();
    setInterval(updateClock, 1000);

    // Initialize search functionality
    initializeSearch();

    // Show welcome notification
    showNotification("Selamat datang di AttendPro!", "success");
});

// Create sidebar overlay for mobile
function createSidebarOverlay() {
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    overlay.id = 'sidebarOverlay';
    overlay.addEventListener('click', closeSidebar);
    document.body.appendChild(overlay);
}

// Clock functionality
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString("id-ID", {
        hour12: false,
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });

    const dateString = now.toLocaleDateString("id-ID", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    });

    const clockElement = document.getElementById("liveClock");
    const dateElement = document.getElementById("liveDate");
    
    if (clockElement) clockElement.textContent = timeString;
    if (dateElement) dateElement.textContent = dateString;
}

// Navigation functionality
function showSection(sectionName) {
    // Hide all sections
    const sections = document.querySelectorAll(".content-section");
    sections.forEach((section) => {
        section.style.display = "none";
    });

    // Show selected section
    const targetSection = document.getElementById(sectionName + "-section");
    if (targetSection) {
        targetSection.style.display = "block";
    }

    // Update navigation active state
    const navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach((link) => {
        link.classList.remove("active");
    });

    // Add active class to clicked link
    if (event && event.target) {
        event.target.classList.add("active");
    }

    // Update page title and breadcrumb
    const titles = {
        dashboard: "Dashboard Absensi",
        attendance: "Absensi Hari Ini",
        employees: "Manajemen Karyawan",
        reports: "Laporan Absensi",
        settings: "Pengaturan Sistem",
        schedule: "Jadwal Kerja",
        notifications: "Notifikasi",
        help: "Bantuan"
    };

    const pageTitle = document.getElementById("pageTitle");
    const breadcrumbCurrent = document.getElementById("breadcrumbCurrent");
    
    if (pageTitle) {
        pageTitle.textContent = titles[sectionName] || "AttendPro";
    }
    if (breadcrumbCurrent) {
        breadcrumbCurrent.textContent = titles[sectionName] || "Dashboard";
    }

    // Close sidebar on mobile after navigation
    if (window.innerWidth <= 768) {
        closeSidebar();
    }
}

// Mobile sidebar toggle
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");
    
    if (sidebar && overlay) {
        if (sidebar.classList.contains("active")) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }
}

// Open sidebar
function openSidebar() {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");
    
    if (sidebar && overlay) {
        sidebar.classList.add("active");
        overlay.classList.add("active");
        // Prevent body scroll when sidebar is open
        document.body.style.overflow = "hidden";
    }
}

// Close sidebar
function closeSidebar() {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");
    
    if (sidebar && overlay) {
        sidebar.classList.remove("active");
        overlay.classList.remove("active");
        // Restore body scroll
        document.body.style.overflow = "";
    }
}

// Close sidebar when clicking outside on mobile
document.addEventListener("click", function (e) {
    const sidebar = document.getElementById("sidebar");
    const menuBtn = document.querySelector(".mobile-menu-btn");
    const overlay = document.getElementById("sidebarOverlay");

    if (
        window.innerWidth <= 768 &&
        sidebar &&
        menuBtn &&
        !sidebar.contains(e.target) &&
        !menuBtn.contains(e.target) &&
        sidebar.classList.contains("active")
    ) {
        closeSidebar();
    }
});

// Search functionality
function initializeSearch() {
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        searchInput.addEventListener("input", function (e) {
            const searchTerm = e.target.value.toLowerCase();
            // Implement search logic here
            console.log("Searching for:", searchTerm);
            
            if (searchTerm.length > 0) {
                // You can add search results functionality here
                // Example: filter employee list, reports, etc.
            }
        });
    }
}

// Notification system
function showNotification(message, type = "success") {
    let container = document.getElementById("notificationContainer");
    
    // Create container if it doesn't exist
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
            ${
                type === "success"
                    ? "Berhasil!"
                    : type === "error"
                    ? "Error!"
                    : type === "warning"
                    ? "Peringatan!"
                    : "Info!"
            }
        </div>
        <div>${message}</div>
    `;

    container.appendChild(notification);

    // Show notification
    setTimeout(() => {
        notification.classList.add("show");
    }, 100);

    // Hide notification
    setTimeout(() => {
        notification.classList.remove("show");
        setTimeout(() => {
            if (container.contains(notification)) {
                container.removeChild(notification);
            }
        }, 300);
    }, 4000);
}

// Action handlers
function markAttendance() {
    showNotification(
        "Fitur tandai kehadiran akan segera tersedia!",
        "success"
    );
}

function viewReports() {
    showSection("reports");
    showNotification("Navigasi ke halaman laporan", "success");
}

function addEmployee() {
    showNotification(
        "Fitur tambah karyawan akan segera tersedia!",
        "success"
    );
}

function exportData() {
    showNotification(
        "Fitur export data akan segera tersedia!",
        "success"
    );
}

function viewDetails(employeeId) {
    showNotification(
        `Detail karyawan ${employeeId} akan ditampilkan`,
        "success"
    );
}

function showNotifications() {
    showNotification("Anda memiliki 5 notifikasi baru", "success");
    // You can implement actual notification panel here
}

function showProfile() {
    showNotification(
        "Profil pengguna akan segera tersedia!",
        "success"
    );
}

// Logout function (if needed for JavaScript logout)
function logout() {
    if (confirm("Apakah Anda yakin ingin keluar?")) {
        showNotification(
            "Logout berhasil. Sampai jumpa!",
            "success"
        );
        setTimeout(() => {
            // Redirect to logout route or submit logout form
            const logoutForm = document.querySelector('form[action*="logout"]');
            if (logoutForm) {
                logoutForm.submit();
            } else {
                window.location.href = '/logout';
            }
        }, 1000);
    }
}

// Auto-refresh data every 30 seconds
setInterval(() => {
    // Simulate data refresh
    console.log("Refreshing attendance data...");
    // You can implement actual data refresh logic here
    // Example: fetch new attendance data via AJAX
}, 30000);

// Responsive handling
window.addEventListener("resize", function () {
    const sidebar = document.getElementById("sidebar");
    if (window.innerWidth > 768 && sidebar) {
        closeSidebar();
    }
});

// Keyboard shortcuts
document.addEventListener("keydown", function(e) {
    // ESC key closes sidebar on mobile
    if (e.key === "Escape" && window.innerWidth <= 768) {
        closeSidebar();
    }
    
    // Ctrl/Cmd + K opens search
    if ((e.ctrlKey || e.metaKey) && e.key === "k") {
        e.preventDefault();
        const searchInput = document.getElementById("searchInput");
        if (searchInput) {
            searchInput.focus();
        }
    }
});

// Smooth scroll for internal links
document.addEventListener("click", function(e) {
    if (e.target.matches('a[href^="#"]')) {
        e.preventDefault();
        const target = document.querySelector(e.target.getAttribute("href"));
        if (target) {
            target.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        }
    }
});

// Initialize tooltips (if you want to add them)
function initializeTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
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

// Performance optimization: debounce function
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

// Optimized search with debounce
const debouncedSearch = debounce(function(searchTerm) {
    // Implement actual search logic here
    console.log("Performing search for:", searchTerm);
}, 300);

// Update search functionality to use debounced search
function initializeSearch() {
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        searchInput.addEventListener("input", function (e) {
            const searchTerm = e.target.value.toLowerCase();
            debouncedSearch(searchTerm);
        });
    }
}