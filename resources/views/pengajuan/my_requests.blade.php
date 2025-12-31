{{-- resources/views/pengajuan/my_requests.blade.php --}}
@extends('layouts.app')
@section('title', 'Pengajuan Saya')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8 mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-light text-gray-900">Pengajuan Saya</h1>
                    <p class="mt-2 text-gray-600">Lihat dan kelola semua pengajuan izin, cuti, atau sakit Anda</p>
                </div>
                <a href="{{ route('pengajuan.create') }}"
                   class="inline-flex items-center justify-center gap-3 px-6 py-4 bg-black text-white font-medium rounded-full hover:bg-gray-800 transition shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Pengajuan Baru
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 p-5 rounded-2xl mb-8 flex items-center gap-4 shadow-sm">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 p-5 rounded-2xl mb-8 flex items-center gap-4 shadow-sm">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Jika Belum Ada Pengajuan -->
        @if($pengajuans->count() === 0)
            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-16 text-center">
                <div class="w-24 h-24 mx-auto mb-8 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-2xl font-medium text-gray-800 mb-4">Belum ada pengajuan</p>
                <p class="text-gray-600 mb-8">Anda belum pernah mengajukan izin, cuti, atau sakit</p>
                <a href="{{ route('pengajuan.create') }}"
                   class="inline-flex items-center gap-3 px-8 py-4 bg-black text-white font-medium rounded-full hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajukan Sekarang
                </a>
            </div>
        @else
            <!-- Desktop: Tabel Sederhana -->
            <div class="hidden lg:block bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-black text-white">
                            <tr>
                                <th class="px-8 py-6 text-left">Judul Pengajuan</th>
                                <th class="px-8 py-6 text-left">Status</th>
                                <th class="px-8 py-6 text-left">Diajukan Pada</th>
                                <th class="px-8 py-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($pengajuans as $pengajuan)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-8 py-6">
                                        <p class="font-semibold text-gray-900">{{ $pengajuan->title }}</p>
                                        <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                                            {{ \Illuminate\Support\Str::limit($pengajuan->description ?? '', 100, '...') }}
                                        </p>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="inline-block px-5 py-2 rounded-full text-sm font-medium
                                            {{ $pengajuan->status == 'approved' ? 'bg-green-100 text-green-800' :
                                               ($pengajuan->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($pengajuan->status) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-gray-600">
                                        {{ $pengajuan->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <div class="flex justify-center items-center gap-5">
                                            <a href="{{ route('pengajuan.show', $pengajuan) }}"
                                               class="text-gray-700 hover:text-black transition">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>

                                            <!-- Edit hanya jika pending -->
                                            @if($pengajuan->status === 'pending')
                                                <a href="{{ route('pengajuan.edit', $pengajuan) }}"
                                                   class="text-amber-600 hover:text-amber-800 transition" title="Edit">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                            @endif

                                            <!-- Hapus (selalu muncul karena sudah diatur di controller) -->
                                            <form action="{{ route('pengajuan.destroy', $pengajuan) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus pengajuan ini secara permanen?')"
                                                        class="text-red-500 hover:text-red-700 transition"
                                                        title="Hapus">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile: Card View -->
            <div class="lg:hidden space-y-6">
                @foreach($pengajuans as $pengajuan)
                    <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-medium text-gray-900 flex-1 pr-4">{{ $pengajuan->title }}</h3>
                            <span class="px-4 py-2 rounded-full text-sm font-medium
                                {{ $pengajuan->status == 'approved' ? 'bg-green-100 text-green-800' :
                                   ($pengajuan->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($pengajuan->status) }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 mb-5 line-clamp-3">
                            {{ \Illuminate\Support\Str::limit($pengajuan->description ?? '', 100, '...') }}
                        </p>

                        <p class="text-xs text-gray-500 mb-6">
                            Diajukan: {{ $pengajuan->created_at->format('d M Y, H:i') }}
                        </p>

                        <div class="flex flex-col gap-3">
                            <a href="{{ route('pengajuan.show', $pengajuan) }}"
                               class="text-center py-3 bg-gray-900 text-white font-medium rounded-2xl hover:bg-black transition">
                                Lihat Detail
                            </a>

                            @if($pengajuan->status === 'pending')
                                <a href="{{ route('pengajuan.edit', $pengajuan) }}"
                                   class="text-center py-3 border border-amber-300 text-amber-700 font-medium rounded-2xl hover:bg-amber-50 transition">
                                    Edit Pengajuan
                                </a>
                            @endif

                            <form action="{{ route('pengajuan.destroy', $pengajuan) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus pengajuan ini?')"
                                        class="w-full py-3 border border-red-300 text-red-600 font-medium rounded-2xl hover:bg-red-50 transition">
                                    Hapus Pengajuan
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $pengajuans->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
</div>
@endsection