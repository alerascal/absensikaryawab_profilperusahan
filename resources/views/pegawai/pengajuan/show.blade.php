@extends('layouts.app')

@section('content')
<div class="p-4 max-w-lg mx-auto">
    <h2 class="text-2xl font-bold mb-4">Detail Pengajuan</h2>

    <div class="bg-white shadow rounded p-4 space-y-2">
        <p><strong>Tipe:</strong> {{ ucfirst($pengajuan->type) }}</p>
        <p><strong>Judul:</strong> {{ $pengajuan->title }}</p>
        <p><strong>Deskripsi:</strong> {{ $pengajuan->description }}</p>
        <p><strong>Status:</strong> {{ ucfirst($pengajuan->status) }}</p>
        <p><strong>Diajukan pada:</strong> {{ $pengajuan->created_at->format('d-m-Y H:i') }}</p>

        @if($pengajuan->surat_dokter)
            <p><strong>Surat Dokter:</strong> 
                <a href="{{ asset('storage/' . $pengajuan->surat_dokter) }}" target="_blank" class="text-blue-600 hover:underline">
                    Lihat / Unduh
                </a>
            </p>
        @endif

        @if($pengajuan->surat_izin)
            <p><strong>Surat Izin:</strong> 
                <a href="{{ asset('storage/' . $pengajuan->surat_izin) }}" target="_blank" class="text-blue-600 hover:underline">
                    Lihat / Unduh
                </a>
            </p>
        @endif
    </div>

    <a href="{{ route('pegawai.pengajuan.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">
        ← Kembali ke daftar pengajuan
    </a>
</div>
@endsection
