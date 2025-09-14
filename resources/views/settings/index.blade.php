@extends('layouts.app')

@section('title', 'Profil Karyawan')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">👤 Profil Karyawan</h2>
        <p class="text-gray-500">Detail akun & informasi kepegawaian</p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg">
            {{ session("success") }}
        </div>
    @endif

    <!-- Profile Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Data Pribadi -->
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <i class="fas fa-user text-blue-500"></i> Data Pribadi
            </h3>
            <p><strong>Nama:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>ID Pegawai:</strong> {{ $user->employee_id ?? '-' }}</p>
        </div>

        <!-- Data Kepegawaian -->
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <i class="fas fa-briefcase text-purple-500"></i> Data Kepegawaian
            </h3>
            <p><strong>Departemen:</strong> {{ $user->department->name ?? '-' }}</p>
            <p><strong>Jabatan:</strong> {{ $user->position ?? '-' }}</p>
            <p><strong>Status Kerja:</strong> {{ $user->employment_status ?? '-' }}</p>
            <p><strong>Tanggal Bergabung:</strong> {{ $user->join_date ?? '-' }}</p>
            <p><strong>Status Akun:</strong> 
                <span class="px-2 py-1 rounded text-sm {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $user->is_active ? 'Aktif' : 'Non-Aktif' }}
                </span>
            </p>
        </div>
    </div>

    <!-- Statistik Kehadiran -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 bg-green-50 shadow rounded-xl text-center">
            <p class="text-sm text-gray-600">Total Kehadiran</p>
            <p class="text-3xl font-bold text-green-600">{{ $user->attendances_count ?? 0 }}</p>
        </div>
        <div class="p-6 bg-yellow-50 shadow rounded-xl text-center">
            <p class="text-sm text-gray-600">Keterlambatan</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $user->late_count ?? 0 }}</p>
        </div>
        <div class="p-6 bg-red-50 shadow rounded-xl text-center">
            <p class="text-sm text-gray-600">Izin / Cuti</p>
            <p class="text-3xl font-bold text-red-600">{{ $user->leave_count ?? 0 }}</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-wrap gap-3 mt-8">
        <a href="{{ route('settings.edit') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            <i class="fas fa-edit"></i> Edit Profil
        </a>

        <form action="{{ route('settings.destroy') }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus akun ini? Data absensi akan tetap tersimpan.')">
            @csrf @method('DELETE')
            <button type="submit" 
                class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">
                <i class="fas fa-trash"></i> Hapus Akun
            </button>
        </form>
    </div>
</div>
@endsection
