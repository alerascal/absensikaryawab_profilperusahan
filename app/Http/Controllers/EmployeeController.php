<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('department');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        $employees = $query->paginate(10)->withQueryString();
        $departments = Department::all();

        return view('employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('employees.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,pegawai',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function show(User $employee)
    {
        $employee->load('department');
        return view('employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        $departments = Department::all();
        return view('employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,pegawai',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $employee->password,
            'role' => $request->role,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diperbarui');
    }

    public function destroy(User $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil dihapus');
    }
}