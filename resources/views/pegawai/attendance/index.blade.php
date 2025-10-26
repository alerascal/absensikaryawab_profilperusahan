@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="content-wrapper">
    <div class="page-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-text">
                    <h1 class="page-title">
                        <i class="fas fa-history mr-2"></i>
                        Riwayat Absensi
                    </h1>
                    <p class="page-subtitle">Daftar riwayat kehadiran Anda</p>
                </div>
            </div>
        </div>

        <!-- Content Card -->
        <div class="card card-modern">
            <!-- Filter Section -->
            <div class="filter-section">
                <form method="GET" class="filter-form">
                    <div class="filter-grid">
                        <!-- Filter Tanggal -->
                        <div class="filter-group">
                            <label for="date" class="filter-label">
                                <i class="far fa-calendar-days"></i>
                                Tanggal
                            </label>
                            <input 
                                type="date" 
                                name="date" 
                                id="date" 
                                value="{{ request('date') }}"
                                class="filter-input"
                            >
                        </div>

                        <!-- Filter Bulan -->
                        <div class="filter-group">
                            <label for="month" class="filter-label">
                                <i class="far fa-calendar"></i>
                                Bulan
                            </label>
                            <input 
                                type="month" 
                                name="month" 
                                id="month" 
                                value="{{ request('month') }}"
                                class="filter-input"
                            >
                        </div>

                        <!-- Filter Status -->
                        <div class="filter-group">
                            <label for="status" class="filter-label">
                                <i class="fas fa-clipboard-check"></i>
                                Status
                            </label>
                            <select name="status" id="status" class="filter-input">
                                <option value="">Semua Status</option>
                                <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                <option value="Absen" {{ request('status') == 'Absen' ? 'selected' : '' }}>Absen</option>
                            </select>
                        </div>

                        <!-- Filter Actions -->
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-filter">
                                <i class="fas fa-magnifying-glass"></i>
                                <span>Filter</span>
                            </button>
                            <a href="{{ route('pegawai.attendance.index') }}" class="btn btn-reset">
                                <i class="fas fa-rotate-right"></i>
                                <span>Reset</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Download Section -->
            <div class="download-section">
                <div class="download-title">
                    <i class="fas fa-download"></i>
                    Export Data
                </div>
                <div class="download-buttons">
                    <a href="{{ route('pegawai.attendance.export', ['type' => 'pdf'] + request()->all()) }}" 
                       class="btn btn-download btn-pdf">
                        <i class="far fa-file-pdf"></i>
                        <span>Download PDF</span>
                    </a>
                    <a href="{{ route('pegawai.attendance.export', ['type' => 'excel'] + request()->all()) }}" 
                       class="btn btn-download btn-excel">
                        <i class="far fa-file-excel"></i>
                        <span>Download Excel</span>
                    </a>
                </div>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                @if ($attendances->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h3 class="empty-state-title">Belum ada data absensi</h3>
                        <p class="empty-state-text">Data absensi Anda akan muncul di sini setelah melakukan check-in</p>
                    </div>
                @else
                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-lg-block">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <i class="fas fa-hashtag"></i>
                                    </th>
                                    <th width="20%">
                                        <i class="fas fa-user mr-2"></i>Nama
                                    </th>
                                    <th width="15%">
                                        <i class="far fa-calendar mr-2"></i>Tanggal
                                    </th>
                                    <th width="12%">
                                        <i class="far fa-clock mr-2"></i>Waktu
                                    </th>
                                    <th width="13%" class="text-center">
                                        <i class="fas fa-clipboard-check mr-2"></i>Status
                                    </th>
                                    <th width="20%">
                                        <i class="fas fa-map-marker-alt mr-2"></i>Lokasi
                                    </th>
                                    <th width="15%" class="text-center">
                                        <i class="fas fa-camera mr-2"></i>Foto
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $index => $attendance)
                                    <tr class="animate__animated animate__fadeIn">
                                        <td>
                                            <div class="table-number">{{ $attendances->firstItem() + $index }}</div>
                                        </td>
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    {{ substr($attendance->user->name ?? 'U', 0, 1) }}
                                                </div>
                                                <span class="user-name">{{ $attendance->user->name ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="date-info">
                                                <i class="far fa-calendar-days text-blue-500 mr-2"></i>
                                                {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="time-info">
                                                <i class="far fa-clock text-green-500 mr-2"></i>
                                                {{ $attendance->check_in }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge status-{{ strtolower($attendance->status) }}">
                                                <i class="fas fa-circle mr-1"></i>
                                                {{ $attendance->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="location-info">
                                                <i class="fas fa-map-pin text-red-500 mr-2"></i>
                                               {{ $attendance->attendanceLocation->name ?? 'Tidak diketahui' }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($attendance->photo_path)
                                                <a href="{{ route('admin.attendance.photo', $attendance->id) }}" 
                                                   target="_blank"
                                                   class="btn btn-view-photo">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    Lihat Foto
                                                </a>
                                            @else
                                                <span class="no-photo">
                                                    <i class="fas fa-ban"></i>
                                                    Tidak ada
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="d-lg-none">
                        <div class="mobile-cards">
                            @foreach ($attendances as $attendance)
                                <div class="attendance-card animate__animated animate__fadeIn">
                                    <!-- Card Header -->
                                    <div class="card-header-mobile">
                                        <div class="user-info-mobile">
                                            <div class="user-avatar-mobile">
                                                {{ substr($attendance->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="user-name-mobile">{{ $attendance->user->name ?? '-' }}</h4>
                                                <p class="date-mobile">
                                                    <i class="far fa-calendar mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="status-badge-mobile status-{{ strtolower($attendance->status) }}">
                                            {{ $attendance->status }}
                                        </span>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body-mobile">
                                        <div class="info-row-mobile">
                                            <div class="info-item">
                                                <i class="far fa-clock text-blue-500"></i>
                                                <span class="info-label">Waktu</span>
                                                <span class="info-value">{{ $attendance->check_in }}</span>
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-map-marker-alt text-red-500"></i>
                                                <span class="info-label">Lokasi</span>
                                                <span class="info-value">{{ $attendance->attendanceLocation->name ?? 'Tidak diketahui' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Footer -->
                                    <div class="card-footer-mobile">
                                        @if ($attendance->photo_path)
                                            <a href="{{ route('admin.attendance.photo', $attendance->id) }}" 
                                               target="_blank"
                                               class="btn btn-view-photo-mobile">
                                                <i class="fas fa-camera mr-1"></i>
                                                Lihat Foto
                                            </a>
                                        @else
                                            <span class="no-photo-mobile">
                                                <i class="fas fa-ban mr-1"></i>
                                                Tidak ada foto
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $attendances->links('vendor.pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection