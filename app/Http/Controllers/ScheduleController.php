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
        $dayNames = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        // Hari libur
        $holidays = Holiday::pluck('day_of_week')->toArray();

        // Ambil semua schedule (TERBARU DIUTAMAKAN)
        $schedules = Schedule::with(['shift', 'users'])
            ->orderBy('id', 'desc')
            ->get();

        /**
         * STEP 1
         * Jadwal TERAKHIR per user per hari
         */
        $latestSchedulePerUserPerDay = [];

        foreach ($schedules as $schedule) {
            foreach ($schedule->users as $user) {
                $key = $user->id . '-' . $schedule->day;

                if (!isset($latestSchedulePerUserPerDay[$key])) {
                    $latestSchedulePerUserPerDay[$key] = $schedule;
                }
            }
        }

        /**
         * STEP 2
         * Susun jadwal mingguan
         */
        $weeklySchedules = collect(range(1, 7))->mapWithKeys(function ($day) use (
            $schedules,
            $latestSchedulePerUserPerDay,
            $dayNames,
            $holidays
        ) {
            // Hari libur
            if (in_array($day, $holidays)) {
                return [$day => (object)[
                    'day_name' => $dayNames[$day],
                    'is_holiday' => true,
                    'schedules' => collect(),
                ]];
            }

            $daySchedules = $schedules->where('day', $day);

            $grouped = $daySchedules
                ->groupBy(
                    fn($s) =>
                    $s->start_time . '-' .
                        $s->end_time . '-' .
                        $s->is_fulltime . '-' .
                        ($s->shift_id ?? '0')
                )
                ->map(function ($group) use ($latestSchedulePerUserPerDay, $day) {
                    $first = $group->first();

                    $users = $group->flatMap->users
                        ->unique('id')
                        ->filter(function ($user) use ($latestSchedulePerUserPerDay, $first, $day) {
                            $key = $user->id . '-' . $day;
                            return isset($latestSchedulePerUserPerDay[$key]) &&
                                $latestSchedulePerUserPerDay[$key]->id === $first->id;
                        })
                        ->values();

                    return (object)[
                        'ids'         => $group->pluck('id')->toArray(),
                        'start_time'  => $first->start_time,
                        'end_time'    => $first->end_time,
                        'is_fulltime' => $first->is_fulltime,
                        'shift'       => $first->shift,
                        'users'       => $users,
                    ];
                })
                ->values();

            return [$day => (object)[
                'day_name' => $dayNames[$day],
                'is_holiday' => false,
                'schedules' => $grouped,
            ]];
        });

        return view('admin.schedules.index', compact(
            'weeklySchedules',
            'dayNames',
            'holidays'
        ));
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
        $request->merge([
            'start_time' => Carbon::parse($request->start_time)->format('H:i'),
            'end_time'   => Carbon::parse($request->end_time)->format('H:i'),
        ]);

        $validated = $request->validate([
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i',
            'is_fulltime' => 'required|boolean',
            'shift_id'    => 'nullable|exists:shifts,id',
            'holidays'    => 'nullable|array',
            'user_ids'    => 'nullable|array',
        ]);

        // Simpan hari libur
        Holiday::whereNotNull('day_of_week')->delete();
        foreach ($validated['holidays'] ?? [] as $day) {
            Holiday::create([
                'name' => 'Libur Mingguan',
                'day_of_week' => $day,
            ]);
        }

        // ===============================
        // CREATE SHIFT / FULLTIME
        // ===============================
        foreach (range(1, 5) as $day) {
            if (in_array($day, $validated['holidays'] ?? [])) continue;

            $schedule = Schedule::create([
                'day'         => $day,
                'start_time'  => $validated['start_time'],
                'end_time'    => $validated['end_time'],
                'is_fulltime' => $validated['is_fulltime'],
                'shift_id'    => $validated['is_fulltime'] ? null : $validated['shift_id'],
            ]);

            if (!$validated['is_fulltime']) {
                $schedule->users()->sync($validated['user_ids'] ?? []);
            }
        }

        // ===============================
        // UPDATE FULLTIME (SETELAH SHIFT)
        // ===============================
        $usersInShift = Schedule::where('is_fulltime', false)
            ->with('users')
            ->get()
            ->flatMap(fn($s) => $s->users->pluck('id'))
            ->unique();

        $eligibleUsers = User::whereNotIn('id', $usersInShift)->pluck('id');

        Schedule::where('is_fulltime', true)
            ->get()
            ->each(fn($s) => $s->users()->sync($eligibleUsers));

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
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
        if ($request->start_time) {
            $request->merge([
                'start_time' => Carbon::parse($request->start_time)->format('H:i')
            ]);
        }

        if ($request->end_time) {
            $request->merge([
                'end_time' => Carbon::parse($request->end_time)->format('H:i')
            ]);
        }

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
        foreach ($validated['holidays'] ?? [] as $day) {
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

            // 🔥 SIMPAN SESUAI PILIHAN ADMIN
            $s->users()->sync($validated['user_ids'] ?? []);
        }

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }
    /**
     * Tampilkan jadwal kerja seorang pegawai
     */
    /**
     * Tampilkan jadwal kerja seorang pegawai (sesuai yang dibuat admin)
     */
    public function show(User $user)
    {
        // Ambil semua schedule dan group seperti di admin
        $schedules = Schedule::with(['shift', 'users'])
            ->orderBy('id')
            ->get()
            ->groupBy(
                fn($item) =>
                $item->start_time . '-' . $item->end_time . '-' .
                    $item->is_fulltime . '-' . ($item->shift_id ?? '0')
            );

        // Daftar user yang sedang masuk shift (bukan fulltime)
        $usersInShift = $schedules->flatMap(function ($group) {
            $first = $group->first();
            return $first->is_fulltime ? [] : $first->users->pluck('id');
        })->unique();

        // Hari libur mingguan
        $holidays = Holiday::pluck('day_of_week')->toArray();

        // Nama hari
        $dayNames = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        // Buat jadwal mingguan untuk user ini
        $weeklySchedules = collect(range(1, 7))->mapWithKeys(function ($day) use (
            $schedules,
            $user,
            $usersInShift,
            $holidays,
            $dayNames
        ) {
            // Hari libur
            if (in_array($day, $holidays)) {
                return [$day => (object)[
                    'day_name'   => $dayNames[$day],
                    'is_holiday' => true,
                    'schedule'   => null,
                    'type'       => 'holiday',
                ]];
            }

            // Cari grup jadwal yang memiliki record untuk hari ini
            $matchingGroup = $schedules->first(function ($group) use ($day) {
                return $group->contains(fn($s) => $s->day == $day);
            });

            if (!$matchingGroup) {
                return [$day => (object)[
                    'day_name'   => $dayNames[$day],
                    'is_holiday' => false,
                    'schedule'   => null,
                    'type'       => 'none',
                ]];
            }

            $first = $matchingGroup->first();

            // Cek apakah user ini masuk ke grup ini
            $userInThisGroup = $first->is_fulltime
                ? !$usersInShift->contains($user->id)  // fulltime = semua yang tidak di shift
                : $first->users->contains('id', $user->id); // shift = yang dipilih admin

            if ($userInThisGroup) {
                return [$day => (object)[
                    'day_name'   => $dayNames[$day],
                    'is_holiday' => false,
                    'schedule'   => (object)[
                        'start_time'  => $first->start_time,
                        'end_time'    => $first->end_time,
                        'is_fulltime' => $first->is_fulltime,
                        'shift'       => $first->shift,
                    ],
                    'type' => $first->is_fulltime ? 'fulltime' : 'shift',
                ]];
            }

            // User tidak masuk jadwal ini
            return [$day => (object)[
                'day_name'   => $dayNames[$day],
                'is_holiday' => false,
                'schedule'   => null,
                'type'       => 'none',
            ]];
        });

        return view('pegawai.schedules.show', compact(
            'user',
            'weeklySchedules',
            'dayNames',
            'holidays'
        ));
    }
    /**
     * Hapus jadwal
     */
    public function destroy(Request $request, Schedule $schedule)
    {

        $ids = $request->input('ids', [$schedule->id]);

        // Proteksi kalau masih string
        $ids = collect($ids)
            ->flatMap(fn($v) => is_string($v) ? explode(',', $v) : [$v])
            ->map(fn($v) => (int) $v)
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        Schedule::whereIn('id', $ids)->delete();

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }
}
