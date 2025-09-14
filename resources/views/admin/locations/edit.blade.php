@extends('layouts.app')

@section('title', 'Edit Lokasi Absensi')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg p-6 sm:p-8">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Lokasi Absensi</h2>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.locations.update', $location->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-medium mb-1">Nama Lokasi</label>
                <input type="text" name="name" value="{{ $location->name }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Link Google Maps</label>
                <input type="url" name="maps_link" value="https://www.google.com/maps/place/@{{ $location->latitude }},{{ $location->longitude }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Radius (meter)</label>
                <input type="number" name="radius" value="{{ $location->radius }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200 font-medium flex-1 text-center">
                    Update
                </button>
                <a href="{{ route('admin.locations.index') }}"
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200 flex-1 text-center">
                   Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
