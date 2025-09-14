<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PegawaiPengajuanController extends Controller
{
    // List pengajuan pegawai
    public function index()
    {
        $pengajuans = Pengajuan::where('user_id', Auth::id())->latest()->paginate(10);
        return view('pegawai.pengajuan.index', compact('pengajuans'));
    }

    // Form pengajuan baru
    public function create()
    {
        return view('pegawai.pengajuan.create');
    }

  public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|in:izin,sakit', // tipe pengajuan: izin/sakit
        'surat_dokter' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'surat_izin' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
    ]);

    $data = $request->all();
    $data['user_id'] = Auth::id();
    $data['status'] = 'pending'; // default status

    if ($request->hasFile('surat_dokter')) {
        $data['surat_dokter'] = $request->file('surat_dokter')->store('pengajuan/surat_dokter', 'public');
    }

    if ($request->hasFile('surat_izin')) {
        $data['surat_izin'] = $request->file('surat_izin')->store('pengajuan/surat_izin', 'public');
    }

    Pengajuan::create($data);

    return redirect()->route('pegawai.pengajuan.index')->with('success', 'Pengajuan berhasil dibuat.');
}


    // Detail pengajuan
    public function show(Pengajuan $pengajuan)
    {
        // pastikan pegawai hanya bisa lihat pengajuannya sendiri
        if ($pengajuan->user_id != Auth::id()) {
            abort(403);
        }

        return view('pegawai.pengajuan.show', compact('pengajuan'));
    }
}
