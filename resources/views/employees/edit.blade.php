@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Karyawan</h1>

    <form method="POST" action="{{ route('employees.update', $employee->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="employee_id">ID Karyawan</label>
            <input type="text" name="employee_id" id="employee_id" 
                   value="{{ old('employee_id', $employee->employee_id) }}" 
                   class="form-control">
            @error('employee_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name', $employee->name) }}" 
                   class="form-control">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" 
                   value="{{ old('email', $employee->email ?? '') }}" 
                   class="form-control" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control">
                <option value="admin" {{ old('role', $employee->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ old('role', $employee->role) == 'user' ? 'selected' : '' }}>User</option>
            </select>
            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="department_id">Departemen</label>
            <select name="department_id" id="department_id" class="form-control">
                <option value="">Tidak ada</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
            @error('department_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
