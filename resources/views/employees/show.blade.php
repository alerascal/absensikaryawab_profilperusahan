@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<style>
    .employee-detail {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease-in-out;
    }

    .employee-detail h1 {
        font-size: 2rem;
        color: #1e293b;
        margin-bottom: 1.5rem;
        text-align: center;
        font-weight: 700;
        position: relative;
    }

    .employee-detail h1::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 4px;
        background: #3b82f6;
        border-radius: 2px;
    }

    .employee-info {
        display: grid;
        gap: 1.5rem;
        padding: 1.5rem;
        background: #f9fafb;
        border-radius: 8px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 1rem;
        background: #ffffff;
        border-left: 4px solid #3b82f6;
        border-radius: 6px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .info-item:hover {
        transform: translateX(8px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .info-item i {
        color: #3b82f6;
        font-size: 1.2rem;
    }

    .info-item span {
        font-size: 1rem;
        color: #1e293b;
        font-weight: 500;
    }

    .info-item p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    .back-btn {
        display: inline-block;
        margin-top: 2rem;
        padding: 0.75rem 1.5rem;
        background: #3b82f6;
        color: #ffffff;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .back-btn:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .employee-detail {
            padding: 1.5rem;
        }

        .employee-detail h1 {
            font-size: 1.5rem;
        }

        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .info-item:hover {
            transform: translateX(0);
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="employee-detail">
    <h1>Detail Karyawan</h1>
    <div class="employee-info">
        <div class="info-item">
            <i class="fas fa-id-card"></i>
            <div>
                <span>ID Karyawan</span>
                <p>{{ $employee->id, 3, '0', STR_PAD_LEFT ?? 'Tidak ada' }}</p>
            </div>
        </div>
        <div class="info-item">
            <i class="fas fa-user"></i>
            <div>
                <span>Nama</span>
                <p>{{ $employee->name ?? 'Tidak ada' }}</p>
            </div>
        </div>
        <div class="info-item">
            <i class="fas fa-envelope"></i>
            <div>
                <span>Email</span>
                <p>{{ $employee->email ?? 'Tidak ada' }}</p>
            </div>
        </div>
        <div class="info-item">
            <i class="fas fa-shield-alt"></i>
            <div>
                <span>Role</span>
                <p>{{ ucfirst($employee->role) ?? 'Tidak ada' }}</p>
            </div>
        </div>
        <div class="info-item">
            <i class="fas fa-building"></i>
            <div>
                <span>Departemen</span>
                <p>{{ $employee->department ? $employee->department->name : 'Tidak ada' }}</p>
            </div>
        </div>
        <div class="info-item">
            <i class="fas fa-calendar-check"></i>
            <div>
                <span>Dibuat Pada</span>
                <p>{{ $employee->created_at ? $employee->created_at->format('d M Y H:i') : 'Tidak ada' }}</p>
            </div>
        </div>
        <div class="info-item">
            <i class="fas fa-calendar-alt"></i>
            <div>
                <span>Terakhir Diperbarui</span>
                <p>{{ $employee->updated_at ? $employee->updated_at->format('d M Y H:i') : 'Tidak ada' }}</p>
            </div>
        </div>
    </div>
    <a href="{{ route('employees.index') }}" class="back-btn">Kembali</a>
</div>
@endsection