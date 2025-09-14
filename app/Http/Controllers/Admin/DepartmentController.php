<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // <--- ini wajib
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // Tampilkan semua departemen
    public function index()
    {
        $departments = Department::all();
        return view('admin.departments.index', compact('departments'));
    }

    // API: Best departments
    public function bestDepartments()
    {
        $departments = Department::orderBy('persen', 'desc')->get();
        return response()->json($departments);
    }

    // Form tambah
    public function create()
    {
        return view('admin.departments.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'persen' => 'required|integer|min:0|max:100',
        ]);

        Department::create($request->all());

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Departemen berhasil ditambahkan');
    }

    // Form edit
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    // Update data
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'persen' => 'required|integer|min:0|max:100',
        ]);

        $department->update($request->all());

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Departemen berhasil diupdate');
    }

    // Hapus data
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Departemen berhasil dihapus');
    }
   public function topDepartments()
{
    $departments = \App\Models\Department::orderBy('persen', 'desc')->get();

    // Format data untuk frontend
    $data = $departments->map(function($d){
        return [
            'nama' => $d->nama,
            'jumlah' => $d->jumlah ?? 0, // jumlah karyawan di departemen
            'persen' => $d->persen ?? 0,
        ];
    });

    return response()->json($data);
}


}
