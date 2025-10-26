@extends('layouts.app')

@section('title', 'Detail Absensi - AttendPro')

@section('content')
<div class="main-content" style="padding: 24px; font-family: 'Inter', sans-serif; background: #f4f7fc;">
    <div class="attendance-panel" style="background: #fff; border-radius: 1rem; padding: 24px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px;">
            <h1 style="font-size: 24px; font-weight: 600; color: #1f2937;">📋 Detail Absensi</h1>
            <p style="color: #6b7280;">Informasi lengkap data absensi</p>
        </div>

        <!-- Detail Content -->
        <div style="display: grid; gap: 16px; font-size: 14px; color: #1f2937;">
            <div style="display: flex; gap: 12px;">
                <strong style="font-weight: 600; color: #4f46e5; width: 120px;">Pegawai:</strong>
                <span>{{ $attendance->user->name }}</span>
            </div>
            <div style="display: flex; gap: 12px;">
                <strong style="font-weight: 600; color: #4f46e5; width: 120px;">Tanggal:</strong>
                <span>{{ $attendance->date }}</span>
            </div>
            <div style="display: flex; gap: 12px;">
                <strong style="font-weight: 600; color: #4f46e5; width: 120px;">Status:</strong>
                <span style="padding: 6px 12px; border-radius: 9999px; font-size: 12px; font-weight: 500; 
                    {{ $attendance->status == 'Hadir' ? 'background: #d1fae5; color: #065f46;' : 
                       ($attendance->status == 'Terlambat' ? 'background: #fef3c7; color: #92400e;' : 'background: #fecaca; color: #b91c1c;') }}">
                    {{ $attendance->status }}
                </span>
            </div>
            <div style="display: flex; gap: 12px;">
                <strong style="font-weight: 600; color: #4f46e5; width: 120px;">Check In:</strong>
                <span>{{ $attendance->check_in }}</span>
            </div>
            <div style="display: flex; gap: 12px;">
                <strong style="font-weight: 600; color: #4f46e5; width: 120px;">Lokasi:</strong>
                <span>{{ $attendance->attendanceLocation->name ?? '-' }}</span>
            </div>
        </div>

        <!-- Photo -->
        @if($attendance->photo_path)
            <div style="margin-top: 24px;">
                <img src="{{ route('admin.attendance.photo', $attendance->id) }}" 
                     style="border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 100%; height: auto; display: block; margin: 0 auto;">
            </div>
        @endif

        <!-- Back Button -->
        <div style="margin-top: 24px;">
            <a href="{{ route('admin.attendance.index') }}" 
               style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: #4f46e5; color: #fff; border-radius: 0.75rem; font-weight: 500; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-decoration: none; transition: all 0.3s;"
               onmouseover="this.style.background='#4338ca'; this.style.transform='scale(1.05)';" 
               onmouseout="this.style.background='#4f46e5'; this.style.transform='scale(1);'">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection