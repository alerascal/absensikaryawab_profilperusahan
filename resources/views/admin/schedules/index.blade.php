@extends('layouts.app')

@section('title', 'Daftar Jadwal')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-lg p-6 sm:p-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Daftar Jadwal</h1>
            <a href="{{ route('admin.schedules.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200 ease-in-out font-medium">
                Tambah Jadwal
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
                        <th class="px-4 py-3 text-sm font-semibold uppercase">Tipe</th>
                        <th class="px-4 py-3 text-sm font-semibold uppercase">Shift</th>
                        <th class="px-4 py-3 text-sm font-semibold uppercase">Karyawan</th>
                        <th class="px-4 py-3 text-sm font-semibold uppercase">Waktu Mulai</th>
                        <th class="px-4 py-3 text-sm font-semibold uppercase">Waktu Selesai</th>
                        <th class="px-4 py-3 text-sm font-semibold uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($schedules as $schedule)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="border-t px-4 py-3">
                                {{ $schedule->is_fulltime ? 'Penuh Waktu (Semua Karyawan)' : 'Berdasarkan Shift' }}
                            </td>
                            <td class="border-t px-4 py-3">
                                {{ $schedule->shift ? $schedule->shift->name : '-' }}
                            </td>
                            <td class="border-t px-4 py-3">
                                @if($schedule->is_fulltime)
                                    <span class="text-gray-500">Semua Karyawan</span>
                                @elseif($schedule->users->count() > 0)
                                    @foreach($schedule->users as $user)
                                        <span class="inline-block bg-indigo-100 text-indigo-800 rounded-full px-3 py-1 text-sm mr-2 mb-2">{{ $user->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-gray-500">Belum ada karyawan</span>
                                @endif
                            </td>
                            <td class="border-t px-4 py-3">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                            <td class="border-t px-4 py-3">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                            <td class="border-t px-4 py-3 flex gap-2">
                                <a href="{{ route('admin.schedules.edit', $schedule->id) }}"
                                   class="px-3 py-1 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition duration-200 text-sm">Edit</a>
                                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200 text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border-t px-4 py-3 text-center text-gray-500">Tidak ada jadwal tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card (Mobile) -->
        <div class="md:hidden space-y-4 mt-4">
            @forelse($schedules as $schedule)
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <div class="grid grid-cols-2 gap-2 text-sm text-gray-700">
                        <div class="font-semibold">Tipe:</div>
                        <div>{{ $schedule->is_fulltime ? 'Penuh Waktu (Semua Karyawan)' : 'Berdasarkan Shift' }}</div>
                        <div class="font-semibold">Shift:</div>
                        <div>{{ $schedule->shift ? $schedule->shift->name : '-' }}</div>
                        <div class="font-semibold">Karyawan:</div>
                        <div>
                            @if($schedule->is_fulltime)
                                <span class="text-gray-500">Semua Karyawan</span>
                            @elseif($schedule->users->count() > 0)
                                @foreach($schedule->users as $user)
                                    <span class="inline-block bg-indigo-100 text-indigo-800 rounded-full px-2 py-1 text-xs mr-1 mb-1">{{ $user->name }}</span>
                                @endforeach
                            @else
                                <span class="text-gray-500">Belum ada karyawan</span>
                            @endif
                        </div>
                        <div class="font-semibold">Waktu Mulai:</div>
                        <div>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</div>
                        <div class="font-semibold">Waktu Selesai:</div>
                        <div>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('admin.schedules.edit', $schedule->id) }}"
                           class="flex-1 text-center px-3 py-2 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition duration-200 text-sm">Edit</a>
                        <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200 text-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 p-4">Tidak ada jadwal tersedia.</div>
            @endforelse
        </div>

    </div>
</div>
@endsection
