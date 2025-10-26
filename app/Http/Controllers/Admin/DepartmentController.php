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

    // Form tambah
    public function create()
    {
        return view('admin.departments.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
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
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
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
}