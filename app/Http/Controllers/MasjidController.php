<?php

namespace App\Http\Controllers;

use App\Models\Masjid;
use Illuminate\Http\Request;

class MasjidController extends Controller
{
    public function index()
    {
        $masjids = Masjid::all();
        return view('masjids.index', compact('masjids'));
    }

    public function create()
    {
        return view('masjids.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'total_area' => 'nullable|string|max:255',
            'covered_area_sqm' => 'nullable|numeric',
            'capacity' => 'nullable|integer',
            'gate_count' => 'nullable|integer',
            'wing_count' => 'nullable|integer',
            'prayer_hall_count' => 'nullable|integer',
            'tawaf_per_hour' => 'nullable|integer',
            'general_info' => 'nullable|string',
            'available_services' => 'nullable|string',
            'general_statistics' => 'nullable|string',
            'programs_count' => 'nullable|array',
            'current_datetime' => 'nullable|date',
        ]);
        Masjid::create($validated);
        return redirect()->route('masjids.index')->with('success', 'تم إضافة المسجد بنجاح');
    }

    public function show(Masjid $masjid)
    {
        return view('masjids.show', compact('masjid'));
    }

    public function home(Masjid $masjid)
    {
        if (!$masjid) {
            abort(404, 'المسجد غير موجود');
        }
        $programs = $masjid->programs()->latest()->get();
        $announcements = $masjid->announcements()->latest()->get();
        $announcementsArray = $announcements->map(function($a) {
            return [
                'content' => $a->content,
                'is_urgent' => $a->is_urgent,
                'start' => $a->display_start_at,
                'end' => $a->display_end_at,
            ];
        })->values()->all();
        return view('masjids.home', compact('masjid', 'programs', 'announcements', 'announcementsArray'));
    }

    public function display(Request $request, Masjid $masjid)
    {
        if (!$masjid) {
            abort(404, 'المسجد غير موجود');
        }
        
        $type = $request->query('type');
        $filters = $request->except(['type', 'show_all']);
        $showAll = $request->query('show_all', false);
        
        // Calculate actual program counts from database
        $programsCount = $masjid->structuredPrograms()->count();
        $lessonsCount = $masjid->structuredPrograms()
            ->whereHas('programType', function($query) {
                $query->where('name', 'like', '%درس%');
            })->count();
        $circlesCount = $masjid->structuredPrograms()
            ->whereHas('programType', function($query) {
                $query->where('name', 'like', '%حلقة%')
                      ->orWhere('name', 'like', '%تحفيظ%');
            })->count();
        
        // Update masjid programs_count with actual data
        $masjid->programs_count = [
            'programs' => $programsCount,
            'lessons' => $lessonsCount,
            'circles' => $circlesCount
        ];
        
        // Get settings data for navbar
        $iconPath = \App\Models\Setting::get('sidebar_icon_path');
        $iconUrl = $iconPath ? (\Illuminate\Support\Facades\Storage::disk('public')->exists($iconPath) ? \Illuminate\Support\Facades\Storage::disk('public')->url($iconPath) : null) : null;
        $siteName = \App\Models\Setting::get('site_name') ?: 'الهيئة العامة للعناية بشؤون المسجد الحرام والمسجد النبوي';
        
        // Determine which programs to query
        if ($showAll) {
            // Query programs from Al-Haram and Al-Nabawi masjids only
            $query = \App\Models\StructuredProgram::with(['masjid', 'programType', 'section', 'major', 'location', 'teacher', 'book', 'level'])
                ->whereIn('masjid_id', [1, 2])->latest();
        } else {
            // Query programs from specific masjid
            $query = \App\Models\StructuredProgram::with(['masjid', 'programType', 'section', 'major', 'location', 'teacher', 'book', 'level'])
                ->where('masjid_id', $masjid->id)
                ->latest();
        }
        
        // Apply filters from welcome page
        if ($request->filled('program_type')) {
            $query->where('program_type_id', $request->program_type);
        }
        
        if ($request->filled('section')) {
            $query->where('section_id', $request->section);
        }
        
        if ($request->filled('direction')) {
            $query->whereHas('building', function($q) use ($request) {
                $q->where('direction', $request->direction);
            });
        }
        
        if ($request->filled('floors_count')) {
            $query->whereHas('building', function($q) use ($request) {
                $q->where('floors_count', $request->floors_count);
            });
        }
        
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }
        
        $programs = $query->get();
        
        // Group programs by program type
        $programsByType = $programs->groupBy(function($program) {
            return $program->programType ? $program->programType->name : 'غير محدد';
        });
        
        $announcements = $masjid->announcements()->latest()->get();
        $announcementsArray = $announcements->map(function($a) {
            return [
                'content' => $a->content,
                'is_urgent' => $a->is_urgent,
                'start' => $a->display_start_at,
                'end' => $a->display_end_at,
            ];
        })->values()->all();
        
        return view('masjids.display', compact('masjid', 'programsByType', 'announcements', 'announcementsArray', 'type', 'filters', 'showAll', 'iconUrl', 'siteName'));
    }

    public function filterScientific(Request $request, Masjid $masjid)
    {
        $query = $masjid->programs()->where('program_type', 'درس علمي');
        if ($request->filled('field')) $query->where('field', $request->field);
        if ($request->filled('specialty')) $query->where('specialty', $request->specialty);
        if ($request->filled('teacher')) $query->where('teacher', 'like', '%'.$request->teacher.'%');
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('date')) $query->whereDate('date', $request->date);
        $programs = $query->latest()->get();
        return view('masjids.partials.table_scientific_rows', compact('programs'))->render();
    }
    
    public function filterHalaqat(Request $request, Masjid $masjid)
    {
        $query = $masjid->programs()->where('program_type', 'حلقة تحفيظ');
        if ($request->filled('instructor')) $query->where('instructor', 'like', '%'.$request->instructor.'%');
        if ($request->filled('level')) $query->where('level', $request->level);
        if ($request->filled('group')) $query->where('group', $request->group);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('date')) $query->whereDate('date', $request->date);
        $programs = $query->latest()->get();
        return view('masjids.partials.table_halaqat_rows', compact('programs'))->render();
    }

    public function getAnnouncementsApi(Masjid $masjid)
    {
        $announcements = $masjid->announcements()->latest()->get();
        $announcementsArray = $announcements->map(function($a) {
            return [
                'id' => $a->id,
                'content' => $a->content,
                'is_urgent' => $a->is_urgent,
                'start' => $a->display_start_at,
                'end' => $a->display_end_at,
                'updated_at' => $a->updated_at->timestamp,
            ];
        })->values()->all();
        
        return response()->json([
            'announcements' => $announcementsArray,
            'timestamp' => now()->timestamp
        ]);
    }

    // API method for fetching programs
    public function getProgramsApi(Request $request, Masjid $masjid)
    {
        $type = $request->query('type');
        $showAll = $request->query('show_all', false);
        
        // Get current date and weekday
        $currentDate = now()->toDateString();
        $currentWeekday = strtolower(now()->format('l')); // e.g., 'monday', 'tuesday'
        
        // Determine which programs to query
        if ($showAll) {
            $query = \App\Models\StructuredProgram::with(['masjid', 'programType', 'section', 'major', 'location', 'teacher', 'book', 'level'])
                ->whereIn('masjid_id', [1, 2])->latest();
        } else {
            $query = \App\Models\StructuredProgram::with(['masjid', 'programType', 'section', 'major', 'location', 'teacher', 'book', 'level'])
                ->where('masjid_id', $masjid->id)
                ->latest();
        }
        
        // Filter by date range - but exclude Imama programs from date restrictions
        $query->where(function($q) use ($currentDate) {
            // For regular programs: check if current date is within start_date and end_date
            $q->where(function($dateQuery) use ($currentDate) {
                $dateQuery->whereNotNull('start_date')
                         ->whereNotNull('end_date')
                         ->where('start_date', '<=', $currentDate)
                         ->where('end_date', '>=', $currentDate);
            })
            // Include Imama programs (they appear every day without restrictions)
            ->orWhere(function($imamaQuery) {
                $imamaQuery->whereNotNull('date'); // Imama programs have a specific date field
            })
            // Include programs without date restrictions (legacy programs)
            ->orWhere(function($legacyQuery) {
                $legacyQuery->whereNull('start_date')
                           ->whereNull('end_date')
                           ->whereNull('date');
            });
        });
        
        // Apply filters from welcome page
        if ($request->filled('program_type')) {
            $query->where('program_type_id', $request->program_type);
        }
        
        if ($request->filled('section')) {
            $query->where('section_id', $request->section);
        }
        
        if ($request->filled('direction')) {
            $query->whereHas('building', function($q) use ($request) {
                $q->where('direction', $request->direction);
            });
        }
        
        if ($request->filled('floors_count')) {
            $query->whereHas('building', function($q) use ($request) {
                $q->where('floors_count', $request->floors_count);
            });
        }
        
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }
        
        $allPrograms = $query->get();
        
        // Filter programs by weekday for recurring programs
        $programs = $allPrograms->filter(function($program) use ($currentWeekday) {
            // If program has weekdays defined, check if current day is included
            if ($program->weekdays && is_array($program->weekdays)) {
                return in_array($currentWeekday, $program->weekdays);
            }
            // If no weekdays defined (like Imama programs), include the program
            return true;
        });
        
        // Group programs by program type
        $programsByType = $programs->groupBy(function($program) {
            return $program->programType ? $program->programType->name : 'غير محدد';
        });
        
        return response()->json([
            'programs' => $programsByType,
            'timestamp' => now()->timestamp
        ]);
    }
}