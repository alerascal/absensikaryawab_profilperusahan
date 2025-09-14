@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="quick-panel">
    <div class="panel-header">
        <h2 class="panel-title">Edit Profil</h2>
        <p class="panel-subtitle">Perbarui data akun & kepegawaian</p>
    </div>

    <form action="{{ route('settings.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Data Pribadi -->
        <div>
            <label class="block font-medium">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input w-full" required>
        </div>

        <div>
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input w-full" required>
        </div>

        <div>
            <label class="block font-medium">Password Baru</label>
            <input type="password" name="password" class="form-input w-full">
            <small class="text-gray-500">Kosongkan jika tidak ingin mengganti password.</small>
        </div>

        <div>
            <label class="block font-medium">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-input w-full">
        </div>

        <!-- Data Kepegawaian -->
        <div>
            <label class="block font-medium">NIK / ID Karyawan</label>
            <input type="text" name="employee_id" value="{{ old('employee_id', $user->employee_id) }}" class="form-input w-full">
        </div>

        <div>
            <label class="block font-medium">Jabatan</label>
            <input type="text" name="position" value="{{ old('position', $user->position) }}" class="form-input w-full">
        </div>

        <div>
            <label class="block font-medium">Status Kerja</label>
            <select name="employment_status" class="form-input w-full">
                <option value="Aktif" {{ $user->employment_status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Cuti" {{ $user->employment_status == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                <option value="Resign" {{ $user->employment_status == 'Resign' ? 'selected' : '' }}>Resign</option>
            </select>
        </div>

        <div>
            <label class="block font-medium">Tanggal Bergabung</label>
            <input type="date" name="join_date" value="{{ old('join_date', $user->join_date) }}" class="form-input w-full">
        </div>

        <div>
            <label class="block font-medium">Departemen</label>
            <select name="department_id" class="form-input w-full">
                <option value="">-- Pilih Departemen --</option>
                @foreach(App\Models\Department::all() as $dept)
                    <option value="{{ $dept->id }}" {{ $user->department_id == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Status Akun</label>
            <select name="is_active" class="form-input w-full">
                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Non-Aktif</option>
            </select>
        </div>

        <div class="flex space-x-2 mt-4">
            <button type="submit" class="btn-compact btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('settings.index') }}" class="btn-compact btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
