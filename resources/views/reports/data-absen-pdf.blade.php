<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kehadiran Harian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            margin: 20px;
        }
        h1 {
            text-align: center;
            font-size: 18pt;
        }
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .attendance-table th, .attendance-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12pt;
            text-align: left;
        }
        .attendance-table th {
            background-color: #f2f2f2;
        }
        .status-present { color: green; }
        .status-late { color: orange; }
        .status-absent { color: red; }
        .status-remote { color: blue; }
        .time-badge, .location-badge, .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            background-color: #f8f8f8;
        }
        .employee-avatar {
            display: none; /* Hide avatar in PDF */
        }
    </style>
</head>
<body>
    <h1>Laporan Kehadiran - {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</h1>

    <table class="attendance-table">
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
                <td class="employee-info">
                    <div class="employee-avatar">{{ strtoupper(substr($attendance->user->name, 0, 1)) }}</div>
                    <div class="employee-details">
                        <h4>{{ $attendance->user->name }}</h4>
                    </div>
                </td>
                <td>{{ $attendance->user->department->name ?? '-' }}</td>
                <td><span class="time-badge">{{ $attendance->check_in ?? '-' }}</span></td>
                <td><span class="time-badge">{{ $attendance->check_out ?? '-' }}</span></td>
                <td>
                    @php
                        $statusClass = [
                            'Hadir' => 'status-present',
                            'Terlambat' => 'status-late',
                            'Alpha' => 'status-absent',
                            'Remote' => 'status-remote'
                        ];
                    @endphp
                    <span class="status-badge {{ $statusClass[$attendance->status] ?? 'status-absent' }}">
                        {{ $attendance->status }}
                    </span>
                </td>
                <td>
                    <span class="location-badge">{{ $attendance->location ?? '-' }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>