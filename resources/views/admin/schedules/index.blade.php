@extends('layouts.app')
@section('title', 'Daftar Jadwal')
@section('content')

<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">📅 Daftar Jadwal Pegawai</h1>
                    <p class="text-gray-600">Kelola jadwal shift dan fulltime dengan mudah</p>
                </div>
                <a
                    href="{{ route('admin.schedules.create') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg"
                >
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Jadwal Baru</span>
                </a>
            </div>
        </div>

        <!-- Flash Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 shadow">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check-circle text-white text-lg"></i>
                </div>
                <p class="text-green-800 font-semibold">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Hari Libur Card -->
        <div class="bg-gradient-to-r from-red-50 to-orange-50 border-2 border-red-200 rounded-lg p-6 mb-6 shadow">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0 shadow">
                    <i class="fas fa-calendar-times text-white text-xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-900 mb-3">Hari Libur Mingguan</h2>
                    @if(!empty($holidays))
                        <div class="flex flex-wrap gap-3">
                            @foreach($holidays as $holidayDay)
                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-lg font-semibold shadow">
                                    <i class="fas fa-moon"></i>
                                    {{ $dayNames[$holidayDay] }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-700 font-medium">Tidak ada hari libur yang ditetapkan</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Per Hari -->
        <div class="space-y-4">
            @foreach($weeklySchedules as $day)
                @if(!$day->is_holiday)
                <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-blue-500">
                    
                    <!-- Header Hari -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow">
                                    <i class="fas fa-calendar-day text-blue-600"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-white">{{ $day->day_name }}</h3>
                            </div>
                            <span class="px-4 py-2 bg-white bg-opacity-20 text-black rounded-lg font-semibold">
                                {{ $day->schedules->count() }} Jadwal
                            </span>
                        </div>
                    </div>

                    <!-- Daftar Jadwal -->
                    <div class="p-6">
                        @forelse($day->schedules as $schedule)
                        <div class="mb-4 last:mb-0 bg-gray-50 rounded-lg p-5 border-2 border-gray-200 hover:border-blue-300 transition-all duration-200 hover:shadow-md">
                            
                            <!-- Info Jadwal -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                                
                                <!-- Jam Kerja -->
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fas fa-clock text-blue-600"></i>
                                        <span class="text-xs font-bold text-gray-600 uppercase">Jam Kerja</span>
                                    </div>
                                    <p class="font-bold text-gray-900 text-lg">
                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                        <span class="text-gray-500">-</span>
                                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                    </p>
                                </div>

                                <!-- Tipe -->
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fas fa-tag text-blue-600"></i>
                                        <span class="text-xs font-bold text-gray-600 uppercase">Tipe</span>
                                    </div>
                                    @if($schedule->is_fulltime)
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 font-bold rounded-lg bg-green-500 text-white">
                                            <i class="fas fa-briefcase"></i>
                                            Fulltime
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 font-bold rounded-lg bg-blue-500 text-white">
                                            <i class="fas fa-user-clock"></i>
                                            Shift
                                        </span>
                                    @endif
                                </div>

                                <!-- Shift -->
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fas fa-sync-alt text-blue-600"></i>
                                        <span class="text-xs font-bold text-gray-600 uppercase">Nama Shift</span>
                                    </div>
                                    <span class="inline-block px-3 py-1.5 font-bold rounded-lg bg-gray-200 text-gray-900 border-2 border-gray-300">
                                        {{ $schedule->shift->name ?? '-' }}
                                    </span>
                                </div>

                                <!-- Aksi -->
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fas fa-cog text-blue-600"></i>
                                        <span class="text-xs font-bold text-gray-600 uppercase">Aksi</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <a
                                            href="{{ route('admin.schedules.edit', $schedule->ids[0]) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-600 font-bold transition-all duration-200 shadow text-sm"
                                            title="Edit jadwal"
                                        >
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.schedules.destroy', $schedule->ids[0]) }}"
                                            method="POST"
                                            class="inline"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            @foreach ($schedule->ids as $id)
                                                <input type="hidden" name="ids[]" value="{{ $id }}">
                                            @endforeach

                                            <button
                                                type="submit"
                                                onclick="return confirm('⚠️ Yakin ingin menghapus jadwal ini?')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-bold transition-all duration-200 shadow text-sm"
                                                title="Hapus jadwal"
                                            >
                                                <i class="fas fa-trash-alt"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>

                            <!-- Pegawai -->
                            <div class="border-t-2 border-gray-300 pt-4">
                                <div class="flex items-center gap-2 mb-3">
                                    <i class="fas fa-users text-blue-600"></i>
                                    <span class="text-sm font-bold text-gray-600 uppercase">Daftar Pegawai</span>
                                </div>
                                
                                @if($schedule->is_fulltime)
                                    <div class="flex items-center gap-2 px-4 py-3 bg-green-50 border-2 border-green-200 rounded-lg">
                                        <i class="fas fa-users text-green-600 text-lg"></i>
                                        <span class="font-semibold text-gray-900">Semua Pegawai Non-Shift</span>
                                    </div>
                                @else
                                    @if($schedule->users->isNotEmpty())
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                            @foreach($schedule->users as $user)
                                            <div class="flex items-center gap-3 bg-white px-4 py-3 rounded-lg border-2 border-gray-300 hover:border-blue-400 transition-colors">
                                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <span class="font-semibold text-gray-900">{{ $user->name }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="px-4 py-3 bg-yellow-50 border-2 border-yellow-200 rounded-lg text-gray-700 font-medium">
                                            <i class="fas fa-exclamation-circle text-yellow-600"></i> Belum ada pegawai ditugaskan
                                        </div>
                                    @endif
                                @endif
                            </div>

                        </div>
                        @empty
                        <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar-times text-gray-600 text-2xl"></i>
                                </div>
                                <p class="text-gray-700 font-bold text-lg">Belum Ada Jadwal</p>
                                <p class="text-gray-600">Silakan tambahkan jadwal untuk hari ini</p>
                            </div>
                        </div>
                        @endforelse
                    </div>

                </div>
                @endif
            @endforeach
        </div>

    </div>
</div>

@endsection