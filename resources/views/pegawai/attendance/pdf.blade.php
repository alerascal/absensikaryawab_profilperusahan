<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Absensi Pegawai</title>
    <style>
        /* ====== Global Styles ====== */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 30px;
        }

        h2 {
            text-align: center;
            text-transform: uppercase;
            font-size: 18px;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        p.subheading {
            text-align: center;
            font-size: 13px;
            color: #666;
            margin-bottom: 25px;
        }

        /* ====== Table Styles ====== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 8px 6px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }

        td {
            font-size: 11.5px;
        }

        /* ====== Alternating Row Colors ====== */
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* ====== Status Badges ====== */
        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 11px;
            display: inline-block;
        }

        .status-hadir {
            background-color: #e8f5e9;
            color: #388e3c;
        }

        .status-terlambat {
            background-color: #fff3e0;
            color: #f57c00;
        }

        .status-absen {
            background-color: #ffebee;
            color: #d32f2f;
        }

        /* ====== Footer ====== */
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #777;
        }

        /* ====== Header Info ====== */
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border: none;
        }

        .info-table td {
            border: none;
            padding: 3px 0;
        }

        .info-label {
            font-weight: bold;
            width: 120px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <h2>Riwayat Absensi Pegawai</h2>
    <p class="subheading">Laporan Kehadiran Karyawan - {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>

    <!-- Info Karyawan -->
    <table class="info-table">
        <tr>
            <td class="info-label">Nama Pegawai</td>
            <td>: {{ auth()->user()->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Tanggal Cetak</td>
            <td>: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}</td>
        </tr>
    </table>

    <!-- Data Absensi -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Tanggal</th>
                <th style="width: 15%;">Waktu</th>
                <th style="width: 15%;">Status</th>
                <th style="width: 25%;">Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $index => $attendance)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                <td>{{ $attendance->check_in ?? '-' }}</td>
                <td>
                    @php
                        $statusClass = match(strtolower($attendance->status)) {
                            'hadir' => 'status-hadir',
                            'terlambat' => 'status-terlambat',
                            'absen' => 'status-absen',
                            default => ''
                        };
                    @endphp
                    <span class="status {{ $statusClass }}">{{ ucfirst($attendance->status ?? '-') }}</span>
                </td>
                <td>{{ $attendance->attendanceLocation->name ?? 'Tidak diketahui' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Dicetak otomatis oleh Sistem Absensi — {{ config('app.name') }}
    </div>
</body>
</html>
