@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp

<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8m-9-9V8a2 2 0 012-2h2m5 4v8a2 2 0 01-2 2H6m3-6h6m3-8h.01M12 14h.01"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Daftar Pengajuan</h1>
                        <p class="text-sm text-gray-600 hidden sm:block">Kelola semua pengajuan dengan mudah</p>
                    </div>
                </div>
                <a href="{{ route('admin.pengajuan.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-200 transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span class="hidden sm:inline">Tambah</span>
                    <span class="sm:hidden">Baru</span>
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-8">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
            <div class="px-6 py-6">
                <form action="{{ url()->current() }}" method="GET" class="flex flex-col lg:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                placeholder="Cari judul atau nama pengaju..." 
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-500 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-200"
                            >
                        </div>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="w-full lg:w-48">
                        <select 
                            name="status" 
                            onchange="this.form.submit()"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-200"
                        >
                            <option value="">Semua Status</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                        </select>
                    </div>
                    
                    <!-- Search Button -->
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>
                </form>
            </div>
        </div>
     
        <!-- Desktop Table View -->
        <div class="hidden lg:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengajuan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengaju</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dokumen</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($pengajuans as $pengajuan)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-5">
                                <div class="max-w-sm">
                                    <h3 class="text-sm font-semibold text-gray-900 mb-1">{{ $pengajuan->title }}</h3>
                                    <p class="text-xs text-gray-500 line-clamp-2">{{ Str::limit($pengajuan->description, 80) }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $pengajuan->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $pengajuan->status == 'approved' ? 'bg-green-100 text-green-800 border border-green-200' : '' }}
                                    {{ $pengajuan->status == 'rejected' ? 'bg-red-100 text-red-800 border border-red-200' : '' }}
                                    {{ $pengajuan->status == 'pending' ? 'bg-amber-100 text-amber-800 border border-amber-200' : '' }}">
                                    <div class="w-1.5 h-1.5 rounded-full mr-1.5
                                        {{ $pengajuan->status == 'approved' ? 'bg-green-600' : '' }}
                                        {{ $pengajuan->status == 'rejected' ? 'bg-red-600' : '' }}
                                        {{ $pengajuan->status == 'pending' ? 'bg-amber-600' : '' }}">
                                    </div>
                                    {{ ucfirst($pengajuan->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-xs font-medium text-gray-600">{{ substr($pengajuan->user->name ?? 'N', 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $pengajuan->user->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex space-x-2">
                                    @if ($pengajuan->surat_dokter)
                                        <a href="{{ Storage::url($pengajuan->surat_dokter) }}" target="_blank" 
                                           class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded border border-blue-200 hover:bg-blue-100 transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Dokter
                                        </a>
                                    @endif
                                    @if ($pengajuan->surat_izin)
                                        <a href="{{ Storage::url($pengajuan->surat_izin) }}" target="_blank" 
                                           class="inline-flex items-center px-2 py-1 bg-green-50 text-green-700 text-xs font-medium rounded border border-green-200 hover:bg-green-100 transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                            </svg>
                                            Izin
                                        </a>
                                    @endif
                                    @if (!$pengajuan->surat_dokter && !$pengajuan->surat_izin)
                                        <span class="text-xs text-gray-400">Tidak ada</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.pengajuan.show', $pengajuan) }}" 
                                       class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200" 
                                       title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.pengajuan.edit', $pengajuan) }}" 
                                       class="p-2 text-amber-600 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition-all duration-200" 
                                       title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.pengajuan.destroy', $pengajuan) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200" 
                                                title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8m-9-9V8a2 2 0 012-2h2m5 4v8a2 2 0 01-2 2H6m3-6h6m3-8h.01M12 14h.01"/>
                                    </svg>
                                    <p class="text-gray-500 font-medium">Belum ada pengajuan</p>
                                    <p class="text-gray-400 text-sm">Pengajuan yang dibuat akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="grid grid-cols-1 gap-4 lg:hidden">
            @forelse ($pengajuans as $pengajuan)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1 truncate">{{ $pengajuan->title }}</h3>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($pengajuan->description, 100) }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium ml-3
                                {{ $pengajuan->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $pengajuan->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $pengajuan->status == 'pending' ? 'bg-amber-100 text-amber-800' : '' }}">
                                {{ ucfirst($pengajuan->status) }}
                            </span>
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                            <div>
                                <p class="font-medium text-gray-600 mb-1">Pengaju</p>
                                <div class="flex items-center">
                                    <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center mr-2">
                                        <span class="text-xs font-medium text-gray-600">{{ substr($pengajuan->user->name ?? 'N', 0, 1) }}</span>
                                    </div>
                                    <span class="text-gray-900">{{ $pengajuan->user->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div>
                                <p class="font-medium text-gray-600 mb-1">Tanggal</p>
                                <p class="text-gray-900">{{ $pengajuan->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="mb-4">
                            <p class="font-medium text-gray-600 mb-2 text-sm">Dokumen</p>
                            <div class="flex flex-wrap gap-2">
                                @if ($pengajuan->surat_dokter)
                                    <a href="{{ Storage::url($pengajuan->surat_dokter) }}" target="_blank" 
                                       class="inline-flex items-center px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-md border border-blue-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Surat Dokter
                                    </a>
                                @endif
                                @if ($pengajuan->surat_izin)
                                    <a href="{{ Storage::url($pengajuan->surat_izin) }}" target="_blank" 
                                       class="inline-flex items-center px-2.5 py-1 bg-green-50 text-green-700 text-xs font-medium rounded-md border border-green-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                        Surat Izin
                                    </a>
                                @endif
                                @if (!$pengajuan->surat_dokter && !$pengajuan->surat_izin)
                                    <span class="text-xs text-gray-400">Tidak ada dokumen</span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end space-x-2 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.pengajuan.show', $pengajuan) }}" 
                               class="p-2.5 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.pengajuan.edit', $pengajuan) }}" 
                               class="p-2.5 text-amber-600 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.pengajuan.destroy', $pengajuan) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2.5 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12">
                    <div class="text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8m-9-9V8a2 2 0 012-2h2m5 4v8a2 2 0 01-2 2H6m3-6h6m3-8h.01M12 14h.01"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pengajuan</h3>
                        <p class="text-gray-500 mb-6">Pengajuan yang dibuat akan muncul di sini</p>
                        <a href="{{ route('admin.pengajuan.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Buat Pengajuan Pertama
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($pengajuans->hasPages())
        <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4">
                {{ $pengajuans->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// Enhanced search functionality
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on status change
    const statusSelect = document.querySelector('select[name="status"]');
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }

    // Search input enhancements
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
                return;
            }
            
            // Auto-search after 1 second of no typing
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 3 || this.value.length === 0) {
                    this.form.submit();
                }
            }, 1000);
        });
    }

    // Confirmation dialogs with better UX
    const deleteButtons = document.querySelectorAll('form[method="POST"] button[type="submit"]');
    deleteButtons.forEach(button => {
        button.closest('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const title = form.closest('tr')?.querySelector('h3')?.textContent || 
                         form.closest('.bg-white')?.querySelector('h3')?.textContent || 
                         'pengajuan ini';
            
            if (confirm(`Yakin ingin menghapus "${title}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
                form.submit();
            }
        });
    });
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth hover animations */
.hover\:scale-105:hover {
    transform: scale(1.05);
}

/* Custom scrollbar for better UX */
.overflow-x-auto::-webkit-scrollbar {
    height: 4px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 2px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endsection