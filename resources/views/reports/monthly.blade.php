@extends('layouts.app')

@section('title', 'Rekap Kehadiran Bulanan')

@section('content')
<style>
    .calendar-wrapper {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        margin-top: 1rem;
    }

    .calendar-day-header {
        text-align: center;
        font-weight: 600;
        padding: 1rem 0.5rem;
        color: #6b7280;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .calendar-day {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem;
        min-height: 100px;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .calendar-day:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        border-color: #667eea;
    }

    .calendar-day.other-month {
        background: #f9fafb;
        opacity: 0.5;
    }

    .calendar-day.today {
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .day-number {
        font-weight: 700;
        font-size: 1.125rem;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .calendar-day.today .day-number {
        color: #667eea;
    }

    .attendance-dots {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-top: 0.5rem;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .dot-hadir { background: #10b981; }
    .dot-terlambat { background: #f59e0b; }
    .dot-absen { background: #ef4444; }
    .dot-remote { background: #3b82f6; }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem;
        background: white;
        border-radius: 8px;
    }

    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    @media (max-width: 768px) {
        .calendar-day {
            min-height: 80px;
            padding: 0.5rem;
        }

        .day-number {
            font-size: 0.875rem;
        }

        .attendance-dots {
            gap: 2px;
        }

        .dot {
            width: 6px;
            height: 6px;
        }
    }
</style>

<div class="calendar-wrapper px-3 px-md-4 py-4">
    <!-- Header -->
    <div class="mb-4">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body header-gradient p-4 text-white">
                <h1 class="mb-2 fw-bold">Rekap Kehadiran Bulanan</h1>
                @php
                    $displayMonth = \Carbon\Carbon::createFromDate($year, $month)->translatedFormat('F Y');
                @endphp
                <p class="mb-0 opacity-75">{{ $displayMonth }}</p>
            </div>
        </div>
    </div>

    <!-- Filter & Controls -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('reports.monthly') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-semibold text-secondary small">Bulan</label>
                        <select name="month" class="form-select">
                            @for($m=1; $m<=12; $m++)
                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-12 col-md-2">
                        <label class="form-label fw-semibold text-secondary small">Tahun</label>
                        <select name="year" class="form-select">
                            @for($y = date('Y') - 5; $y <= date('Y'); $y++)
                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-12 col-md-7">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-filter me-2"></i>Filter Data
                            </button>
                            <a href="{{ route('reports.monthly.pdf', ['month' => $month, 'year' => $year]) }}" 
                               class="btn btn-success">
                                <i class="fas fa-download me-2"></i>PDF
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    @if(!empty($monthlyAttendances))
        <div class="row g-3 mb-4">
            @php
                $totalEmployees = count($monthlyAttendances);
                $totalPresent = collect($monthlyAttendances)->sum('present_count');
                $totalLate = collect($monthlyAttendances)->sum('late_count');
                $totalAbsent = collect($monthlyAttendances)->sum('absent_count');
            @endphp
            
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center mb-2">
                        <div class="p-2 bg-primary bg-opacity-10 rounded me-2">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                        <span class="small text-muted">Karyawan</span>
                    </div>
                    <div class="h4 fw-bold mb-0 text-primary">{{ $totalEmployees }}</div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center mb-2">
                        <div class="p-2 bg-success bg-opacity-10 rounded me-2">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <span class="small text-muted">Hadir</span>
                    </div>
                    <div class="h4 fw-bold mb-0 text-success">{{ $totalPresent }}</div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center mb-2">
                        <div class="p-2 bg-warning bg-opacity-10 rounded me-2">
                            <i class="fas fa-clock text-warning"></i>
                        </div>
                        <span class="small text-muted">Terlambat</span>
                    </div>
                    <div class="h4 fw-bold mb-0 text-warning">{{ $totalLate }}</div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center mb-2">
                        <div class="p-2 bg-danger bg-opacity-10 rounded me-2">
                            <i class="fas fa-times-circle text-danger"></i>
                        </div>
                        <span class="small text-muted">Alpha</span>
                    </div>
                    <div class="h4 fw-bold mb-0 text-danger">{{ $totalAbsent }}</div>
                </div>
            </div>
        </div>

        <!-- Legend -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-6 col-md-3">
                        <div class="legend-item">
                            <span class="legend-dot dot-hadir"></span>
                            <span class="small fw-semibold">Hadir</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="legend-item">
                            <span class="legend-dot dot-terlambat"></span>
                            <span class="small fw-semibold">Terlambat</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="legend-item">
                            <span class="legend-dot dot-absen"></span>
                            <span class="small fw-semibold">Alpha</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="legend-item">
                            <span class="legend-dot dot-remote"></span>
                            <span class="small fw-semibold">Remote</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar View -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3 p-md-4">
                <div class="calendar-grid">
                    <!-- Day Headers -->
                    @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                        <div class="calendar-day-header">{{ $day }}</div>
                    @endforeach

                    <!-- Calendar Days -->
                    @php
                        $date = \Carbon\Carbon::createFromDate($year, $month, 1);
                        $daysInMonth = $date->daysInMonth;
                        $firstDayOfWeek = $date->dayOfWeek;
                        
                        // Adjust for Monday start (0=Monday, 6=Sunday)
                        $startOffset = ($firstDayOfWeek == 0) ? 6 : $firstDayOfWeek - 1;
                        
                        // Previous month days
                        $prevMonthDate = $date->copy()->subMonth();
                        $prevMonthDays = $prevMonthDate->daysInMonth;
                        
                        $today = \Carbon\Carbon::today();
                    @endphp

                    <!-- Previous month days -->
                    @for($i = $prevMonthDays - $startOffset + 1; $i <= $prevMonthDays; $i++)
                        <div class="calendar-day other-month">
                            <div class="day-number">{{ $i }}</div>
                        </div>
                    @endfor

                    <!-- Current month days -->
                    @for($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $currentDate = \Carbon\Carbon::createFromDate($year, $month, $day);
                            $isToday = $currentDate->isSameDay($today);
                            
                            // Get attendances for this day
                            $dayAttendances = collect($monthlyAttendances)->flatMap(function($user) use ($year, $month, $day) {
                                return collect($user->attendances ?? [])->filter(function($att) use ($year, $month, $day) {
                                    $attDate = \Carbon\Carbon::parse($att['date']);
                                    return $attDate->year == $year && 
                                           $attDate->month == $month && 
                                           $attDate->day == $day;
                                });
                            });
                        @endphp
                        <div class="calendar-day {{ $isToday ? 'today' : '' }}">
                            <div class="day-number">{{ $day }}</div>
                            @if($dayAttendances->count() > 0)
                                <div class="small text-muted mb-1">{{ $dayAttendances->count() }} absen</div>
                                <div class="attendance-dots">
                                    @foreach($dayAttendances->take(10) as $att)
                                        <span class="dot dot-{{ strtolower($att['status']) }}" 
                                              title="{{ $att['status'] }}"></span>
                                    @endforeach
                                    @if($dayAttendances->count() > 10)
                                        <span class="small text-muted">+{{ $dayAttendances->count() - 10 }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endfor

                    <!-- Next month days to fill the grid -->
                    @php
                        $totalCells = $startOffset + $daysInMonth;
                        $remainingCells = (7 - ($totalCells % 7)) % 7;
                    @endphp
                    @for($i = 1; $i <= $remainingCells; $i++)
                        <div class="calendar-day other-month">
                            <div class="day-number">{{ $i }}</div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h5 class="fw-bold mb-2">Tidak ada data kehadiran</h5>
                <p class="text-muted mb-0">Data kehadiran untuk periode yang dipilih belum tersedia</p>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Add tooltip on calendar days
    document.querySelectorAll('.calendar-day').forEach(day => {
        day.addEventListener('click', function() {
            const dayNumber = this.querySelector('.day-number').textContent;
            console.log('Clicked day:', dayNumber);
            // You can add modal or detail view here
        });
    });
</script>
@endpush
@endsection