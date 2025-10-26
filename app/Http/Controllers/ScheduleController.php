<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Shift;
use App\Models\User;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Tampilkan daftar jadwal (grouped).
     */
    public function index()
    {
        $schedules = Schedule::with(['shift', 'users'])
            ->orderBy('id')
            ->get()
            ->groupBy(fn($item) =>
                $item->start_time . '-' . $item->end_time . '-' .
                $item->is_fulltime . '-' . ($item->shift_id ?? '0')
            );

        $usersInShift = $schedules->flatMap(function ($group) {
            $first = $group->first();
            return $first->is_fulltime ? [] : $first->users->pluck('id');
        })->unique();

        $groupedSchedules = $schedules->map(function ($group) use ($usersInShift) {
            $first = $group->first();

            $users = $first->is_fulltime
                ? $first->users->reject(fn($u) => $usersInShift->contains($u->id))->values()
                : $first->users;

            return (object) [
                'ids'        => $group->pluck('id')->toArray(),
                'start_time' => $first->start_time,
                'end_time'   => $first->end_time,
                'is_fulltime' => $first->is_fulltime,
                'shift'      => $first->shift,
                'users'      => $users,
            ];
        });

        // Ambil hari libur global
        $holidays = Holiday::pluck('day_of_week')->toArray();

        $dayNames = [
            1 => "Senin",
            2 => "Selasa",
            3 => "Rabu",
            4 => "Kamis",
            5 => "Jumat",
            6 => "Sabtu",
            7 => "Minggu",
        ];

        $holidayNames = array_map(fn($d) => $dayNames[$d] ?? 'Tidak diketahui', $holidays);

        return view('admin.schedules.index', compact('groupedSchedules', 'holidayNames'));
    }

    /**
     * Form tambah jadwal
     */
    public function create()
    {
        $shifts = Shift::all();
        $users = User::all();
        $holidays = Holiday::pluck('day_of_week')->toArray();
        return view('admin.schedules.create', compact('shifts', 'users', 'holidays'));
    }

    /**
     * Simpan jadwal baru
     */
    public function store(Request $request)
    {
        // Normalisasi waktu
        if ($request->start_time) {
            $request->merge(['start_time' => Carbon::parse($request->start_time)->format('H:i')]);
        }
        if ($request->end_time) {
            $request->merge(['end_time' => Carbon::parse($request->end_time)->format('H:i')]);
        }

        $validated = $request->validate([
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i',
            'is_fulltime' => 'required|boolean',
            'shift_id'    => 'nullable|exists:shifts,id',
            'holidays'    => 'nullable|array',
            'user_ids'    => 'nullable|array',
        ]);

        // Simpan hari libur mingguan ke tabel
        Holiday::whereNotNull('day_of_week')->delete();
        $holidays = $validated['holidays'] ?? [];
        foreach ($holidays as $day) {
            Holiday::create([
                'name' => 'Libur Mingguan',
                'day_of_week' => $day,
            ]);
        }

        // Cek shift malam
        $start = Carbon::createFromFormat('H:i', $validated['start_time']);
        $end   = Carbon::createFromFormat('H:i', $validated['end_time']);
        if ($end->lessThanOrEqualTo($start)) $end->addDay();
        if ($start->equalTo($end)) {
            return back()->withErrors(['end_time' => 'Waktu selesai tidak boleh sama dengan waktu mulai.'])->withInput();
        }

        // Ambil user eligible
        $usersInShift = Schedule::where('is_fulltime', false)->with('users')->get()
            ->flatMap(fn($s) => $s->users->pluck('id'))->unique();
        $eligibleUsers = User::whereNotIn('id', $usersInShift)->pluck('id')->toArray();

        if ($validated['is_fulltime']) {
            // Full-time Senin–Jumat (skip libur)
            foreach (range(1, 5) as $day) {
                if (in_array($day, $holidays)) continue;

                $schedule = Schedule::create([
                    'day'         => $day,
                    'start_time'  => $validated['start_time'],
                    'end_time'    => $validated['end_time'],
                    'is_fulltime' => true,
                    'shift_id'    => null,
                ]);
                $schedule->users()->sync($eligibleUsers);
            }
        } else {
            // Shift Senin–Jumat (skip libur)
            foreach (range(1, 5) as $day) {
                if (in_array($day, $holidays)) continue;

                // Filter user agar tidak dobel shift di hari yang sama
                $alreadyAssigned = Schedule::where('day', $day)
                    ->with('users')->get()
                    ->flatMap(fn($s) => $s->users->pluck('id'))->unique();

                $validUserIds = collect($validated['user_ids'] ?? [])->diff($alreadyAssigned)->toArray();

                $schedule = Schedule::create([
                    'day'         => $day,
                    'start_time'  => $validated['start_time'],
                    'end_time'    => $validated['end_time'],
                    'is_fulltime' => false,
                    'shift_id'    => $validated['shift_id'],
                ]);
                $schedule->users()->sync($validUserIds);
            }

            // Update fulltime → hanya user tanpa shift
            $fulltimeSchedules = Schedule::where('is_fulltime', true)->get();
            foreach ($fulltimeSchedules as $fulltimeSchedule) {
                $fulltimeSchedule->users()->sync($eligibleUsers);
            }
        }

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    /**
     * Form edit jadwal
     */
    public function edit(Schedule $schedule)
    {
        $related = Schedule::where('start_time', $schedule->start_time)
            ->where('end_time', $schedule->end_time)
            ->where('is_fulltime', $schedule->is_fulltime)
            ->where('shift_id', $schedule->shift_id)
            ->pluck('id')->toArray();

        $shifts = Shift::all();
        $users = User::all();
        $holidays = Holiday::pluck('day_of_week')->toArray();

        return view('admin.schedules.edit', [
            'schedule'    => $schedule,
            'related_ids' => $related,
            'shifts'      => $shifts,
            'users'       => $users,
            'holidays'    => $holidays,
        ]);
    }

    /**
     * Update jadwal
     */
    public function update(Request $request, Schedule $schedule)
    {
        if ($request->start_time) $request->merge(['start_time' => Carbon::parse($request->start_time)->format('H:i')]);
        if ($request->end_time) $request->merge(['end_time' => Carbon::parse($request->end_time)->format('H:i')]);

        $validated = $request->validate([
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i',
            'is_fulltime' => 'required|in:0,1',
            'shift_id'    => 'nullable|exists:shifts,id',
            'user_ids'    => 'nullable|array',
            'ids'         => 'required|array',
            'holidays'    => 'nullable|array',
        ]);

        // Update libur
        Holiday::whereNotNull('day_of_week')->delete();
        $holidays = $validated['holidays'] ?? [];
        foreach ($holidays as $day) {
            Holiday::create([
                'name' => 'Libur Mingguan',
                'day_of_week' => $day,
            ]);
        }

        foreach ($validated['ids'] as $id) {
            $s = Schedule::find($id);
            if (!$s) continue;

            $s->update([
                'start_time'  => $validated['start_time'],
                'end_time'    => $validated['end_time'],
                'is_fulltime' => $validated['is_fulltime'],
                'shift_id'    => $validated['is_fulltime'] ? null : $validated['shift_id'],
            ]);

            if ($validated['is_fulltime']) {
                $usersInShift = Schedule::where('is_fulltime', false)->with('users')->get()
                    ->flatMap(fn($sch) => $sch->users->pluck('id'))->unique();
                $eligibleUsers = User::whereNotIn('id', $usersInShift)->pluck('id')->toArray();
                $s->users()->sync($eligibleUsers);
            } else {
                $alreadyAssigned = Schedule::where('day', $s->day)
                    ->where('id', '!=', $s->id)
                    ->with('users')->get()
                    ->flatMap(fn($sch) => $sch->users->pluck('id'))->unique();
                $validUserIds = collect($validated['user_ids'] ?? [])->diff($alreadyAssigned)->toArray();
                $s->users()->sync($validUserIds);
            }
        }

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    /**
     * Hapus jadwal
     */
    public function destroy(Request $request, Schedule $schedule)
    {
        $ids = $request->input('ids', [$schedule->id]);
        Schedule::whereIn('id', $ids)->delete();

        // Perbarui fulltime setelah hapus shift
        $usersInShift = Schedule::where('is_fulltime', false)->with('users')->get()
            ->flatMap(fn($s) => $s->users->pluck('id'))->unique();
        $eligibleUsers = User::whereNotIn('id', $usersInShift)->pluck('id')->toArray();

        $fulltimeSchedules = Schedule::where('is_fulltime', true)->get();
        foreach ($fulltimeSchedules as $fulltimeSchedule) {
            $fulltimeSchedule->users()->sync($eligibleUsers);
        }

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
