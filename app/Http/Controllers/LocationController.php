<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    public function index()
    {
        $locations = AttendanceLocation::paginate(10);
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255|unique:attendance_locations,name',
            'maps_link' => 'required|url',
            'radius'    => 'required|integer|min:50|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $coordinates = $this->extractCoordinatesFromMapsLink($request->maps_link);

        if (!$coordinates) {
            return back()->withErrors([
                'maps_link' => 'Link Google Maps harus format panjang (@lat,lng)'
            ])->withInput();
        }

        AttendanceLocation::create([
            'name'      => $request->name,
            'maps_link' => $request->maps_link,
            'latitude'  => $coordinates['lat'],
            'longitude' => $coordinates['lng'],
            'radius'    => $request->radius,
        ]);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi berhasil ditambahkan');
    }

    public function edit(AttendanceLocation $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, AttendanceLocation $location)
    {
        $validator = Validator::make($request->all(), [
            'name'      => [
                'required',
                'string',
                'max:255',
                Rule::unique('attendance_locations')->ignore($location->id),
            ],
            'maps_link' => 'required|url',
            'radius'    => 'required|integer|min:50|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $coordinates = $this->extractCoordinatesFromMapsLink($request->maps_link);

        if (!$coordinates) {
            return back()->withErrors([
                'maps_link' => 'Link Google Maps tidak valid'
            ])->withInput();
        }

        $location->update([
            'name'      => $request->name,
            'maps_link' => $request->maps_link,
            'latitude'  => $coordinates['lat'],
            'longitude' => $coordinates['lng'],
            'radius'    => $request->radius,
        ]);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi berhasil diperbarui');
    }

    public function destroy(AttendanceLocation $location)
    {
        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi berhasil dihapus');
    }

    private function extractCoordinatesFromMapsLink(string $link): ?array
    {
        if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $link, $matches)) {
            return [
                'lat' => $matches[1],
                'lng' => $matches[2],
            ];
        }
        return null;
    }
}
