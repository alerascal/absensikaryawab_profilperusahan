@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📜 History Absensi</h3>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Lokasi</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensi as $item)
                <tr>
                    <td>{{ $item->date }}</td>
                    <td><span class="badge bg-success">{{ $item->status }}</span></td>
                    <td>{{ $item->location }}</td>
                    <td>{{ $item->check_in }}</td>
                    <td>
                        @if($item->photo_path)
                            <img src="{{ asset('storage/' . $item->photo_path) }}" 
                                 alt="Foto Absensi" width="60" class="rounded">
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada data absensi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
