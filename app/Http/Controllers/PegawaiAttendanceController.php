<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PegawaiAttendanceController extends Controller
{
    /**
     * Halaman riwayat absensi pegawai
     */
    public function index()
    {
        $user = Auth::user();

        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('pegawai.attendance.index', compact('attendances', 'user'));
    }

    /**
     * Halaman kamera absensi
     */
    public function cameraPage()
    {
        return view('pegawai.attendance.camera');
    }

    /**
     * Proses absensi dengan kamera + lokasi
     */
    public function cameraAttendance(Request $request)
    {
        $request->validate([
            'photo'     => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $user = Auth::user();
        $now = Carbon::now();

        // 1️⃣ Simpan foto
        if (!Storage::disk('public')->exists('attendances')) {
            Storage::disk('public')->makeDirectory('attendances');
        }
        $path = $request->file('photo')->store('attendances', 'public');

        // 2️⃣ Cek lokasi dari admin
        $locations = AttendanceLocation::all();
        if ($locations->isEmpty()) {
            Storage::disk('public')->delete($path);
            return back()->with('error', '❌ Belum ada lokasi absensi yang dikonfigurasi admin.');
        }

        $isValid = false;
        $validLocation = null;
        foreach ($locations as $loc) {
            $distance = $this->calculateDistance(
                (float)$request->latitude,
                (float)$request->longitude,
                (float)$loc->latitude,
                (float)$loc->longitude
            );

            if ($distance <= $loc->radius) {
                $isValid = true;
                $validLocation = $loc;
                break;
            }
        }

        if (!$isValid) {
            Storage::disk('public')->delete($path);
            return back()->with('error', '❌ Anda berada di luar area absensi!');
        }

        // 3️⃣ Simpan absensi
        Attendance::create([
            'user_id'    => $user->id,
            'status'     => 'Hadir',
            'location'   => $validLocation->name,
            'date'       => $now->toDateString(),
            'check_in'   => $now->format('H:i:s'),
            'photo_path' => $path,
        ]);

        return redirect()->route('pegawai.attendance.index')->with('success', '✅ Absensi berhasil di ' . $validLocation->name);
    }

    /**
     * Fungsi hitung jarak (Haversine Formula)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) ** 2 +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
    public function history()
{
    $absensi = auth()->user()->attendance()->latest()->get();
    return view('pegawai.attendance.history', compact('absensi'));
}

}
