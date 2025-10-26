@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                <a href="{{ route('admin.pengajuan.index') }}" class="hover:text-blue-600 transition-colors">Pengajuan</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900">Detail Pengajuan</span>
            </nav>
            
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Detail Pengajuan</h1>
                    <p class="text-gray-600">Informasi lengkap pengajuan</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Info Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="px-6 py-8 sm:px-8">
                        <!-- Title Section -->
                        <div class="mb-8">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">{{ $pengajuan->title }}</h2>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span>{{ $pengajuan->user->name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V5.5M8 7h8M8 7V5.5m0 0V5a2 2 0 012-2h4a2 2 0 012 2v.5M16 7V5.5"/>
                                            </svg>
                                            <span>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $pengajuan->status == 'approved' ? 'bg-green-100 text-green-800 border border-green-200' : '' }}
                                    {{ $pengajuan->status == 'rejected' ? 'bg-red-100 text-red-800 border border-red-200' : '' }}
                                    {{ $pengajuan->status == 'pending' ? 'bg-amber-100 text-amber-800 border border-amber-200' : '' }}">
                                    <div class="w-2 h-2 rounded-full mr-2
                                        {{ $pengajuan->status == 'approved' ? 'bg-green-600' : '' }}
                                        {{ $pengajuan->status == 'rejected' ? 'bg-red-600' : '' }}
                                        {{ $pengajuan->status == 'pending' ? 'bg-amber-600' : '' }}">
                                    </div>
                                    {{ ucfirst($pengajuan->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi</h3>
                            <div class="bg-gray-50 rounded-lg p-6 border-l-4 border-blue-500">
                                <p class="text-gray-700 leading-relaxed">{{ $pengajuan->description }}</p>
                            </div>
                        </div>

                        <!-- Documents Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900">Dokumen Pendukung</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Surat Dokter -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <div class="flex items-center space-x-3 mb-4">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">Surat Dokter</h4>
                                            <p class="text-sm text-gray-500">Dokumen medis</p>
                                        </div>
                                    </div>
                                    @if ($pengajuan->surat_dokter)
                                        <a href="{{ Storage::url($pengajuan->surat_dokter) }}" target="_blank" 
                                           class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-700 font-medium transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <span>Lihat Dokumen</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    @else
                                        <div class="flex items-center space-x-2 text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                                            </svg>
                                            <span class="text-sm">Tidak ada dokumen</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Surat Izin -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <div class="flex items-center space-x-3 mb-4">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">Surat Izin</h4>
                                            <p class="text-sm text-gray-500">Dokumen perizinan</p>
                                        </div>
                                    </div>
                                    @if ($pengajuan->surat_izin)
                                        <a href="{{ Storage::url($pengajuan->surat_izin) }}" target="_blank" 
                                           class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-700 font-medium transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <span>Lihat Dokumen</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    @else
                                        <div class="flex items-center space-x-2 text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                                            </svg>
                                            <span class="text-sm">Tidak ada dokumen</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="px-6 py-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengajuan</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                                <span class="text-sm font-medium text-gray-600">Status</span>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $pengajuan->status == 'approved' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $pengajuan->status == 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $pengajuan->status == 'pending' ? 'bg-amber-100 text-amber-700' : '' }}">
                                    {{ ucfirst($pengajuan->status) }}
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                                <span class="text-sm font-medium text-gray-600">Pengaju</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $pengajuan->user->name ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                                <span class="text-sm font-medium text-gray-600">Tanggal Dibuat</span>
                                <span class="text-sm text-gray-900">{{ $pengajuan->created_at->format('d/m/Y') }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                                <span class="text-sm font-medium text-gray-600">Waktu</span>
                                <span class="text-sm text-gray-900">{{ $pengajuan->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="px-6 py-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('admin.pengajuan.edit', $pengajuan) }}" 
                               class="flex items-center justify-center w-full px-4 py-3 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 focus:ring-2 focus:ring-amber-500/20 focus:outline-none transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Pengajuan
                            </a>
                            
                            <a href="{{ route('admin.pengajuan.index') }}" 
                               class="flex items-center justify-center w-full px-4 py-3 bg-white text-gray-700 font-semibold border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 focus:ring-2 focus:ring-gray-500/20 focus:outline-none transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                                </svg>
                                Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Timeline Card (Optional Enhancement) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="px-6 py-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Pengajuan Dibuat</p>
                                    <p class="text-sm text-gray-500">{{ $pengajuan->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            
                            @if($pengajuan->updated_at != $pengajuan->created_at)
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Terakhir Diperbarui</p>
                                    <p class="text-sm text-gray-500">{{ $pengajuan->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection