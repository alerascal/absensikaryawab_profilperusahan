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
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('employee_id', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        $employees = $query->paginate(10)->withQueryString();
        $departments = Department::all();

        return view('admin.employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.employees.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,hr,finance,it_admin,supervisor,employee,guest',
            'department_id' => 'nullable|exists:departments,id',
            'employee_id' => 'nullable|string|unique:users,employee_id',
            'position' => 'nullable|string|max:255',
            'employment_status' => 'nullable|in:full-time,part-time,contract',
            'join_date' => 'nullable|date',
            'is_active' => 'boolean',
        ], [
            'password.min' => 'Password harus memiliki minimal 8 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role harus salah satu dari: admin, manager, hr, finance, it_admin, supervisor, employee, guest.',
            'employee_id.unique' => 'ID Karyawan sudah digunakan.',
            'join_date.date' => 'Tanggal bergabung harus format tanggal yang valid.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'department_id' => $request->department_id,
            'employee_id' => $request->employee_id,
            'position' => $request->position,
            'employment_status' => $request->employment_status,
            'join_date' => $request->join_date,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function show(User $employee)
    {
        $employee->load('department');
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        $departments = Department::all();
        return view('admin.employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,hr,finance,it_admin,supervisor,employee,guest',
            'department_id' => 'nullable|exists:departments,id',
            'employee_id' => 'nullable|string|unique:users,employee_id,' . $employee->id,
            'position' => 'nullable|string|max:255',
            'employment_status' => 'nullable|in:full-time,part-time,contract',
            'join_date' => 'nullable|date',
            'is_active' => 'boolean',
        ], [
            'password.min' => 'Password harus memiliki minimal 8 karakter.',
            'password.string' => 'Password harus berupa teks.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role harus salah satu dari: admin, manager, hr, finance, it_admin, supervisor, employee, guest.',
            'employee_id.unique' => 'ID Karyawan sudah digunakan.',
            'join_date.date' => 'Tanggal bergabung harus format tanggal yang valid.',
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $employee->password,
            'role' => $request->role,
            'department_id' => $request->department_id,
            'employee_id' => $request->employee_id,
            'position' => $request->position,
            'employment_status' => $request->employment_status,
            'join_date' => $request->join_date,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Data karyawan berhasil diperbarui');
    }

    public function destroy(User $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Karyawan berhasil dihapus');
    }
}