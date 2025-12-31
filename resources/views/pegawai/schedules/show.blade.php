@extends('layouts.app')

@section('title', 'Jadwal Kerja Saya')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Jadwal Kerja - {{ $user->name }}</h2>

            <div class="row">
                @foreach($weeklySchedules as $day => $data)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-header text-white {{ $data->is_holiday ? 'bg-danger' : 'bg-primary' }}">
                                <h5 class="mb-0">{{ $data->day_name }}</h5>
                                @if($data->is_holiday)
                                    <small>Libur Mingguan</small>
                                @endif
                            </div>
                            <div class="card-body">
                                @if($data->is_holiday)
                                    <p class="text-danger fw-bold">HARI LIBUR</p>
                                @elseif($data->schedule)
                                    <p>
                                        <strong>Jam Kerja:</strong><br>
                                        {{ $data->schedule->start_time }} - {{ $data->schedule->end_time }}
                                    </p>
                                    <p>
                                        <strong>Tipe Jadwal:</strong><br>
                                        @if($data->type === 'fulltime')
                                            <span class="badge bg-success">Fulltime (Reguler)</span>
                                        @else
                                            <span class="badge bg-info">Shift {{ $data->schedule->shift?->name ?? '-' }}</span>
                                        @endif
                                    </p>
                                @else
                                    <p class="text-muted">Tidak ada jadwal kerja</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <a href="{{ route('pegawai.attendance.index') }}" class="btn btn-secondary">
                    ← Kembali ke Absensi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection