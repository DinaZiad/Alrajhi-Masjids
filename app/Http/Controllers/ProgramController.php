<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Masjid;
use App\Models\Location;
use App\Models\ProgramType;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Masjid $masjid)
    {
        $programs = $masjid->programs()->latest()->get();
        return view('programs.index', compact('masjid', 'programs'));
    }

    public function create(Request $request, $masjid = null)
    {
        $masjids = \App\Models\Masjid::all();
        $masjidModel = $masjid ? \App\Models\Masjid::find($masjid) : null;
        $programTypes = ProgramType::orderBy('name')->pluck('name')->toArray();
        $locations = \App\Models\Location::all();
        return view('programs.create', compact('masjids', 'masjidModel', 'programTypes', 'locations'));
    }

    public function store(Request $request, $masjid = null)
    {
        $validated = $request->validate([
            'masjid_id' => 'required|exists:masjids,id',
            'program_type' => 'required|string',
            'name' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'location_id' => 'nullable|exists:locations,id',
            'attendance_type' => 'nullable|string|max:255',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'notes' => 'nullable|string',
            'day' => 'nullable|string',
            // Type-specific fields will be validated in the view via JS
        ]);
        $program = new \App\Models\Program($validated);
        $program->masjid_id = $request->input('masjid_id');
        $program->save();
        return redirect()->route('masjids.programs.index', $program->masjid_id)->with('success', 'تم إضافة البرنامج بنجاح');
    }

    public function edit(Masjid $masjid, Program $program)
    {
        if ($program->masjid_id !== $masjid->id) {
            abort(404, 'البرنامج لا ينتمي لهذا المسجد');
        }
        $programTypes = ProgramType::orderBy('name')->pluck('name', 'name')->toArray();
        $locations = Location::all();
        return view('programs.edit', compact('masjid', 'program', 'programTypes', 'locations'));
    }

    public function update(Request $request, Masjid $masjid, Program $program)
    {
        $validated = $request->validate([
            'program_type' => 'required|string',
            'name' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'location_id' => 'nullable|exists:locations,id',
            'attendance_type' => 'nullable|string|max:255',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'notes' => 'nullable|string',
        ]);
        $validated['masjid_id'] = $masjid->id;
        $locationDetail = $request->input('location_detail', []);
        $validated['location'] = (array) $locationDetail;
        $program->update($validated + $request->only([
            'field','specialty','book','teacher','teacher_link',
            'group','instructor','instructor_link',
            'imam_name','day','date',
            'imam_fajr','imam_dhuhr','imam_asr','imam_maghrib','imam_isha',
            'adhan_fajr','iqama_fajr','adhan_dhuhr','iqama_dhuhr','adhan_asr','iqama_asr','adhan_maghrib','iqama_maghrib','adhan_isha','iqama_isha',
        ]));
        return redirect()->route('masjids.programs.index', $masjid)->with('success', 'تم تحديث البرنامج بنجاح');
    }

    public function destroy(Request $request, Masjid $masjid, Program $program)
    {
        $program->delete();
        // Redirect back to the overview page if provided (preserves filters)
        if ($request->filled('return_url')) {
            return redirect()->to($request->input('return_url'))->with('success', 'تم حذف البرنامج بنجاح');
        }
        // Or if explicitly requested to go to data.programs
        if ($request->input('redirect') === 'data.programs') {
            return redirect()->route('data.programs')->with('success', 'تم حذف البرنامج بنجاح');
        }
        // Default: back to masjid programs index
        return redirect()->route('masjids.programs.index', $masjid)->with('success', 'تم حذف البرنامج بنجاح');
    }

    public function chooseMasjid()
    {
        $masjids = \App\Models\Masjid::all();
        return view('programs.choose-masjid', compact('masjids'));
    }
} 