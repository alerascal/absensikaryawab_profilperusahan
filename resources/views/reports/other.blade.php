@extends('layouts.app')

@section('title', 'Laporan Lembur & Cuti')

@section('content')
<div class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1>Laporan Lembur & Cuti</h1>
        </div>
    </div>

 <!-- Filter Form -->
<div class="filter-panel bg-white shadow-lg rounded-lg p-6 mb-8">
    <form method="GET" action="{{ route('reports.other') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pegawai</label>
            <input type="text" name="name" id="name" value="{{ request('name') }}" placeholder="Cari nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
        </div>

        <div>
            <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Departemen</label>
            <select name="department" id="department" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <option value="">Semua</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="date" id="date" value="{{ request('date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <option value="">Semua</option>
                <option value="Lembur" {{ request('status') == 'Lembur' ? 'selected' : '' }}>Lembur</option>
                <option value="Cuti" {{ request('status') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
            </select>
        </div>

        <div class="sm:col-span-2 lg:col-span-4 flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">Filter</button>
        </div>
    </form>
</div>
    <!-- Tabel Laporan -->
    <div class="attendance-panel">
        <div class="table-container">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Nama Pegawai</th>
                        <th>Departemen</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->user->name }}</td>
                            <td>{{ $attendance->user->department->name ?? '-' }}</td>
                            <td>{{ $attendance->date }}</td>
                            <td>
                                @php
                                    $statusClass = match($attendance->status) {
                                        'Lembur' => 'status-present',
                                        'Cuti' => 'status-late',
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">{{ $attendance->status }}</span>
                            </td>
                            <td>{{ $attendance->description ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data lembur/cuti</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

   <!-- Form Pengajuan Lembur & Cuti -->
<div class="submission-panel mt-8 bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Ajukan Lembur / Cuti</h2>
    <form method="POST" action="{{ route('reports.submit') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @csrf
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
            <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                <option value="Lembur">Lembur</option>
                <option value="Cuti">Cuti</option>
            </select>
        </div>

        <div>
            <label for="date_request" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="date" id="date_request" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
        </div>

        <div class="sm:col-span-2 lg:col-span-1">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
            <input type="text" name="description" id="description" placeholder="Alasan lembur / cuti" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
        </div>

        <div class="sm:col-span-2 lg:col-span-3 flex justify-end">
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">Ajukan</button>
        </div>
    </form>
</div>

<style>
    @media (max-width: 640px) {
        .submission-panel form {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 640px) {
        .filter-panel form {
            grid-template-columns: 1fr;
        }
    }

</style>
</div>
@endsection
