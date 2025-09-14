<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard-admin')->with('success', 'Login berhasil sebagai Admin');
            } elseif (Auth::user()->role === 'pegawai') {
                return redirect()->route('pegawai.dashboard')->with('success', 'Login berhasil sebagai Pegawai');
            }

            Auth::logout();
            return back()->withErrors(['login' => 'Role pengguna tidak dikenali']);
        }

        return back()->withErrors(['login' => 'Email atau password salah']);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout');
    }

    // Simulasi login biometric (gunakan user default di database)
    public function biometricLogin($type)
    {
        // Contoh: login user pertama sebagai pegawai/admin
        $user = null;
        if ($type === 'fingerprint' || $type === 'face') {
            $user = \App\Models\User::where('role','pegawai')->first();
        } elseif ($type === 'qr') {
            $user = \App\Models\User::where('role','admin')->first();
        }

        if (!$user) {
            return redirect()->route('login')->withErrors(['login' => 'Metode biometric tidak tersedia']);
        }

        Auth::login($user);
        session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard-admin')->with('success', 'Login via QR Code berhasil!');
        } else {
            return redirect()->route('pegawai.dashboard')->with('success', 'Login via Biometric berhasil!');
        }
    }
}
