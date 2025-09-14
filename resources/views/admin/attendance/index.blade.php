@extends('layouts.app')

@section('title', 'Kelola Absensi')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Absensi</h1>
        <div>
            <a href="{{ route('attendance.camera.page') }}" class="btn btn-success me-2">
                <i class="fas fa-camera"></i> Absensi Kamera
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAttendanceModal">
                <i class="fas fa-plus"></i> Tambah Manual
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendances->where('date', today())->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hadir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendances->where('status', 'Hadir')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Terlambat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendances->where('status', 'Terlambat')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Absen</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendances->where('status', 'Absen')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.attendance.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pengguna</label>
                    <select name="user_id" class="form-control">
                        <option value="">Semua Pengguna</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                        <option value="Absen" {{ request('status') == 'Absen' ? 'selected' : '' }}>Absen</option>
                        <option value="WFH" {{ request('status') == 'WFH' ? 'selected' : '' }}>WFH</option>
                        <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">
                        <i class="fas fa-refresh"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Absensi</h6>
            <div>
                <a href="{{ route('admin.attendance.export') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-download"></i> Export Excel
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Check In</th>
                            <th>Status</th>
                            <th>Lokasi</th>
                            <th>GPS Quality</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                            <tr>
                                <td>{{ $loop->iteration + ($attendances->currentPage() - 1) * $attendances->perPage() }}</td>
                                <td>{{ $attendance->formatted_date }}</td>
                                <td>{{ $attendance->user->name }}</td>
                                <td>{{ $attendance->formatted_check_in }}</td>
                                <td>
                                    <span class="badge {{ $attendance->status_badge }}">
                                        {{ $attendance->status }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ $attendance->location_info }}</small>
                                    @if($attendance->accuracy)
                                        <br><small class="text-muted">±{{ $attendance->accuracy }}m</small>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->gps_quality)
                                        <small class="badge 
                                            @if($attendance->accuracy <= 20) bg-success 
                                            @elseif($attendance->accuracy <= 50) bg-warning 
                                            @else bg-danger @endif">
                                            {{ $attendance->gps_quality }}
                                        </small>
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->photo_path)
                                        <a href="{{ route('admin.attendance.photo', $attendance->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-image"></i> Lihat
                                        </a>
                                    @else
                                        <small class="text-muted">Tidak ada</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.attendance.show', $attendance->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-warning" onclick="editAttendance({{ $attendance->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                       <form action="{{ route('admin.attendance.destroy', $attendance->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="fas fa-trash"></i>
    </button>
</form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p>Tidak ada data absensi yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($attendances->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $attendances->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Attendance Modal -->
<div class="modal fade" id="addAttendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Absensi Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addAttendanceForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pengguna *</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">Pilih Pengguna</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal *</label>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Terlambat">Terlambat</option>
                            <option value="Absen">Absen</option>
                            <option value="WFH">WFH</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle add attendance form
    document.getElementById('addAttendanceForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Menyimpan...';
        
        try {
            const response = await fetch('{{ route("admin.attendance.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                // Close modal and reload page
                bootstrap.Modal.getInstance(document.getElementById('addAttendanceModal')).hide();
                window.location.reload();
            } else {
                alert('Error: ' + (result.message || 'Gagal menyimpan data'));
                console.error('Validation errors:', result.errors);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan jaringan');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
});
</script>
@endpush
@endsection