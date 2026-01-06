@extends('layouts.app') @section('title', 'Riwayat Absensi Saya')
@section('content')
<div class="animate__animated animate__fadeIn">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 fw-bold text-primary mb-0">
            <i class="fas fa-history me-2"></i>Riwayat Absensi Saya
        </h2>
        <div class="text-muted small">
            <i class="far fa-calendar-alt me-1"></i>
            {{ now()->format('d F Y') }}
        </div>
    </div>

    <!-- Filter Bulan -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4 col-sm-6">
                    <label class="form-label fw-semibold text-secondary">
                        <i class="fas fa-filter me-1"></i> Filter Bulan
                    </label>
                    <input
                        type="month"
                        name="month"
                        class="form-control form-control-lg shadow-sm"
                        value="{{ request('month') }}"
                    />
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <button
                        type="submit"
                        class="btn btn-primary btn-lg shadow-sm w-100 w-sm-auto"
                    >
                        <i class="fas fa-search me-2"></i> Terapkan Filter
                    </button>
                    @if(request('month'))
                    <a
                        href="{{ route('attendance.my') }}"
                        class="btn btn-outline-secondary btn-lg shadow-sm mt-2 mt-sm-0 w-100 w-sm-auto"
                    >
                        <i class="fas fa-times me-2"></i> Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik Bulan Ini -->
    <div class="row mb-4 g-3">
        <div class="col-lg-3 col-md-6">
            <div
                class="card border-0 shadow-sm h-100 bg-gradient text-black"
                style="background: linear-gradient(135deg, #28a745, #20c997)"
            >
                <div class="card-body text-center py-4">
                    <i class="fas fa-check-circle fa-3x mb-3 opacity-75"></i>
                    <h5 class="card-title mb-1">Hadir</h5>
                    <h2 class="display-5 fw-bold mb-0">
                        {{ $stats["Hadir"] ?? 0 }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div
                class="card border-0 shadow-sm h-100 bg-gradient text-black"
                style="background: linear-gradient(135deg, #ffc107, #fd7e14)"
            >
                <div class="card-body text-center py-4">
                    <i class="fas fa-clock fa-3x mb-3 opacity-75"></i>
                    <h5 class="card-title mb-1">Terlambat</h5>
                    <h2 class="display-5 fw-bold mb-0">
                        {{ $stats["Terlambat"] ?? 0 }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div
                class="card border-0 shadow-sm h-100 bg-gradient text-black"
                style="background: linear-gradient(135deg, #0dcaf0, #17a2b8)"
            >
                <div class="card-body text-center py-4">
                    <i
                        class="fas fa-envelope-open-text fa-3x mb-3 opacity-75"
                    ></i>
                    <h5 class="card-title mb-1">Izin / Sakit</h5>
                    <h2 class="display-5 fw-bold mb-0">
                        {{ ($stats["Izin"] ?? 0) + ($stats["Sakit"] ?? 0) }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div
                class="card border-0 shadow-sm h-100 bg-gradient text-black"
                style="background: linear-gradient(135deg, #dc3545, #e4606d)"
            >
                <div class="card-body text-center py-4">
                    <i class="fas fa-user-times fa-3x mb-3 opacity-75"></i>
                    <h5 class="card-title mb-1">Alpha</h5>
                    <h2 class="display-5 fw-bold mb-0">
                        {{ $stats["Alpha"] ?? 0 }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Absensi -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-black py-3">
            <h5 class="mb-0">
                <i class="fas fa-table me-2"></i> Daftar Riwayat Absensi
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr
                            class="animate__animated animate__fadeIn"
                            style="animation-delay: {{ $loop->iteration * 0.05 }}s;"
                        >
                            <td class="ps-4 fw-semibold">
                                {{ $attendance->date->format('d M Y') }}
                                <small
                                    class="text-muted d-block"
                                    >{{ $attendance->date->format('l') }}</small
                                >
                            </td>
                            <td>
                                @if($attendance->check_in)
                                <span
                                    class="badge bg-soft-success text-success"
                                >
                                    <i class="fas fa-sign-in-alt me-1"></i>
                                    {{ $attendance->check_in->format('H:i') }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <i
                                    class="fas fa-map-marker-alt text-danger me-1"
                                ></i>

                                @if($attendance->attendanceLocation)
                                {{ $attendance->attendanceLocation->name }}
                                @else
                                <em class="text-muted">Tidak tercatat</em>
                                @endif
                            </td>

                            <td>
                                @php $statusConfig = [ 'Hadir' => ['bg-success',
                                'check-circle'], 'Terlambat' => ['bg-warning',
                                'clock'], 'Izin' => ['bg-info',
                                'envelope-open-text'], 'Sakit' => ['bg-primary',
                                'head-side-cough'], 'Alpha' => ['bg-danger',
                                'user-times'], ]; $cfg =
                                $statusConfig[$attendance->status] ??
                                ['bg-secondary', 'question-circle']; @endphp
                                <span
                                    class="badge {{ $cfg[0] }} fs-6 px-3 py-2"
                                >
                                    <i class="fas fa-{{ $cfg[1] }} me-1"></i>
                                    {{ $attendance->status }}
                                </span>
                            </td>
                            <td class="text-muted">
                                {{ $attendance->notes ?? '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i
                                    class="fas fa-inbox fa-3x mb-3 opacity-50"
                                ></i>
                                <p class="mb-0">Belum ada data absensi</p>
                                <small
                                    >Mulailah melakukan absensi untuk melihat
                                    riwayat di sini.</small
                                >
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($attendances->hasPages())
        <div class="card-footer bg-light border-0 py-3">
            {{ $attendances->links('vendor.pagination.bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection @push('styles')
<style>
    .bg-gradient {
        border-radius: 0.75rem;
    }
    .bg-soft-success {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745 !important;
    }
    .card {
        border-radius: 0.75rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
    }
</style>
@endpush
