<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;


class PengajuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Daftar semua pengajuan (hanya untuk admin)
     */
    public function index()
    {
        // Hanya admin yang bisa melihat semua pengajuan
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $pengajuans = Pengajuan::with('user')->latest()->paginate(10);
        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    /**
     * Daftar pengajuan milik user yang login (untuk pegawai & admin)
     */
    public function myRequests()
    {
        $pengajuans = Auth::user()->pengajuans()->latest()->paginate(10);
        return view('pengajuan.my_requests', compact('pengajuans'));
    }

    /**
     * Form tambah pengajuan (semua user)
     */
    public function create()
    {
        return view('pengajuan.create');
    }

    /**
     * Simpan pengajuan baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'surat_dokter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'surat_izin' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['title', 'description']);
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending'; // Status awal selalu pending

        if ($request->hasFile('surat_dokter')) {
            $data['surat_dokter'] = $request->file('surat_dokter')->store('pengajuan', 'public');
        }
        if ($request->hasFile('surat_izin')) {
            $data['surat_izin'] = $request->file('surat_izin')->store('pengajuan', 'public');
        }

        Pengajuan::create($data);

        return redirect()->route('pengajuan.my')->with('success', 'Pengajuan berhasil diajukan dan menunggu persetujuan.');
    }

    /**
     * Tampilkan detail pengajuan
     */
    public function show(Pengajuan $pengajuan)
    {
        // Hanya pemilik atau admin yang boleh lihat
        if (Auth::id() !== $pengajuan->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('pengajuan.show', compact('pengajuan'));
    }

    /**
     * Form edit pengajuan (hanya jika status masih pending)
     */
    public function edit(Pengajuan $pengajuan)
    {
        // Hanya pemilik yang boleh edit, dan hanya jika masih pending
        if (Auth::id() !== $pengajuan->user_id) {
            abort(403);
        }

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan yang sudah diproses tidak dapat diedit.');
        }

        return view('pengajuan.edit', compact('pengajuan'));
    }

    /**
     * Update pengajuan (hanya pemilik & status pending)
     */
    public function update(Request $request, Pengajuan $pengajuan)
    {
        if (Auth::id() !== $pengajuan->user_id) {
            abort(403);
        }

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'surat_dokter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'surat_izin' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['title', 'description']);

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

        return redirect()->route('pengajuan.my')->with('success', 'Pengajuan berhasil diperbarui.');
    }
    /**
     * Hapus pengajuan
     * 
     * - Siapa pun (pegawai/admin) hanya boleh hapus pengajuan milik sendiri
     * - Tidak ada batasan status (pending/approved/rejected boleh dihapus)
     * - Admin tidak boleh hapus pengajuan orang lain (termasuk admin lain)
     */
    public function destroy(Pengajuan $pengajuan)
    {
        $currentUser = Auth::user();

        // Hanya pemilik yang boleh hapus (baik pegawai maupun admin)
        if (Auth::id() !== $pengajuan->user_id) {
            abort(403, 'Anda tidak diizinkan menghapus pengajuan ini.');
        }

        // Tidak ada batasan status — boleh hapus kapan saja

        // Hapus file dokumen
        if ($pengajuan->surat_dokter) {
            Storage::disk('public')->delete($pengajuan->surat_dokter);
        }
        if ($pengajuan->surat_izin) {
            Storage::disk('public')->delete($pengajuan->surat_izin);
        }

        // Hapus dari database
        $pengajuan->delete();

        // Redirect sesuai konteks
        $redirectRoute = $currentUser->role === 'admin' ? 'admin.pengajuan.index' : 'pengajuan.my';

        return redirect()->route($redirectRoute)
            ->with('success', 'Pengajuan berhasil dihapus.');
    }
    /**
     * Approve pengajuan (hanya admin & bukan milik sendiri)
     */
    public function approve($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $pengajuan = Pengajuan::findOrFail($id);

        // Admin tidak boleh approve pengajuannya sendiri
        if ($pengajuan->user_id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menyetujui pengajuan milik sendiri.');
        }

        // Update status pengajuan
        $pengajuan->update(['status' => 'approved']);

        // Tentukan status absensi
        $attendanceStatus = null;

        if (strtolower($pengajuan->title) === 'izin') {
            $attendanceStatus = 'Izin';
        }

        if (strtolower($pengajuan->title) === 'sakit') {
            $attendanceStatus = 'Sakit';
        }

        // Update / buat absensi hari ini
        if ($attendanceStatus) {
            Attendance::updateOrCreate(
                [
                    'user_id' => $pengajuan->user_id,
                    'date' => Carbon::today(),
                ],
                [
                    'status' => $attendanceStatus,
                    'notes' => 'Otomatis dari pengajuan yang disetujui admin',
                    'check_in' => null,
                    'check_out' => null,
                ]
            );
        }

        return redirect()
            ->route('admin.pengajuan.index')
            ->with('success', 'Pengajuan disetujui & absensi otomatis diperbarui.');
    }
    /**
     * Reject pengajuan (hanya admin & bukan milik sendiri)
     */
    public function reject($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $pengajuan = Pengajuan::findOrFail($id);

        // Admin tidak boleh reject pengajuannya sendiri
        if ($pengajuan->user_id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menolak pengajuan milik sendiri.');
        }

        $pengajuan->update(['status' => 'rejected']);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil ditolak.');
    }
}
