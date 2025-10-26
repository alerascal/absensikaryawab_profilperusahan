@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
<div class="mx-auto px-4 py-8 max-w-7xl">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Manajemen Karyawan</h1>
                <p class="text-sm text-blue-100 mt-1">Kelola data karyawan dengan mudah dan efisien</p>
            </div>
            <a href="{{ route('admin.employees.create') }}"
                class="bg-white text-blue-600 px-6 py-3 rounded-xl font-medium shadow-md hover:bg-gray-50 transition duration-300 ease-in-out">
                + Tambah Karyawan
            </a>
        </div>

        <!-- Filter Form -->
        <div class="p-6 md:p-8 border-b border-gray-200 bg-gray-50">
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Cari Nama / Email / ID Karyawan</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Ketik nama, email, atau ID karyawan..."
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none transition duration-200 sm:text-sm">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                    <select id="role" name="role"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none transition duration-200 sm:text-sm">
                        <option value="">Semua</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="hr" {{ request('role') == 'hr' ? 'selected' : '' }}>HR</option>
                        <option value="finance" {{ request('role') == 'finance' ? 'selected' : '' }}>Finance</option>
                        <option value="it_admin" {{ request('role') == 'it_admin' ? 'selected' : '' }}>IT Admin</option>
                        <option value="supervisor" {{ request('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                        <option value="employee" {{ request('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                        <option value="guest" {{ request('role') == 'guest' ? 'selected' : '' }}>Guest</option>
                    </select>
                </div>

                <!-- Department -->
                <div>
                    <label for="department" class="block text-sm font-semibold text-gray-700 mb-2">Departemen</label>
                    <select id="department" name="department"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none transition duration-200 sm:text-sm">
                        <option value="">Semua</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol -->
                <div class="flex flex-col sm:flex-row gap-4 w-full">
                    <button type="submit"
                        class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-xl font-medium shadow-md hover:bg-blue-700 transition duration-300 ease-in-out">
                        Filter
                    </button>
                    <a href="{{ route('admin.employees.index') }}"
                        class="flex-1 bg-gray-200 text-gray-800 px-6 py-3 rounded-xl font-medium shadow-md hover:bg-gray-300 transition duration-300 ease-in-out text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Content -->
        <div class="p-6 md:p-8">
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if ($employees->isEmpty())
                <p class="text-gray-500 text-center py-8">Belum ada data karyawan yang tersedia.</p>
            @else
                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold tracking-wider">
                                <th class="py-4 px-6 text-left">Nama</th>
                                <th class="py-4 px-6 text-left">Email</th>
                                <th class="py-4 px-6 text-left">Role</th>
                                <th class="py-4 px-6 text-left">Departemen</th>
                                <th class="py-4 px-6 text-left">Posisi</th>
                                <th class="py-4 px-6 text-left">Status</th>
                                <th class="py-4 px-6 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($employees as $employee)
                                <tr class="hover:bg-gray-50 transition duration-200">
                                    <td class="py-4 px-6 text-sm">{{ $employee->name }}</td>
                                    <td class="py-4 px-6 text-sm">{{ $employee->email }}</td>
                                    <td class="py-4 px-6 text-sm capitalize">{{ $employee->role }}</td>
                                    <td class="py-4 px-6 text-sm">
                                        {{ $employee->department ? $employee->department->name : '-' }}
                                    </td>
                                    <td class="py-4 px-6 text-sm">{{ $employee->position ?? '-' }}</td>
                                    <td class="py-4 px-6 text-sm capitalize">{{ $employee->employment_status ?? '-' }}</td>
                                    <td class="py-4 px-6 flex gap-3 text-sm">
                                        <a href="{{ route('admin.employees.show', $employee->id) }}"
                                            class="text-green-600 hover:text-green-800 font-medium transition">Lihat</a>
                                        <a href="{{ route('admin.employees.edit', $employee->id) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium transition">Edit</a>
                                        <form action="{{ route('admin.employees.destroy', $employee->id) }}"
                                            method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-medium transition"
                                                onclick="return confirm('Yakin ingin menghapus karyawan ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    {{ $employees->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection