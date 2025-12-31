@extends('layouts.app')
@section('title', 'Buat Pengajuan Baru')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12">
    <div class="max-w-2xl w-full px-6">
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-black text-white px-10 py-12 text-center">
                <h1 class="text-3xl font-light mb-2">Buat Pengajuan Baru</h1>
                <p class="text-gray-300">Isi form di bawah ini dengan lengkap</p>
            </div>

            <div class="p-10">
                <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-10">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Judul Pengajuan *</label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                   class="w-full px-5 py-4 border border-gray-200 rounded-2xl focus:border-black focus:outline-none transition"
                                   placeholder="Misal: Izin Sakit, Cuti Tahunan">
                            @error('title') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Deskripsi / Alasan</label>
                            <textarea name="description" rows="6"
                                      class="w-full px-5 py-4 border border-gray-200 rounded-2xl focus:border-black focus:outline-none transition resize-none"
                                      placeholder="Jelaskan secara singkat alasan pengajuan Anda...">{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Surat Dokter (opsional)</label>
                                <input type="file" name="surat_dokter" accept=".pdf,.jpg,.jpeg,.png"
                                       class="w-full px-5 py-4 border border-dashed border-gray-300 rounded-2xl file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:bg-black file:text-white hover:file:bg-gray-800 cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Surat Izin / Dokumen Lain</label>
                                <input type="file" name="surat_izin" accept=".pdf,.jpg,.jpeg,.png"
                                       class="w-full px-5 py-4 border border-dashed border-gray-300 rounded-2xl file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:bg-black file:text-white hover:file:bg-gray-800 cursor-pointer">
                            </div>
                        </div>

                        <div class="pt-6 flex gap-4">
                            <button type="submit"
                                    class="flex-1 py-4 bg-black text-white font-medium rounded-2xl hover:bg-gray-800 transition shadow-md">
                                Kirim Pengajuan
                            </button>
                            <a href="{{ route('pengajuan.my') }}"
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