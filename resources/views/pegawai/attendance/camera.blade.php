@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📸 Absen dengan Kamera</h3>

    <form action="{{ route('pegawai.attendance.camera.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Upload Foto Absensi</label>
            <input type="file" name="photo" class="form-control" accept="image/*" required>
        </div>

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <button type="submit" class="btn btn-success">✅ Simpan Absensi</button>
    </form>
</div>

<script>
    // Ambil lokasi otomatis
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;
        }, function(error) {
            alert("⚠️ Lokasi tidak dapat diakses, aktifkan GPS Anda.");
        });
    } else {
        alert("Browser tidak mendukung geolocation.");
    }
</script>
@endsection
