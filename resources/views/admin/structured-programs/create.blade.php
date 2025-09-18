@extends('layouts.admin')

@section('title', 'إضافة برنامج جديد')

@section('content')
@include('components.breadcrumb', [
    'items' => [
        ['title' => 'إدارة البيانات', 'url' => route('admin.structured-programs.index')],
        ['title' => 'إضافة برنامج جديد']
    ]
])
<div style="height:2.5rem;"></div>
<div class="programs-page-container" style="max-width:1200px;margin:0 auto;">
    <div class="programs-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        <h2 class="programs-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:2rem;">إضافة برنامج جديد</h2>
        <form action="{{ route('admin.structured-programs.store') }}" method="POST" id="structuredProgramForm">
            @csrf
                        
                        <!-- Basic Information Section -->
                        <div class="form-section mb-5">
                            <h5 class="section-title mb-4" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;border-bottom:2px solid #d4af37;padding-bottom:8px;">المعلومات الأساسية</h5>
                            <div class="row g-4">
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">عنوان البرنامج <span style="color:#e74c3c">*</span></label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-book input-inside-icon"></i>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;">
                                    </div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المسجد <span style="color:#e74c3c">*</span></label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-mosque input-inside-icon"></i>
                                        <select name="masjid_id" id="masjid_id" class="form-select @error('masjid_id') is-invalid @enderror" required style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" onchange="loadTeachersByMasjid(this.value); loadBuildingsByMasjid(this.value);">
                                            <option value="">اختر المسجد</option>
                                            @foreach($masjids as $masjid)
                                                <option value="{{ $masjid->id }}" {{ old('masjid_id') == $masjid->id ? 'selected' : '' }}>{{ $masjid->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('masjid_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">نوع البرنامج</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-tags input-inside-icon"></i>
                                        <select name="program_type_id" class="form-select @error('program_type_id') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;">
                                            <option value="">اختر نوع البرنامج</option>
                                            @foreach($programTypes as $programType)
                                                <option value="{{ $programType->id }}" {{ old('program_type_id') == $programType->id ? 'selected' : '' }}>{{ $programType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('program_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الفترة</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-clock input-inside-icon"></i>
                                        <select name="period" class="form-select @error('period') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                            <option value="">اختر الفترة</option>
                                            @foreach($periods as $key => $period)
                                                <option value="{{ $key }}" {{ old('period') == $key ? 'selected' : '' }}>{{ $period }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('period')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Academic Content Section -->
                        <div class="form-section mb-5">
                            <h5 class="section-title mb-4" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;border-bottom:2px solid #d4af37;padding-bottom:8px;">المحتوى الأكاديمي</h5>
                            <div class="row g-4">
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">القسم</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-layer-group input-inside-icon"></i>
                                        <select name="section_id" id="section_id" class="form-select @error('section_id') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" onchange="loadMajorsBySection(this.value)" required>
                                            <option value="">اختر القسم</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('section_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">التخصص</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-graduation-cap input-inside-icon"></i>
                                        <select name="major_id" id="major_select" class="form-select @error('major_id') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" onchange="loadBooksByMajor(this.value)" required>
                                            <option value="">اختر التخصص</option>
                                            @foreach($majors as $major)
                                                <option value="{{ $major->id }}" data-section="{{ $major->section_id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('major_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الكتاب</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-book-open input-inside-icon"></i>
                                        <select name="book_id" id="book_select" class="form-select @error('book_id') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                            <option value="">اختر الكتاب</option>
                                            @foreach($books as $book)
                                                <option value="{{ $book->id }}" data-major="{{ $book->major_id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>{{ $book->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('book_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-4 mt-2">
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الدرس</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-chalkboard-teacher input-inside-icon"></i>
                                        <input type="text" name="lesson" class="form-control @error('lesson') is-invalid @enderror" value="{{ old('lesson') }}" placeholder="أدخل اسم الدرس" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                    </div>
                                    @error('lesson')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المستوى</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-signal input-inside-icon"></i>
                                        <select name="level_id" class="form-select @error('level_id') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                            <option value="">اختر المستوى</option>
                                            @foreach($levels as $level)
                                                <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('level_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اللغة</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-language input-inside-icon"></i>
                                        <select name="language" class="form-select @error('language') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                            <option value="">اختر اللغة</option>
                                            @foreach($languages as $key => $language)
                                                <option value="{{ $key }}" {{ old('language') == $key ? 'selected' : '' }}>{{ $language }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Schedule & Timing Section -->
                        <div class="form-section mb-5">
                            <h5 class="section-title mb-4" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;border-bottom:2px solid #d4af37;padding-bottom:8px;">الجدولة والتوقيت</h5>
                            <div class="row g-4">
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">وقت البداية</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-clock input-inside-icon"></i>
                                        <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time') }}" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                    </div>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">وقت النهاية</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-clock input-inside-icon"></i>
                                        <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time') }}" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                    </div>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">تاريخ البداية</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-calendar-alt input-inside-icon"></i>
                                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                    </div>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">تاريخ النهاية</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-calendar-alt input-inside-icon"></i>
                                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                    </div>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-4 mt-2">
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المحاضر</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-user-tie input-inside-icon"></i>
                                        <select name="teacher_id" id="teacher_select" class="form-select @error('teacher_id') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                            <option value="">اختر المحاضر</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" data-masjid="{{ $teacher->masjid_id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }} - {{ $teacher->masjid->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('teacher_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المبنى</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-building input-inside-icon"></i>
                                        <select name="location_id" id="building_select" class="form-select @error('location_id') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                            <option value="">اختر المبنى</option>
                                            @foreach($buildings as $building)
                                        <option value="{{ $building->id }}" data-masjid="{{ $building->masjid_id }}" {{ old('location_id') == $building->id ? 'selected' : '' }}>{{ $building->direction }} - {{ $building->building_number }} - {{ $building->floors_count }} - {{ $building->masjid->name }}</option>
                                    @endforeach
                                        </select>
                                    </div>
                                    @error('location_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Program Settings Section -->
                        <div class="form-section mb-5">
                            <h5 class="section-title mb-4" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;border-bottom:2px solid #d4af37;padding-bottom:8px;">إعدادات البرنامج</h5>
                            <div class="row g-4">
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الحالة <span style="color:#e74c3c">*</span></label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-toggle-on input-inside-icon"></i>
                                        <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" value="لم تبدأ" readonly disabled style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;background-color:#f8f9fa;">
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">أيام الأسبوع</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-calendar-week input-inside-icon"></i>
                                        <select name="weekdays[]" class="form-select @error('weekdays') is-invalid @enderror" multiple style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;min-height:120px;" required>
                                            @foreach($weekdays as $key => $day)
                                                <option value="{{ $key }}" {{ in_array($key, old('weekdays', [])) ? 'selected' : '' }}>{{ $day }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('weekdays')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="form-section mb-5">
                            <h5 class="section-title mb-4" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;border-bottom:2px solid #d4af37;padding-bottom:8px;">معلومات إضافية</h5>
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">رابط البث</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-link input-inside-icon"></i>
                                        <input type="url" name="broadcast_link" class="form-control @error('broadcast_link') is-invalid @enderror" value="{{ old('broadcast_link') }}" placeholder="https://example.com/broadcast" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;">
                                    </div>
                                    @error('broadcast_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-4 mt-2">
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">وصف البرنامج</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-align-left input-inside-icon"></i>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;">{{ old('description') }}</textarea>
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">ملاحظات</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-sticky-note input-inside-icon"></i>
                                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="4" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;">{{ old('notes') }}</textarea>
                                    </div>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-4 mt-2">
                                <div class="col-12">
                                    <div class="form-check" style="background:#f8f9fa;padding:15px;border-radius:12px;border:2px solid #d4af37;">
                                        <input class="form-check-input" type="checkbox" name="sign_language_support" value="1" id="sign_language_support" {{ old('sign_language_support') ? 'checked' : '' }} style="border:2px solid #d4af37;transform:scale(1.2);">
                                        <label class="form-check-label" for="sign_language_support" style="color:#174032;font-family:'Cairo',sans-serif;font-weight:600;margin-right:10px;">
                                            <i class="fas fa-hands" style="color:#d4af37;margin-left:8px;"></i>
                                            دعم لغة الإشارة
                                        </label>
                                    </div>
                                    @error('sign_language_support')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Prayer Fields Section (for Imama program type) -->
                        <div class="form-section mb-5" id="prayer-fields-section" style="display: none;">
                            <h5 class="section-title mb-4" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;border-bottom:2px solid #d4af37;padding-bottom:8px;">أوقات الصلاة والأئمة</h5>
                            
                            <!-- Date Field -->
                            <div class="row g-4 mb-4">
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">التاريخ</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-calendar input-inside-icon"></i>
                                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;">
                                    </div>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Prayer Times Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered" style="border:2px solid #d4af37;border-radius:12px;overflow:hidden;">
                                    <thead style="background:linear-gradient(135deg, #d4af37 0%, #C9B037 100%);color:#174032;">
                                        <tr>
                                            <th style="font-family:'Cairo',sans-serif;font-weight:700;text-align:center;padding:15px;">الصلاة</th>
                                            <th style="font-family:'Cairo',sans-serif;font-weight:700;text-align:center;padding:15px;">الأذان</th>
                                            <th style="font-family:'Cairo',sans-serif;font-weight:700;text-align:center;padding:15px;">الإقامة</th>
                                            <th style="font-family:'Cairo',sans-serif;font-weight:700;text-align:center;padding:15px;">الإمام</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background:white;">
                                        <!-- Fajr Prayer -->
                                        <tr>
                                            <td style="background:#f8f9fa;font-family:'Cairo',sans-serif;font-weight:600;color:#174032;text-align:center;padding:15px;vertical-align:middle;">
                                                <i class="fas fa-sun" style="color:#d4af37;margin-left:8px;"></i>صلاة الفجر
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="adhan_fajr" class="form-control @error('adhan_fajr') is-invalid @enderror" value="{{ old('adhan_fajr') }}" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('adhan_fajr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="iqama_fajr" class="form-control @error('iqama_fajr') is-invalid @enderror" value="{{ old('iqama_fajr') }}" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('iqama_fajr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="text" name="imam_fajr" class="form-control @error('imam_fajr') is-invalid @enderror" value="{{ old('imam_fajr') }}" placeholder="اسم الإمام" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('imam_fajr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <!-- Dhuhr Prayer -->
                                        <tr>
                                            <td style="background:#f8f9fa;font-family:'Cairo',sans-serif;font-weight:600;color:#174032;text-align:center;padding:15px;vertical-align:middle;">
                                                <i class="fas fa-sun" style="color:#d4af37;margin-left:8px;"></i>صلاة الظهر
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="adhan_dhuhr" class="form-control @error('adhan_dhuhr') is-invalid @enderror" value="{{ old('adhan_dhuhr') }}" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('adhan_dhuhr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="iqama_dhuhr" class="form-control @error('iqama_dhuhr') is-invalid @enderror" value="{{ old('iqama_dhuhr') }}" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('iqama_dhuhr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="text" name="imam_dhuhr" class="form-control @error('imam_dhuhr') is-invalid @enderror" value="{{ old('imam_dhuhr') }}" placeholder="اسم الإمام" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('imam_dhuhr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <!-- Asr Prayer -->
                                        <tr>
                                            <td style="background:#f8f9fa;font-family:'Cairo',sans-serif;font-weight:600;color:#174032;text-align:center;padding:15px;vertical-align:middle;">
                                                <i class="fas fa-sun" style="color:#d4af37;margin-left:8px;"></i>صلاة العصر
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="adhan_asr" class="form-control @error('adhan_asr') is-invalid @enderror" value="{{ old('adhan_asr') }}" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('adhan_asr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="iqama_asr" class="form-control @error('iqama_asr') is-invalid @enderror" value="{{ old('iqama_asr') }}" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('iqama_asr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="text" name="imam_asr" class="form-control @error('imam_asr') is-invalid @enderror" value="{{ old('imam_asr') }}" placeholder="اسم الإمام" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('imam_asr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <!-- Maghrib Prayer -->
                                        <tr>
                                            <td style="background:#f8f9fa;font-family:'Cairo',sans-serif;font-weight:600;color:#174032;text-align:center;padding:15px;vertical-align:middle;">
                                                <i class="fas fa-moon" style="color:#d4af37;margin-left:8px;"></i>صلاة المغرب
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="adhan_maghrib" class="form-control @error('adhan_maghrib') is-invalid @enderror" value="{{ old('adhan_maghrib') }}" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('adhan_maghrib')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="iqama_maghrib" class="form-control @error('iqama_maghrib') is-invalid @enderror" value="{{ old('iqama_maghrib') }}" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('iqama_maghrib')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="text" name="imam_maghrib" class="form-control @error('imam_maghrib') is-invalid @enderror" value="{{ old('imam_maghrib') }}" placeholder="اسم الإمام" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('imam_maghrib')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <!-- Isha Prayer -->
                                        <tr>
                                            <td style="background:#f8f9fa;font-family:'Cairo',sans-serif;font-weight:600;color:#174032;text-align:center;padding:15px;vertical-align:middle;">
                                                <i class="fas fa-moon" style="color:#d4af37;margin-left:8px;"></i>صلاة العشاء
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="adhan_isha" class="form-control @error('adhan_isha') is-invalid @enderror" value="{{ old('adhan_isha') }}" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('adhan_isha')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="iqama_isha" class="form-control @error('iqama_isha') is-invalid @enderror" value="{{ old('iqama_isha') }}" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                @error('iqama_isha')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                 <input type="text" name="imam_isha" class="form-control @error('imam_isha') is-invalid @enderror" value="{{ old('imam_isha') }}" placeholder="اسم الإمام" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                 @error('imam_isha')
                                                     <div class="invalid-feedback">{{ $message }}</div>
                                                 @enderror
                                             </td>
                                         </tr>
                                         <!-- Friday Prayer -->
                                         <tr>
                                             <td style="background:#f8f9fa;font-family:'Cairo',sans-serif;font-weight:600;color:#174032;text-align:center;padding:15px;vertical-align:middle;">
                                                 <i class="fas fa-calendar" style="color:#d4af37;margin-left:8px;"></i>صلاة الجمعة
                                             </td>
                                             <td style="padding:10px;">
                                                 <input type="time" name="adhan_friday" class="form-control @error('adhan_friday') is-invalid @enderror" value="{{ old('adhan_friday') }}" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                 @error('adhan_friday')
                                                     <div class="invalid-feedback">{{ $message }}</div>
                                                 @enderror
                                             </td>
                                             <td style="padding:10px;">
                                                 <input type="time" name="iqama_friday" class="form-control @error('iqama_friday') is-invalid @enderror" value="{{ old('iqama_friday') }}" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                 @error('iqama_friday')
                                                     <div class="invalid-feedback">{{ $message }}</div>
                                                 @enderror
                                             </td>
                                             <td style="padding:10px;">
                                                 <input type="text" name="imam_friday" class="form-control @error('imam_friday') is-invalid @enderror" value="{{ old('imam_friday') }}" placeholder="اسم الإمام" style="border:1px solid #d4af37;border-radius:8px;font-family:'Cairo',sans-serif;">
                                                 @error('imam_friday')
                                                     <div class="invalid-feedback">{{ $message }}</div>
                                                 @enderror
                                             </td>
                                         </tr>
                                     </tbody>
                                 </table>
                             </div>
                          </div>

                        <div class="programs-form-actions" style="text-align:center;margin-top:2.5rem;padding-top:2rem;border-top:2px solid #e5e7eb;">
                            <button type="submit" class="programs-btn programs-btn-primary" style="background:#d4af37;color:#174032;border:none;padding:0.9rem 2.5rem;border-radius:12px;font-weight:700;font-family:'Cairo',sans-serif;font-size:1rem;margin-left:1rem;transition:all 0.3s ease;">
                                <i class="fas fa-save" style="margin-left:0.5rem;"></i>
                                حفظ البرنامج
                            </button>
                            <a href="{{ route('admin.structured-programs.index') }}" class="programs-btn programs-btn-secondary" style="background:#6b7280;color:white;border:none;padding:0.9rem 2.5rem;border-radius:12px;font-weight:700;font-family:'Cairo',sans-serif;font-size:1rem;text-decoration:none;display:inline-block;transition:all 0.3s ease;">
                                <i class="fas fa-times" style="margin-left:0.5rem;"></i>
                                إلغاء
                            </a>
                        </div>
                    </form>
    </div>
</div>

<style>
    .programs-page-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 20px;
    }
    .programs-table-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        padding: 40px;
        margin-bottom: 30px;
        border: 1px solid rgba(212, 175, 55, 0.1);
    }
    .form-section {
        background: rgba(248, 249, 250, 0.5);
        border-radius: 15px;
        padding: 25px;
        border: 1px solid rgba(212, 175, 55, 0.15);
        transition: all 0.3s ease;
    }
    .form-section:hover {
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.1);
        transform: translateY(-2px);
    }
    .section-title {
        position: relative;
        padding-left: 15px;
    }
    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 20px;
        background: linear-gradient(135deg, #d4af37, #C9B037);
        border-radius: 2px;
    }
    .input-icon-wrapper {
        position: relative;
    }
    .input-inside-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #C9B037;
        z-index: 10;
        pointer-events: none;
        font-size: 16px;
    }
    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid #e9ecef;
        font-family: 'Cairo', sans-serif;
        padding: 14px 45px 14px 15px;
        transition: all 0.3s ease;
        background: white;
    }
    .form-control:focus, .form-select:focus {
        border-color: #d4af37;
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.15);
        background: #fefefe;
    }
    .form-control:hover, .form-select:hover {
        border-color: #d4af37;
    }
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    .form-label {
        color: #174032;
        font-weight: 700;
        font-family: 'Cairo', sans-serif;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .programs-btn-primary {
        background: linear-gradient(135deg, #d4af37 0%, #C9B037 100%);
        border: none;
        border-radius: 12px;
        padding: 14px 35px;
        font-family: 'Cairo', sans-serif;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
    }
    .programs-btn-primary:hover {
        background: linear-gradient(135deg, #C9B037 0%, #b8a032 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
    }
    .programs-btn-secondary {
        background: #6c757d;
        border: none;
        border-radius: 12px;
        padding: 14px 35px;
        font-family: 'Cairo', sans-serif;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .programs-btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-1px);
    }
    .row {
        margin: 0;
    }
    .row .col-lg-3, .row .col-lg-4, .row .col-lg-6, .row .col-md-6, .row .col-md-12, .row .col-12 {
        padding: 0 10px;
    }
    @media (max-width: 768px) {
        .programs-table-card {
            padding: 25px 20px;
            margin: 10px;
            border-radius: 15px;
        }
        .form-section {
            padding: 20px 15px;
        }
        .row .col-lg-3, .row .col-lg-4, .row .col-lg-6, .row .col-md-6, .row .col-md-12, .row .col-12 {
            padding: 0 5px;
            margin-bottom: 15px;
        }
    }
</style>

<script>
function loadMajorsBySection(sectionId) {
    const majorSelect = document.getElementById('major_select');
    const bookSelect = document.getElementById('book_select');
    
    // Reset major and book selects
    majorSelect.value = '';
    bookSelect.value = '';
    
    // Hide all major options
    Array.from(majorSelect.options).forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
        } else {
            option.style.display = option.dataset.section == sectionId ? 'block' : 'none';
        }
    });
    
    // Hide all book options
    Array.from(bookSelect.options).forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });
}

function loadBooksByMajor(majorId) {
    const bookSelect = document.getElementById('book_select');
    
    // Reset book select
    bookSelect.value = '';
    
    // Show/hide book options based on major
    Array.from(bookSelect.options).forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
        } else {
            option.style.display = option.dataset.major == majorId ? 'block' : 'none';
        }
    });
}

function loadTeachersByMasjid(masjidId) {
    const teacherSelect = document.getElementById('teacher_select');
    
    // Reset teacher select
    teacherSelect.value = '';
    
    // Show/hide teacher options based on masjid
    Array.from(teacherSelect.options).forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
        } else {
            option.style.display = option.dataset.masjid == masjidId ? 'block' : 'none';
        }
    });
}

function loadBuildingsByMasjid(masjidId) {
    const buildingSelect = document.getElementById('building_select');
    
    // Reset building select
    buildingSelect.value = '';
    
    // Show/hide building options based on masjid
    Array.from(buildingSelect.options).forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
        } else {
            option.style.display = option.dataset.masjid == masjidId ? 'block' : 'none';
        }
    });
}

function togglePrayerFields() {
    const programTypeSelect = document.querySelector('select[name="program_type_id"]');
    const prayerFieldsSection = document.getElementById('prayer-fields-section');
    
    if (programTypeSelect && prayerFieldsSection) {
        const selectedOption = programTypeSelect.options[programTypeSelect.selectedIndex];
        const programTypeName = selectedOption ? selectedOption.text : '';
        
        // Show prayer fields if 'إمامة' is selected
        if (programTypeName === 'إمامة') {
            prayerFieldsSection.style.display = 'block';
            hideNonEssentialFields(true);
        } else {
            prayerFieldsSection.style.display = 'none';
            hideNonEssentialFields(false);
        }
    }
}

function hideNonEssentialFields(isImama) {
    // Hide title and period fields
    const titleField = document.querySelector('input[name="title"]');
    if (titleField) {
        const titleGroup = titleField.closest('.col-lg-6, .col-md-12');
        if (titleGroup) {
            titleGroup.style.display = isImama ? 'none' : 'block';
        }
        // Handle required attribute for title
        if (isImama) {
            if (titleField.hasAttribute('required')) {
                titleField.setAttribute('data-was-required', 'true');
            }
            titleField.removeAttribute('required');
        } else {
            if (titleField.getAttribute('data-was-required') === 'true') {
                titleField.setAttribute('required', 'required');
            }
        }
    }
    
    const periodField = document.querySelector('select[name="period"]');
    if (periodField) {
        const periodGroup = periodField.closest('.col-lg-3, .col-md-6');
        if (periodGroup) {
            periodGroup.style.display = isImama ? 'none' : 'block';
        }
        // Handle required attribute for period
        if (isImama) {
            if (periodField.hasAttribute('required')) {
                periodField.setAttribute('data-was-required', 'true');
            }
            periodField.removeAttribute('required');
        } else {
            if (periodField.getAttribute('data-was-required') === 'true') {
                periodField.setAttribute('required', 'required');
            }
        }
    }
    
    // Hide entire sections with their headers
    const sectionsToHide = [
        // Find sections by their header text
        { header: 'المحتوى الأكاديمي', selector: '.form-section' },
        { header: 'الجدولة والتوقيت', selector: '.form-section' },
        { header: 'إعدادات البرنامج', selector: '.form-section' },
        { header: 'معلومات إضافية', selector: '.form-section' }
    ];
    
    sectionsToHide.forEach(sectionInfo => {
        const headers = document.querySelectorAll('h5.section-title');
        headers.forEach(header => {
            if (header.textContent.trim() === sectionInfo.header) {
                const section = header.closest(sectionInfo.selector);
                if (section) {
                    section.style.display = isImama ? 'none' : 'block';
                    
                    // Remove required attributes from all fields in this section
                    const fields = section.querySelectorAll('input, select, textarea');
                    fields.forEach(field => {
                        if (isImama) {
                            if (field.hasAttribute('required')) {
                                field.setAttribute('data-was-required', 'true');
                            }
                            field.removeAttribute('required');
                        } else {
                            if (field.getAttribute('data-was-required') === 'true') {
                                field.setAttribute('required', 'required');
                            }
                        }
                    });
                }
            }
        });
    });
    
    // List of individual form fields to hide for Imama program type (fallback)
    const fieldsToHide = [
        'select[name="section_id"]',
        'select[name="major_id"]',
        'select[name="book_id"]',
        'input[name="lesson"]',
        'select[name="level_id"]',
        'select[name="language_id"]',
        'input[name="start_time"]',
        'input[name="end_time"]',
        'input[name="start_date"]',
        'input[name="end_date"]',
        'select[name="teacher_id"]',
        'select[name="building_id"]',
        'select[name="status"]',
        'input[name="broadcast_link"]',
        'textarea[name="description"]',
        'textarea[name="notes"]',
        'input[name="sign_language_support"]'
    ];
    
    fieldsToHide.forEach(selector => {
        const field = document.querySelector(selector);
        if (field) {
            const formGroup = field.closest('.col-lg-3, .col-lg-4, .col-lg-6, .col-md-6, .col-md-12, .col-12');
            if (formGroup) {
                formGroup.style.display = isImama ? 'none' : 'block';
            }
            
            // Handle required attribute
            if (isImama) {
                if (field.hasAttribute('required')) {
                    field.setAttribute('data-was-required', 'true');
                }
                field.removeAttribute('required');
            } else {
                if (field.getAttribute('data-was-required') === 'true') {
                    field.setAttribute('required', 'required');
                }
            }
        }
    });
    
    // Handle weekdays checkboxes separately
    const weekdayCheckboxes = document.querySelectorAll('input[name="weekdays[]"]');
    weekdayCheckboxes.forEach(checkbox => {
        const weekdaysSection = checkbox.closest('.form-section');
        if (weekdaysSection) {
            weekdaysSection.style.display = isImama ? 'none' : 'block';
        }
        
        // Handle required attribute for weekdays
        if (isImama) {
            if (checkbox.hasAttribute('required')) {
                checkbox.setAttribute('data-was-required', 'true');
            }
            checkbox.removeAttribute('required');
        } else {
            if (checkbox.getAttribute('data-was-required') === 'true') {
                checkbox.setAttribute('required', 'required');
            }
        }
    });
    
    // Handle sign language checkbox
    const signLanguageContainer = document.querySelector('input[name="sign_language_support"]');
    if (signLanguageContainer) {
        const signLanguageSection = signLanguageContainer.closest('.col-12');
        if (signLanguageSection) {
            signLanguageSection.style.display = isImama ? 'none' : 'block';
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initially show all options
    const majorSelect = document.getElementById('major_select');
    const bookSelect = document.getElementById('book_select');
    const teacherSelect = document.getElementById('teacher_select');
    const buildingSelect = document.getElementById('building_select');
    
    // Show all options initially
    [majorSelect, bookSelect, teacherSelect, buildingSelect].forEach(select => {
        Array.from(select.options).forEach(option => {
            option.style.display = 'block';
        });
    });
    
    // If there are old values, trigger the cascading selects
    const sectionSelect = document.querySelector('select[name="section_id"]');
    const masjidSelect = document.querySelector('select[name="masjid_id"]');
    
    if (sectionSelect.value) {
        loadMajorsBySection(sectionSelect.value);
    }
    
    if (majorSelect.value) {
        loadBooksByMajor(majorSelect.value);
    }
    
    if (masjidSelect.value) {
        loadTeachersByMasjid(masjidSelect.value);
        loadBuildingsByMasjid(masjidSelect.value);
    }
    
    // Add event listener for program type change
    const programTypeSelect = document.querySelector('select[name="program_type_id"]');
    if (programTypeSelect) {
        programTypeSelect.addEventListener('change', togglePrayerFields);
        // Check initial state
        togglePrayerFields();
    }
});
</script>
@endsection