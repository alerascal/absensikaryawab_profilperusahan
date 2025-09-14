@extends('layouts.app')

@section('content')
<div class="p-4 max-w-lg mx-auto">
    <h2 class="text-2xl font-bold mb-4">Buat Pengajuan</h2>

    <form action="{{ route('pegawai.pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block font-semibold">Tipe Pengajuan</label>
            <select name="type" class="w-full border rounded p-2">
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold">Judul</label>
            <input type="text" name="title" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-semibold">Deskripsi</label>
            <textarea name="description" class="w-full border rounded p-2" rows="4" required></textarea>
        </div>

        <div>
            <label class="block font-semibold">Upload Surat Dokter (sesuaikan sama tipe pengajuan)</label>
            <input type="file" name="surat_dokter" class="w-full">
        </div>

        <div>
            <label class="block font-semibold">Upload Surat Izin (sesuaikan sama tipe pengajuan)</label>
            <input type="file" name="surat_izin" class="w-full">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-paper-plane"></i> Ajukan
        </button>
    </form>
</div>
@endsection
