<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\User;
use App\Exports\AttendanceExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Resources\AttendanceResource;
use Carbon\Carbon;

class AttendanceReportService
{
    public function getAttendancePageData(Request $request)
    {
        $query = Attendance::with([
            'user' => fn($q) => $q->select('id', 'name', 'department_id'),
            'user.department' => fn($q) => $q->select('id', 'name')
        ]);

        if ($request->filled('department')) {
            $query->whereHas('user.department', fn($q) => $q->where('name', $request->department));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $totalData = $query->count();
        $attendances = $query->orderBy('date', 'desc')->orderBy('id', 'desc')->paginate(10);

        return [
            'attendances' => AttendanceResource::collection($attendances),
            'totalData' => $totalData
        ];
    }

    public function downloadAttendancePdf($date)
    {
        $parsedDate = Carbon::parse($date)->format('Y-m-d');
        $attendances = Attendance::with([
            'user' => fn($q) => $q->select('id', 'name', 'department_id'),
            'user.department' => fn($q) => $q->select('id', 'name')
        ])->whereDate('date', $parsedDate)->get();

        $pdf = Pdf::loadView('reports.attendance_pdf', ['date' => $parsedDate, 'attendances' => $attendances])
            ->setPaper('A4', 'portrait');
        return $pdf->download('Laporan_Kehadiran_' . $parsedDate . '.pdf');
    }

    public function downloadMonthlyPdf(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $monthlyAttendances = User::with(['department' => fn($q) => $q->select('id', 'name')])->withCount([
            'attendances as present_count' => fn($q) => $q->whereMonth('date', $month)->whereYear('date', $year)->where('status', 'Hadir'),
            'attendances as late_count' => fn($q) => $q->whereMonth('date', $month)->whereYear('date', $year)->where('status', 'Terlambat'),
            'attendances as absent_count' => fn($q) => $q->whereMonth('date', $month)->whereYear('date', $year)->where('status', 'Absen'),
            'attendances as remote_count' => fn($q) => $q->whereMonth('date', $month)->whereYear('date', $year)->where('status', 'WFH'),
        ])->get();

        $displayMonth = Carbon::createFromDate($year, $month)->translatedFormat('F Y');
        $pdf = Pdf::loadView('reports.monthly_pdf', compact('monthlyAttendances', 'displayMonth'));
        return $pdf->download("Rekap_Kehadiran_$displayMonth.pdf");
    }

    public function downloadAttendanceExcel(Request $request)
    {
        $filters = $request->only(['department', 'status', 'date']);
        return Excel::download(new AttendanceExport($filters), 'Data_Absensi_Filtered.xlsx');
    }
}