<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Masjid;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::with('masjid')->orderBy('serial_number')->paginate(20);
        $masjids = Masjid::orderBy('name')->get();
        return view('buildings.index', compact('buildings', 'masjids'));
    }

    public function create()
    {
        $masjids = Masjid::orderBy('name')->get();
        return view('buildings.create', compact('masjids'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'masjid_id' => 'required|exists:masjids,id',
            'building_number' => 'required|string|max:255',
            'direction' => 'nullable|string|max:255',
            'floors_count' => 'required|integer|min:0',
            'labs_halls_count' => 'required|string|max:255',
        ]);

        // Allow duplicate building numbers per masjid

        $nextSerial = (Building::max('serial_number') ?? 0) + 1; // global serial

        $building = Building::create([
            'masjid_id' => $validated['masjid_id'],
            'serial_number' => $nextSerial,
            'building_number' => $validated['building_number'],
            'direction' => $validated['direction'] ?? null,
            'floors_count' => $validated['floors_count'],
            'labs_halls_count' => $validated['labs_halls_count'],
        ]);

        return redirect()->route('admin.constants.buildings.index')->with('success', 'تم إضافة المبنى بنجاح');
    }

    public function edit(Building $building)
    {
        $masjids = Masjid::orderBy('name')->get();
        return view('buildings.edit', compact('building', 'masjids'));
    }

    public function update(Request $request, Building $building)
    {
        $validated = $request->validate([
            'masjid_id' => 'required|exists:masjids,id',
            'building_number' => 'required|string|max:255',
            'direction' => 'nullable|string|max:255',
            'floors_count' => 'required|integer|min:0',
            'labs_halls_count' => 'required|string|max:255',
        ]);

        // Allow duplicate building numbers per masjid

        $building->update($validated);

        return redirect()->route('admin.constants.buildings.index')->with('success', 'تم تحديث بيانات المبنى بنجاح');
    }

    public function destroy(Building $building)
    {
        $building->delete();
        return redirect()->route('admin.constants.buildings.index')->with('success', 'تم حذف المبنى بنجاح');
    }
}
