@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-700 to-green-500 text-white p-6 md:p-8">
            <h1 class="text-3xl font-bold tracking-tight">Tambah Karyawan</h1>
            <p class="text-sm text-green-100 mt-1">Masukkan data karyawan baru dengan mudah</p>
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

            <form action="{{ route('admin.employees.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition duration-200 sm:text-sm"
                        required>
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition duration-200 sm:text-sm"
                        required>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition duration-200 sm:text-sm"
                        required>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition duration-200 sm:text-sm"
                        required>
                </div>

                <div class="mb-6">
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                    <select name="role" id="role"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition duration-200 sm:text-sm"
                        required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="hr" {{ old('role') == 'hr' ? 'selected' : '' }}>HR</option>
                        <option value="finance" {{ old('role') == 'finance' ? 'selected' : '' }}>Finance</option>
                        <option value="it_admin" {{ old('role') == 'it_admin' ? 'selected' : '' }}>IT Admin</option>
                        <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                        <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                        <option value="guest" {{ old('role') == 'guest' ? 'selected' : '' }}>Guest</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="department_id" class="block text-sm font-semibold text-gray-700 mb-2">Departemen</label>
                    <select name="department_id" id="department_id"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition duration-200 sm:text-sm">
                        <option value="">-- Pilih Departemen --</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="employee_id" class="block text-sm font-semibold text-gray-700 mb-2">ID Karyawan</label>
                    <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id') }}"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition duration-200 sm:text-sm">
                </div>

                <div class="mb-6">
                    <label for="position" class="block text-sm font-semibold text-gray-700 mb-2">Posisi</label>
                    <input type="text" name="position" id="position" value="{{ old('position') }}"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition duration-200 sm:text-sm">
                </div>

                <div class="mb-6">
                    <label for="employment_status" class="block text-sm font-semibold text-gray-700 mb-2">Status Pekerjaan</label>
                    <select name="employment_status" id="employment_status"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition duration-200 sm:text-sm">
                        <option value="">-- Pilih Status --</option>
                        <option value="full-time" {{ old('employment_status') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="part-time" {{ old('employment_status') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="contract" {{ old('employment_status') == 'contract' ? 'selected' : '' }}>Contract</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="join_date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Bergabung</label>
                    <input type="date" name="join_date" id="join_date" value="{{ old('join_date') }}"
                        class="w-full rounded-xl border border-gray-300 shadow-sm px-4 py-3 
                               focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition duration-200 sm:text-sm">
                </div>

                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm font-semibold text-gray-700">Aktif</span>
                    </label>
                </div>

                <div class="flex flex-col sm:flex-row justify-between gap-4">
                    <a href="{{ route('admin.employees.index') }}"
                        class="flex-1 bg-gray-200 text-gray-800 px-6 py-3 rounded-xl font-medium shadow-md hover:bg-gray-300 transition duration-300 ease-in-out text-center">
                        Kembali
                    </a>
                    <button type="submit"
                        class="flex-1 bg-green-600 text-white px-6 py-3 rounded-xl font-medium shadow-md hover:bg-green-700 transition duration-300 ease-in-out">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection