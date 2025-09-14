@extends('layouts.app')

@section('content')
<div class="pengajuan-container">
    <h1 class="pengajuan-title">Tambah Pengajuan</h1>
    
    <form action="{{ route('admin.pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="pengajuan-form">
        @csrf
        <div class="mb-4">
            <label for="title" class="pengajuan-form-label">Judul</label>
            <input type="text" name="title" id="title" class="pengajuan-form-input" value="{{ old('title') }}" required>
            @error('title')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description" class="pengajuan-form-label">Deskripsi</label>
            <textarea name="description" id="description" class="pengajuan-form-textarea" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="status" class="pengajuan-form-label">Status</label>
            <select name="status" id="status" class="pengajuan-form-select" required>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            @error('status')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="surat_dokter" class="pengajuan-form-label">Surat Dokter (PDF/JPG/PNG, max 2MB)</label>
            <input type="file" name="surat_dokter" id="surat_dokter" class="pengajuan-form-input">
            @error('surat_dokter')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="surat_izin" class="pengajuan-form-label">Surat Izin (PDF/JPG/PNG, max 2MB)</label>
            <input type="file" name="surat_izin" id="surat_izin" class="pengajuan-form-input">
            @error('surat_izin')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex space-x-4">
            <button type="submit" class="pengajuan-btn btn-primary">Simpan</button>
            <a href="{{ route('admin.pengajuan.index') }}" class="pengajuan-btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection