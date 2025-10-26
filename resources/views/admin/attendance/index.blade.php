@extends('layouts.app')

@section('title', 'Data Absensi - AttendPro')

@section('content')
<style>
    .attendance-wrapper {
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header-section {
        background: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 32px rgba(161, 196, 253, 0.3);
    }

    .filter-section {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #e8ecf1;
    }

    .filter-input, .filter-select {
        border: 2px solid #e8ecf1;
        border-radius: 10px;
        padding: 0.6rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .filter-input:focus, .filter-select:focus {
        border-color: #a1c4fd;
        box-shadow: 0 0 0 4px rgba(161, 196, 253, 0.1);
        outline: none;
    }

    .btn-primary-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        position: relative;
        overflow: hidden;
    }

    .btn-primary-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-primary-gradient::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-primary-gradient:hover::after {
        width: 300px;
        height: 300px;
    }

    .collapse-transition {
        transition: all 0.4s ease-in-out;
    }

    .btn-reset {
        background: white;
        border: 2px solid #e8ecf1;
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        color: #6b7280;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
        border-color: #667eea;
        color: #667eea;
        transform: translateY(-2px);
    }

    .mobile-card {
        background: white;
        border-radius: 16px;
        padding: 1.2rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        border: 1px solid #f3f4f6;
        transition: all 0.3s ease;
    }

    .mobile-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .status-hadir {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(16, 185, 129, 0.3);
    }

    .status-terlambat {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(245, 158, 11, 0.3);
    }

    .status-absen {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(239, 68, 68, 0.3);
    }

    .table-wrapper {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .custom-table {
        margin-bottom: 0;
    }

    .custom-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .custom-table thead th {
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1.2rem 1rem;
        border: none;
    }

    .custom-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f3f4f6;
    }

    .custom-table tbody tr:hover {
        background: linear-gradient(90deg, #fafbfc 0%, #f9fafb 100%);
        transform: scale(1.01);
    }

    .custom-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #374151;
    }

    .date-badge {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-block;
    }

    .time-badge {
        background: #f3f4f6;
        padding: 0.4rem 0.9rem;
        border-radius: 8px;
        font-weight: 600;
        color: #4b5563;
        font-size: 0.9rem;
    }

    .btn-view {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        padding: 0.5rem 1.2rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .btn-action-detail {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
        border: none;
        border-radius: 8px;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
    }

    .btn-action-detail:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.5);
    }

    .btn-action-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        border-radius: 8px;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    .btn-action-delete:hover {
        transform: scale(1.1) rotate(-5deg);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.5);
    }

    .alert-custom {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
        border-left: 4px solid #10b981;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Custom Pagination Styles */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pagination-wrapper nav {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .pagination-wrapper .pagination {
        margin: 0;
        gap: 0.5rem;
    }

    .pagination-wrapper .page-item {
        margin: 0;
    }

    .pagination-wrapper .page-link {
        border: 2px solid #e8ecf1;
        color: #6b7280;
        font-weight: 600;
        padding: 0.5rem 0.9rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        background: white;
        min-width: 40px;
        text-align: center;
    }

    .pagination-wrapper .page-link:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        transform: scale(1.05);
    }

    .pagination-wrapper .page-item.disabled .page-link {
        background: #f3f4f6;
        color: #9ca3af;
        border-color: #e8ecf1;
        cursor: not-allowed;
    }

    .pagination-wrapper .page-item.disabled .page-link:hover {
        transform: none;
        box-shadow: none;
        background: #f3f4f6;
        color: #9ca3af;
    }

    @media (max-width: 768px) {
        .pagination-wrapper nav {
            padding: 0.75rem 1rem;
        }

        .pagination-wrapper .page-link {
            padding: 0.4rem 0.7rem;
            font-size: 0.9rem;
            min-width: 36px;
        }
    }

    @media (max-width: 768px) {
        .header-section {
            padding: 1.5rem;
        }
    }
</style>

