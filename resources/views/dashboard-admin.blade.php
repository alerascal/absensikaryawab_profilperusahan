@extends('layouts.app')

@section('breadcrumb') Dashboard @endsection

@section('content')
<div id="dashboard-section" class="content-section">

    <!-- Live Status Card -->
    <div class="status-card animate-slide-up bg-white rounded-xl shadow-md p-6">
        <div class="live-clock text-2xl font-bold text-gray-800" id="liveClock">
            {{ now()->format('H:i:s') }}
        </div>
        <div class="live-date text-sm text-gray-600" id="liveDate">
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
        <div class="status-info grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
            <div class="status-item text-center">
                <div class="status-value text-lg font-semibold text-gray-900">{{ $jamMasuk }}</div>
                <div class="status-label text-sm text-gray-600">Jam Masuk</div>
            </div>
            <div class="status-item text-center">
                <div class="status-value text-lg font-semibold text-gray-900">{{ $jamPulang }}</div>
                <div class="status-label text-sm text-gray-600">Jam Pulang</div>
            </div>
            <div class="status-item text-center">
                <div class="status-value text-lg font-semibold text-gray-900">{{ $statusSistem }}</div>
                <div class="status-label text-sm text-gray-600">Status Sistem</div>
            </div>
            <div class="status-item text-center">
                <div class="status-value text-lg font-semibold text-gray-900">{{ $karyawanAktif }}/{{ $totalUsers }}</div>
                <div class="status-label text-sm text-gray-600">Karyawan Aktif / Total</div>
            </div>
        </div>
    </div>

    <!-- Stats Grid Modern & Minimalis -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mt-6 animate-fade-in">
        <div class="stat-card bg-white shadow-md rounded-xl p-5 flex items-center space-x-4 transform transition hover:scale-105 hover:shadow-lg">
            <div class="stat-icon w-14 h-14 flex items-center justify-center rounded-full bg-green-500 text-white text-2xl">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <div class="stat-number text-3xl font-extrabold text-gray-900">{{ $hadirHariIni }}</div>
                <div class="stat-label text-sm font-medium text-gray-600">Hadir Hari Ini</div>
            </div>
        </div>

        <div class="stat-card bg-white shadow-md rounded-xl p-5 flex items-center space-x-4 transform transition hover:scale-105 hover:shadow-lg">
            <div class="stat-icon w-14 h-14 flex items-center justify-center rounded-full bg-yellow-500 text-white text-2xl">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div class="stat-number text-3xl font-extrabold text-gray-900">{{ $terlambat }}</div>
                <div class="stat-label text-sm font-medium text-gray-600">Terlambat</div>
            </div>
        </div>

        <div class="stat-card bg-white shadow-md rounded-xl p-5 flex items-center space-x-4 transform transition hover:scale-105 hover:shadow-lg">
            <div class="stat-icon w-14 h-14 flex items-center justify-center rounded-full bg-red-500 text-white text-2xl">
                <i class="fas fa-user-times"></i>
            </div>
            <div>
                <div class="stat-number text-3xl font-extrabold text-gray-900">{{ $absenHariIni }}</div>
                <div class="stat-label text-sm font-medium text-gray-600">Absen</div>
            </div>
        </div>

        <div class="stat-card bg-white shadow-md rounded-xl p-5 flex items-center space-x-4 transform transition hover:scale-105 hover:shadow-lg">
            <div class="stat-icon w-14 h-14 flex items-center justify-center rounded-full bg-blue-500 text-white text-2xl">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="stat-number text-3xl font-extrabold text-gray-900">{{ $totalUsers }}</div>
                <div class="stat-label text-sm font-medium text-gray-600">Total Karyawan</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Panel -->
    <div class="quick-panel animate-slide-up mt-6 bg-white rounded-xl shadow-md p-6">
        <div class="panel-header">
            <div class="panel-title text-lg font-semibold text-gray-800">Aksi Cepat</div>
            <div class="panel-subtitle text-sm text-gray-600">Kelola absensi dengan mudah</div>
        </div>
        <div class="actions-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-4">
            <a href="{{ route('reports.attendance') }}" class="action-btn warning bg-yellow-100 text-yellow-700 rounded-lg p-4 hover:bg-yellow-200 transition">
                <i class="fas fa-file-alt text-xl"></i>
                <div class="btn-text font-medium">Buat Laporan</div>
                <div class="btn-desc text-sm">Generate laporan absensi</div>
            </a>
            <a href="{{ route('employees.create') }}" class="action-btn secondary bg-blue-100 text-blue-700 rounded-lg p-4 hover:bg-blue-200 transition">
                <i class="fas fa-user-plus text-xl"></i>
                <div class="btn-text font-medium">Tambah Karyawan</div>
                <div class="btn-desc text-sm">Daftarkan karyawan baru</div>
            </a>
            <a href="{{  route('reports.monthly')  }}" class="action-btn danger bg-red-100 text-red-700 rounded-lg p-4 hover:bg-red-200 transition">
                <i class="fas fa-download text-xl"></i>
                <div class="btn-text font-medium">Export Data</div>
                <div class="btn-desc text-sm">Download data Excel/PDF</div>
            </a>
        </div>
    </div>

    <!-- Month Filter -->
    <div class="flex justify-end mb-4 mt-6">
        <form action="{{ route('admin.dashboard-admin') }}" method="GET" class="flex items-center space-x-2">
            <label for="month" class="text-sm font-medium text-gray-700">Pilih Bulan:</label>
            <select name="month" id="month" class="border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-500">
                @foreach($months as $m)
                <option value="{{ $m['value'] }}" {{ $month == $m['value'] ? 'selected' : '' }}>{{ $m['name'] }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-white rounded-lg px-4 py-2 text-sm hover:bg-blue-600 transition">Tampilkan</button>
        </form>
    </div>

    <!-- Chart Section -->
    <div class="chart-panel mt-6 bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-bold mb-4 text-gray-800">Grafik Kehadiran Harian ({{ Carbon\Carbon::create(null, $month, 1)->translatedFormat('F Y') }})</h3>
        <div id="attendanceChartContainer"
             data-labels="{{ json_encode($monthlyLabels, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }}"
             data-hadir="{{ json_encode($monthlyHadir, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }}"
             data-terlambat="{{ json_encode($monthlyTerlambat, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }}"
             data-absen="{{ json_encode($monthlyAbsen, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }}">
            <canvas id="monthlyAttendanceChart" style="max-height: 400px;"></canvas>
        </div>
    </div>

    <!-- Departments and Late Table -->
    <div class="flex flex-col md:flex-row gap-6 mt-6">
        <div class="flex-1 chart-panel animate-fade-in p-6 bg-white rounded-xl shadow-md">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Departemen Terbaik (Persentase Kehadiran)</h3>
            <ul class="departemen-list space-y-4">
                @foreach($departments as $dept)
                <li class="flex items-center justify-between">
                    <span class="font-medium text-gray-700">{{ $dept->name }}</span>
                    <span class="font-semibold text-gray-900">{{ $dept->persen }}%</span>
                </li>
                <li>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-green-500 h-2.5 rounded-full transition-all duration-300" style="width: {{ $dept->persen }}%"></div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
      <div class="overflow-x-auto">
    <table class="min-w-full text-sm text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 text-gray-700">
                <th class="p-3 border-b font-semibold">No</th>
                <th class="p-3 border-b font-semibold">Nama Karyawan</th>
                <th class="p-3 border-b font-semibold">Jam Masuk</th>
                <th class="p-3 border-b font-semibold">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @forelse($terlambatHariIni as $user)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-3 border-b">{{ $no++ }}</td>
                <td class="p-3 border-b">{{ $user->name }}</td>
                <td class="p-3 border-b">{{ $user->attendance->check_in ?? '-' }}</td>
                <td class="p-3 border-b text-yellow-600 font-semibold">Terlambat</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-3 text-center text-gray-500">Tidak ada yang terlambat hari ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

    </div>
</div>
<!-- Include Chart.js and attendance_chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/admin/attendance_chart.js') }}"></script>
<link href="{{ asset('assets/admin/attendance_chart.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection
