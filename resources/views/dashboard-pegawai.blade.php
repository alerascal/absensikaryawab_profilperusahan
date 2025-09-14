@extends('layouts.app')

@section('breadcrumb') Dashboard @endsection

@section('content')
<div id="dashboard-section" class="content-section">

    <!-- Live Clock + Info Hari Ini -->
    <div class="status-card animate-slide-up bg-white rounded-xl shadow-md p-6">
        <div class="live-clock text-2xl font-bold text-gray-800" id="liveClock">
            {{ now()->format('H:i:s') }}
        </div>
        <div class="live-date text-sm text-gray-600" id="liveDate">
            {{ now()->translatedFormat('l, d F Y') }}
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
            <div class="status-item text-center">
                <div class="status-value text-lg font-semibold text-gray-900">
                    {{ $todayCheckIn ?? '-' }}
                </div>
                <div class="status-label text-sm text-gray-600">Jam Masuk</div>
            </div>
            <div class="status-item text-center">
                <div class="status-value text-lg font-semibold text-gray-900">
                    {{ $todayCheckOut ?? '-' }}
                </div>
                <div class="status-label text-sm text-gray-600">Jam Pulang</div>
            </div>
            <div class="status-item text-center">
                <div class="status-value text-lg font-semibold 
                    {{ $todayStatus == 'Hadir' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $todayStatus ?? 'Belum Absen' }}
                </div>
                <div class="status-label text-sm text-gray-600">Status</div>
            </div>
            <div class="status-item text-center">
                <div class="status-value text-lg font-semibold text-gray-900">
                    {{ $totalAbsensi }}
                </div>
                <div class="status-label text-sm text-gray-600">Total Kehadiran Bulan Ini</div>
            </div>
        </div>
    </div>

    <!-- Riwayat Absensi -->
    <div class="mt-6 bg-white rounded-xl shadow-md p-6 animate-fade-in">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Riwayat Absensi Minggu Ini</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700">
                        <th class="p-3 border-b font-semibold">Tanggal</th>
                        <th class="p-3 border-b font-semibold">Jam Masuk</th>
                        <th class="p-3 border-b font-semibold">Jam Pulang</th>
                        <th class="p-3 border-b font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($weeklyAttendance as $att)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-3 border-b">{{ \Carbon\Carbon::parse($att->date)->translatedFormat('l, d F Y') }}</td>
                        <td class="p-3 border-b">{{ $att->check_in ?? '-' }}</td>
                        <td class="p-3 border-b">{{ $att->check_out ?? '-' }}</td>
                        <td class="p-3 border-b font-semibold 
                            {{ $att->status == 'Hadir' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $att->status }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-3 text-center text-gray-500">Belum ada data absensi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Grafik Kehadiran Bulanan -->
    <div class="chart-panel mt-6 bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-bold mb-4 text-gray-800">Grafik Kehadiran Bulan Ini</h3>
        <div id="attendanceChartContainer"
             data-labels="{{ json_encode($monthlyLabels) }}"
             data-hadir="{{ json_encode($monthlyData) }}">
            <canvas id="pegawaiMonthlyChart" style="max-height: 350px;"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("attendanceChartContainer");
    if (!container) return;

    const labels = JSON.parse(container.dataset.labels || "[]");
    const hadir  = JSON.parse(container.dataset.hadir || "[]");

    const ctx = document.getElementById("pegawaiMonthlyChart").getContext("2d");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Jumlah Absensi",
                    data: hadir,
                    backgroundColor: "rgba(59, 130, 246, 0.7)",
                    borderRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
@endsection
