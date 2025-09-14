@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        margin: 2rem auto;
        padding: 1.5rem;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-size: 0.9rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .btn-submit {
        background: #3b82f6;
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }
</style>

<div class="form-container">
    <h1 class="font-bold text-2xl mb-6 text-gray-800">Tambah Karyawan</h1>
    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="@error('name') border-red-500 @enderror" required>
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="@error('email') border-red-500 @enderror" required>
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="@error('password') border-red-500 @enderror" required>
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="@error('password_confirmation') border-red-500 @enderror" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="@error('role') border-red-500 @enderror" required>
                <option value="admin" @if(old('role') == 'admin') selected @endif>Admin</option>
                <option value="pegawai" @if(old('role') == 'pegawai') selected @endif>Pegawai</option>
            </select>
            @error('role')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="department_id">Departemen</label>
            <select name="department_id" id="department_id" class="@error('department_id') border-red-500 @enderror">
                <option value="">Pilih Departemen</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" @if(old('department_id') == $dept->id) selected @endif>{{ $dept->name }}</option>
                @endforeach
            </select>
            @error('department_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn-submit">Simpan</button>
    </form>
</div>
@endsection