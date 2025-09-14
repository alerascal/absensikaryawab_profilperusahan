@extends('layouts.app')

@section('content')
<div class="pengajuan-container">
    <h1 class="pengajuan-title">Detail Pengajuan</h1>
    
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h5 class="text-xl font-semibold text-gray-800 mb-4">{{ $pengajuan->title }}</h5>
        <p class="text-gray-600 mb-2"><strong>Deskripsi:</strong> {{ $pengajuan->description }}</p>
        <p class="text-gray-600 mb-2"><strong>Status:</strong> {{ $pengajuan->status }}</p>
        <p class="text-gray-600 mb-2"><strong>Pengaju:</strong> {{ $pengajuan->user->name ?? 'N/A' }}</p>
        <p class="text-gray-600 mb-2"><strong>Surat Dokter:</strong> 
            @if ($pengajuan->surat_dokter)
                <a href="{{ Storage::url($pengajuan->surat_dokter) }}" target="_blank" class="file-preview">Lihat File</a>
            @else
                Tidak Ada
            @endif
        </p>
        <p class="text-gray-600 mb-2"><strong>Surat Izin:</strong> 
            @if ($pengajuan->surat_izin)
                <a href="{{ Storage::url($pengajuan->surat_izin) }}" target="_blank" class="file-preview">Lihat File</a>
            @else
                Tidak Ada
            @endif
        </p>
        <p class="text-gray-600 mb-4"><strong>Tanggal Dibuat:</strong> {{ $pengajuan->created_at->format('d/m/Y H:i') }}</p>
        <div class="flex space-x-4">
            <a href="{{ route('admin.pengajuan.edit', $pengajuan) }}" class="pengajuan-btn btn-warning">Edit</a>
            <a href="{{ route('admin.pengajuan.index') }}" class="pengajuan-btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection