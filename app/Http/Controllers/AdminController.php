<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Halaman dashboard admin
    public function index()
    {
        return view('dashboard-admin'); // resources/views/admin/dashboard.blade.php
    }

    // Contoh halaman kelola pegawai
    public function kelolaPegawai()
    {
        return view('admin.kelola-pegawai'); // resources/views/admin/kelola-pegawai.blade.php
    }
}
