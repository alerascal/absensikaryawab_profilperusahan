@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('admin.pengajuan.index') }}" class="hover:text-blue-600 transition-colors">Pengajuan</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900">Edit Pengajuan</span>
        </nav>

        <!-- Header Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
            <div class="px-6 py-8 sm:px-8">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-8 h-8 bg-amber-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Edit Pengajuan</h1>
                </div>
                <p class="text-gray-600 text-sm sm:text-base">Perbarui informasi pengajuan sesuai kebutuhan</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <form action="{{ route('admin.pengajuan.update', $pengajuan) }}" method="POST" enctype="multipart/form-data" class="px-6 py-8 sm:px-8">
                @csrf
                @method('PUT')
                
                <div class="space-y-8">
                    <!-- Title Field -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-semibold text-gray-800">Judul Pengajuan</label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-500 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-200" 
                            placeholder="Masukkan judul pengajuan"
                            value="{{ old('title', $pengajuan->title) }}" 
                            required
                        >
                        @error('title')
                            <p class="text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-semibold text-gray-800">Deskripsi</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="5" 
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-500 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-200 resize-none" 
                            placeholder="Jelaskan detail pengajuan Anda"
                            required
                        >{{ old('description', $pengajuan->description) }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Status Field -->
                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-semibold text-gray-800">Status</label>
                        <select 
                            name="status" 
                            id="status" 
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-200" 
                            required
                        >
                            <option value="pending" {{ old('status', $pengajuan->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $pengajuan->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $pengajuan->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <p class="text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- File Upload Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Surat Dokter -->
                        <div class="space-y-3">
                            <label for="surat_dokter" class="block text-sm font-semibold text-gray-800">Surat Dokter</label>
                            
                            @if ($pengajuan->surat_dokter)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-green-900">File saat ini tersedia</p>
                                                <p class="text-xs text-green-700">Upload file baru untuk mengganti</p>
                                            </div>
                                        </div>
                                        <a href="{{ Storage::url($pengajuan->surat_dokter) }}" target="_blank" 
                                           class="text-green-600 hover:text-green-700 font-medium text-sm">
                                            Lihat File
                                        </a>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="relative">
                                <input 
                                    type="file" 
                                    name="surat_dokter" 
                                    id="surat_dokter" 
                                    class="sr-only" 
                                    accept=".pdf,.jpg,.jpeg,.png"
                                >
                                <label 
                                    for="surat_dokter" 
                                    class="flex items-center justify-center w-full h-32 bg-gray-50 border-2 border-gray-200 border-dashed rounded-lg cursor-pointer hover:bg-gray-100 hover:border-blue-300 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/20 transition-all duration-200"
                                >
                                    <div class="text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium text-blue-600">Pilih file baru</span><br>
                                            <span class="text-xs">PDF, JPG, PNG (max 2MB)</span>
                                        </p>
                                    </div>
                                </label>
                            </div>
                            
                            @error('surat_dokter')
                                <p class="text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Surat Izin -->
                        <div class="space-y-3">
                            <label for="surat_izin" class="block text-sm font-semibold text-gray-800">Surat Izin</label>
                            
                            @if ($pengajuan->surat_izin)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-green-900">File saat ini tersedia</p>
                                                <p class="text-xs text-green-700">Upload file baru untuk mengganti</p>
                                            </div>
                                        </div>
                                        <a href="{{ Storage::url($pengajuan->surat_izin) }}" target="_blank" 
                                           class="text-green-600 hover:text-green-700 font-medium text-sm">
                                            Lihat File
                                        </a>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="relative">
                                <input 
                                    type="file" 
                                    name="surat_izin" 
                                    id="surat_izin" 
                                    class="sr-only" 
                                    accept=".pdf,.jpg,.jpeg,.png"
                                >
                                <label 
                                    for="surat_izin" 
                                    class="flex items-center justify-center w-full h-32 bg-gray-50 border-2 border-gray-200 border-dashed rounded-lg cursor-pointer hover:bg-gray-100 hover:border-blue-300 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/20 transition-all duration-200"
                                >
                                    <div class="text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium text-blue-600">Pilih file baru</span><br>
                                            <span class="text-xs">PDF, JPG, PNG (max 2MB)</span>
                                        </p>
                                    </div>
                                </label>
                            </div>
                            
                            @error('surat_izin')
                                <p class="text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100">
                        <button 
                            type="submit" 
                            class="flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transform hover:scale-[1.02] transition-all duration-200"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a 
                            href="{{ route('admin.pengajuan.index') }}" 
                            class="flex items-center justify-center px-6 py-3 bg-white text-gray-700 font-semibold border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 focus:ring-2 focus:ring-gray-500/20 focus:outline-none transition-all duration-200"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// File upload preview and status update
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const label = this.nextElementSibling;
            const fileName = this.files[0]?.name;
            
            if (fileName) {
                const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2);
                label.innerHTML = `
                    <div class="text-center">
                        <svg class="mx-auto h-8 w-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-gray-900 font-medium">${fileName}</p>
                        <p class="text-xs text-gray-600">${fileSize} MB - File baru dipilih</p>
                    </div>
                `;
                label.classList.remove('border-gray-200', 'hover:border-blue-300', 'bg-gray-50');
                label.classList.add('border-blue-300', 'bg-blue-50');
            }
        });
    });

    // Status selector enhancement
    const statusSelect = document.getElementById('status');
    statusSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        this.className = this.className.replace(/border-\w+-\d+/, 'border-gray-200');
        
        if (this.value === 'approved') {
            this.classList.add('border-green-300', 'bg-green-50');
        } else if (this.value === 'rejected') {
            this.classList.add('border-red-300', 'bg-red-50');
        } else if (this.value === 'pending') {
            this.classList.add('border-amber-300', 'bg-amber-50');
        }
    });
});
</script>
@endsection