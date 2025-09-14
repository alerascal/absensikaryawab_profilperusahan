@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📅 Jadwal {{ $user->name }}</h3>

    @if($schedules->isEmpty())
        <div class="alert alert-warning">Belum ada jadwal untuk Anda.</div>
    @else
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Tipe</th>
                    <th>Shift</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                    <tr>
                        <td>{{ ucfirst($schedule->type) }}</td>
                        <td>{{ $schedule->shift ? $schedule->shift->name : '-' }}</td>
                        <td>{{ $schedule->start_time ?? '-' }}</td>
                        <td>{{ $schedule->end_time ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>
@endsection
