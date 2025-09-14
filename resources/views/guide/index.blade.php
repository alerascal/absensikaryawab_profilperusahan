@extends('layouts.app')

@section('content')
<div class="main-content p-4 md:p-8 lg:p-12">
    <h1 class="text-2xl md:text-3xl font-bold mb-6 text-gray-800">Panduan Penggunaan Sistem</h1>

    <!-- Panduan Admin -->
    <div class="mb-8">
        <h2 class="text-xl md:text-2xl font-semibold mb-4 text-blue-600 flex items-center gap-2">
            <i class="fas fa-user-shield"></i> Panduan Admin
        </h2>
        <div class="bg-white shadow-md rounded-lg p-6 md:p-8 hover:shadow-lg transition duration-300">
            <ol class="list-decimal list-inside space-y-3 text-gray-700 text-sm md:text-base leading-relaxed">
                <li>Admin membuat <b>Departemen</b> terlebih dahulu di menu Departemen.</li>
                <li>Atur <b>Jadwal Kerja</b> dan <b>Shift</b> jika diperlukan.</li>
                <li>Masuk menu <b>Karyawan</b> untuk menambahkan user login dan mengelola user (misalnya ada yang resign dan karyawan baru).</li>
                <li><b>Dashboard</b> menampilkan data ringkas sistem berjalan.</li>
                <li>Jika setup sudah selesai, lakukan <b>Absensi</b> di menu absensi dan kelola datanya.</li>
                <li><b>Unduh</b> dan <b>hapus</b> data absensi setiap ±6 bulan sekali agar sistem tetap ringan.</li>
                <li>Menu <b>Laporan</b> berisi rekap harian, bulanan, serta data lembur & cuti.</li>
            </ol>
        </div>
    </div>

    <!-- Panduan Pegawai -->
    <div class="mb-8">
        <h2 class="text-xl md:text-2xl font-semibold mb-4 text-green-600 flex items-center gap-2">
            <i class="fas fa-user-clock"></i> Panduan Pegawai
        </h2>
        <div class="bg-white shadow-md rounded-lg p-6 md:p-8 hover:shadow-lg transition duration-300">
            <ol class="list-decimal list-inside space-y-3 text-gray-700 text-sm md:text-base leading-relaxed">
                <li>Masuk ke <b>Dashboard</b> untuk melihat ringkasan data pribadi Anda (absensi, jadwal).</li>
                <li>Lihat <b>Jadwal Kerja</b> di menu Jadwal Kerja untuk mengetahui shift dan jam kerja Anda.</li>
                <li>Lakukan <b>Absensi</b> menggunakan menu <b>Riwayat Absensi</b> atau <b>Absen Kamera</b>.</li>
                <li>Pastikan GPS dan kamera aktif saat melakukan absensi.</li>
                <li>Cek <b>History Absensi</b> untuk melihat riwayat absensi harian Anda.</li>
                <li>Gunakan menu <b>Laporan</b> (jika tersedia) untuk melihat rekap absensi pribadi.</li>
                <li>Jika ada kendala, hubungi admin atau atasan langsung.</li>
            </ol>
        </div>
    </div>
</div>
@endsection
