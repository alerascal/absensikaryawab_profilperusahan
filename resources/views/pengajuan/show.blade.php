@extends('layouts.app') @section('title', 'Detail Pengajuan')
@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-6">
        <div
            class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden"
        >
            <!-- Header Status -->
            <div
                class="px-10 py-14 text-center
                {{ $pengajuan->status == 'approved' ? 'bg-green-600' :
                   ($pengajuan->status == 'rejected' ? 'bg-red-600' : 'bg-gray-800') }} text-white"
            >
                <p class="text-sm uppercase tracking-wider mb-3 opacity-80">
                    Status Pengajuan
                </p>
                <h1 class="text-4xl font-light mb-6">
                    {{ $pengajuan->title }}
                </h1>
                <div class="text-2xl font-medium">
                    {{ $pengajuan->status == 'approved' ? 'Disetujui' :
                       ($pengajuan->status == 'rejected' ? 'Ditolak' : 'Menunggu Persetujuan') }}
                </div>
                <p class="mt-6 text-lg opacity-90">
                    Diajukan pada
                    {{ $pengajuan->created_at->format('d F Y \p\u\k\u\l H:i') }}
                </p>
            </div>

            <div class="p-10 md:p-12">
                <!-- Pengaju -->
                <div class="flex items-center gap-6 mb-10">
                    <div
                        class="w-16 h-16 bg-black rounded-2xl flex items-center justify-center text-white text-2xl font-bold"
                    >
                        {{ strtoupper(substr($pengajuan->user->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Pengaju</p>
                        <p class="text-xl font-medium text-gray-900">
                            {{ $pengajuan->user->name }}
                        </p>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-12">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">
                        Deskripsi
                    </h3>
                    <div
                        class="bg-gray-50 rounded-2xl p-8 text-gray-700 leading-relaxed"
                    >
                        {{ $pengajuan->description ?: 'Tidak ada deskripsi tambahan.' }}
                    </div>
                </div>

                <!-- Dokumen -->
                <div>
                    <h3 class="text-lg font-medium text-gray-800 mb-6">
                        Dokumen Pendukung
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($pengajuan->surat_dokter)
                        <a
                            href="{{ asset('storage/' . $pengajuan->surat_dokter) }}"
                            target="_blank"
                            class="block p-10 bg-gray-50 border border-gray-200 rounded-3xl hover:bg-gray-100 transition text-center"
                        >
                            <div
                                class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-2xl flex items-center justify-center"
                            >
                                <svg
                                    class="w-8 h-8 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                            </div>
                            <p class="font-medium text-gray-900">
                                Surat Dokter
                            </p>
                            <p class="text-sm text-gray-600 mt-2">
                                Klik untuk membuka
                            </p>
                        </a>
                        @endif @if($pengajuan->surat_izin)
                        <a
                            href="{{ asset('storage/' . $pengajuan->surat_izin) }}"
                            target="_blank"
                            class="block p-10 bg-gray-50 border border-gray-200 rounded-3xl hover:bg-gray-100 transition text-center"
                        >
                            <div
                                class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-2xl flex items-center justify-center"
                            >
                                <svg
                                    class="w-8 h-8 text-green-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                            <p class="font-medium text-gray-900">Surat Izin</p>
                            <p class="text-sm text-gray-600 mt-2">
                                Klik untuk membuka
                            </p>
                        </a>
                        @endif @if(!$pengajuan->surat_dokter &&
                        !$pengajuan->surat_izin)
                        <p class="col-span-2 text-center text-gray-500 py-12">
                            Tidak ada dokumen yang diunggah.
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Aksi -->
                <div class="mt-12 pt-8 border-t border-gray-100 flex gap-4">
                    @if(auth()->id() === $pengajuan->user_id &&
                    $pengajuan->status === 'pending')
                    <a
                        href="{{ route('pengajuan.edit', $pengajuan) }}"
                        class="px-8 py-4 bg-black text-white font-medium rounded-2xl hover:bg-gray-800 transition"
                    >
                        Edit Pengajuan
                    </a>
                    @endif
                    <a
                        href="{{ auth()->user()->role === 'admin' ? route('admin.pengajuan.index') : route('pengajuan.my') }}"
                        class="flex-1 text-center py-4 border border-gray-300 text-gray-700 font-medium rounded-2xl hover:bg-gray-50 transition"
                    >
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
