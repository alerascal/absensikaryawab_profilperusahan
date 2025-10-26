@extends('layouts.app')

@section('breadcrumb') Dashboard @endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-4 px-4 sm:py-6 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Live Status Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col space-y-4 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 mb-6">
                <div>
                    <div class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1" id="liveClock">
                        {{ now()->format('H:i:s') }}
                    </div>
                    <div class="text-sm text-gray-600" id="liveDate">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>
                <div>
                    <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                        Sistem Aktif
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <div class="text-center p-3 sm:p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <div class="text-lg sm:text-xl font-semibold text-blue-900 mb-1">{{ $jamMasuk }}</div>
                    <div class="text-xs text-blue-600 font-medium">Jam Masuk</div>
                </div>
                <div class="text-center p-3 sm:p-4 bg-purple-50 rounded-xl border border-purple-100">
                    <div class="text-lg sm:text-xl font-semibold text-purple-900 mb-1">{{ $jamPulang }}</div>
                    <div class="text-xs text-purple-600 font-medium">Jam Pulang</div>
                </div>
                <div class="text-center p-3 sm:p-4 bg-green-50 rounded-xl border border-green-100">
                    <div class="text-lg sm:text-xl font-semibold text-green-900 mb-1">{{ $statusSistem }}</div>
                    <div class="text-xs text-green-600 font-medium">Status Sistem</div>
                </div>
                <div class="text-center p-3 sm:p-4 bg-orange-50 rounded-xl border border-orange-100">
                    <div class="text-lg sm:text-xl font-semibold text-orange-900 mb-1">{{ $karyawanAktif }}/{{ $totalUsers }}</div>
                    <div class="text-xs text-orange-600 font-medium">Karyawan Aktif</div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                        <p class="text-xl sm:text-2xl font-bold text-gray-900 truncate">{{ $hadirHariIni }}</p>
                        <p class="text-sm text-gray-600 font-medium">Hadir Hari Ini</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                        <p class="text-xl sm:text-2xl font-bold text-gray-900 truncate">{{ $terlambat }}</p>
                        <p class="text-sm text-gray-600 font-medium">Terlambat</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                        <p class="text-xl sm:text-2xl font-bold text-gray-900 truncate">{{ $absenHariIni }}</p>
                        <p class="text-sm text-gray-600 font-medium">Absen</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                        <p class="text-xl sm:text-2xl font-bold text-gray-900 truncate">{{ $totalUsers }}</p>
                        <p class="text-sm text-gray-600 font-medium">Total Karyawan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Panel -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 lg:p-8">
            <div class="mb-6">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">Aksi Cepat</h3>
                <p class="text-sm sm:text-base text-gray-600">Kelola absensi dan karyawan dengan mudah</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <a href="{{ route('reports.attendance') }}" 
                   class="group p-4 sm:p-6 bg-yellow-50 hover:bg-yellow-100 rounded-xl border border-yellow-200 transition-all duration-200 hover:shadow-md hover:border-yellow-300">
                    <div class="flex items-center justify-center w-10 h-10 bg-yellow-200 group-hover:bg-yellow-300 rounded-lg mb-3 sm:mb-4 mx-auto">
                        <svg class="w-5 h-5 text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-yellow-900 mb-1 text-center text-sm sm:text-base">Buat Laporan</h4>
                    <p class="text-xs sm:text-sm text-yellow-700 text-center">Generate laporan absensi</p>
                </a>

                <a href="{{ route('admin.employees.create') }}" 
                   class="group p-4 sm:p-6 bg-blue-50 hover:bg-blue-100 rounded-xl border border-blue-200 transition-all duration-200 hover:shadow-md hover:border-blue-300">
                    <div class="flex items-center justify-center w-10 h-10 bg-blue-200 group-hover:bg-blue-300 rounded-lg mb-3 sm:mb-4 mx-auto">
                        <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-blue-900 mb-1 text-center text-sm sm:text-base">Tambah Karyawan</h4>
                    <p class="text-xs sm:text-sm text-blue-700 text-center">Daftarkan karyawan baru</p>
                </a>

                <a href="{{ route('reports.monthly') }}" 
                   class="group p-4 sm:p-6 bg-green-50 hover:bg-green-100 rounded-xl border border-green-200 transition-all duration-200 hover:shadow-md hover:border-green-300">
                    <div class="flex items-center justify-center w-10 h-10 bg-green-200 group-hover:bg-green-300 rounded-lg mb-3 sm:mb-4 mx-auto">
                        <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-green-900 mb-1 text-center text-sm sm:text-base">Export Data</h4>
                    <p class="text-xs sm:text-sm text-green-700 text-center">Download data Excel/PDF</p>
                </a>

                <button onclick="openManualAttendanceModal()" 
                        class="group p-4 sm:p-6 bg-purple-50 hover:bg-purple-100 rounded-xl border border-purple-200 transition-all duration-200 hover:shadow-md hover:border-purple-300 text-left w-full">
                    <div class="flex items-center justify-center w-10 h-10 bg-purple-200 group-hover:bg-purple-300 rounded-lg mb-3 sm:mb-4 mx-auto">
                        <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-purple-900 mb-1 text-center text-sm sm:text-base">Absen Manual</h4>
                    <p class="text-xs sm:text-sm text-purple-700 text-center">Input absensi karyawan</p>
                </button>
            </div>
        </div>

        <!-- Month Filter -->
        <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900">Grafik Kehadiran Bulanan</h3>
            <form action="{{ route('admin.dashboard-admin') }}" method="GET" class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-3">
                <label for="month" class="text-sm font-medium text-gray-700 whitespace-nowrap">Pilih Bulan:</label>
                <div class="flex space-x-3 w-full sm:w-auto">
                    <select name="month" id="month" class="flex-1 sm:flex-none px-3 py-2 bg-white border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($months as $m)
                        <option value="{{ $m['value'] }}" {{ $month == $m['value'] ? 'selected' : '' }}>{{ $m['name'] }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-colors whitespace-nowrap">
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>

        <!-- Chart Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 lg:p-8">
            <h4 class="text-base sm:text-lg font-medium text-gray-900 mb-4 sm:mb-6">
                Kehadiran Harian - {{ \Carbon\Carbon::create(null, $month, 1)->translatedFormat('F Y') }}
            </h4>
            <div id="attendanceChartContainer"
                 data-labels="{{ json_encode($monthlyLabels, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }}"
                 data-hadir="{{ json_encode($monthlyHadir, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }}"
                 data-terlambat="{{ json_encode($monthlyTerlambat, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }}"
                 data-absen="{{ json_encode($monthlyAbsen, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }}">
                <div class="w-full overflow-x-auto">
                    <canvas id="monthlyAttendanceChart" style="max-height: 300px; min-height: 250px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <!-- Department Performance -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 lg:p-8">
                <h4 class="text-base sm:text-lg font-medium text-gray-900 mb-4 sm:mb-6">Performa Departemen</h4>
                <div class="space-y-4 sm:space-y-6">
                    @foreach($departments as $dept)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700 truncate pr-2">{{ $dept->name }}</span>
                            <span class="text-sm font-semibold text-gray-900 whitespace-nowrap">{{ $dept->persen }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full transition-all duration-500" 
                                 style="width: {{ $dept->persen }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Late Employees Today -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 lg:p-8">
                <h4 class="text-base sm:text-lg font-medium text-gray-900 mb-4 sm:mb-6">Karyawan Terlambat Hari Ini</h4>
                <div class="overflow-hidden">
                    @forelse($terlambatHariIni as $index => $user)
                        <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                            <div class="flex items-center space-x-3 min-w-0 flex-1">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-yellow-600 font-medium text-sm">{{ $index + 1 }}</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $user->department->name ?? 'No Department' }}</p>
                                </div>
                            </div>
                            <div class="text-right ml-3 flex-shrink-0">
                                <p class="text-sm text-gray-900">{{ $user->attendance->check_in ?? '-' }}</p>
                                <p class="text-xs text-yellow-600 font-medium">Terlambat</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500">Tidak ada yang terlambat hari ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Manual Attendance Modal -->
<div id="manualAttendanceModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white p-4 sm:p-6 border-b border-gray-200 rounded-t-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Absensi Manual</h3>
                <button onclick="closeManualAttendanceModal()" class="text-gray-400 hover:text-gray-600 p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <p class="text-sm text-gray-600 mt-2">Input manual absensi karyawan jika terjadi masalah sistem</p>
        </div>
        
        <form id="manualAttendanceForm" class="p-4 sm:p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Karyawan</label>
                <select name="user_id" required class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Karyawan</option>
                    @foreach($allUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} @if($user->employee_id) - {{ $user->employee_id }} @endif</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                <input type="date" name="date" value="{{ date('Y-m-d') }}" required 
                       class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Absensi</label>
                <select name="type" required onchange="toggleTimeFields()" 
                        class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Jenis</option>
                    <option value="check_in">Absen Masuk</option>
                    <option value="check_out">Absen Pulang</option>
                    <option value="full_day">Full Day (Masuk & Pulang)</option>
                </select>
            </div>
            
            <div id="checkInTime" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jam Masuk</label>
                <input type="time" name="check_in" value="{{ $jamMasuk ?? '08:00' }}" 
                       class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div id="checkOutTime" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jam Pulang</label>
                <input type="time" name="check_out" value="{{ $jamPulang ?? '17:00' }}" 
                       class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" required 
                        class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="hadir">Hadir</option>
                    <option value="terlambat">Terlambat</option>
                    <option value="remote">Remote</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                <textarea name="notes" rows="3" placeholder="Alasan input manual (opsional)"
                          class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
            </div>
            
            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3 pt-4">
                <button type="submit" 
                        class="flex-1 bg-blue-600 text-white py-2.5 px-4 rounded-xl font-medium hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-colors">
                    Simpan Absensi
                </button>
                <button type="button" onclick="closeManualAttendanceModal()" 
                        class="flex-1 sm:flex-none px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-colors">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Live Clock Update
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID');
    const dateString = now.toLocaleDateString('id-ID', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
    
    document.getElementById('liveClock').textContent = timeString;
    document.getElementById('liveDate').textContent = dateString;
}

// Update clock every second
setInterval(updateClock, 1000);

// Manual Attendance Modal Functions
function openManualAttendanceModal() {
    document.getElementById('manualAttendanceModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeManualAttendanceModal() {
    document.getElementById('manualAttendanceModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    document.getElementById('manualAttendanceForm').reset();
    document.getElementById('checkInTime').classList.add('hidden');
    document.getElementById('checkOutTime').classList.add('hidden');
}

function toggleTimeFields() {
    const type = document.querySelector('select[name="type"]').value;
    const checkInField = document.getElementById('checkInTime');
    const checkOutField = document.getElementById('checkOutTime');
    
    checkInField.classList.add('hidden');
    checkOutField.classList.add('hidden');
    
    if (type === 'check_in' || type === 'full_day') {
        checkInField.classList.remove('hidden');
        checkInField.querySelector('input[name="check_in"]').required = true;
    } else {
        checkInField.querySelector('input[name="check_in"]').required = false;
    }
    
    if (type === 'check_out' || type === 'full_day') {
        checkOutField.classList.remove('hidden');
        checkOutField.querySelector('input[name="check_out"]').required = true;
    } else {
        checkOutField.querySelector('input[name="check_out"]').required = false;
    }
}

// Handle manual attendance form submission
document.getElementById('manualAttendanceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    // Add loading state
    submitBtn.textContent = 'Menyimpan...';
    submitBtn.disabled = true;
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        alert('Error: CSRF token tidak ditemukan');
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        return;
    }
    
    fetch('/admin/admin/manual-attendance', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken.content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Error response body:', text);
                let errorMessage = `HTTP error! status: ${response.status}`;
                
                try {
                    const errorData = JSON.parse(text);
                    if (errorData.message) {
                        errorMessage = errorData.message;
                    } else if (errorData.errors) {
                        errorMessage = Object.values(errorData.errors).flat().join(', ');
                    }
                } catch (parseError) {
                    console.log('Could not parse error response as JSON');
                }
                
                throw new Error(errorMessage);
            });
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Success response:', data);
        
        if (data.success) {
            alert('Absensi manual berhasil disimpan!');
            closeManualAttendanceModal();
            
            // Refresh page to show updated data
            setTimeout(() => {
                window.location.reload();
            }, 500);
        } else {
            alert(data.message || 'Terjadi kesalahan saat menyimpan absensi');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Terjadi kesalahan: ' + error.message);
    })
    .finally(() => {
        // Reset button state
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
});

// Close modal when clicking outside
document.getElementById('manualAttendanceModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeManualAttendanceModal();
    }
});

// Handle window resize for chart responsiveness
window.addEventListener('resize', function() {
    // Trigger chart resize if chart exists
    if (window.monthlyChart && typeof window.monthlyChart.resize === 'function') {
        window.monthlyChart.resize();
    }
});

// Initialize tooltips and other interactive elements
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scroll behavior
    document.documentElement.style.scrollBehavior = 'smooth';
    
    // Initialize any additional interactive features
    const cards = document.querySelectorAll('.hover\\:shadow-md');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Auto-refresh data every 5 minutes
    setInterval(function() {
        // Only refresh if user is active (not hidden/minimized)
        if (!document.hidden) {
            const currentTime = new Date();
            const lastRefresh = localStorage.getItem('lastDataRefresh');
            
            if (!lastRefresh || (currentTime - new Date(lastRefresh)) > 5 * 60 * 1000) {
                localStorage.setItem('lastDataRefresh', currentTime.toISOString());
                // Uncomment the line below to enable auto-refresh
                // window.location.reload();
            }
        }
    }, 5 * 60 * 1000); // 5 minutes
});
</script>

<!-- Include Chart.js and custom scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/admin/attendance_chart.js') }}"></script>

@endsection