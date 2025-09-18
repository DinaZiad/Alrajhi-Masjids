<?php

namespace App\Http\Controllers;

use App\Models\StructuredProgram;
use App\Models\Masjid;
use App\Models\Section;
use App\Models\Major;
use App\Models\Book;
use App\Models\Level;
use App\Models\Teacher;
use App\Models\Building;
use App\Models\ProgramType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StructuredProgramController extends Controller
{
    public function __construct()
    {
        // Middleware for viewing data (index, show)
        $this->middleware(function ($request, $next) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if (!$user->hasPermission('manage_data')) {
                abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة');
            }
            return $next($request);
        })->only(['index', 'show']);
        
        // Middleware for creating data (create, store)
        $this->middleware(function ($request, $next) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if (!$user->hasPermission('add_new_data')) {
                abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة');
            }
            return $next($request);
        })->only(['create', 'store']);
        
        // Middleware for editing/deleting data (edit, update, destroy)
        $this->middleware(function ($request, $next) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if (!$user->hasPermission('manage_data')) {
                abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة');
            }
            return $next($request);
        })->only(['edit', 'update', 'destroy']);
        
        // Middleware for AJAX routes
        $this->middleware(function ($request, $next) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if (!$user->hasPermission('manage_data') && !$user->hasPermission('add_new_data')) {
                abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة');
            }
            return $next($request);
        })->only(['getMajorsBySection', 'getBooksByMajor', 'getTeachersByMasjid']);
    }

    /**
     * Display a listing of structured programs
     */
    public function index(Request $request)
    {
        $query = StructuredProgram::with([
            'masjid',
            'programType',
            'section',
            'major',
            'book',
            'level',
            'teacher',
            'location'
        ]);

        // Apply filters
        if ($request->filled('masjid_id')) {
            $query->where('masjid_id', $request->masjid_id);
        }

        if ($request->filled('program_type_id')) {
            $query->where('program_type_id', $request->program_type_id);
        }

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        if ($request->filled('major_id')) {
            $query->where('major_id', $request->major_id);
        }

        if ($request->filled('teacher')) {
            $query->where('teacher_id', $request->teacher);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('lesson', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('teacher', function ($teacherQuery) use ($search) {
                      $teacherQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $programs = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get filter options
        $masjids = Masjid::orderBy('name')->get();
        $programTypes = ProgramType::orderBy('name')->get();
        $sections = Section::orderBy('name')->get();
        $majors = Major::orderBy('name')->get();
        $teachers = Teacher::orderBy('name')->get();

        return view('admin.structured-programs.index', compact('programs', 'masjids', 'programTypes', 'sections', 'majors', 'teachers'));
    }

    /**
     * Show the form for creating a new structured program
     */
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Filter masjids based on user permissions
        if ($user->role === 'super_admin') {
            $masjids = Masjid::orderBy('name')->get();
        } else {
            // Get masjids that the user has manage_masjid permission for
            $masjidIds = $user->permissions()
                ->where('name', 'manage_masjid')
                ->whereNotNull('admin_permissions.masjid_id')
                ->pluck('admin_permissions.masjid_id')
                ->unique();
            $masjids = Masjid::whereIn('id', $masjidIds)->orderBy('name')->get();
        }
        
        // Filter program types based on user permissions
        if ($user->role === 'super_admin') {
            $programTypes = ProgramType::orderBy('name')->get();
        } else {
            // Get program types that the user has manage_program_types permission for
            $programTypeIds = $user->permissions()
                ->where('name', 'manage_program_types')
                ->whereNotNull('admin_permissions.program_type')
                ->pluck('admin_permissions.program_type')
                ->unique();
            $programTypes = ProgramType::whereIn('id', $programTypeIds)->orderBy('name')->get();
        }
        $sections = Section::orderBy('name')->get();
        $majors = Major::orderBy('name')->get();
        $books = Book::orderBy('title')->get();
        $levels = Level::orderBy('name')->get();
        $teachers = Teacher::with('masjid')->orderBy('name')->get();
        $buildings = Building::with('masjid')->orderBy('building_number')->get();

        $weekdays = [
            'sunday' => 'الأحد',
            'monday' => 'الإثنين',
            'tuesday' => 'الثلاثاء',
            'wednesday' => 'الأربعاء',
            'thursday' => 'الخميس',
            'friday' => 'الجمعة',
            'saturday' => 'السبت',
        ];

        $languages = [
            'العربية' => 'العربية',
            'الإنجليزية' => 'الإنجليزية',
            'الفرنسية' => 'الفرنسية',
            'الأردية' => 'الأردية',
        ];

        $periods = [
            'الفجر' => 'الفجر',
            'الضحى' => 'الضحى',
            'الظهر' => 'الظهر',
            'العصر' => 'العصر',
            'المغرب' => 'المغرب',
            'العشاء' => 'العشاء',
            'بعد العشاء' => 'بعد العشاء',
        ];

        return view('admin.structured-programs.create', compact(
            'masjids', 'programTypes', 'sections', 'majors', 'books', 'levels', 
            'teachers', 'buildings', 'weekdays', 'languages', 'periods'
        ));
    }

    /**
     * Store a newly created structured program
     */
    public function store(Request $request)
    {
        // Check if this is an Imama program type
        $isImama = false;
        if ($request->filled('program_type_id')) {
            $programType = ProgramType::find($request->program_type_id);
            $isImama = $programType && $programType->name === 'إمامة';
        }

        // Base validation rules
        $rules = [
            'masjid_id' => 'required|exists:masjids,id',
            'program_type_id' => 'nullable|exists:program_types,id',
        ];
        
        // Add title and period validation based on program type
        if (!$isImama) {
            $rules['title'] = 'required|string|max:255';
            $rules['period'] = 'required|string|max:100';
        } else {
            $rules['title'] = 'nullable|string|max:255';
            $rules['period'] = 'nullable|string|max:100';
        }

        // Add conditional validation rules based on program type
        if (!$isImama) {
            // These fields are required for non-Imama programs
            $rules = array_merge($rules, [
                'section_id' => 'required|exists:sections,id',
                'major_id' => 'required|exists:majors,id',
                'book_id' => 'required|exists:books,id',
                'level_id' => 'required|exists:levels,id',
                'teacher_id' => 'required|exists:teachers,id',
                'location_id' => 'required|exists:buildings,id',
                'weekdays' => 'required|array|min:1',
                'weekdays.*' => 'string|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
                'lesson' => 'required|string|max:255',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'language' => 'required|string|max:100',
                'sign_language_support' => 'boolean',
                'broadcast_link' => 'nullable|url|max:500',
                'description' => 'nullable|string',

                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'notes' => 'nullable|string',
            ]);
        } else {
            // These fields are optional for Imama programs
            $rules = array_merge($rules, [
                'section_id' => 'nullable|exists:sections,id',
                'major_id' => 'nullable|exists:majors,id',
                'book_id' => 'nullable|exists:books,id',
                'level_id' => 'nullable|exists:levels,id',
                'teacher_id' => 'nullable|exists:teachers,id',
                'location_id' => 'nullable|exists:buildings,id',
                'weekdays' => 'nullable|array',
                'weekdays.*' => 'string|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
                'lesson' => 'nullable|string|max:255',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i|after:start_time',
                'language' => 'nullable|string|max:100',
                'sign_language_support' => 'boolean',
                'broadcast_link' => 'nullable|url|max:500',
                'description' => 'nullable|string',
                'status' => 'nullable|string|in:لم تبدأ,في الموعد,بدأت,تأجلت,اختبار,انتهت',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'notes' => 'nullable|string',
            ]);
        }

        // Add prayer fields validation for Imama program type
        if ($isImama) {
            $rules = array_merge($rules, [
                    'date' => 'nullable|date',
                    'adhan_fajr' => 'nullable|date_format:H:i',
                    'iqama_fajr' => 'nullable|date_format:H:i',
                    'imam_fajr' => 'nullable|string|max:255',
                    'adhan_dhuhr' => 'nullable|date_format:H:i',
                    'iqama_dhuhr' => 'nullable|date_format:H:i',
                    'imam_dhuhr' => 'nullable|string|max:255',
                    'adhan_asr' => 'nullable|date_format:H:i',
                    'iqama_asr' => 'nullable|date_format:H:i',
                    'imam_asr' => 'nullable|string|max:255',
                    'adhan_maghrib' => 'nullable|date_format:H:i',
                    'iqama_maghrib' => 'nullable|date_format:H:i',
                    'imam_maghrib' => 'nullable|string|max:255',
                    'adhan_isha' => 'nullable|date_format:H:i',
                    'iqama_isha' => 'nullable|date_format:H:i',
                    'imam_isha' => 'nullable|string|max:255',
                    'adhan_friday' => 'nullable|date_format:H:i',
                    'iqama_friday' => 'nullable|date_format:H:i',
                    'imam_friday' => 'nullable|string|max:255',
                ]);
        }

        $validated = $request->validate($rules, [
            'title.required' => 'عنوان البرنامج مطلوب',
            'masjid_id.required' => 'المسجد مطلوب',
            'masjid_id.exists' => 'المسجد المحدد غير موجود',
            'program_type_id.exists' => 'نوع البرنامج المحدد غير موجود',
            'section_id.required' => 'القسم مطلوب',
            'major_id.required' => 'التخصص مطلوب',
            'book_id.required' => 'الكتاب مطلوب',
            'level_id.required' => 'المستوى مطلوب',
            'teacher_id.required' => 'المعلم مطلوب',
            'location_id.required' => 'المبنى مطلوب',
            'period.required' => 'الفترة مطلوبة',
            'weekdays.required' => 'أيام الأسبوع مطلوبة',
            'weekdays.min' => 'يجب اختيار يوم واحد على الأقل',
            'lesson.required' => 'الدرس مطلوب',
            'start_time.required' => 'وقت البداية مطلوب',
            'end_time.required' => 'وقت النهاية مطلوب',
            'end_time.after' => 'وقت النهاية يجب أن يكون بعد وقت البداية',
            'language.required' => 'اللغة مطلوبة',
            'start_date.required' => 'تاريخ البداية مطلوب',
            'end_date.required' => 'تاريخ النهاية مطلوب',
            'end_date.after_or_equal' => 'تاريخ النهاية يجب أن يكون بعد أو يساوي تاريخ البداية',
            'broadcast_link.url' => 'رابط البث يجب أن يكون رابطاً صحيحاً',
        ]);

        // Set default values for Imama programs if fields are null
        if ($isImama) {
            $validated['language'] = $validated['language'] ?? 'العربية';
        }
        
        // Always set status to "لم تبدأ" since it's disabled in the form
        $validated['status'] = 'لم تبدأ';

        StructuredProgram::create($validated);

        return redirect()->route('admin.structured-programs.index')
            ->with('success', 'تم إنشاء البرنامج المنظم بنجاح');
    }

    /**
     * Display the specified structured program
     */
    public function show(StructuredProgram $structuredProgram)
    {
        $structuredProgram->load([
            'masjid',
            'programType',
            'section',
            'major',
            'book',
            'level',
            'teacher',
            'location'
        ]);

        return view('admin.structured-programs.show', compact('structuredProgram'));
    }

    /**
     * Show the form for editing the specified structured program
     */
    public function edit(StructuredProgram $structuredProgram)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Filter masjids based on user permissions
        if ($user->role === 'super_admin') {
            $masjids = Masjid::orderBy('name')->get();
        } else {
            // Get masjids that the user has manage_masjid permission for
            $masjidIds = $user->permissions()
                ->where('name', 'manage_masjid')
                ->whereNotNull('admin_permissions.masjid_id')
                ->pluck('admin_permissions.masjid_id')
                ->unique();
            $masjids = Masjid::whereIn('id', $masjidIds)->orderBy('name')->get();
        }
        
        // Filter program types based on user permissions
        if ($user->role === 'super_admin') {
            $programTypes = ProgramType::orderBy('name')->get();
        } else {
            // Get program types that the user has manage_program_types permission for
            $programTypeIds = $user->permissions()
                ->where('name', 'manage_program_types')
                ->whereNotNull('admin_permissions.program_type')
                ->pluck('admin_permissions.program_type')
                ->unique();
            $programTypes = ProgramType::whereIn('id', $programTypeIds)->orderBy('name')->get();
        }
        $sections = Section::orderBy('name')->get();
        $majors = Major::orderBy('name')->get();
        $books = Book::orderBy('title')->get();
        $levels = Level::orderBy('name')->get();
        $teachers = Teacher::with('masjid')->orderBy('name')->get();
        $buildings = Building::with('masjid')->orderBy('building_number')->get();

        $weekdays = [
            'sunday' => 'الأحد',
            'monday' => 'الإثنين',
            'tuesday' => 'الثلاثاء',
            'wednesday' => 'الأربعاء',
            'thursday' => 'الخميس',
            'friday' => 'الجمعة',
            'saturday' => 'السبت',
        ];

        $languages = [
            'العربية' => 'العربية',
            'الإنجليزية' => 'الإنجليزية',
            'الفرنسية' => 'الفرنسية',
            'الأردية' => 'الأردية',
        ];

        $periods = [
            'الفجر' => 'الفجر',
            'الضحى' => 'الضحى',
            'الظهر' => 'الظهر',
            'العصر' => 'العصر',
            'المغرب' => 'المغرب',
            'العشاء' => 'العشاء',
            'بعد العشاء' => 'بعد العشاء',
        ];

        return view('admin.structured-programs.edit', compact(
            'structuredProgram', 'masjids', 'programTypes', 'sections', 'majors', 'books', 
            'levels', 'teachers', 'buildings', 'weekdays', 'languages', 'periods'
        ));
    }

    /**
     * Update the specified structured program
     */
    public function update(Request $request, StructuredProgram $structuredProgram)
    {
        // Check if this is an Imama program type
        $isImama = false;
        if ($request->filled('program_type_id')) {
            $programType = ProgramType::find($request->program_type_id);
            $isImama = $programType && $programType->name === 'إمامة';
        }

        // Base validation rules
        $rules = [
            'masjid_id' => 'required|exists:masjids,id',
            'program_type_id' => 'nullable|exists:program_types,id',
        ];
        
        // Add title and period validation based on program type
        if (!$isImama) {
            $rules['title'] = 'required|string|max:255';
            $rules['period'] = 'required|string|max:100';
        } else {
            $rules['title'] = 'nullable|string|max:255';
            $rules['period'] = 'nullable|string|max:100';
        }

        // Add conditional validation rules based on program type
        if (!$isImama) {
            // These fields are required for non-Imama programs
            $rules = array_merge($rules, [
                'section_id' => 'required|exists:sections,id',
                'major_id' => 'required|exists:majors,id',
                'book_id' => 'required|exists:books,id',
                'level_id' => 'required|exists:levels,id',
                'teacher_id' => 'required|exists:teachers,id',
                'location_id' => 'required|exists:buildings,id',
                'weekdays' => 'required|array|min:1',
                'weekdays.*' => 'string|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
                'lesson' => 'required|string|max:255',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'language' => 'required|string|max:100',
                'sign_language_support' => 'boolean',
                'broadcast_link' => 'nullable|url|max:500',
                'description' => 'nullable|string',

                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'notes' => 'nullable|string',
            ]);
        } else {
            // These fields are optional for Imama programs
            $rules = array_merge($rules, [
                'section_id' => 'nullable|exists:sections,id',
                'major_id' => 'nullable|exists:majors,id',
                'book_id' => 'nullable|exists:books,id',
                'level_id' => 'nullable|exists:levels,id',
                'teacher_id' => 'nullable|exists:teachers,id',
                'location_id' => 'nullable|exists:buildings,id',
                'weekdays' => 'nullable|array',
                'weekdays.*' => 'string|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
                'lesson' => 'nullable|string|max:255',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i|after:start_time',
                'language' => 'nullable|string|max:100',
                'sign_language_support' => 'boolean',
                'broadcast_link' => 'nullable|url|max:500',
                'description' => 'nullable|string',
                'status' => 'nullable|string|in:لم تبدأ,في الموعد,بدأت,تأجلت,اختبار,انتهت',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'notes' => 'nullable|string',
            ]);
        }

        // Add prayer fields validation for Imama program type
        if ($isImama) {
            $rules = array_merge($rules, [
                    'date' => 'nullable|date',
                    'adhan_fajr' => 'nullable|date_format:H:i',
                    'iqama_fajr' => 'nullable|date_format:H:i',
                    'imam_fajr' => 'nullable|string|max:255',
                    'adhan_dhuhr' => 'nullable|date_format:H:i',
                    'iqama_dhuhr' => 'nullable|date_format:H:i',
                    'imam_dhuhr' => 'nullable|string|max:255',
                    'adhan_asr' => 'nullable|date_format:H:i',
                    'iqama_asr' => 'nullable|date_format:H:i',
                    'imam_asr' => 'nullable|string|max:255',
                    'adhan_maghrib' => 'nullable|date_format:H:i',
                    'iqama_maghrib' => 'nullable|date_format:H:i',
                    'imam_maghrib' => 'nullable|string|max:255',
                    'adhan_isha' => 'nullable|date_format:H:i',
                    'iqama_isha' => 'nullable|date_format:H:i',
                    'imam_isha' => 'nullable|string|max:255',
                    'adhan_friday' => 'nullable|date_format:H:i',
                    'iqama_friday' => 'nullable|date_format:H:i',
                    'imam_friday' => 'nullable|string|max:255',
                ]);
        }

        $validated = $request->validate($rules, [
            'title.required' => 'عنوان البرنامج مطلوب',
            'masjid_id.required' => 'المسجد مطلوب',
            'masjid_id.exists' => 'المسجد المحدد غير موجود',
            'program_type_id.exists' => 'نوع البرنامج المحدد غير موجود',
            'section_id.required' => 'القسم مطلوب',
            'major_id.required' => 'التخصص مطلوب',
            'book_id.required' => 'الكتاب مطلوب',
            'level_id.required' => 'المستوى مطلوب',
            'teacher_id.required' => 'المعلم مطلوب',
            'location_id.required' => 'الموقع مطلوب',
            'period.required' => 'الفترة مطلوبة',
            'weekdays.required' => 'أيام الأسبوع مطلوبة',
            'weekdays.min' => 'يجب اختيار يوم واحد على الأقل',
            'lesson.required' => 'الدرس مطلوب',
            'start_time.required' => 'وقت البداية مطلوب',
            'end_time.required' => 'وقت النهاية مطلوب',
            'end_time.after' => 'وقت النهاية يجب أن يكون بعد وقت البداية',
            'language.required' => 'اللغة مطلوبة',
            'start_date.required' => 'تاريخ البداية مطلوب',
            'end_date.required' => 'تاريخ النهاية مطلوب',
            'end_date.after_or_equal' => 'تاريخ النهاية يجب أن يكون بعد أو يساوي تاريخ البداية',
            'broadcast_link.url' => 'رابط البث يجب أن يكون رابطاً صحيحاً',
        ]);

        // Set default values for Imama programs if fields are null
        if ($isImama) {
            $validated['language'] = $validated['language'] ?? 'العربية';
        }
        
        // Always set status to "لم تبدأ" since it's disabled in the form
        $validated['status'] = 'لم تبدأ';

        Log::info('About to update StructuredProgram', [
            'program_id' => $structuredProgram->id,
            'validated_data' => $validated
        ]);
        
        $structuredProgram->update($validated);
        
        Log::info('StructuredProgram updated successfully', [
            'program_id' => $structuredProgram->id
        ]);

        Log::info('Redirecting to index page with success message');
        
        return redirect()->route('admin.structured-programs.index')
            ->with('success', 'تم تحديث البرنامج المنظم بنجاح');
    }

    /**
     * Remove the specified structured program
     */
    public function destroy(StructuredProgram $structuredProgram)
    {
        $structuredProgram->delete();

        return redirect()->route('admin.structured-programs.index')
            ->with('success', 'تم حذف البرنامج المنظم بنجاح');
    }

    /**
     * Update specific fields inline via AJAX
     */
    public function inlineUpdate(Request $request, StructuredProgram $structuredProgram)
    {
        $validated = $request->validate([
            'field' => 'required|string|in:notes,status',
            'value' => 'nullable|string|max:1000',
        ]);

        $structuredProgram->update([
            $validated['field'] => $validated['value']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم التحديث بنجاح',
            'value' => $validated['value'] ?? ''
        ]);
    }

    /**
     * Get majors by section (AJAX)
     */
    public function getMajorsBySection(Request $request)
    {
        $majors = Major::where('section_id', $request->section_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($majors);
    }

    /**
     * Get books by major (AJAX)
     */
    public function getBooksByMajor(Request $request)
    {
        $books = Book::where('major_id', $request->major_id)
            ->orderBy('title')
            ->get(['id', 'title']);

        return response()->json($books);
    }

    /**
     * Get teachers by masjid (AJAX)
     */
    public function getTeachersByMasjid(Request $request)
    {
        $teachers = Teacher::where('masjid_id', $request->masjid_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($teachers);
    }
}