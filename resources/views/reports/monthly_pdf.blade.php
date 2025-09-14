<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Kehadiran {{ $displayMonth }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background: #ddd;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Rekap Kehadiran Bulanan - {{ $displayMonth }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Karyawan</th>
                <th>Departemen</th>
                <th>Hadir</th>
                <th>Terlambat</th>
                <th>Alpha</th>
                <th>Remote</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyAttendances as $key => $user)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->department->name ?? '-' }}</td>
                    <td>{{ $user->present_count }}</td>
                    <td>{{ $user->late_count }}</td>
                    <td>{{ $user->absent_count }}</td>
                    <td>{{ $user->remote_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
