<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Attendance; // ✅ perbaikan namespace

class ProfileController extends Controller
{
    // ✅ Tampilkan profil user login
    public function index()
    {
        $user = Auth::user();

        // Hitung data absensi
        $user->attendances_count = $user->attendances()->count();
        $user->late_count = $user->attendances()->where('status', 'late')->count();
        $user->leave_count = $user->attendances()->where('status', 'leave')->count();

        return view('settings.index', compact('user'));
    }

    // ✅ Form edit data
    public function edit()
    {
        $user = Auth::user();
        return view('settings.edit', compact('user'));
    }

    // ✅ Update data user
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email,' . $user->id,
            'employee_id'       => 'nullable|string|max:50',
            'position'          => 'nullable|string|max:100',
            'employment_status' => 'nullable|string|max:50',
            'join_date'         => 'nullable|date',
            'department_id'     => 'nullable|exists:departments,id',
            'is_active'         => 'nullable|boolean',
            'password'          => 'nullable|string|min:6|confirmed',
        ]);

        $user->name              = $request->name;
        $user->email             = $request->email;
        $user->employee_id       = $request->employee_id;
        $user->position          = $request->position;
        $user->employment_status = $request->employment_status;
        $user->join_date         = $request->join_date;
        $user->department_id     = $request->department_id;
        $user->is_active         = $request->is_active ?? $user->is_active;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('settings.index')->with('success', 'Profil berhasil diperbarui!');
    }

    // ✅ Hapus akun (absensi TIDAK dihapus)
    public function destroy()
    {
        $user = Auth::user();

        // Jangan hapus absensi
        $user->delete();

        Auth::logout();

        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }
}
