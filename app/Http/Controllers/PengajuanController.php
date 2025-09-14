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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'surat_dokter' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'surat_izin' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $request->only(['title', 'description']);
        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';

        if ($request->hasFile('surat_dokter')) {
            $data['surat_dokter'] = $request->file('surat_dokter')->store('pengajuan', 'public');
        }
        if ($request->hasFile('surat_izin')) {
            $data['surat_izin'] = $request->file('surat_izin')->store('pengajuan', 'public');
        }

        $pengajuan = Pengajuan::create($data);

        return response()->json(['success' => true, 'message' => 'Pengajuan berhasil diajukan', 'data' => $pengajuan], 201);
    }

    public function approve(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update(['status' => 'approved']);
        return response()->json(['success' => true, 'message' => 'Pengajuan disetujui']);
    }

    public function reject(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update(['status' => 'rejected']);
        return response()->json(['success' => true, 'message' => 'Pengajuan ditolak']);
    }
}