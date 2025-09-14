<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['shift', 'users'])->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $shifts = Shift::all();
        $users = User::all();
        return view('admin.schedules.create', compact('shifts', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after_or_equal:start_time',
            'is_fulltime' => 'required|boolean',

            'shift_id'   => 'exclude_if:is_fulltime,1|required|exists:shifts,id',
            'user_ids'   => 'exclude_if:is_fulltime,1|required|array',
            'user_ids.*' => 'exclude_if:is_fulltime,1|exists:users,id',
        ]);
        $schedule = Schedule::create([
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'is_fulltime' => $request->is_fulltime,
            'shift_id'   => $request->is_fulltime ? null : $request->shift_id,
        ]);

        if ($request->is_fulltime) {
            // Ambil semua user aktif
            $allUsers = User::pluck('id')->toArray();

            // Cari user yang sudah punya schedule shift pada periode ini
            $usersWithShift = Schedule::where('is_fulltime', 0)
                ->where(function ($q) use ($request) {
                    $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                        ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
                })
                ->with('users')
                ->get()
                ->pluck('users')
                ->flatten()
                ->pluck('id')
                ->unique()
                ->toArray();

            // Sisakan hanya user yang tidak punya shift
            $eligibleUsers = array_diff($allUsers, $usersWithShift);

            $schedule->users()->sync($eligibleUsers);
        } else {
            $schedule->users()->sync($request->user_ids);
        }

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule)
    {
        $shifts = Shift::all();
        $users  = User::all();
        return view('admin.schedules.edit', compact('schedule', 'shifts', 'users'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after_or_equal:start_time',
            'is_fulltime' => 'required|boolean',

            'shift_id'   => 'exclude_if:is_fulltime,1|required|exists:shifts,id',
            'user_ids'   => 'exclude_if:is_fulltime,1|required|array',
            'user_ids.*' => 'exclude_if:is_fulltime,1|exists:users,id',
        ]);

        $schedule->update([
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'is_fulltime' => $request->is_fulltime,
            'shift_id'   => $request->is_fulltime ? null : $request->shift_id,
        ]);

        if ($request->is_fulltime) {
            $allUsers = User::pluck('id')->toArray();

            $usersWithShift = Schedule::where('id', '!=', $schedule->id) // exclude current
                ->where('is_fulltime', 0)
                ->where(function ($q) use ($request) {
                    $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                        ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
                })
                ->with('users')
                ->get()
                ->pluck('users')
                ->flatten()
                ->pluck('id')
                ->unique()
                ->toArray();

            $eligibleUsers = array_diff($allUsers, $usersWithShift);

            $schedule->users()->sync($eligibleUsers);
        } else {
            $schedule->users()->sync($request->user_ids);
        }

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule berhasil diupdate.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Schedule berhasil dihapus.');
    }
}
