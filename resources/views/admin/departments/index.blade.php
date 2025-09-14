@extends('layouts.app')

@section('title', 'Daftar Departemen - AttendPro')

@section('content')
<div class="main-content" style="padding: 24px; font-family: 'Inter', sans-serif; background: #f4f7fc;">

    <div class="attendance-panel" 
         style="background: #fff; border-radius: 1rem; padding: 24px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 12px; justify-content: space-between; flex-wrap: wrap;">
            <div>
                <h1 style="font-size: 24px; font-weight: 600; color: #1f2937;">Daftar Departemen</h1>
                <p style="color: #6b7280;">Kelola data departemen dengan mudah</p>
            </div>
            <div>
                <a href="{{ route('admin.departments.create') }}" 
                   style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: #4f46e5; color: #fff; border-radius: 0.75rem; font-weight: 500; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-decoration: none; transition: all 0.3s;"
                   onmouseover="this.style.background='#4338ca'; this.style.transform='scale(1.05)';" 
                   onmouseout="this.style.background='#4f46e5'; this.style.transform='scale(1)';">
                    <i class="fas fa-plus"></i> Tambah Departemen
                </a>
            </div>
        </div>

        <!-- Alert -->
        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 0.75rem; margin: 16px 0; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                {{ session('success') }}
            </div>
        @endif
        <!-- Info Keterangan Kolom -->
<div style="background: #e0f2fe; color: #0369a1; padding: 12px 16px; border-radius: 0.75rem; margin-bottom: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); font-size: 14px;">
    <strong>Keterangan:</strong> <br>
    - <strong>Jumlah:</strong> Menunjukkan jumlah karyawan yang bekerja di departemen ini. <br>
    - <strong>Persen:</strong> Menunjukkan persentase pencapaian target departemen dalam satu periode.
</div>


        <!-- Table -->
        <div style="overflow-x:auto; -webkit-overflow-scrolling: touch; margin-top: 16px;">
            <table style="min-width: 600px; width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(90deg, #7c3aed, #4f46e5); color: #fff;">
                    <tr>
                        <th style="padding: 12px; text-align: center;">No</th>
                        <th style="padding: 12px; text-align: left;">Nama Departemen</th>
                        <th style="padding: 12px; text-align: center;">Jumlah</th>
                        <th style="padding: 12px; text-align: center;">Persen (%)</th>
                        <th style="padding: 12px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="background: #fff;">
                    @forelse($departments as $key => $department)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px; text-align: center;">{{ $key+1 }}</td>
                            <td style="padding: 12px;">{{ $department->name }}</td>
                            <td style="padding: 12px; text-align: center;">{{ $department->jumlah }}</td>
                            <td style="padding: 12px; text-align: center;">{{ $department->persen }}%</td>
                            <td style="padding: 12px; display: flex; justify-content: center; gap: 8px;">
                                <a href="{{ route('admin.departments.edit', $department->id) }}" 
                                   style="display: flex; align-items: center; justify-content: center; width:36px; height:36px; background:#fde68a; color:#b45309; border-radius:9999px; transition: all 0.2s;" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.departments.destroy', $department->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            style="display: flex; align-items: center; justify-content: center; width:36px; height:36px; background:#fecaca; color:#b91c1c; border-radius:9999px; transition: all 0.2s;"
                                            onclick="return confirm('Yakin ingin menghapus departemen ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:16px; color:#9ca3af;">Belum ada departemen</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Inline JS -->
<script>
    // Fade out alert
    window.addEventListener('DOMContentLoaded', () => {
        const alert = document.getElementById('alert-success');
        if(alert){
            setTimeout(() => { alert.style.display = 'none'; }, 4000);
        }
    });

    // Confirm delete
    function confirmDelete(event){
        if(!confirm('Yakin ingin menghapus departemen ini?')){
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>
@endsection
