<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Program;
use App\Models\Masjid;
use App\Models\Location;

class DataManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            
            // Check if user has manage_data permission
            if (!$user->hasPermission('manage_data')) {
                abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة');
            }
            
            return $next($request);
        });
    }

    public function programs(Request $request)
    {
        $masjidId = $request->input('masjid_id');
        $programType = $request->input('program_type');
        $status = $request->input('status');
        $locationId = $request->input('location_id');
        $teacher = $request->input('teacher');
        $major = $request->input('major'); // maps to specialty/field
        $book = $request->input('book');
        $day = $request->input('day');
        $timeFrom = $request->input('time_from');
        $timeTo = $request->input('time_to');

        $query = Program::query()->with(['masjid']);

        if ($masjidId) {
            $query->where('masjid_id', $masjidId);
        }
        if ($programType) {
            $query->where('program_type', $programType);
        }
        if ($status) {
            $query->where('status', 'like', "%$status%");
        }
        if ($locationId) {
            $query->where('location_id', $locationId);
        }
        if ($teacher) {
            $query->where(function ($q) use ($teacher) {
                $q->where('teacher', 'like', "%$teacher%")
                  ->orWhere('instructor', 'like', "%$teacher%");
            });
        }
        if ($major) {
            $query->where(function ($q) use ($major) {
                $q->where('specialty', 'like', "%$major%")
                  ->orWhere('field', 'like', "%$major%");
            });
        }
        if ($book) {
            $query->where('book', 'like', "%$book%");
        }
        if ($day) {
            $query->where('day', $day);
        }
        if ($timeFrom) {
            $query->where('start_time', '>=', $timeFrom);
        }
        if ($timeTo) {
            $query->where('end_time', '<=', $timeTo);
        }

        $programs = $query->latest()->paginate(15)->withQueryString();

        $masjids = Masjid::orderBy('name')->get(['id','name']);
        $programTypes = Program::query()->distinct()->pluck('program_type')->filter()->values();
        $locations = Location::orderBy('name')->get(['id','name']);
        $days = Program::query()->distinct()->pluck('day')->filter()->values();

        return view('data.programs', compact(
            'programs', 'masjids', 'programTypes', 'locations', 'days',
            'masjidId', 'programType', 'status', 'locationId', 'teacher', 'major', 'book', 'day', 'timeFrom', 'timeTo'
        ));
    }

    public function updateProgramNote(Request $request, Program $program)
    {
        $data = $request->validate([
            'notes' => 'nullable|string',
        ]);
        $program->notes = $data['notes'] ?? null;
        $program->save();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'ok',
                'notes' => $program->notes,
                'id' => $program->id,
            ]);
        }

        return back()->with('success', 'تم حفظ الملاحظة');
    }
}
