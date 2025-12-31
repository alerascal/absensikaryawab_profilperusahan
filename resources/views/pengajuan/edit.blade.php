@extends('layouts.app')
@section('title', 'kelola Pengajuan')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12">
    <div class="max-w-2xl w-full px-6">
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-black text-white px-10 py-12 text-center">
                <h1 class="text-3xl font-light mb-2">kelola Pengajuan</h1>
                <p class="text-gray-300">Anda hanya dapat mengedit pengajuan yang masih berstatus <strong>Pending</strong></p>
            </div>

            <div class="p-10">
                <form action="{{ route('pengajuan.update', $pengajuan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-10">
                        <!-- Judul -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Judul Pengajuan
                            </label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $pengajuan->title) }}"
                                   required
                                   class="w-full px-5 py-4 border border-gray-200 rounded-2xl focus:border-black focus:outline-none transition"
                                   placeholder="Contoh: Izin Sakit, Cuti Tahunan">
                            @error('title')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Deskripsi / Alasan
                            </label>
                            <textarea name="description"
                                      rows="6"
                                      class="w-full px-5 py-4 border border-gray-200 rounded-2xl focus:border-black focus:outline-none transition resize-none"
                                      placeholder="Perbarui alasan pengajuan Anda jika diperlukan...">{{ old('description', $pengajuan->description) }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dokumen Saat Ini & Upload Baru -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Surat Dokter -->
                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6">
                                <p class="font-medium text-gray-800 mb-4">Surat Dokter Saat Ini</p>
                                @if($pengajuan->surat_dokter)
                                    <a href="{{ asset('storage/' . $pengajuan->surat_dokter) }}"
                                       target="_blank"
                                       class="inline-block mb-4 text-blue-600 hover:underline text-sm font-medium">
                                        ↗ Lihat dokumen saat ini
                                    </a>
                                @else
                                    <p class="text-gray-500 mb-4 text-sm">Tidak ada dokumen</p>
                                @endif
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Ganti dengan file baru (opsional)
                                </label>
                                <input type="file"
                                       name="surat_dokter"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       class="w-full px-5 py-4 border border-dashed border-gray-300 rounded-2xl file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:bg-black file:text-white hover:file:bg-gray-800 cursor-pointer">
                            </div>

                            <!-- Surat Izin -->
                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6">
                                <p class="font-medium text-gray-800 mb-4">Surat Izin / Pendukung Saat Ini</p>
                                @if($pengajuan->surat_izin)
                                    <a href="{{ asset('storage/' . $pengajuan->surat_izin) }}"
                                       target="_blank"
                                       class="inline-block mb-4 text-green-600 hover:underline text-sm font-medium">
                                        ↗ Lihat dokumen saat ini
                                    </a>
                                @else
                                    <p class="text-gray-500 mb-4 text-sm">Tidak ada dokumen</p>
                                @endif
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Ganti dengan file baru (opsional)
                                </label>
                                <input type="file"
                                       name="surat_izin"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       class="w-full px-5 py-4 border border-dashed border-gray-300 rounded-2xl file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:bg-black file:text-white hover:file:bg-gray-800 cursor-pointer">
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="pt-8 flex gap-4">
                            <button type="submit"
                                    class="flex-1 py-4 bg-black text-white font-medium rounded-2xl hover:bg-gray-800 transition shadow-md">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('pengajuan.show', $pengajuan) }}"
                               class="flex-1 text-center py-4 border border-gray-300 text-gray-700 font-medium rounded-2xl hover:bg-gray-50 transition">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection