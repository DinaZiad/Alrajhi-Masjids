<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        \Log::info('Location store request', $request->all());
        \Log::info('Details field', ['details' => $request->input('details')]);

        $details = null;
        if ($request->filled('details')) {
            $details = json_decode($request->input('details'), true);
            \Log::info('Decoded details', ['decoded' => $details]);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withInput()->withErrors(['details' => 'تفاصيل الموقع يجب أن تكون بصيغة JSON صحيحة.']);
            }
        }

        $location = Location::create([
            'name' => $validated['name'],
            'details' => $details,
        ]);
        \Log::info('Saved location', $location->toArray());

        return redirect()->route('locations.index')->with('success', 'تمت إضافة الموقع بنجاح');
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        \Log::info('Location update request', $request->all());
        \Log::info('Details field', ['details' => $request->input('details')]);

        $details = null;
        if ($request->filled('details')) {
            $details = json_decode($request->input('details'), true);
            \Log::info('Decoded details', ['decoded' => $details]);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withInput()->withErrors(['details' => 'تفاصيل الموقع يجب أن تكون بصيغة JSON صحيحة.']);
            }
        }

        $location->update([
            'name' => $validated['name'],
            'details' => $details,
        ]);
        \Log::info('Updated location', $location->toArray());

        return redirect()->route('locations.index')->with('success', 'تم تحديث الموقع بنجاح');
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'تم حذف الموقع بنجاح');
    }
} 