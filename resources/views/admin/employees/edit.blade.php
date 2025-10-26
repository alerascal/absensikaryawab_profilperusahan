@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white p-6 md:p-8">
            <h1 class="text-3xl font-bold tracking-tight">Edit Karyawan</h1>
            <p class="text-sm text-blue-100 mt-1">Perbarui detail karyawan dengan mudah</p>
        </div>

        <!-- Form -->
        <div class="p-6 md:p-8">
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                    <input type="text" name="name" id="name" class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none transition duration-200 sm:text-sm" 
                           value="{{ old('name', $employee->name) }}" required>
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none transition duration-200 sm:text-sm" 
                           value="{{ old('email', $employee->email) }}" required>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" id="password" class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none transition duration-200 sm:text-sm">
                </div>

                <div class="mb-6">
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                    <select name="role" id="role" class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                             focus:border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none transition duration-200 sm:text-sm"
                             required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role', $employee->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manager" {{ old('role', $employee->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="hr" {{ old('role', $employee->role) == 'hr' ? 'selected' : '' }}>HR</option>
                        <option value="finance" {{ old('role', $employee->role) == 'finance' ? 'selected' : '' }}>Finance</option>
                        <option value="it_admin" {{ old('role', $employee->role) == 'it_admin' ? 'selected' : '' }}>IT Admin</option>
                        <option value="supervisor" {{ old('role', $employee->role) == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                        <option value="employee" {{ old('role', $employee->role) == 'employee' ? 'selected' : '' }}>Employee</option>
                        <option value="guest" {{ old('role', $employee->role) == 'guest' ? 'selected' : '' }}>Guest</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="department_id" class="block text-sm font-semibold text-gray-700 mb-2">Departemen</label>
                    <select name="department_id" id="department_id" class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                             focus:border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none transition duration-200 sm:text-sm">
                        <option value="">Pilih Departemen</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="employee_id" class="block text-sm font-semibold text-gray-700 mb-2">ID Karyawan</label>
                    <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id', $employee->employee_id) }}"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none transition duration-200 sm:text-sm">
                </div>

                <div class="mb-6">
                    <label for="position" class="block text-sm font-semibold text-gray-700 mb-2">Posisi</label>
                    <input type="text" name="position" id="position" value="{{ old('position', $employee->position) }}"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none transition duration-200 sm:text-sm">
                </div>

                <div class="mb-6">
                    <label for="employment_status" class="block text-sm font-semibold text-gray-700 mb-2">Status Pekerjaan</label>
                    <select name="employment_status" id="employment_status"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none transition duration-200 sm:text-sm">
                        <option value="">-- Pilih Status --</option>
                        <option value="full-time" {{ old('employment_status', $employee->employment_status) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="part-time" {{ old('employment_status', $employee->employment_status) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="contract" {{ old('employment_status', $employee->employment_status) == 'contract' ? 'selected' : '' }}>Contract</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="join_date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Bergabung</label>
                    <input type="date" name="join_date" id="join_date" value="{{ old('join_date', $employee->join_date?->format('Y-m-d')) }}"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none transition duration-200 sm:text-sm">
                </div>

                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" {{ old('is_active', $employee->is_active) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm font-semibold text-gray-700">Aktif</span>
                    </label>
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-4">
                    <a href="{{ route('admin.employees.index') }}" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-xl font-medium shadow-md hover:bg-gray-300 transition duration-300 ease-in-out text-center">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-medium shadow-md hover:bg-blue-700 transition duration-300 ease-in-out">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection