@extends('layouts.app')

@section('title', 'Daftar Jadwal')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-10 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-xl p-6 sm:p-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">📅 Daftar Jadwal</h1>
                <p class="text-gray-500 mt-1 text-sm">Kelola jadwal shift dan fulltime pegawai dengan mudah</p>
            </div>
            <a href="{{ route('admin.schedules.create') }}"
               class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition-all duration-200 text-sm font-medium">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
        </div>

        <!-- Flash Message -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Hari Libur -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-calendar-day text-indigo-500"></i> Hari Libur Mingguan
            </h2>
            <p class="text-sm text-gray-600 mt-2 pl-1">
                {{ !empty($holidayNames) ? implode(', ', $holidayNames) : 'Tidak ada hari libur' }}
            </p>
        </div>

        <!-- Tabel Jadwal -->
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold">Jam</th>
                        <th class="px-6 py-3 text-left font-semibold">Tipe</th>
                        <th class="px-6 py-3 text-left font-semibold">Shift</th>
                        <th class="px-6 py-3 text-left font-semibold">Pegawai</th>
                        <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($groupedSchedules as $schedule)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- Jam -->
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                </span>
                            </td>

                            <!-- Tipe -->
                            <td class="px-6 py-4">
                                @if($schedule->is_fulltime)
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Fulltime</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Shift</span>
                                @endif
                            </td>

                            <!-- Shift -->
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
                                    {{ $schedule->shift->name ?? '-' }}
                                </span>
                            </td>

                            <!-- Pegawai -->
                            <td class="px-6 py-4">
                                @if($schedule->is_fulltime)
                                    <span class="italic text-gray-600">Semua pegawai (non-shift)</span>
                                @else
                                    @if($schedule->users->isNotEmpty())
                                        <ul class="space-y-1">
                                            @foreach($schedule->users as $user)
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-user text-gray-400"></i>
                                                    <span>{{ $user->name }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.schedules.edit', $schedule->ids[0]) }}"
                                       class="px-3 py-1.5 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 text-xs font-medium transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.schedules.destroy', $schedule->ids[0]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="ids[]" value="{{ implode(',', $schedule->ids) }}">
                                        <button type="submit"
                                                onclick="return confirm('Hapus jadwal ini?')"
                                                class="px-3 py-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 text-xs font-medium transition">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500 text-sm">
                                <i class="fas fa-calendar-times text-gray-400 text-lg"></i><br>
                                Belum ada jadwal
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
