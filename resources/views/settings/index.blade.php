@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
            <div class="bg-slate-900 px-6 py-8 sm:px-8">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white">Profil Karyawan</h1>
                        <p class="text-slate-300 mt-1">Detail akun & informasi kepegawaian</p>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mx-6 mt-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Profile Information Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Personal Data -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Data Pribadi</h3>
                </div>

                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-100 pb-3">
                        <span class="text-gray-600 font-medium mb-1 sm:mb-0">Nama</span>
                        <span class="text-gray-900 font-semibold">{{ $user->name }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-100 pb-3">
                        <span class="text-gray-600 font-medium mb-1 sm:mb-0">Email</span>
                        <span class="text-gray-900 break-all">{{ $user->email }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between">
                        <span class="text-gray-600 font-medium mb-1 sm:mb-0">ID Pegawai</span>
                        <span class="text-gray-900 font-mono">{{ $user->employee_id ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Employment Data -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Data Kepegawaian</h3>
                </div>

                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-100 pb-3">
                        <span class="text-gray-600 font-medium mb-1 sm:mb-0">Departemen</span>
                        <span class="text-gray-900">{{ $user->department->name ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-100 pb-3">
                        <span class="text-gray-600 font-medium mb-1 sm:mb-0">Jabatan</span>
                        <span class="text-gray-900">{{ $user->position ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-100 pb-3">
                        <span class="text-gray-600 font-medium mb-1 sm:mb-0">Status Kerja</span>
                        <span class="text-gray-900">{{ $user->employment_status ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-100 pb-3">
                        <span class="text-gray-600 font-medium mb-1 sm:mb-0">Tanggal Bergabung</span>
                        <span class="text-gray-900">{{ $user->join_date ? \Carbon\Carbon::parse($user->join_date)->format('d M Y') : '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between">
                        <span class="text-gray-600 font-medium mb-1 sm:mb-0">Status Akun</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <div class="w-2 h-2 rounded-full mr-2 {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }}"></div>
                            {{ $user->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-sm text-gray-600 mb-1">Total Kehadiran</p>
                <p class="text-2xl font-bold text-green-600">{{ $user->attendances_count ?? 0 }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-sm text-gray-600 mb-1">Keterlambatan</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $user->late_count ?? 0 }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V7a2 2 0 012-2h4a2 2 0 012 2v0M8 7v10a2 2 0 002 2h4a2 2 0 002-2V7"></path>
                    </svg>
                </div>
                <p class="text-sm text-gray-600 mb-1">Izin / Cuti</p>
                <p class="text-2xl font-bold text-blue-600">{{ $user->leave_count ?? 0 }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('settings.edit') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Profil
                </a>

                <form action="{{ route('settings.destroy') }}" method="POST" class="inline"
                      onsubmit="return confirm('Yakin ingin menghapus akun ini? Data absensi akan tetap tersimpan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-200 transition-all duration-200 w-full sm:w-auto">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection