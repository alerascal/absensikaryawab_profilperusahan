@extends('layouts.app')
@section('title', 'Dashboard Pegawai')
@php
    use Illuminate\Support\Facades\Auth;
@endphp
@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Selamat Datang -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-10">
            <h1 class="text-3xl md:text-4xl font-light text-gray-900 mb-2">
                Halo, {{ Auth::user()->name }} 👋
            </h1>
            <p class="text-lg text-gray-600">Selamat datang kembali di dashboard absensi Anda</p>
        </div>

        <!-- Live Clock & Status Hari Ini -->
        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <div class="text-4xl font-bold text-gray-900" id="liveClock">
                        {{ now()->format('H:i:s') }}
                    </div>
                    <div class="text-lg text-gray-600 mt-2" id="liveDate">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>
                <div class="mt-6 md:mt-0 text-center md:text-right">
                    <p class="text-sm text-gray-600">Status Hari Ini</p>
                    <p class="text-2xl font-bold mt-2 
                        {{ $todayStatus == 'Hadir' ? 'text-green-600' : 
                           ($todayStatus == 'Izin' ? 'text-amber-600' : 'text-red-600') }}">
                        {{ $todayStatus }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-gray-50 rounded-2xl">
                    <p class="text-3xl font-bold text-gray-900">{{ $todayCheckIn }}</p>
                    <p class="text-sm text-gray-600 mt-2">Jam Masuk</p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-2xl">
                    <p class="text-3xl font-bold text-gray-900">{{ $todayCheckOut }}</p>
                    <p class="text-sm text-gray-600 mt-2">Jam Pulang</p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-2xl">
                    <p class="text-3xl font-bold text-gray-900">{{ $totalAbsensi }}</p>
                    <p class="text-sm text-gray-600 mt-2">Total Hadir Bulan Ini</p>
                </div>
            </div>
        </div>

        <!-- Riwayat Absensi Minggu Ini -->
        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-10">
            <h3 class="text-xl font-semibold text-gray-900 mb-6">Riwayat Absensi Minggu Ini</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-sm text-gray-600 border-b">
                        <tr>
                            <th class="pb-4">Tanggal</th>
                            <th class="pb-4">Masuk</th>
                            <th class="pb-4">Pulang</th>
                            <th class="pb-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($weeklyAttendance as $att)
                            <tr class="hover:bg-gray-50 transition py-4">
                                <td class="py-4">{{ \Carbon\Carbon::parse($att->date)->translatedFormat('D, d M') }}</td>
                                <td class="py-4">{{ $att->check_in ?? '-' }}</td>
                                <td class="py-4">{{ $att->check_out ?? '-' }}</td>
                                <td class="py-4">
                                    <span class="inline-block px-4 py-2 rounded-full text-xs font-medium
                                        {{ $att->status == 'Hadir' ? 'bg-green-100 text-green-800' :
                                           ($att->status == 'Izin' ? 'bg-amber-100 text-amber-800' :
                                           'bg-red-100 text-red-800') }}">
                                        {{ $att->status ?? 'Tidak Hadir' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-gray-500">
                                    Belum ada data absensi minggu ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Grafik Kehadiran Bulan Ini -->
        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8">
            <h3 class="text-xl font-semibold text-gray-900 mb-6">Grafik Kehadiran Bulan {{ now()->translatedFormat('F Y') }}</h3>
            <div class="relative">
                <canvas id="pegawaiMonthlyChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('pegawaiMonthlyChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($monthlyLabels),
            datasets: [{
                label: 'Hadir',
                data: @json($monthlyHadir),
                backgroundColor: 'rgba(30, 41, 59, 0.9)',
                borderColor: 'rgb(30, 41, 59)',
                borderWidth: 1,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw === 1 ? 'Hadir' : 'Tidak Hadir';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 1,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return value === 1 ? 'Hadir' : 'Tidak';
                        }
                    },
                    grid: { display: false }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});

// Live Clock Update
setInterval(() => {
    const now = new Date();
    document.getElementById('liveClock').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
}, 1000);
</script>
@endsection