<!DOCTYPE html>
<html>
<head>
    <title>Absensi Baru</title>
</head>
<body>
    <h1>Absensi Baru Terekam</h1>
    <p>Pengguna: {{ $attendance->user->name }}</p>
    <p>Status: {{ $attendance->status }}</p>
    <p>Lokasi: {{ $attendance->location }}</p>
    <p>Waktu Check-in: {{ $attendance->check_in }}</p>
    <p>Tanggal: {{ $attendance->date }}</p>
</body>
</html>