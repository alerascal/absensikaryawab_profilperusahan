@extends('layouts.app')

@section('title', 'Rekap Kehadiran Bulanan')

@section('content')
<div class="main-content">
    <div class="top-bar flex justify-between items-center mb-4">
        <div class="page-title">
            @php
                $displayMonth = \Carbon\Carbon::createFromDate($year, $month)->translatedFormat('F Y');
            @endphp
            <h1>Rekap Kehadiran Bulanan - {{ $displayMonth }}</h1>
        </div>

        <div class="top-actions flex items-center gap-2">
            <!-- Form Filter Bulan & Tahun -->
            <form action="{{ route('reports.monthly') }}" method="GET" class="flex items-center gap-2">
                <select name="month" class="form-select border rounded p-1">
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>

                <select name="year" class="form-select border rounded p-1">
                    @for($y = date('Y') - 5; $y <= date('Y'); $y++)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>

                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">Filter</button>
            </form>

            <!-- Tombol Download PDF -->
            <a href="{{ route('reports.monthly.pdf', ['month' => $month, 'year' => $year]) }}" 
               class="bg-green-600 text-white px-3 py-1 rounded">
                Download PDF
            </a>
        </div>
    </div>

    <!-- Tabel Kehadiran -->
    <div class="attendance-panel table-responsive">
        <table class="attendance-table border-collapse border w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Karyawan</th>
                    <th class="p-2 border">Departemen</th>
                    <th class="p-2 border">Hadir</th>
                    <th class="p-2 border">Terlambat</th>
                    <th class="p-2 border">Alpha</th>
                    <th class="p-2 border">Remote</th>
                </tr>
            </thead>
            <tbody>
                @forelse($monthlyAttendances as $key => $user)
                    <tr>
                        <td class="p-2 border">{{ $key + 1 }}</td>
                        <td class="p-2 border">{{ $user->name }}</td>
                        <td class="p-2 border">{{ $user->department->name ?? '-' }}</td>
                        <td class="p-2 border">{{ $user->present_count }}</td>
                        <td class="p-2 border">{{ $user->late_count }}</td>
                        <td class="p-2 border">{{ $user->absent_count }}</td>
                        <td class="p-2 border">{{ $user->remote_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-2 border text-center">Data tidak tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.attendance-table th, .attendance-table td {
    text-align: center;
    font-size: 14px;
    border: 1px solid #ccc;
}
.attendance-table th {
    background-color: #f0f0f0;
}
</style>
@endsection
