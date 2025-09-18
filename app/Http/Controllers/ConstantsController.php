<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;
use App\Models\HijriYear;
use App\Models\Section;
use App\Models\Level;
use App\Models\Major;
use App\Models\Book;
use App\Models\ProgramType;
use App\Models\Teacher;
use App\Models\Masjid;
use Illuminate\Validation\Rule;

class ConstantsController extends Controller
{
    public function icons()
    {
        $iconPath = Setting::get('sidebar_icon_path');
        $iconUrl = $iconPath ? (Storage::disk('public')->exists($iconPath) ? Storage::disk('public')->url($iconPath) : null) : null;
        $siteName = Setting::get('site_name');
        return view('constants.icons', compact('iconUrl', 'siteName'));
    }

    public function updateIcon(Request $request)
    {
        $request->validate([
            // Use mimetypes to allow SVG alongside raster images
            'sidebar_icon' => 'required|mimetypes:image/png,image/jpeg,image/svg+xml|max:2048',
        ], [
            'sidebar_icon.required' => 'يرجى اختيار صورة للرمز',
            'sidebar_icon.mimetypes' => 'الأنواع المسموحة: PNG, JPG, SVG',
            'sidebar_icon.max' => 'الحد الأقصى لحجم الملف 2MB',
        ]);

        $file = $request->file('sidebar_icon');
        $path = $file->store('icons', 'public');

        // Remove old icon if exists and different
        $oldPath = Setting::get('sidebar_icon_path');
        if ($oldPath && $oldPath !== $path && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        Setting::set('sidebar_icon_path', $path);

        return redirect()->route('constants.icons')->with('success', 'تم تحديث الرمز بنجاح');
    }

    public function updateSiteName(Request $request)
    {
        $data = $request->validate([
            'site_name' => 'required|string|max:255',
        ], [
            'site_name.required' => 'يرجى إدخال اسم الهيئة',
            'site_name.max' => 'الحد الأقصى لطول الاسم 255 حرفًا',
        ]);

        Setting::set('site_name', $data['site_name']);

        return redirect()->route('constants.icons')->with('success', 'تم تحديث اسم الهيئة بنجاح');
    }

    public function hijriYears()
    {
        $years = HijriYear::orderByDesc('year')->get();
        return view('constants.hijri-years', compact('years'));
    }

    public function storeHijriYear(Request $request)
    {
        $data = $request->validate([
            'year' => 'required|integer|min:1300|max:1700|unique:hijri_years,year',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'year.required' => 'أدخل السنة الهجرية',
            'year.integer' => 'السنة يجب أن تكون رقمًا',
            'year.unique' => 'السنة موجودة مسبقًا',
            'start_date.required' => 'أدخل تاريخ بداية السنة',
            'end_date.required' => 'أدخل تاريخ نهاية السنة',
            'end_date.after_or_equal' => 'تاريخ النهاية يجب أن يكون بعد أو يساوي البداية',
        ]);

        HijriYear::create($data);
        return redirect()->route('constants.hijri-years')->with('success', 'تمت إضافة السنة بنجاح');
    }

    public function editHijriYear(HijriYear $hijriYear)
    {
        return view('constants.hijri-years-edit', compact('hijriYear'));
    }

    public function updateHijriYear(Request $request, HijriYear $hijriYear)
    {
        $data = $request->validate([
            'year' => 'required|integer|min:1300|max:1700|unique:hijri_years,year,' . $hijriYear->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $hijriYear->update($data);
        return redirect()->route('constants.hijri-years')->with('success', 'تم تحديث السنة بنجاح');
    }

    public function destroyHijriYear(HijriYear $hijriYear)
    {
        $hijriYear->delete();
        return redirect()->route('constants.hijri-years')->with('success', 'تم حذف السنة بنجاح');
    }

    // Sections (الأقسام)
    public function sections()
    {
        $sections = Section::orderByDesc('id')->get();
        return view('constants.sections', compact('sections'));
    }

    public function storeSection(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:sections,name',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'أدخل اسم القسم',
            'name.unique' => 'اسم القسم موجود مسبقًا',
            'name.max' => 'الحد الأقصى لطول الاسم 255 حرفًا',
        ]);

        Section::create($data);
        return redirect()->route('constants.sections')->with('success', 'تمت إضافة القسم بنجاح');
    }

    public function editSection(Section $section)
    {
        return view('constants.sections-edit', compact('section'));
    }

    public function updateSection(Request $request, Section $section)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:sections,name,' . $section->id,
            'description' => 'nullable|string',
        ], [
            'name.required' => 'أدخل اسم القسم',
            'name.unique' => 'اسم القسم موجود مسبقًا',
            'name.max' => 'الحد الأقصى لطول الاسم 255 حرفًا',
        ]);

        $section->update($data);
        return redirect()->route('constants.sections')->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroySection(Section $section)
    {
        $section->delete();
        return redirect()->route('constants.sections')->with('success', 'تم حذف القسم بنجاح');
    }

    // Levels (المستويات)
    public function levels()
    {
        $levels = Level::orderByDesc('id')->get();
        return view('constants.levels', compact('levels'));
    }

    public function storeLevel(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:levels,name',
            'symbol' => 'required|integer|min:0',
        ], [
            'name.required' => 'أدخل اسم المستوى',
            'name.unique' => 'اسم المستوى موجود مسبقًا',
            'name.max' => 'الحد الأقصى لطول الاسم 255 حرفًا',
            'symbol.required' => 'أدخل رمز المستوى',
            'symbol.integer' => 'الرمز يجب أن يكون رقمًا',
        ]);

        Level::create($data);
        return redirect()->route('constants.levels')->with('success', 'تمت إضافة المستوى بنجاح');
    }

    public function editLevel(Level $level)
    {
        return view('constants.levels-edit', compact('level'));
    }

    public function updateLevel(Request $request, Level $level)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:levels,name,' . $level->id,
            'symbol' => 'required|integer|min:0',
        ], [
            'name.required' => 'أدخل اسم المستوى',
            'name.unique' => 'اسم المستوى موجود مسبقًا',
            'name.max' => 'الحد الأقصى لطول الاسم 255 حرفًا',
            'symbol.required' => 'أدخل رمز المستوى',
            'symbol.integer' => 'الرمز يجب أن يكون رقمًا',
        ]);

        $level->update($data);
        return redirect()->route('constants.levels')->with('success', 'تم تحديث المستوى بنجاح');
    }

    public function destroyLevel(Level $level)
    {
        $level->delete();
        return redirect()->route('constants.levels')->with('success', 'تم حذف المستوى بنجاح');
    }

    // Majors (التخصصات)
    public function majors()
    {
        $majors = Major::with('section')->orderByDesc('id')->get();
        $sections = Section::orderBy('name')->get();
        return view('constants.majors', compact('majors', 'sections'));
    }

    public function storeMajor(Request $request)
    {
        $data = $request->validate([
            'section_id' => ['required', 'exists:sections,id'],
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('majors', 'name')->where(fn ($q) => $q->where('section_id', $request->input('section_id'))),
            ],
            'description' => ['nullable', 'string'],
        ], [
            'section_id.required' => 'اختر القسم',
            'section_id.exists' => 'القسم المحدد غير موجود',
            'name.required' => 'أدخل اسم التخصص',
            'name.unique' => 'هذا التخصص موجود ضمن نفس القسم',
            'name.max' => 'الحد الأقصى لطول الاسم 255 حرفًا',
        ]);

        Major::create($data);
        return redirect()->route('constants.majors')->with('success', 'تمت إضافة التخصص بنجاح');
    }

    public function editMajor(Major $major)
    {
        $sections = Section::orderBy('name')->get();
        return view('constants.majors-edit', compact('major', 'sections'));
    }

    public function updateMajor(Request $request, Major $major)
    {
        $data = $request->validate([
            'section_id' => ['required', 'exists:sections,id'],
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('majors', 'name')
                    ->ignore($major->id)
                    ->where(fn ($q) => $q->where('section_id', $request->input('section_id'))),
            ],
            'description' => ['nullable', 'string'],
        ]);

        $major->update($data);
        return redirect()->route('constants.majors')->with('success', 'تم تحديث التخصص بنجاح');
    }

    public function destroyMajor(Major $major)
    {
        $major->delete();
        return redirect()->route('constants.majors')->with('success', 'تم حذف التخصص بنجاح');
    }

    // Books (الكتب)
    public function books()
    {
        $books = Book::with(['major.section'])->orderByDesc('id')->get();
        $sections = Section::orderBy('name')->get();
        $majors = Major::orderBy('name')->get();
        return view('constants.books', compact('books', 'sections', 'majors'));
    }

    public function storeBook(Request $request)
    {
        $data = $request->validate([
            'section_id' => ['required', 'exists:sections,id'],
            'major_id' => [
                'required',
                Rule::exists('majors', 'id')->where(fn ($q) => $q->where('section_id', $request->input('section_id'))),
            ],
            'title' => [
                'required', 'string', 'max:255',
                Rule::unique('books', 'title')->where(fn ($q) => $q->where('major_id', $request->input('major_id'))),
            ],
            'author' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ], [
            'section_id.required' => 'اختر القسم',
            'major_id.required' => 'اختر التخصص',
            'major_id.exists' => 'التخصص المحدد غير موجود ضمن هذا القسم',
            'title.required' => 'أدخل عنوان الكتاب',
            'title.unique' => 'هذا الكتاب موجود ضمن نفس التخصص',
        ]);

        // We don't store section_id in books; ensure integrity via major_id only
        $payload = [
            'major_id' => $data['major_id'],
            'title' => $data['title'],
            'author' => $data['author'] ?? null,
            'description' => $data['description'] ?? null,
        ];

        Book::create($payload);
        return redirect()->route('constants.books')->with('success', 'تمت إضافة الكتاب بنجاح');
    }

    public function editBook(Book $book)
    {
        $sections = Section::orderBy('name')->get();
        $majors = Major::orderBy('name')->get();
        return view('constants.books-edit', compact('book', 'sections', 'majors'));
    }

    public function updateBook(Request $request, Book $book)
    {
        $data = $request->validate([
            'section_id' => ['required', 'exists:sections,id'],
            'major_id' => [
                'required',
                Rule::exists('majors', 'id')->where(fn ($q) => $q->where('section_id', $request->input('section_id'))),
            ],
            'title' => [
                'required', 'string', 'max:255',
                Rule::unique('books', 'title')
                    ->ignore($book->id)
                    ->where(fn ($q) => $q->where('major_id', $request->input('major_id'))),
            ],
            'author' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $payload = [
            'major_id' => $data['major_id'],
            'title' => $data['title'],
            'author' => $data['author'] ?? null,
            'description' => $data['description'] ?? null,
        ];

        $book->update($payload);
        return redirect()->route('constants.books')->with('success', 'تم تحديث الكتاب بنجاح');
    }

    public function destroyBook(Book $book)
    {
        $book->delete();
        return redirect()->route('constants.books')->with('success', 'تم حذف الكتاب بنجاح');
    }

    // Program Types (المجالات)
    public function programTypes()
    {
        $types = ProgramType::orderBy('name')->get();
        return view('constants.program-types', compact('types'));
    }

    public function storeProgramType(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:program_types,name'],
        ], [
            'name.required' => 'أدخل اسم المجال',
            'name.unique' => 'اسم المجال موجود مسبقًا',
            'name.max' => 'الحد الأقصى لطول الاسم 255 حرفًا',
        ]);

        ProgramType::create($data);
        return redirect()->route('constants.program-types')->with('success', 'تمت إضافة المجال بنجاح');
    }

    public function editProgramType(ProgramType $programType)
    {
        return view('constants.program-types-edit', compact('programType'));
    }

    public function updateProgramType(Request $request, ProgramType $programType)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('program_types', 'name')->ignore($programType->id)],
        ]);

        $programType->update($data);
        return redirect()->route('constants.program-types')->with('success', 'تم تحديث المجال بنجاح');
    }

    public function destroyProgramType(ProgramType $programType)
    {
        $programType->delete();
        return redirect()->route('constants.program-types')->with('success', 'تم حذف المجال بنجاح');
    }

    // Teachers (المعلمين)
    public function teachers()
    {
        $teachers = Teacher::with('masjid')->orderByDesc('id')->get();
        $masjids = Masjid::orderBy('name')->get();
        return view('constants.teachers', compact('teachers', 'masjids'));
    }

    public function storeTeacher(Request $request)
    {
        $data = $request->validate([
            'masjid_id' => ['required', 'exists:masjids,id'],
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('teachers', 'name')->where(fn($q) => $q->where('masjid_id', $request->input('masjid_id'))),
            ],
        ], [
            'masjid_id.required' => 'اختر المسجد',
            'masjid_id.exists' => 'المسجد المحدد غير موجود',
            'name.required' => 'أدخل اسم المعلم',
            'name.unique' => 'هذا المعلم موجود لهذا المسجد',
        ]);

        Teacher::create($data);
        return redirect()->route('constants.teachers')->with('success', 'تمت إضافة المعلم بنجاح');
    }

    public function editTeacher(Teacher $teacher)
    {
        $masjids = Masjid::orderBy('name')->get();
        return view('constants.teachers-edit', compact('teacher', 'masjids'));
    }

    public function updateTeacher(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'masjid_id' => ['required', 'exists:masjids,id'],
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('teachers', 'name')
                    ->ignore($teacher->id)
                    ->where(fn($q) => $q->where('masjid_id', $request->input('masjid_id'))),
            ],
        ]);

        $teacher->update($data);
        return redirect()->route('constants.teachers')->with('success', 'تم تحديث بيانات المعلم بنجاح');
    }

    public function destroyTeacher(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('constants.teachers')->with('success', 'تم حذف المعلم بنجاح');
    }
}
