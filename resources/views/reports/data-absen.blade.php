@extends('layouts.app') @section('title', 'Laporan Kehadiran Harian')
@section('content')
<div class="main-content">
    <div class="top-bar flex justify-between items-center mb-4">
        <div class="page-title">
            <h1>
                Laporan Kehadiran -
                {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
            </h1>
        </div>
        <div class="top-actions">
            <a
                href="{{ route('attendance.report.download', ['date' => $date]) }}"
                style="
                    padding: 0.5rem 1rem;
                    background-color: #4f46e5;
                    color: #fff;
                    border-radius: 0.5rem;
                    text-decoration: none;
                    font-weight: 600;
                "
            >
                Unduh PDF
            </a>
        </div>
    </div>

    <div
        style="
            overflow-x: auto;
            background: #fff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        "
    >
        <table style="width: 100%; border-collapse: collapse; min-width: 700px">
            <thead
                style="
                    background: #f3f4f6;
                    position: sticky;
                    top: 0;
                    z-index: 5;
                "
            >
                <tr>
                    <th style="padding: 0.75rem; text-align: left">No</th>
                    <th style="padding: 0.75rem; text-align: left">Karyawan</th>
                    <th style="padding: 0.75rem; text-align: left">
                        Departemen
                    </th>
                    <th style="padding: 0.75rem; text-align: left">Check In</th>
                    <th style="padding: 0.75rem; text-align: left">
                        Check Out
                    </th>
                    <th style="padding: 0.75rem; text-align: left">Status</th>
                    <th style="padding: 0.75rem; text-align: left">Lokasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $key => $attendance)
                <tr style="border-bottom: 1px solid #e5e7eb">
                    <td style="padding: 0.75rem">{{ $key + 1 }}</td>
                    <td
                        style="
                            padding: 0.75rem;
                            display: flex;
                            align-items: center;
                            gap: 0.5rem;
                        "
                    >
                        <div
                            style="
                                width: 32px;
                                height: 32px;
                                background: #6366f1;
                                color: #fff;
                                border-radius: 50%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-weight: 600;
                            "
                        >
                            {{ strtoupper(substr($attendance->user->name,0,1)) }}
                        </div>
                        <div>{{ $attendance->user->name }}</div>
                    </td>
                    <td style="padding: 0.75rem">
                        {{ $attendance->user->department->name ?? '-' }}
                    </td>
                    <td style="padding: 0.75rem">
                        <span
                            style="
                                background: #e0f2fe;
                                padding: 0.25rem 0.5rem;
                                border-radius: 0.25rem;
                            "
                            >{{ $attendance->check_in ?? '-' }}</span
                        >
                    </td>
                    <td style="padding: 0.75rem">
                        <span
                            style="
                                background: #e0f2fe;
                                padding: 0.25rem 0.5rem;
                                border-radius: 0.25rem;
                            "
                            >{{ $attendance->check_out ?? '-' }}</span
                        >
                    </td>
                    <td style="padding: 0.75rem">
                        @php $statusClass = [ 'Hadir'=>'background:#dcfce7;
                        color:#166534;', 'Terlambat'=>'background:#fef3c7;
                        color:#b45309;', 'Alpha'=>'background:#fee2e2;
                        color:#991b1b;', 'Remote'=>'background:#f0fdfa;
                        color:#047857;' ]; @endphp
                        <span
                            style="padding:0.25rem 0.5rem; border-radius:9999px; font-weight:600; {{ $statusClass[$attendance->status] ?? 'background:#fee2e2; color:#991b1b;' }}"
                        >
                            {{ $attendance->status }}
                        </span>
                    </td>
                    <td style="padding: 0.75rem">
                        <span
                            style="
                                background: #f3f4f6;
                                padding: 0.25rem 0.5rem;
                                border-radius: 0.25rem;
                            "
                            >{{ $attendance->location ?? '-' }}</span
                        >
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6 flex justify-center">
            {{ $attendances->withQueryString()->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
