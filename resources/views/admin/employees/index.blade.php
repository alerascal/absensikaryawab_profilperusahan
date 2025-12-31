@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
<div class="mx-auto px-4 py-8 max-w-7xl">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white p-6 md:p-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight">Manajemen Karyawan</h1>
                    <p class="text-blue-100 mt-2 text-base">Kelola data karyawan dengan mudah dan efisien</p>
                </div>
                <a href="{{ route('admin.employees.create') }}"
                    class="inline-flex items-center gap-2 bg-white text-blue-700 px-6 py-3.5 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:bg-gray-50 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Karyawan
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="p-6 md:p-8 bg-gray-50 border-b border-gray-200">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Search -->
                <div class="lg:col-span-1">
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Cari</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Nama, email, atau ID karyawan..."
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition px-4 py-3">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                    <select id="role" name="role"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition px-4 py-3">
                        <option value="">Semua Role</option>
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
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition px-4 py-3">
                        <option value="">Semua Departemen</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 lg:col-span-1 lg:justify-end">
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16l2 4H3V4zM3 19h18l-2 2H5l-2-2zM7 8v10m10-10v10" />
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('admin.employees.index') }}"
                        class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-800 rounded-xl font-semibold text-center hover:bg-gray-300 shadow-md transition-all duration-300">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Messages -->
        <div class="px-6 md:px-8 pt-6">
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-xl mb-6 shadow-sm flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-xl mb-6 shadow-sm flex items-center gap-3">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Employee List -->
        <div class="p-6 md:p-8 pb-10">
            @if ($employees->isEmpty())
                <div class="text-center py-16">
                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-24 h-24 mx-auto mb-6"></div>
                    <p class="text-gray-500 text-lg">Belum ada data karyawan yang tersedia.</p>
                    <a href="{{ route('admin.employees.create') }}" class="inline-block mt-4 text-blue-600 hover:text-blue-800 font-medium">
                        + Tambah karyawan pertama
                    </a>
                </div>
            @else
                <!-- Desktop Table -->
                <div class="hidden lg:block overflow-hidden rounded-2xl border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Karyawan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Departemen</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Posisi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($employees as $employee)
                                <tr class="hover:bg-gray-50 transition duration-200">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                {{ strtoupper(substr($employee->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $employee->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $employee->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                            {{ ucfirst($employee->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-900">
                                        {{ $employee->department ? $employee->department->name : '-' }}
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-900">
                                        {{ $employee->position ?? '-' }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                                            {{ $employee->employment_status == 'active' ? 'bg-green-100 text-green-800' : 
                                               ($employee->employment_status == 'inactive' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($employee->employment_status ?? '-') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-sm">
                                        <div class="flex items-center gap-4">
                                            <a href="{{ route('admin.employees.show', $employee->id) }}"
                                                class="text-green-600 hover:text-green-800 font-medium">Lihat</a>
                                            <a href="{{ route('admin.employees.edit', $employee->id) }}"
                                                class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                            <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin ingin menghapus karyawan ini?')"
                                                    class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card List -->
                <div class="lg:hidden space-y-4">
                    @foreach ($employees as $employee)
                        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-xl shadow-md">
                                        {{ strtoupper(substr($employee->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-lg text-gray-900">{{ $employee->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $employee->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-sm mb-5">
                                <div>
                                    <span class="text-gray-500">Role</span>
                                    <p class="mt-1">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                            {{ ucfirst($employee->role) }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Status</span>
                                    <p class="mt-1">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                                            {{ $employee->employment_status == 'active' ? 'bg-green-100 text-green-800' : 
                                               ($employee->employment_status == 'inactive' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($employee->employment_status ?? '-') }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Departemen</span>
                                    <p class="mt-1 font-medium">{{ $employee->department ? $employee->department->name : '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Posisi</span>
                                    <p class="mt-1 font-medium">{{ $employee->position ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="flex justify-end gap-4 border-t pt-4">
                                <a href="{{ route('admin.employees.show', $employee->id) }}"
                                    class="text-green-600 hover:text-green-800 font-medium">Lihat</a>
                                <a href="{{ route('admin.employees.edit', $employee->id) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')"
                                        class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-10 flex justify-center">
                    {{ $employees->appends(request()->query())->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection