<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Lokasi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($attendances as $attendance)
        <tr>
            <td>{{ $attendance->user->name ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
            <td>{{ $attendance->check_in }}</td>
            <td>{{ $attendance->status }}</td>
             <td>{{ $attendance->attendanceLocation->name ?? 'Tidak diketahui' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
