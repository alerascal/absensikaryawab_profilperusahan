{{-- resources/views/admin/pengajuan/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Kelola Pengajuan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Sticky -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-black rounded-2xl flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8m-9-9V8a2 2 0 012-2h2m5 4v8a2 2 0 01-2 2H6m3-6h6m3-8h.01M12 14h.01"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-light text-gray-900">Kelola Pengajuan</h1>
                        <p class="text-sm text-gray-600 hidden sm:block">Review dan proses semua pengajuan karyawan</p>
                    </div>
                </div>

                <a href="{{ route('pengajuan.create') }}"
                   class="inline-flex items-center gap-3 px-6 py-3.5 bg-black text-white font-medium rounded-full hover:bg-gray-800 transition shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span class="hidden sm:inline">Tambah Pengajuan</span>
                    <span class="sm:hidden">+</span>
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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

        <!-- Statistik Ringkas -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-3xl font-bold text-gray-900">{{ $pengajuans->total() }}</p>
                <p class="text-sm text-gray-600 mt-2">Total Pengajuan</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-3xl font-bold text-amber-600">{{ $pengajuans->where('status', 'pending')->count() }}</p>
                <p class="text-sm text-gray-600 mt-2">Menunggu</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-3xl font-bold text-green-600">{{ $pengajuans->where('status', 'approved')->count() }}</p>
                <p class="text-sm text-gray-600 mt-2">Disetujui</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-3xl font-bold text-red-600">{{ $pengajuans->where('status', 'rejected')->count() }}</p>
                <p class="text-sm text-gray-600 mt-2">Ditolak</p>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari judul atau nama pengaju..."
                           class="w-full pl-12 pr-5 py-4 border border-gray-200 rounded-2xl focus:border-black focus:outline-none transition">
                </div>

                <select name="status" onchange="this.form.submit()"
                        class="px-5 py-4 border border-gray-200 rounded-2xl focus:border-black focus:outline-none transition">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>

                <div class="flex gap-3">
                    <button type="submit"
                            class="flex-1 bg-black text-white py-4 rounded-2xl font-medium hover:bg-gray-800 transition">
                        Filter
                    </button>
                    <a href="{{ route('admin.pengajuan.index') }}"
                       class="flex-1 text-center py-4 border border-gray-300 text-gray-700 rounded-2xl hover:bg-gray-50 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Desktop Table -->
        <div class="hidden lg:block bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-fixed divide-y divide-gray-100">
                    <thead class="bg-gray-900 text-white">
                        <tr>
                            <th class="w-2/5 px-8 py-5 text-left text-sm font-medium">Pengajuan</th>
                            <th class="w-1/5 px-8 py-5 text-left text-sm font-medium">Pengaju</th>
                            <th class="w-1/6 px-8 py-5 text-left text-sm font-medium">Status</th>
                            <th class="w-1/6 px-8 py-5 text-left text-sm font-medium">Dokumen</th>
                            <th class="w-1/6 px-8 py-5 text-center text-sm font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pengajuans as $pengajuan)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-8 py-7">
                                    <div>
                                        <p class="font-semibold text-gray-900 text-lg truncate">{{ $pengajuan->title }}</p>
                                        <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                                            {{ \Illuminate\Support\Str::limit($pengajuan->description ?? '', 120, '...') }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-3">{{ $pengajuan->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-7">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-black rounded-2xl flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                            {{ strtoupper(substr($pengajuan->user->name ?? '?', 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium text-gray-900 truncate">{{ $pengajuan->user->name }}</p>
                                            <p class="text-sm text-gray-500 truncate">{{ $pengajuan->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-7">
                                    <span class="inline-block px-5 py-2 rounded-full text-sm font-medium
                                        {{ $pengajuan->status == 'approved' ? 'bg-green-100 text-green-800' :
                                           ($pengajuan->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($pengajuan->status) }}
                                    </span>
                                </td>
                                <td class="px-8 py-7 text-sm">
                                    <div class="space-y-2">
                                        @if($pengajuan->surat_dokter)
                                            <a href="{{ asset('storage/' . $pengajuan->surat_dokter) }}" target="_blank"
                                               class="block text-blue-600 hover:underline">→ Surat Dokter</a>
                                        @endif
                                        @if($pengajuan->surat_izin)
                                            <a href="{{ asset('storage/' . $pengajuan->surat_izin) }}" target="_blank"
                                               class="block text-green-600 hover:underline">→ Surat Izin</a>
                                        @endif
                                        @if(!$pengajuan->surat_dokter && !$pengajuan->surat_izin)
                                            <span class="text-gray-400">Tidak ada</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-7">
                                    <div class="flex justify-center items-center gap-6 text-lg">
                                        <!-- Lihat Detail -->
                                        <a href="{{ route('pengajuan.show', $pengajuan) }}"
                                           class="text-gray-700 hover:text-black transition" title="Lihat Detail">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        <!-- Approve & Reject hanya jika BUKAN milik sendiri -->
                                        @if($pengajuan->user_id !== auth()->id())
                                            <form action="{{ route('admin.pengajuan.approve', $pengajuan->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-800 transition" title="Setujui">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.pengajuan.reject', $pengajuan->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Tolak">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Tombol Hapus HANYA jika milik sendiri -->
                                        @if($pengajuan->user_id === auth()->id())
                                            <form action="{{ route('pengajuan.destroy', $pengajuan) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus pengajuan ini secara permanen?')"
                                                        class="text-red-500 hover:text-red-700 transition"
                                                        title="Hapus Pengajuan">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-20 text-gray-500">
                                    <p class="text-xl font-medium">Belum ada pengajuan untuk diproses</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="lg:hidden space-y-5">
            @forelse($pengajuans as $pengajuan)
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1 pr-3">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $pengajuan->title }}</h3>
                            <p class="text-sm text-gray-600 line-clamp-3">
                                {{ \Illuminate\Support\Str::limit($pengajuan->description ?? '', 100, '...') }}
                            </p>
                        </div>
                        <span class="px-4 py-2 rounded-full text-xs font-medium
                            {{ $pengajuan->status == 'approved' ? 'bg-green-100 text-green-800' :
                               ($pengajuan->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($pengajuan->status) }}
                        </span>
                    </div>

                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-11 h-11 bg-black rounded-2xl flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($pengajuan->user->name ?? '?', 0, 2)) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $pengajuan->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $pengajuan->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <div class="grid grid-cols-1 gap-3">
                            <a href="{{ route('pengajuan.show', $pengajuan) }}"
                               class="text-center py-3 bg-gray-900 text-white font-medium rounded-2xl hover:bg-black transition">
                                Lihat Detail
                            </a>

                            @if($pengajuan->user_id !== auth()->id())
                                <div class="grid grid-cols-2 gap-3">
                                    <form action="{{ route('admin.pengajuan.approve', $pengajuan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full py-3 bg-green-600 text-white font-medium rounded-2xl hover:bg-green-700 transition">
                                            Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.pengajuan.reject', $pengajuan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full py-3 bg-red-600 text-white font-medium rounded-2xl hover:bg-red-700 transition">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if($pengajuan->user_id === auth()->id())
                                <form action="{{ route('pengajuan.destroy', $pengajuan) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus pengajuan ini secara permanen?')"
                                            class="w-full py-3 border border-red-300 text-red-600 font-medium rounded-2xl hover:bg-red-50 transition">
                                        Hapus Pengajuan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-12 text-center">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-xl text-gray-700 font-medium mb-2">Belum ada pengajuan</p>
                    <p class="text-gray-500 mb-8">Mulai kelola pengajuan sekarang</p>
                    <a href="{{ route('pengajuan.create') }}" class="inline-flex items-center gap-3 px-6 py-3.5 bg-black text-white font-medium rounded-full hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Pengajuan
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($pengajuans->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $pengajuans->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
</div>
@endsection