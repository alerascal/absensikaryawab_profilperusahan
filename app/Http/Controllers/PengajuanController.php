<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PengajuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->only(['approve', 'reject']);
    }

    /**
     * Tampilkan daftar pengajuan
     */
    public function index()
    {
        $pengajuans = Pengajuan::with('user')->latest()->paginate(10);
        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    /**
     * Form tambah pengajuan
     */
    public function create()
    {
        return view('admin.pengajuan.create');
    }

    /**
     * Simpan pengajuan baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,approved,rejected', // Tambahkan validasi untuk status
            'surat_dokter' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'surat_izin' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['title', 'description', 'status']); // Ambil status dari input
        $data['user_id'] = auth()->id();

        if ($request->hasFile('surat_dokter')) {
            $data['surat_dokter'] = $request->file('surat_dokter')->store('pengajuan', 'public');
        }
        if ($request->hasFile('surat_izin')) {
            $data['surat_izin'] = $request->file('surat_izin')->store('pengajuan', 'public');
        }

        Pengajuan::create($data);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil diajukan');
    }

    /**
     * Tampilkan detail pengajuan
     */
    public function show(Pengajuan $pengajuan)
    {
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Form edit pengajuan
     */
    public function edit(Pengajuan $pengajuan)
    {
        return view('admin.pengajuan.edit', compact('pengajuan'));
    }

    /**
     * Update pengajuan
     */
    public function update(Request $request, Pengajuan $pengajuan)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,approved,rejected', // Tambahkan validasi untuk status
            'surat_dokter' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'surat_izin' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['title', 'description', 'status']); // Tambahkan status

        if ($request->hasFile('surat_dokter')) {
            if ($pengajuan->surat_dokter) {
                Storage::disk('public')->delete($pengajuan->surat_dokter);
            }
            $data['surat_dokter'] = $request->file('surat_dokter')->store('pengajuan', 'public');
        }

        if ($request->hasFile('surat_izin')) {
            if ($pengajuan->surat_izin) {
                Storage::disk('public')->delete($pengajuan->surat_izin);
            }
            $data['surat_izin'] = $request->file('surat_izin')->store('pengajuan', 'public');
        }

        $pengajuan->update($data);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui');
    }

    /**
     * Hapus pengajuan
     */
    public function destroy(Pengajuan $pengajuan)
    {
        if ($pengajuan->surat_dokter) {
            Storage::disk('public')->delete($pengajuan->surat_dokter);
        }
        if ($pengajuan->surat_izin) {
            Storage::disk('public')->delete($pengajuan->surat_izin);
        }

        $pengajuan->delete();
        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil dihapus');
    }

    /**
     * Approve pengajuan
     */
    public function approve($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update(['status' => 'approved']);
        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan disetujui');
    }

    /**
     * Reject pengajuan
     */
    public function reject($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update(['status' => 'rejected']);
        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan ditolak');
    }
}
