@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')

<style>
    @media (max-width: 768px) {
        .mx-auto {
            padding: 1.5rem;
        }

        .text-3xl {
            font-size: 1.5rem;
        }

        .bg-gray-50 {
            padding: 1rem;
        }

        .fas {
            font-size: 1rem;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .bg-white {
        animation: fadeIn 0.5s ease-in-out;
    }
</style>
<div class="mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white p-6 md:p-8">
            <h1 class="text-3xl font-bold tracking-tight text-center">Detail Karyawan</h1>
            <p class="text-sm text-blue-100 mt-1 text-center">Informasi lengkap tentang karyawan</p>
        </div>

        <!-- Employee Info -->
        <div class="p-6 md:p-8">
            <div class="grid gap-6">
                <div class="bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-300 ease-in-out">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-id-card text-blue-600 text-xl"></i>
                        <div>
                            <span class="block text-sm font-semibold text-gray-700">ID Karyawan</span>
                            <p class="text-gray-600">{{ $employee->employee_id ?? 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-300 ease-in-out">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-user text-blue-600 text-xl"></i>
                        <div>
                            <span class="block text-sm font-semibold text-gray-700">Nama</span>
                            <p class="text-gray-600">{{ $employee->name ?? 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-300 ease-in-out">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-envelope text-blue-600 text-xl"></i>
                        <div>
                            <span class="block text-sm font-semibold text-gray-700">Email</span>
                            <p class="text-gray-600">{{ $employee->email ?? 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-300 ease-in-out">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                        <div>
                            <span class="block text-sm font-semibold text-gray-700">Role</span>
                            <p class="text-gray-600">{{ ucfirst($employee->role) ?? 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-300 ease-in-out">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-building text-blue-600 text-xl"></i>
                        <div>
                            <span class="block text-sm font-semibold text-gray-700">Departemen</span>
                            <p class="text-gray-600">{{ $employee->department ? $employee->department->name : 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-300 ease-in-out">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-briefcase text-blue-600 text-xl"></i>
                        <div>
                            <span class="block text-sm font-semibold text-gray-700">Posisi</span>
                            <p class="text-gray-600">{{ $employee->position ?? 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-300 ease-in-out">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-user-check text-blue-600 text-xl"></i>
                        <div>
                            <span class="block text-sm font-semibold text-gray-700">Status Pekerjaan</span>
                            <p class="text-gray-600">{{ ucfirst($employee->employment_status) ?? 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-300 ease-in-out">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-calendar-plus text-blue-600 text-xl"></i>
                        <div>
                            <span class="block text-sm font-semibold text-gray-700">Tanggal Bergabung</span>
                            <p class="text-gray-600">{{ $employee->join_date ? $employee->join_date->format('d M Y') : 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-300 ease-in-out">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-toggle-on text-blue-600 text-xl"></i>
                        <div>
                            <span class="block text-sm font-semibold text-gray-700">Status Aktif</span>
                            <p class="text-gray-600">{{ $employee->is_active ? 'Aktif' : 'Tidak Aktif' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-300 ease-in-out">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                        <div>
                            <span class="block text-sm font-semibold text-gray-700">Dibuat Pada</span>
                            <p class="text-gray-600">{{ $employee->created_at ? $employee->created_at->format('d M Y H:i') : 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-300 ease-in-out">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                        <div>
                            <span class="block text-sm font-semibold text-gray-700">Terakhir Diperbarui</span>
                            <p class="text-gray-600">{{ $employee->updated_at ? $employee->updated_at->format('d M Y H:i') : 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-center">
                <a href="{{ route('admin.employees.index') }}"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl font-medium shadow-md hover:bg-blue-700 transition duration-300 ease-in-out">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection