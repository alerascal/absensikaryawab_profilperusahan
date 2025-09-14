@extends('layouts.app')

@section('title', 'Edit Shift - AttendPro')

@section('content')
<div class="main-content" style="padding: 24px; font-family: 'Inter', sans-serif; background: #f4f7fc;">
    <div class="form-panel" style="background: #fff; border-radius: 1rem; padding: 24px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">

        <!-- Header -->
        <h1 style="font-size: 24px; font-weight: 600; color: #1f2937; margin-bottom: 8px;">Edit Shift</h1>
        <p style="color: #6b7280; margin-bottom: 24px;">Ubah informasi shift</p>

        <!-- Alert -->
        @if($errors->any())
            <div style="background: #fee2e2; color: #b91c1c; padding: 12px 16px; border-radius: 0.75rem; margin-bottom: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.shifts.update', $shift->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 16px;">
            @csrf
            @method('PUT')

            <div style="display: flex; flex-direction: column; gap: 4px;">
                <label for="name" style="font-weight: 500; color: #374151;">Nama Shift</label>
                <input type="text" name="name" id="name" value="{{ old('name', $shift->name) }}" required
                       style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 0.5rem; transition: all 0.3s; width: 100%;"
                       onfocus="this.style.borderColor='#6366f1';" onblur="this.style.borderColor='#d1d5db';">
            </div>

            <div style="display: flex; flex-direction: column; gap: 4px;">
                <label for="start_time" style="font-weight: 500; color: #374151;">Jam Mulai</label>
                <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $shift->start_time) }}" required
                       style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 0.5rem; width: 100%;">
            </div>

            <div style="display: flex; flex-direction: column; gap: 4px;">
                <label for="end_time" style="font-weight: 500; color: #374151;">Jam Selesai</label>
                <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $shift->end_time) }}" required
                       style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 0.5rem; width: 100%;">
            </div>

            <div style="display: flex; gap: 12px; margin-top: 16px;">
                <a href="{{ route('admin.shifts.index') }}" 
                   style="padding: 8px 16px; background: #f3f4f6; color: #374151; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: all 0.3s;"
                   onmouseover="this.style.background='#e5e7eb';" onmouseout="this.style.background='#f3f4f6';">
                    Kembali
                </a>
                <button type="submit" 
                        style="padding: 8px 16px; background: #4f46e5; color: #fff; border-radius: 0.5rem; font-weight: 500; border: none; cursor: pointer; transition: all 0.3s;"
                        onmouseover="this.style.background='#4338ca'; this.style.transform='scale(1.05)';" 
                        onmouseout="this.style.background='#4f46e5'; this.style.transform='scale(1)';">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
