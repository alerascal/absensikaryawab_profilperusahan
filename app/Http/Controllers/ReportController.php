<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Department;

class ReportController extends Controller
{
    // Lembur & Cuti
    public function other(Request $request)
    {
        $departments = Department::all();

        $query = Attendance::with('user.department')
            ->whereIn('status', ['Lembur', 'Cuti', 'Diterima', 'Ditolak']); // Tambahkan status baru

        // Filter
        if ($request->filled('name')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$request->name}%"));
        }

        if ($request->filled('department')) {
            $query->whereHas('user', fn($q) => $q->where('department_id', $request->department));
        }

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        return view('reports.other', compact('attendances', 'departments'));
    }

    // Pengajuan lembur / cuti oleh admin
    public function submit(Request $request)
    {
        $request->validate([
            'status' => 'required|in:Lembur,Cuti',
            'date' => 'required|date',
            'description' => 'required|string|max:255',
        ]);

        Attendance::create([
            'user_id' => auth()->id(),
            'date' => $request->date,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Pengajuan berhasil dikirim.');
    }

    // Update status pengajuan (hanya admin, dijamin oleh AdminMiddleware)
    public function updateStatus(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Lembur,Cuti,Diterima,Ditolak'
        ]);

        $attendance->status = $request->status;
        $attendance->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }


    public function attendance(Request $request)
    {
        $query = Attendance::with('user.department');
        $date = $request->date ?? Carbon::today()->toDateString();

        $query->whereDate('date', $date);

        // Menggunakan paginate (10 data per halaman)
        $attendances = $query->orderBy('check_in', 'asc')->paginate(10);

        return view('reports.data-absen', compact('attendances', 'date'));
    }


    // Rekap Bulanan (opsional)
    public function monthly(Request $request)
    {
        $month = $request->month ?? Carbon::now()->month;
        $year  = $request->year ?? Carbon::now()->year;

        $monthlyAttendances = User::with('department')->withCount([
            'attendances as present_count' => function ($q) use ($month, $year) {
                $q->where('status', 'Hadir')->whereMonth('date', $month)->whereYear('date', $year);
            },
            'attendances as late_count' => function ($q) use ($month, $year) {
                $q->where('status', 'Terlambat')->whereMonth('date', $month)->whereYear('date', $year);
            },
            'attendances as absent_count' => function ($q) use ($month, $year) {
                $q->where('status', 'Alpha')->whereMonth('date', $month)->whereYear('date', $year);
            },
            'attendances as remote_count' => function ($q) use ($month, $year) {
                $q->where('status', 'Remote')->whereMonth('date', $month)->whereYear('date', $year);
            },
        ])->get();

        return view('reports.monthly', compact('monthlyAttendances', 'month', 'year'));
    }
}
