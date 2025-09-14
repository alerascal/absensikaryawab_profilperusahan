@extends('layouts.app')

@section('content')
<div class="pengajuan-container">
    <h1 class="pengajuan-title">Daftar Pengajuan</h1>
    <a href="{{ route('admin.pengajuan.create') }}" class="pengajuan-btn btn-primary mb-6">Tambah Pengajuan</a>
    
    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <table class="pengajuan-table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Pengaju</th>
                <th>Surat Dokter</th>
                <th>Surat Izin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengajuans as $pengajuan)
                <tr>
                    <td>{{ $pengajuan->title }}</td>
                    <td>{{ Str::limit($pengajuan->description, 50) }}</td>
                    <td>{{ $pengajuan->status }}</td>
                    <td>{{ $pengajuan->user->name ?? 'N/A' }}</td>
                    <td>
                        @if ($pengajuan->surat_dokter)
                            <a href="{{ Storage::url($pengajuan->surat_dokter) }}" target="_blank" class="pengajuan-btn btn-primary">Lihat</a>
                        @else
                            Tidak Ada
                        @endif
                    </td>
                    <td>
                        @if ($pengajuan->surat_izin)
                            <a href="{{ Storage::url($pengajuan->surat_izin) }}" target="_blank" class="pengajuan-btn btn-primary">Lihat</a>
                        @else
                            Tidak Ada
                        @endif
                    </td>
                    <td class="flex space-x-2">
                        <a href="{{ route('admin.pengajuan.show', $pengajuan) }}" class="pengajuan-btn btn-primary">Lihat</a>
                        <a href="{{ route('admin.pengajuan.edit', $pengajuan) }}" class="pengajuan-btn btn-warning">Edit</a>
                        <form action="{{ route('admin.pengajuan.destroy', $pengajuan) }}" method="POST" class="delete-form" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="pengajuan-btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-6">
        {{ $pengajuans->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection