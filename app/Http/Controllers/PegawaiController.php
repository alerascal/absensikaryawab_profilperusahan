<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    // Halaman dashboard pegawai
    public function index()
    {
        return view('dashboard-pegawai'); // resources/views/pegawai/dashboard.blade.php
    }

    // Contoh halaman profil pegawai
    public function profil()
    {
        return view('pegawai.profil'); // resources/views/pegawai/profil.blade.php
    }
}
