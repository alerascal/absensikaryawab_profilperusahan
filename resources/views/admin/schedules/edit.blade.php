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

        <!-- Error -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 rounded-lg p-4 text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            @foreach($related_ids as $id)
    <input type="hidden" name="ids[]" value="{{ $id }}">
@endforeach


            <!-- Tipe Jadwal -->
            <div>
                <label for="is_fulltime" class="block text-sm font-medium text-gray-700">Tipe Jadwal</label>
                <select name="is_fulltime" id="is_fulltime"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                        required>
                    <option value="1" {{ old('is_fulltime', $schedule->is_fulltime) == 1 ? 'selected' : '' }}>
                        Fulltime (Semua Karyawan, kecuali yang sudah punya shift)
                    </option>
                    <option value="0" {{ old('is_fulltime', $schedule->is_fulltime) == 0 ? 'selected' : '' }}>
                        Berdasarkan Shift
                    </option>
                </select>
                @error('is_fulltime')
                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Shift -->
            <div id="shift_group" class="{{ $schedule->is_fulltime ? 'hidden' : '' }}">
                <label for="shift_id" class="block text-sm font-medium text-gray-700">Pilih Shift</label>
                <select name="shift_id" id="shift_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="" disabled {{ old('shift_id', $schedule->shift_id) ? '' : 'selected' }}>-- Pilih Shift --</option>
                    @foreach($shifts as $shift)
                        <option value="{{ $shift->id }}" {{ old('shift_id', $schedule->shift_id) == $shift->id ? 'selected' : '' }}>
                            {{ $shift->name }} ({{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }})
                        </option>
                    @endforeach
                </select>
                @error('shift_id')
                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Users -->
            <div id="users_group" class="{{ $schedule->is_fulltime ? 'hidden' : '' }}">
                <label class="block text-sm font-medium text-gray-700">Pilih Karyawan</label>
                <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 gap-2 max-h-60 overflow-y-auto border rounded-lg p-3">
                    @foreach($users as $user)
                        <label class="flex items-center space-x-2 border rounded-lg p-2 hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                   class="rounded text-indigo-600 focus:ring-indigo-500"
                                   {{ in_array($user->id, old('user_ids', $schedule->users->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">{{ $user->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('user_ids')
                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Start Time -->
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                <input type="time" name="start_time" id="start_time"
       value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}"
       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
       required>
                @error('start_time')
                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- End Time -->
            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
              <input type="time" name="end_time" id="end_time"
       value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}"
       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
       required>

                @error('end_time')
                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <!-- Hari Libur -->
<div>
    <label class="block text-sm font-medium text-gray-700">Hari Libur</label>
    <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-2">
        @php
            $dayNames = [
                1 => "Senin",
                2 => "Selasa",
                3 => "Rabu",
                4 => "Kamis",
                5 => "Jumat",
                6 => "Sabtu",
                7 => "Minggu",
            ];
          $selectedHolidays = old('holidays', $holidays ?? []);
        @endphp

        @foreach($dayNames as $key => $day)
            <label class="flex items-center space-x-2 border rounded-lg p-2 hover:bg-gray-50 cursor-pointer">
                <input type="checkbox" name="holidays[]" value="{{ $key }}"
                       class="rounded text-indigo-600 focus:ring-indigo-500"
                       {{ in_array($key, $selectedHolidays) ? 'checked' : '' }}>
                <span class="text-sm text-gray-700">{{ $day }}</span>
            </label>
        @endforeach
    </div>
    @error('holidays')
        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
    @enderror
</div>

            <!-- Submit -->
            <div class="flex justify-end gap-3">
                <button type="reset"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm">
                    Reset
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const isFulltimeSelect = document.getElementById("is_fulltime");
    const shiftGroup = document.getElementById("shift_group");
    const usersGroup = document.getElementById("users_group");

    function toggleFields() {
        if (isFulltimeSelect.value === "1") {
            shiftGroup.classList.add("hidden");
            usersGroup.classList.add("hidden");
            document.getElementById("shift_id").value = "";
            document.querySelectorAll('input[name="user_ids[]"]').forEach(cb => cb.checked = false);
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
