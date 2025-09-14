@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
<style>
/* Reset dan Base Styling */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    background: #f4f7fc;
}

/* Container */
.content-section {
    max-width: 1440px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

/* Filter Form */
.filter-group {
    background: linear-gradient(145deg, #6b7280, #4b5563);
    padding: 1.5rem;
    border-radius: 12px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    transition: transform 0.3s ease;
}

.filter-group:hover {
    transform: translateY(-4px);
}

.filter-group label {
    color: #e5e7eb;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
}

.filter-group input,
.filter-group select {
    padding: 0.75rem;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    background: #fff;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.filter-group input:focus,
.filter-group select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.filter-group button {
    background: #3b82f6;
    color: #fff;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.filter-group button:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
}

/* Table Styling */
.attendance-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.attendance-table th {
    background: #e5e7eb;
    font-weight: 600;
    font-size: 0.9rem;
    color: #1f2937;
    padding: 1.25rem;
    text-align: left;
}

.attendance-table td {
    padding: 1.25rem;
    font-size: 0.9rem;
    color: #374151;
    border-top: 1px solid #f3f4f6;
}

.attendance-table tr {
    transition: all 0.3s ease;
}

.attendance-table tr:hover {
    background: #eff6ff;
    transform: translateY(-2px);
}

/* Action Icons Styling */
.action-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px; /* Ukuran simetris dan nyaman dilihat */
    height: 32px; /* Ukuran simetris */
    border-radius: 50%;
    font-size: 0.8rem; /* Sesuai dengan ukuran ikon */
    margin: 0 0.2rem; /* Jarak simetris antar ikon */
    transition: all 0.3s ease;
}

.action-icon.view {
    background: #dbeafe;
    color: #1d4ed8;
}

.action-icon.view:hover {
    background: #1d4ed8;
    color: #fff;
    transform: scale(1.05); /* Hover lebih halus */
}

.action-icon.edit {
    background: #fef3c7;
    color: #d97706;
}

.action-icon.edit:hover {
    background: #d97706;
    color: #fff;
    transform: scale(1.05);
}

.action-icon.delete {
    background: #fee2e2;
    color: #dc2626;
}

.action-icon.delete:hover {
    background: #dc2626;
    color: #fff;
    transform: scale(1.05);
}

/* Enhance Table Responsiveness */
.table-container {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.attendance-table {
    width: 100%;
    min-width: 600px;
    border-collapse: separate;
    border-spacing: 0;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.attendance-table th,
.attendance-table td {
    padding: 1rem;
    font-size: 0.9rem;
    color: #374151;
    border-top: 1px solid #f3f4f6;
    white-space: nowrap;
}

/* Adjust Action Icons Layout */
.attendance-table td.text-center {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.2rem; /* Jarak antar ikon agar rapi */
}

/* Media Queries untuk Responsivitas */
@media (max-width: 768px) {
    .attendance-table th,
    .attendance-table td {
        padding: 0.75rem;
        font-size: 0.85rem;
    }

    .action-icon {
        width: 30px; /* Penyesuaian untuk tablet */
        height: 30px;
        font-size: 0.75rem;
        margin: 0.15rem;
    }

    .attendance-table td.text-center {
        gap: 0.15rem;
    }
}

@media (max-width: 480px) {
    .attendance-table th,
    .attendance-table td {
        padding: 0.5rem;
        font-size: 0.75rem;
    }

    .action-icon {
        width: 28px; /* Penyesuaian untuk ponsel */
        height: 28px;
        font-size: 0.7rem;
        margin: 0.1rem;
    }

    .attendance-table td.text-center {
        gap: 0.1rem;
    }

    .employee-avatar {
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
    }
}

/* Pagination */
.pagination {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
    margin-top: 2.5rem;
    flex-wrap: wrap;
}

.pagination li {
    list-style: none;
}

.pagination li a,
.pagination li span {
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.pagination li a {
    background: #f3f4f6;
    color: #374151;
    text-decoration: none;
}

.pagination li a:hover {
    background: #3b82f6;
    color: #fff;
    transform: translateY(-3px);
}

.pagination li.active span {
    background: #1d4ed8;
    color: #fff;
}

.pagination li.disabled span {
    background: #e5e7eb;
    color: #9ca3af;
    cursor: not-allowed;
}

/* Alert */
.alert-success {
    background: #d1fae5;
    color: #065f46;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideDown 0.5s ease;
}

@keyframes slideDown {
    from { transform: translateY(-30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .filter-group {
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    }

    .attendance-table th,
    .attendance-table td {
        padding: 1rem;
    }
}

@media (max-width: 768px) {
    .content-section {
        padding: 1.5rem 0.75rem;
    }

    .table-controls {
        flex-direction: column;
        align-items: flex-start;
        gap: 1.5rem;
    }

    .filter-group {
        grid-template-columns: 1fr;
    }

    .attendance-table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    .action-icon {
        width: 30px;
        height: 30px;
        font-size: 0.75rem;
    }
}

@media (max-width: 480px) {
    .employee-avatar {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
    }

    .attendance-table th,
    .attendance-table td {
        font-size: 0.85rem;
        padding: 0.75rem;
    }

    .filter-group input,
    .filter-group select {
        font-size: 0.85rem;
    }

    .filter-group button {
        padding: 0.6rem 1rem;
    }
}
</style>
<div id="employees-section" class="content-section">
    <div class="attendance-panel">
        <!-- Panel Header -->
        <div class="table-controls flex justify-between items-center mb-8">
            <div>
                <h1 class="panel-title font-bold text-3xl text-gray-800">
                    <i class="fas fa-users mr-3"></i> Manajemen Karyawan
                </h1>
                <p class="panel-subtitle text-gray-600 text-base mt-2">
                    Kelola data karyawan perusahaan dengan antarmuka yang intuitif
                </p>
            </div>
            <div>
                <a href="{{ route('employees.create') }}" class="btn btn-primary flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-plus"></i> Tambah Karyawan
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('employees.index') }}" class="filter-group">
            <div>
                <label for="search">Cari Nama</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Masukkan nama karyawan...">
            </div>
            <div>
                <label for="role">Role</label>
                <select name="role" id="role">
                    <option value="">Semua Role</option>
                    <option value="admin" @if(request('role') == 'admin') selected @endif>Admin</option>
                    <option value="pegawai" @if(request('role') == 'pegawai') selected @endif>Pegawai</option>
                </select>
            </div>
            <div>
                <label for="department">Departemen</label>
                <select name="department" id="department">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" @if(request('department') == $dept->id) selected @endif>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit"><i class="fas fa-filter"></i> Terapkan</button>
            </div>
        </form>

        <!-- Alert -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="table-container">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Departemen</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $employee)
                    <tr>
                        <td>
                            <div class="flex items-center gap-4">
                                <div class="employee-avatar" style="width: 40px; height: 40px; background: #6b7280; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                                    {{ strtoupper(substr($employee->name, 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">
                                        <a href="{{ route('employees.show', $employee->id) }}" class="hover:text-indigo-600 transition">
                                            {{ $employee->name }}
                                        </a>
                                    </h4>
                                    <span class="text-sm text-gray-500">
                                        ID: {{ str_pad($employee->id, 3, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $employee->email ?? '-' }}</td>
                        <td>
                            <span class="px-3 py-1.5 text-sm font-medium rounded-full 
                                {{ $employee->role === 'admin' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                <i class="fas {{ $employee->role === 'admin' ? 'fa-user-shield' : 'fa-user' }} mr-1"></i>
                                {{ ucfirst($employee->role) }}
                            </span>
                        </td>
                        <td>{{ $employee->department->name ?? '-' }}</td>
                        <td class="text-center">
    <a href="{{ route('employees.show', $employee->id) }}" class="action-icon view" title="Lihat">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('employees.edit', $employee->id) }}" class="action-icon edit" title="Edit">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline">
        @csrf @method('DELETE')
        <button type="submit" class="action-icon delete" onclick="return confirm('Yakin mau hapus data ini?')" title="Hapus">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-500 italic">
                            Tidak ada data karyawan ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($employees->hasPages())
        <ul class="pagination">
            @if ($employees->onFirstPage())
                <li><span>&laquo; Sebelumnya</span></li>
            @else
                <li><a href="{{ $employees->previousPageUrl() }}">&laquo; Sebelumnya</a></li>
            @endif

            @foreach ($employees->getUrlRange(1, $employees->lastPage()) as $page => $url)
                @if ($page == $employees->currentPage())
                    <li class="active"><span>{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($employees->hasMorePages())
                <li><a href="{{ $employees->nextPageUrl() }}">Selanjutnya &raquo;</a></li>
            @else
                <li><span>Selanjutnya &raquo;</span></li>
            @endif
        </ul>
        @endif
    </div>
</div>
@endsection