<div class="attendance-wrapper px-3 px-md-4 py-4">
    <!-- Header -->
    <div class="header-section">
        <h1 class="mb-2" style="font-size: 2rem; font-weight: 700; color: #1e3a8a;">Data Absensi</h1>
        <p class="mb-0" style="color: #475569; font-size: 1.05rem;">Kelola dan pantau kehadiran pegawai secara efisien</p>
    </div>

    <!-- Filter Dropdown Button -->
    <div class="mb-4">
        <button 
            class="btn btn-primary-gradient w-100" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#filterCollapse" 
            aria-expanded="false" 
            aria-controls="filterCollapse"
        >
            <i class="fas fa-filter me-2"></i>
            Filter Data Absensi
            <i class="fas fa-chevron-down ms-2 float-end mt-1"></i>
        </button>
    </div>

    <!-- Filter Section (Collapsible) -->
    <div class="collapse mb-4" id="filterCollapse">
        <div class="filter-section">
            <form method="GET" action="{{ route('admin.attendance.index') }}">
                <div class="row g-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold text-secondary small">Tanggal</label>
                        <input 
                            type="date" 
                            name="date" 
                            value="{{ request('date') }}"
                            class="form-control filter-input"
                        />
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold text-secondary small">Pegawai</label>
                        <select name="user_id" class="form-select filter-select">
                            <option value="">Semua Pegawai</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <label class="form-label fw-semibold text-secondary small">Status</label>
                        <select name="status" class="form-select filter-select">
                            <option value="">Semua Status</option>
                            <option value="Hadir" {{ request('status')=='Hadir'?'selected':'' }}>Hadir</option>
                            <option value="Terlambat" {{ request('status')=='Terlambat'?'selected':'' }}>Terlambat</option>
                            <option value="Absen" {{ request('status')=='Absen'?'selected':'' }}>Absen</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label fw-semibold text-secondary small d-none d-lg-block">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-gradient flex-grow-1">
                                Terapkan Filter
                            </button>
                            @if(request()->hasAny(['date', 'user_id', 'status']))
                                <a href="{{ route('admin.attendance.index') }}" class="btn btn-reset">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-custom alert-dismissible fade show" role="alert" id="alert-success">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-3" style="font-size: 1.5rem; color: #059669;"></i>
                <span style="color: #065f46; font-weight: 600;">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Mobile View -->
    <div class="d-lg-none">
        @forelse($attendances as $a)
        <div class="mobile-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h6 class="fw-bold mb-1" style="color: #1f2937;">{{ $a->user->name ?? '-' }}</h6>
                    <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($a->date)->translatedFormat('d M Y') }}</p>
                </div>
                <span class="status-{{ strtolower($a->status) }}">{{ $a->status }}</span>
            </div>
            
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <small class="text-muted d-block mb-1">Lokasi</small>
                   <span class="fw-semibold" style="color: #374151;">{{ $a->attendanceLocation->name ?? 'Tidak diketahui' }}</span>
                </div>
                <div class="col-6">
                    <small class="text-muted d-block mb-1">Check In</small>
                    <span class="fw-semibold" style="color: #374151;">{{ $a->check_in ? \Carbon\Carbon::parse($a->check_in)->format('H:i') : '-' }}</span>
                </div>
            </div>

            <div class="d-flex gap-2">
                @if($a->photo_path)
                    <a href="{{ asset('storage/'.$a->photo_path) }}" target="_blank" class="btn btn-view btn-sm flex-grow-1">
                        Lihat Foto
                    </a>
                @endif
                <a href="{{ route('admin.attendance.show', $a->id) }}" class="btn btn-action-detail">
                    <i class="fas fa-eye"></i>
                </a>
                <form action="{{ route('admin.attendance.destroy', $a->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-action-delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="mobile-card empty-state">
            <i class="fas fa-folder-open"></i>
            <p class="fw-semibold mb-0">Tidak ada data absensi</p>
        </div>
        @endforelse
    </div>

    <!-- Desktop Table View -->
    <div class="d-none d-lg-block table-wrapper">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th class="text-center">Tanggal</th>
                    <th>Pegawai</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Lokasi</th>
                    <th class="text-center">Check In</th>
                    <th class="text-center">Foto</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $a)
                <tr>
                    <td class="text-center">
                        <span class="date-badge">
                            {{ \Carbon\Carbon::parse($a->date)->translatedFormat('d M Y') }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-bold" style="color: #1f2937;">{{ $a->user->name ?? '-' }}</div>
                    </td>
                    <td class="text-center">
                        <span class="status-{{ strtolower($a->status) }}">{{ $a->status }}</span>
                    </td>
              <td class="text-center">
    {{ $a->attendanceLocation->name ?? 'Tidak diketahui' }}
</td>
                    <td class="text-center">
                        @if($a->check_in)
                            <span class="time-badge">
                                {{ \Carbon\Carbon::parse($a->check_in)->format('H:i') }}
                            </span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($a->photo_path)
                            <a href="{{ asset('storage/'.$a->photo_path) }}" target="_blank" class="btn btn-view btn-sm">
                                Lihat
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('admin.attendance.show', $a->id) }}" 
                               class="btn btn-action-detail"
                               title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.attendance.destroy', $a->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-action-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-folder-open"></i>
                            <p class="fw-semibold mb-0">Tidak ada data absensi</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($attendances->hasPages())
    <div class="mt-4">
        <div class="pagination-wrapper">
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($attendances->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $attendances->previousPageUrl() }}" rel="prev">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach(range(1, $attendances->lastPage()) as $page)
                        @if($page == $attendances->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $attendances->url($page) }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($attendances->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $attendances->nextPageUrl() }}" rel="next">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
        
        {{-- Pagination Info --}}
        <div class="text-center mt-3">
            <p class="text-muted small mb-0">
                Menampilkan <strong>{{ $attendances->firstItem() ?? 0 }}</strong> 
                sampai <strong>{{ $attendances->lastItem() ?? 0 }}</strong> 
                dari <strong>{{ $attendances->total() }}</strong> data
            </p>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Auto hide success alert
    const alertSuccess = document.getElementById('alert-success');
    if(alertSuccess) {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alertSuccess);
            bsAlert.close();
        }, 4000);
    }

    // Confirm delete
    function confirmDelete(event) {
        if(!confirm('Yakin ingin menghapus data absensi ini?')) {
            event.preventDefault();
            return false;
        }
        return true;
    }

    // Auto open filter if has filter params
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('date') || urlParams.has('user_id') || urlParams.has('status')) {
            const filterCollapse = document.getElementById('filterCollapse');
            if (filterCollapse) {
                const bsCollapse = new bootstrap.Collapse(filterCollapse, {
                    toggle: true
                });
            }
        }
    });

    // Rotate chevron icon on collapse toggle
    const filterCollapseEl = document.getElementById('filterCollapse');
    if (filterCollapseEl) {
        filterCollapseEl.addEventListener('show.bs.collapse', function () {
            const chevron = document.querySelector('[data-bs-target="#filterCollapse"] .fa-chevron-down');
            if (chevron) {
                chevron.style.transform = 'rotate(180deg)';
                chevron.style.transition = 'transform 0.3s ease';
            }
        });
        
        filterCollapseEl.addEventListener('hide.bs.collapse', function () {
            const chevron = document.querySelector('[data-bs-target="#filterCollapse"] .fa-chevron-down');
            if (chevron) {
                chevron.style.transform = 'rotate(0deg)';
            }
        });
    }
</script>
@endpush
@endsection