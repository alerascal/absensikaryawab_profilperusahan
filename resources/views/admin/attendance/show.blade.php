@extends('layouts.app')

@section('title', 'Detail Absensi')

@section('content')
<div class="attendance-card">
    <h2><i class="fas fa-clipboard-check"></i> Detail Absensi</h2>
    <a href="{{ route('attendance') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Kembali</a>

    <!-- Employee Info -->
    <div class="employee-info">
        <div class="info-card">
            <div class="icon"><i class="fas fa-id-card"></i></div>
            <div class="value">{{ $attendance->user ? str_pad($attendance->user->id, 3, '0', STR_PAD_LEFT) : '-' }}</div>
            <div class="label">ID Pegawai</div>
        </div>
        <div class="info-card">
            <div class="icon"><i class="fas fa-user"></i></div>
            <div class="value">{{ $attendance->user ? $attendance->user->name : '-' }}</div>
            <div class="label">Nama Pegawai</div>
        </div>
        <div class="info-card">
            <div class="icon"><i class="fas fa-building"></i></div>
            <div class="value">{{ $attendance->user && $attendance->user->department ? $attendance->user->department->name : '-' }}</div>
            <div class="label">Departemen</div>
        </div>
    </div>

    <!-- Attendance Details -->
    <div class="attendance-details">
        <div class="detail-item">
            <div class="value">{{ $attendance->check_in ?? '-' }}</div>
            <div class="label">Check In</div>
        </div>
        <div class="detail-item">
            <div class="value">{{ $attendance->check_out ?? '-' }}</div>
            <div class="label">Check Out</div>
        </div>
        <div class="detail-item {{ $attendance->status === 'Hadir' ? 'status-hadir' : ($attendance->status === 'Terlambat' ? 'status-terlambat' : 'status-absen') }}">
            <div class="value">{{ $attendance->status ?? '-' }}</div>
            <div class="label">Status</div>
        </div>
        <div class="detail-item">
            <div class="value"><i class="fas fa-map-marker-alt"></i> {{ $attendance->location ?? '-' }}</div>
            <div class="label">Lokasi</div>
        </div>
        <div class="detail-item">
            <div class="value">{{ $attendance->date ? $attendance->date->format('d/m/Y') : '-' }}</div>
            <div class="label">Tanggal</div>
        </div>
    </div>
</div>
@endsection
