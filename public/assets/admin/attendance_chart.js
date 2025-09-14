document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('attendanceChartContainer');
    if (!container) {
        console.error("Chart container not found");
        return;
    }

    // Helper function to safely parse JSON
    const safeParseJSON = (data, defaultValue = []) => {
        try {
            if (!data) return defaultValue;
            return JSON.parse(data);
        } catch (e) {
            console.error("JSON parse error:", e, "Data:", data);
            return defaultValue;
        }
    };

    const labels = safeParseJSON(container.dataset.labels, []);
    const hadir = safeParseJSON(container.dataset.hadir, []);
    const terlambat = safeParseJSON(container.dataset.terlambat, []);
    const absen = safeParseJSON(container.dataset.absen, []);
    const wfh = safeParseJSON(container.dataset.wfh, []);

    if (!labels.length) {
        console.warn("Data labels kosong, chart tidak akan ditampilkan");
        return;
    }

    const ctx = document.getElementById('monthlyAttendanceChart').getContext('2d');
    if (!ctx) {
        console.error("Canvas context not found");
        return;
    }

    // Gradient colors for Area Chart
    const gradientHadir = ctx.createLinearGradient(0, 0, 0, 400);
    gradientHadir.addColorStop(0, 'rgba(52, 211, 153, 0.4)');
    gradientHadir.addColorStop(1, 'rgba(16, 185, 129, 0.1)');

    const gradientTerlambat = ctx.createLinearGradient(0, 0, 0, 400);
    gradientTerlambat.addColorStop(0, 'rgba(250, 204, 21, 0.4)');
    gradientTerlambat.addColorStop(1, 'rgba(245, 158, 11, 0.1)');

    const gradientAbsen = ctx.createLinearGradient(0, 0, 0, 400);
    gradientAbsen.addColorStop(0, 'rgba(248, 113, 113, 0.4)');
    gradientAbsen.addColorStop(1, 'rgba(239, 68, 68, 0.1)');

    const gradientWFH = ctx.createLinearGradient(0, 0, 0, 400);
    gradientWFH.addColorStop(0, 'rgba(96, 165, 250, 0.4)');
    gradientWFH.addColorStop(1, 'rgba(59, 130, 246, 0.1)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Hadir',
                    data: hadir,
                    backgroundColor: gradientHadir,
                    borderColor: '#10b981',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3, // Slightly reduced tension for daily data
                    pointRadius: 0,
                },
                {
                    label: 'Terlambat',
                    data: terlambat,
                    backgroundColor: gradientTerlambat,
                    borderColor: '#f59e0b',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 0,
                },
                {
                    label: 'Tidak Hadir',
                    data: absen,
                    backgroundColor: gradientAbsen,
                    borderColor: '#ef4444',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 0,
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: { size: 14, family: 'Inter, sans-serif' },
                        color: '#1f2937',
                        padding: 20,
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(31, 41, 55, 0.9)',
                    titleColor: '#f9fafb',
                    bodyColor: '#f9fafb',
                    padding: 12,
                    cornerRadius: 8,
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            scales: {
                x: {
                    stacked: true,
                    grid: { display: false },
                    ticks: {
                        font: { size: 12, family: 'Inter, sans-serif' },
                        color: '#6b7280',
                        maxTicksLimit: 10, // Limit ticks for readability with daily data
                    }
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 12, family: 'Inter, sans-serif' },
                        color: '#6b7280',
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false,
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
});