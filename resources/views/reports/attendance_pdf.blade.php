<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kehadiran - {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-hadir {
            background-color: #dcfce7;
            color: #166534;
            padding: 2px 8px;
            border-radius: 12px;
        }
        .status-terlambat {
            background-color: #fef3c7;
            color: #b45309;
            padding: 2px 8px;
            border-radius: 12px;
        }
        .status-alpha {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 2px 8px;
            border-radius: 12px;
        }
        .status-remote {
            background-color: #f0fdfa;
            color: #047857;
            padding: 2px 8px;
            border-radius: 12px;
        }
    </style>
</head>
<body>
    <h1>Laporan Kehadiran - {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Karyawan</th>
                <th>Departemen</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $key => $attendance)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $attendance->user->name }}</td>
                <td>{{ $attendance->user->department->name ?? '-' }}</td>
                <td>{{ $attendance->check_in ?? '-' }}</td>
                <td>{{ $attendance->check_out ?? '-' }}</td>
                <td>
                    <span class="@if($attendance->status == 'Hadir') status-hadir 
                                @elseif($attendance->status == 'Terlambat') status-terlambat 
                                @elseif($attendance->status == 'Alpha') status-alpha 
                                @elseif($attendance->status == 'Remote') status-remote 
                                @else status-alpha @endif">
                        {{ $attendance->status }}
                    </span>
                </td>
                <td>{{ $attendance->attendanceLocation->name ?? 'Tidak diketahui' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>