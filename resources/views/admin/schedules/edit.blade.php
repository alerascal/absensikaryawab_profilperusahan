@extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg p-6 sm:p-8">

        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Edit Jadwal</h1>
            <a href="{{ route('admin.schedules.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm">
                ← Kembali
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Fulltime -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipe Jadwal</label>
                <select name="is_fulltime" id="is_fulltime"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="1" {{ $schedule->is_fulltime ? 'selected' : '' }}>Fulltime (Semua Karyawan)</option>
                    <option value="0" {{ !$schedule->is_fulltime ? 'selected' : '' }}>Berdasarkan Shift</option>
                </select>
            </div>

            <!-- Shift -->
            <div id="shift_group" class="{{ $schedule->is_fulltime ? 'hidden' : '' }}">
                <label class="block text-sm font-medium text-gray-700">Pilih Shift</label>
                <select name="shift_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">-- Pilih Shift --</option>
                    @foreach($shifts as $shift)
                        <option value="{{ $shift->id }}" {{ $schedule->shift_id == $shift->id ? 'selected' : '' }}>
                            {{ $shift->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Users -->
            <div id="users_group" class="{{ $schedule->is_fulltime ? 'hidden' : '' }}">
                <label class="block text-sm font-medium text-gray-700">Pilih Karyawan</label>
                <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 gap-2">
                    @foreach($users as $user)
                        <label class="flex items-center space-x-2 border rounded-lg p-2 hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                   class="rounded text-indigo-600"
                                   {{ $schedule->users->contains($user->id) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">{{ $user->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Start Time -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                <input type="time" name="start_time" value="{{ $schedule->start_time }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                       required>
            </div>

            <!-- End Time -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                <input type="time" name="end_time" value="{{ $schedule->end_time }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                       required>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-3">
                <button type="reset"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Reset
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Update Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const isFulltimeSelect = document.getElementById("is_fulltime");
    const shiftGroup = document.getElementById("shift_group");
    const usersGroup = document.getElementById("users_group");

    function toggleFields() {
        if (isFulltimeSelect.value === "1") {
            shiftGroup.classList.add("hidden");
            usersGroup.classList.add("hidden");
        } else {
            shiftGroup.classList.remove("hidden");
            usersGroup.classList.remove("hidden");
        }
    }

    isFulltimeSelect.addEventListener("change", toggleFields);
    toggleFields();
});
</script>
@endsection
