@extends('layouts.app')

@section('title', 'Kelola Lokasi Absensi')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-lg p-6 sm:p-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">📍 Kelola Lokasi Absensi</h1>
            <a href="{{ route('admin.locations.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                + Tambah Lokasi
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Table (Desktop) -->
        <div class="hidden md:block overflow-x-auto border border-gray-200 rounded-lg">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-100 text-gray-600 sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold uppercase">Nama</th>
                        <th class="px-4 py-3 text-sm font-semibold uppercase">Latitude</th>
                        <th class="px-4 py-3 text-sm font-semibold uppercase">Longitude</th>
                        <th class="px-4 py-3 text-sm font-semibold uppercase">Radius (m)</th>
                        <th class="px-4 py-3 text-sm font-semibold uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($locations as $loc)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="border-t px-4 py-3 font-medium">{{ $loc->name }}</td>
                            <td class="border-t px-4 py-3">{{ $loc->latitude }}</td>
                            <td class="border-t px-4 py-3">{{ $loc->longitude }}</td>
                            <td class="border-t px-4 py-3">
                                <span class="inline-block bg-indigo-100 text-indigo-800 rounded-full px-3 py-1 text-sm">
                                    {{ $loc->radius }} m
                                </span>
                            </td>
                            <td class="border-t px-4 py-3 flex gap-2">
                                <a href="{{ route('admin.locations.edit', $loc->id) }}"
                                   class="px-3 py-1 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition duration-200 text-sm">Edit</a>
                                <form action="{{ route('admin.locations.destroy', $loc->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus lokasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200 text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border-t px-4 py-3 text-center text-gray-500">Belum ada lokasi absensi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card (Mobile) -->
        <div class="md:hidden space-y-4">
            @forelse($locations as $loc)
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm animate-fade-in">
                    <div class="grid grid-cols-2 gap-2 text-sm text-gray-700">
                        <div class="font-semibold">Nama:</div>
                        <div>{{ $loc->name }}</div>
                        <div class="font-semibold">Latitude:</div>
                        <div>{{ $loc->latitude }}</div>
                        <div class="font-semibold">Longitude:</div>
                        <div>{{ $loc->longitude }}</div>
                        <div class="font-semibold">Radius:</div>
                        <div>
                            <span class="inline-block bg-indigo-100 text-indigo-800 rounded-full px-2 py-1 text-xs">{{ $loc->radius }} m</span>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('admin.locations.edit', $loc->id) }}"
                           class="flex-1 text-center px-3 py-2 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition duration-200 text-sm">Edit</a>
                        <form action="{{ route('admin.locations.destroy', $loc->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus lokasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200 text-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 p-4">Belum ada lokasi absensi</div>
            @endforelse
        </div>

    </div>
</div>
@endsection
