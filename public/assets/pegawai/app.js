let isCheckedIn = false;
let checkInTimestamp = null;
let workTimer = null;

// Initialize the application
document.addEventListener("DOMContentLoaded", function () {
    // Hide loading overlay
    setTimeout(() => {
        const overlay = document.getElementById("loadingOverlay");
        if (overlay) {
            overlay.style.opacity = "0";
            setTimeout(() => {
                overlay.style.display = "none";
            }, 500);
        }
    }, 1000);

    // Initialize clock
    updateClock();
    setInterval(updateClock, 1000);

    // Show welcome notification
    showNotification("Selamat datang, John! Jangan lupa absen hari ini.", "success");
});

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

    const timeEl = document.getElementById("currentTime");
    const dateEl = document.getElementById("currentDate");

    if (timeEl) timeEl.textContent = timeString;
    if (dateEl) dateEl.textContent = dateString;

    if (isCheckedIn && checkInTimestamp) {
        updateWorkDuration();
    }
}

// Navigation functionality
function showSection(sectionName) {
    const sections = document.querySelectorAll(".content-section");
    sections.forEach((section) => {
        section.style.display = "none";
    });

    const activeSection = document.getElementById(sectionName + "-section");
    if (activeSection) activeSection.style.display = "block";

    const navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach((link) => link.classList.remove("active"));

    if (event && event.target) {
        event.target.classList.add("active");
    }

    const titles = {
        dashboard: "Dashboard Karyawan",
        attendance: "Absensi Saya",
        schedule: "Jadwal Kerja",
        history: "Riwayat Absensi",
        leave: "Pengajuan Cuti",
        overtime: "Lembur",
        payroll: "Slip Gaji",
        profile: "Profil Saya",
        notifications: "Notifikasi",
        help: "Bantuan",
    };

    const pageTitle = document.getElementById("pageTitle");
    const breadcrumbCurrent = document.getElementById("breadcrumbCurrent");

    if (pageTitle) pageTitle.textContent = titles[sectionName] || "AttendPro";
    if (breadcrumbCurrent) breadcrumbCurrent.textContent = titles[sectionName] || "Dashboard";
}

// Check-in functionality
function checkIn() {
    if (isCheckedIn) return;

    const now = new Date();
    const timeString = now.toLocaleTimeString("id-ID", {
        hour12: false,
        hour: "2-digit",
        minute: "2-digit",
    });

    isCheckedIn = true;
    checkInTimestamp = now;

    document.getElementById("checkinBtn").style.display = "none";
    document.getElementById("checkoutBtn").style.display = "flex";
    document.getElementById("checkinBtn").classList.add("checked-in");

    document.getElementById("checkInTime").textContent = timeString;
    document.getElementById("currentStatus").textContent = "Sedang Bekerja";

    updateWorkDuration();
    workTimer = setInterval(updateWorkDuration, 60000);

    showNotification("Check-in berhasil! Selamat bekerja.", "success");
}

// Check-out functionality
function checkOut() {
    if (!isCheckedIn) return;

    const now = new Date();
    const timeString = now.toLocaleTimeString("id-ID", {
        hour12: false,
        hour: "2-digit",
        minute: "2-digit",
    });

    isCheckedIn = false;

    document.getElementById("checkoutBtn").style.display = "none";
    document.getElementById("checkinBtn").style.display = "flex";
    document.getElementById("checkoutBtn").classList.add("checked-out");

    document.getElementById("checkOutTime").textContent = timeString;
    document.getElementById("currentStatus").textContent = "Selesai Kerja";

    if (workTimer) {
        clearInterval(workTimer);
        workTimer = null;
    }

    showNotification("Check-out berhasil! Terima kasih atas kerja kerasnya.", "success");
}

// Update work duration
function updateWorkDuration() {
    if (!checkInTimestamp) return;

    const now = new Date();
    const diffMs = now - checkInTimestamp;
    const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
    const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));

    document.getElementById("workDuration").textContent =
        `${diffHours}:${diffMinutes.toString().padStart(2, "0")}`;
}

// Sidebar toggle (mobile)
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");

    if (sidebar && overlay) {
        sidebar.classList.toggle("active");
        overlay.classList.toggle("active");
        document.body.style.overflow = sidebar.classList.contains("active") ? "hidden" : "";
    }
}

// Close sidebar when overlay clicked
const sidebarOverlay = document.getElementById("sidebarOverlay");
if (sidebarOverlay) {
    sidebarOverlay.addEventListener("click", toggleSidebar);
}

// Close sidebar when clicking outside (mobile)
document.addEventListener("click", function (e) {
    const sidebar = document.getElementById("sidebar");
    const menuBtn = document.querySelector(".mobile-menu-btn");

    if (
        window.innerWidth <= 768 &&
        sidebar &&
        menuBtn &&
        !sidebar.contains(e.target) &&
        !menuBtn.contains(e.target) &&
        sidebar.classList.contains("active")
    ) {
        sidebar.classList.remove("active");
        sidebarOverlay.classList.remove("active");
        document.body.style.overflow = "";
    }
});

// Notification system
function showNotification(message, type = "success") {
    const container = document.getElementById("notificationContainer");
    if (!container) return;

    const notification = document.createElement("div");
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div style="font-weight: 600; margin-bottom: 0.5rem;">
            ${type === "success" ? "Berhasil!" : type === "error" ? "Error!" : "Info!"}
        </div>
        <div>${message}</div>
    `;

    container.appendChild(notification);

    setTimeout(() => {
        notification.classList.add("show");
    }, 100);

    setTimeout(() => {
        notification.classList.remove("show");
        setTimeout(() => {
            container.removeChild(notification);
        }, 300);
    }, 4000);
}

// Action handlers
function showNotifications() {
    showNotification("Anda memiliki 5 notifikasi baru", "success");
}

function showProfile() {
    showSection("profile");
}

function logout() {
    if (confirm("Apakah Anda yakin ingin keluar?")) {
        showNotification("Logout berhasil. Sampai jumpa!", "success");
        setTimeout(() => {
            console.log("Logging out...");
        }, 1000);
    }
}

// Responsive handling
window.addEventListener("resize", function () {
    const sidebar = document.getElementById("sidebar");
    if (window.innerWidth > 768 && sidebar) {
        sidebar.classList.remove("active");
    }
});
