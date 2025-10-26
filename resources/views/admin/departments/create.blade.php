@extends('layouts.app')

@section('title', 'Tambah Departemen - AttendPro')

@section('content')
<div class="main-content" style="padding: 24px; font-family: 'Inter', sans-serif; background: #f4f7fc;">

    <div class="attendance-panel" 
         style="background: #fff; border-radius: 1rem; padding: 24px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <h1 style="font-size: 24px; font-weight: 600; color: #1f2937;">Tambah Departemen</h1>
                <p style="color: #6b7280;">Masukkan data departemen baru</p>
            </div>
            <a href="{{ route('admin.departments.index') }}" 
               style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: #6b7280; color: #fff; border-radius: 0.75rem; font-weight: 500; text-decoration: none; transition: all 0.3s;"
               onmouseover="this.style.background='#4b5563'; this.style.transform='scale(1.05)';" 
               onmouseout="this.style.background='#6b7280'; this.style.transform='scale(1)';">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.departments.store') }}" method="POST">
            @csrf

            <div style="display: flex; flex-direction: column; gap: 16px;">

                <!-- Nama Departemen -->
                <div>
                    <label for="name" style="display: block; font-weight: 500; color: #374151; margin-bottom: 8px;">Nama Departemen</label>
                    <input type="text" name="name" id="name" required 
                           style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 0.75rem; background: #f9fafb; color: #111827; transition: all 0.2s;"
                           placeholder="Masukkan nama departemen" value="{{ old('name') }}">
                    @error('name')
                        <p style="color: #ef4444; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        style="padding: 12px 24px; background: #4f46e5; color: #fff; border-radius: 0.75rem; font-weight: 500; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s;"
                        onmouseover="this.style.background='#4338ca'; this.style.transform='scale(1.05)';" 
                        onmouseout="this.style.background='#4f46e5'; this.style.transform='scale(1)';">
                    Simpan Departemen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection