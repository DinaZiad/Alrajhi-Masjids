<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\LectureController;
use App\Models\ProgramType;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Log as FacadesLog;

// Admin Login Route
Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

Route::post('/admin/login', function () {
    $credentials = request()->only('email', 'password');
    
    if (Auth::attempt($credentials, request('remember'))) {
        request()->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }
    
    return back()->withErrors([
        'email' => 'بيانات الدخول غير صحيحة.',
    ]);
})->name('admin.login.post');

// Custom admin logout route
Route::post('/admin/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/admin/login');
})->name('admin.logout');

// Protect all admin dashboard and admin management pages
Route::middleware('auth')->group(function () {
    
    // Admin User Management Routes
    Route::get('/admin/users/create', [\App\Http\Controllers\AdminController::class, 'create_admin'])->name('admin.users.create');

    Route::post('/admin/users', function () {
        // Debug: dump the request data to check the role value
        FacadesLog::info('Admin creation request', request()->all());
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,super_admin',
            'phone' => 'nullable|string|max:20',
            'note' => 'nullable|string',
        ]);
        
        // Create the user
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
            'note' => $validated['note'] ?? null,
        ]);
        
        $permissions = request()->input('permissions', []);
        
        // If super admin and no specific permissions, give all permissions
        if ($user->role === 'super_admin' && empty($permissions)) {
            $allPermissions = \App\Models\Permission::all();
            foreach ($allPermissions as $perm) {
                $user->permissions()->attach($perm->id, [
                    'masjid_id' => null,
                    'program_type' => null
                ]);
            }
        } 
        // If specific permissions are provided
        else if (!empty($permissions)) {
            $syncData = [];
            
            foreach ($permissions as $permissionId => $scopes) {
                // Handle general permissions
                if (isset($scopes['general'])) {
                    $syncData[] = [
                        'permission_id' => $permissionId,
                        'masjid_id' => null,
                        'program_type' => null,
                    ];
                }
                
                // Handle masjid permissions
                if (isset($scopes['masjids'])) {
                    foreach ((array)$scopes['masjids'] as $masjidId) {
                        if ($masjidId !== null) {
                            $syncData[] = [
                                'permission_id' => $permissionId,
                                'masjid_id' => $masjidId,
                                'program_type' => null,
                            ];
                        }
                    }
                }
                
                // Handle program type permissions
                if (isset($scopes['program_types'])) {
                    foreach ((array)$scopes['program_types'] as $programTypeId) {
                        if ($programTypeId !== null) {
                            $syncData[] = [
                                'permission_id' => $permissionId,
                                'masjid_id' => null,
                                'program_type' => $programTypeId,
                            ];
                        }
                    }
                }
            }
            
            // Debug the sync data
            FacadesLog::info('Admin creation sync data', ['syncData' => $syncData]);
            
            // Attach all permissions at once
            foreach ($syncData as $row) {
                $user->permissions()->attach($row['permission_id'], [
                    'masjid_id' => $row['masjid_id'],
                    'program_type' => $row['program_type']
                ]);
            }
        }
        
        return redirect()->route('admin.admins.index')->with('success', 'تم إنشاء المشرف بنجاح');
    })->name('admin.users.store');

    Route::get('/admin/dashboard', function () {
        $masjidsCount = \App\Models\Masjid::count();
        $programsCount = \App\Models\StructuredProgram::count();
        $announcementsCount = \App\Models\Announcement::count();
        $usersCount = \App\Models\User::count();
        return view('admin.dashboard', compact('masjidsCount', 'programsCount', 'announcementsCount', 'usersCount'));
    })->name('admin.dashboard');

    // Admins list page
    Route::get('/admin/admins', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.admins.index');
    // Admin edit/update/delete
    Route::get('/admin/admins/{id}/edit', [\App\Http\Controllers\AdminController::class, 'edit'])->name('admin.admins.edit');
    Route::put('/admin/admins/{id}', [\App\Http\Controllers\AdminController::class, 'update'])->name('admin.admins.update');
    Route::delete('/admin/admins/{id}', [\App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.admins.destroy');
    Route::get('admins/{id}/permissions', [App\Http\Controllers\AdminController::class, 'permissions'])->name('admin.admins.permissions');
    Route::post('admins/{id}/permissions', [App\Http\Controllers\AdminController::class, 'updatePermissions'])->name('admin.admins.permissions.update');


Route::resource('masjids', \App\Http\Controllers\MasjidController::class);
Route::resource('masjids.programs', \App\Http\Controllers\ProgramController::class);
Route::resource('locations', \App\Http\Controllers\LocationController::class);
Route::resource('announcements', AnnouncementController::class);
Route::get('announcements/urgent/create', [AnnouncementController::class, 'createUrgent'])->name('announcements.urgent.create');
Route::post('announcements/urgent', [AnnouncementController::class, 'storeUrgent'])->name('announcements.urgent.store');
Route::resource('lectures', LectureController::class);

    // Buildings Management
    Route::prefix('admin/constants')->name('admin.constants.')->group(function () {
        Route::resource('buildings', \App\Http\Controllers\BuildingController::class)->names('buildings');
    });

    // Constants (الثوابت) - Icons Management
    Route::get('/admin/constants/icons', [\App\Http\Controllers\ConstantsController::class, 'icons'])->name('constants.icons');
    Route::post('/admin/constants/icons', [\App\Http\Controllers\ConstantsController::class, 'updateIcon'])->name('constants.icons.update');
    Route::post('/admin/constants/site-name', [\App\Http\Controllers\ConstantsController::class, 'updateSiteName'])->name('constants.site-name.update');

    // Constants - Hijri Years
    Route::get('/admin/constants/hijri-years', [\App\Http\Controllers\ConstantsController::class, 'hijriYears'])->name('constants.hijri-years');
    Route::get('/admin/constants/hijri-years/{hijriYear}/edit', [\App\Http\Controllers\ConstantsController::class, 'editHijriYear'])->name('constants.hijri-years.edit');
    Route::post('/admin/constants/hijri-years', [\App\Http\Controllers\ConstantsController::class, 'storeHijriYear'])->name('constants.hijri-years.store');
    Route::put('/admin/constants/hijri-years/{hijriYear}', [\App\Http\Controllers\ConstantsController::class, 'updateHijriYear'])->name('constants.hijri-years.update');
    Route::delete('/admin/constants/hijri-years/{hijriYear}', [\App\Http\Controllers\ConstantsController::class, 'destroyHijriYear'])->name('constants.hijri-years.destroy');

    // Constants - Sections
    Route::get('/admin/constants/sections', [\App\Http\Controllers\ConstantsController::class, 'sections'])->name('constants.sections');
    Route::get('/admin/constants/sections/{section}/edit', [\App\Http\Controllers\ConstantsController::class, 'editSection'])->name('constants.sections.edit');
    Route::post('/admin/constants/sections', [\App\Http\Controllers\ConstantsController::class, 'storeSection'])->name('constants.sections.store');
    Route::put('/admin/constants/sections/{section}', [\App\Http\Controllers\ConstantsController::class, 'updateSection'])->name('constants.sections.update');
    Route::delete('/admin/constants/sections/{section}', [\App\Http\Controllers\ConstantsController::class, 'destroySection'])->name('constants.sections.destroy');

    // Constants - Levels
    Route::get('/admin/constants/levels', [\App\Http\Controllers\ConstantsController::class, 'levels'])->name('constants.levels');
    Route::get('/admin/constants/levels/{level}/edit', [\App\Http\Controllers\ConstantsController::class, 'editLevel'])->name('constants.levels.edit');
    Route::post('/admin/constants/levels', [\App\Http\Controllers\ConstantsController::class, 'storeLevel'])->name('constants.levels.store');
    Route::put('/admin/constants/levels/{level}', [\App\Http\Controllers\ConstantsController::class, 'updateLevel'])->name('constants.levels.update');
    Route::delete('/admin/constants/levels/{level}', [\App\Http\Controllers\ConstantsController::class, 'destroyLevel'])->name('constants.levels.destroy');

    // Constants - Majors
    Route::get('/admin/constants/majors', [\App\Http\Controllers\ConstantsController::class, 'majors'])->name('constants.majors');
    Route::get('/admin/constants/majors/{major}/edit', [\App\Http\Controllers\ConstantsController::class, 'editMajor'])->name('constants.majors.edit');
    Route::post('/admin/constants/majors', [\App\Http\Controllers\ConstantsController::class, 'storeMajor'])->name('constants.majors.store');
    Route::put('/admin/constants/majors/{major}', [\App\Http\Controllers\ConstantsController::class, 'updateMajor'])->name('constants.majors.update');
    Route::delete('/admin/constants/majors/{major}', [\App\Http\Controllers\ConstantsController::class, 'destroyMajor'])->name('constants.majors.destroy');

    // Constants - Books
    Route::get('/admin/constants/books', [\App\Http\Controllers\ConstantsController::class, 'books'])->name('constants.books');
    Route::get('/admin/constants/books/{book}/edit', [\App\Http\Controllers\ConstantsController::class, 'editBook'])->name('constants.books.edit');
    Route::post('/admin/constants/books', [\App\Http\Controllers\ConstantsController::class, 'storeBook'])->name('constants.books.store');
    Route::put('/admin/constants/books/{book}', [\App\Http\Controllers\ConstantsController::class, 'updateBook'])->name('constants.books.update');
    Route::delete('/admin/constants/books/{book}', [\App\Http\Controllers\ConstantsController::class, 'destroyBook'])->name('constants.books.destroy');

    // Constants - Program Types (المجالات)
    Route::get('/admin/constants/program-types', [\App\Http\Controllers\ConstantsController::class, 'programTypes'])->name('constants.program-types');
    Route::get('/admin/constants/program-types/{programType}/edit', [\App\Http\Controllers\ConstantsController::class, 'editProgramType'])->name('constants.program-types.edit');
    Route::post('/admin/constants/program-types', [\App\Http\Controllers\ConstantsController::class, 'storeProgramType'])->name('constants.program-types.store');
    Route::put('/admin/constants/program-types/{programType}', [\App\Http\Controllers\ConstantsController::class, 'updateProgramType'])->name('constants.program-types.update');
    Route::delete('/admin/constants/program-types/{programType}', [\App\Http\Controllers\ConstantsController::class, 'destroyProgramType'])->name('constants.program-types.destroy');

    // Constants - Teachers (المعلمين)
    Route::get('/admin/constants/teachers', [\App\Http\Controllers\ConstantsController::class, 'teachers'])->name('constants.teachers');
    Route::get('/admin/constants/teachers/{teacher}/edit', [\App\Http\Controllers\ConstantsController::class, 'editTeacher'])->name('constants.teachers.edit');
    Route::post('/admin/constants/teachers', [\App\Http\Controllers\ConstantsController::class, 'storeTeacher'])->name('constants.teachers.store');
    Route::put('/admin/constants/teachers/{teacher}', [\App\Http\Controllers\ConstantsController::class, 'updateTeacher'])->name('constants.teachers.update');
    Route::delete('/admin/constants/teachers/{teacher}', [\App\Http\Controllers\ConstantsController::class, 'destroyTeacher'])->name('constants.teachers.destroy');

    // Data Management - Programs overview and notes update
    Route::get('/admin/data/programs', [\App\Http\Controllers\StructuredProgramController::class, 'index'])->name('data.programs');
    Route::post('/admin/data/programs/{program}/note', [\App\Http\Controllers\DataManagementController::class, 'updateProgramNote'])->name('data.programs.note');

    // Structured Programs Management
    Route::prefix('admin/structured-programs')->name('admin.structured-programs.')->group(function () {
        Route::get('/', [\App\Http\Controllers\StructuredProgramController::class, 'index'])->name('index'); 
        Route::get('/create', [\App\Http\Controllers\StructuredProgramController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\StructuredProgramController::class, 'store'])->name('store');
        Route::get('/{structuredProgram}', [\App\Http\Controllers\StructuredProgramController::class, 'show'])->name('show');
        Route::get('/{structuredProgram}/edit', [\App\Http\Controllers\StructuredProgramController::class, 'edit'])->name('edit');
        Route::put('/{structuredProgram}', [\App\Http\Controllers\StructuredProgramController::class, 'update'])->name('update');
        Route::delete('/{structuredProgram}', [\App\Http\Controllers\StructuredProgramController::class, 'destroy'])->name('destroy');
        
        // AJAX routes for dynamic dropdowns
        Route::get('/ajax/majors-by-section/{section}', [\App\Http\Controllers\StructuredProgramController::class, 'getMajorsBySection'])->name('ajax.majors-by-section');
        Route::get('/ajax/books-by-major/{major}', [\App\Http\Controllers\StructuredProgramController::class, 'getBooksByMajor'])->name('ajax.books-by-major');
        Route::get('/ajax/teachers-by-masjid/{masjid}', [\App\Http\Controllers\StructuredProgramController::class, 'getTeachersByMasjid'])->name('ajax.teachers-by-masjid');
        
        // AJAX route for inline editing
        Route::patch('/{structuredProgram}/inline-update', [\App\Http\Controllers\StructuredProgramController::class, 'inlineUpdate'])->name('inline-update');
    });

});





Route::get('/', function () {
    // Get filter data for the welcome page
    $masjids = \App\Models\Masjid::all();
    $programTypes = \App\Models\ProgramType::orderBy('name')->get();
    $sections = \App\Models\Section::orderBy('name')->get();
    $locations = \App\Models\Building::with('masjid')->orderBy('building_number')->get();
    
    // Get icon and site name from settings
    $iconPath = \App\Models\Setting::get('sidebar_icon_path');
    $iconUrl = $iconPath ? (\Illuminate\Support\Facades\Storage::disk('public')->exists($iconPath) ? \Illuminate\Support\Facades\Storage::url($iconPath) : null) : null;
    $siteName = \App\Models\Setting::get('site_name') ?: 'الهيئة العامة للعناية بشؤون المسجد الحرام والمسجد النبوي';
    
    return view('welcome', compact('masjids', 'programTypes', 'sections', 'locations', 'iconUrl', 'siteName'));
});


Route::get('/masjids/{masjid}/home', [\App\Http\Controllers\MasjidController::class, 'home'])->name('masjids.home');

Route::get('/masjids/{masjid}/filter/scientific', [\App\Http\Controllers\MasjidController::class, 'filterScientific'])->name('masjids.filter.scientific');
Route::get('/masjids/{masjid}/filter/halaqat', [\App\Http\Controllers\MasjidController::class, 'filterHalaqat'])->name('masjids.filter.halaqat');
Route::get('/masjids/{masjid}/filter/imama', [\App\Http\Controllers\MasjidController::class, 'filterImama'])->name('masjids.filter.imama');
Route::get('/masjids/{masjid}/filter/all', [\App\Http\Controllers\MasjidController::class, 'filterAll'])->name('masjids.filter.all');
    Route::get('/masjids/{masjid}/display', [\App\Http\Controllers\MasjidController::class, 'display'])->name('masjids.display');

// API routes for real-time updates
Route::get('/api/masjids/{masjid}/announcements', [\App\Http\Controllers\MasjidController::class, 'getAnnouncementsApi'])->name('api.masjids.announcements');
Route::get('/api/masjids/{masjid}/programs', [\App\Http\Controllers\MasjidController::class, 'getProgramsApi'])->name('api.masjids.programs');

require __DIR__.'/auth.php';
