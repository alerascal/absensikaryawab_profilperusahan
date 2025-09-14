@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📅 Riwayat Absensi</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('pegawai.attendance.camera') }}" class="btn btn-primary mb-3">
        <i class="fas fa-camera"></i> Absen dengan Kamera
    </a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Lokasi</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->date }}</td>
                    <td>
                        <span class="badge bg-success">{{ $attendance->status }}</span>
                    </td>
                    <td>{{ $attendance->location }}</td>
                    <td>{{ $attendance->check_in }}</td>
                    <td>
                        @if($attendance->photo_path)
                            <img src="{{ asset('storage/' . $attendance->photo_path) }}" 
                                 alt="Foto Absensi" width="60" class="rounded">
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data absensi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $attendances->links() }}
    </div>
</div>
@endsection
