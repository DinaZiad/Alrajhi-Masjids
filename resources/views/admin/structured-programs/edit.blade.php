@extends('layouts.admin')

@section('title', 'تعديل برنامج')

@section('content')
<div class="programs-page-container" style="max-width:1200px;margin:0 auto;">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom:1.5rem;border-radius:12px;">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom:1.5rem;border-radius:12px;">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom:1.5rem;border-radius:12px;">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>يرجى تصحيح الأخطاء التالية:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="programs-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        <h2 class="programs-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:2rem;">تعديل برنامج: {{ $structuredProgram->title }}</h2>
        <form action="{{ route('admin.structured-programs.update', $structuredProgram) }}" method="POST" id="structuredProgramForm">
            @csrf
            @method('PUT')
                        
                        <!-- Basic Information Section -->
                        <div class="form-section mb-5">
                            <h5 class="section-title mb-4" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;border-bottom:2px solid #d4af37;padding-bottom:8px;">المعلومات الأساسية</h5>
                            <div class="row g-4">
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المسجد <span style="color:#e74c3c">*</span></label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-mosque input-inside-icon"></i>
                                        <select name="masjid_id" id="masjid_id" class="form-select @error('masjid_id') is-invalid @enderror" required style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" onchange="loadTeachersByMasjid(this.value); loadBuildingsByMasjid(this.value);">
                                            <option value="">اختر المسجد</option>
                                            @foreach($masjids as $masjid)
                                                <option value="{{ $masjid->id }}" {{ old('masjid_id', $structuredProgram->masjid_id) == $masjid->id ? 'selected' : '' }}>{{ $masjid->name }}</option>
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
                                        <select name="program_type_id" id="program_type_id" class="form-select @error('program_type_id') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" onchange="toggleProgramTypeFields()">
                                            <option value="">اختر نوع البرنامج</option>
                                            @foreach($programTypes as $programType)
                                                <option value="{{ $programType->id }}" {{ old('program_type_id', $structuredProgram->program_type_id) == $programType->id ? 'selected' : '' }}>{{ $programType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('program_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Program Title Field (initially hidden) -->
                                <div class="col-lg-3 col-md-6" id="program_title_field" style="display: none;">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اسم الحلقة <span style="color:#e74c3c">*</span></label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-tag input-inside-icon"></i>
                                        <input type="text" name="title" id="program_title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $structuredProgram->title) }}" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" placeholder="أدخل اسم الحلقة">
                                    </div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المبنى</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-building input-inside-icon"></i>
                                        <select name="location_id" id="building_select" class="form-select @error('location_id') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                            <option value="">اختر المبنى</option>
                                            @foreach($buildings as $building)
                                        <option value="{{ $building->id }}" data-masjid="{{ $building->masjid_id }}" {{ old('location_id', $structuredProgram->location_id) == $building->id ? 'selected' : '' }}>{{ $building->direction }} - {{ $building->building_number }} - {{ $building->floors_count }} - {{ $building->masjid->name }}</option>
                                    @endforeach
                                        </select>
                                    </div>
                                    @error('location_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Academic Content Section -->
                        <div class="form-section mb-5">
                            <h5 class="section-title mb-4" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;border-bottom:2px solid #d4af37;padding-bottom:8px;">المحتوى الأكاديمي</h5>
                            <!-- First Row: القسم التخصص الكتاب الدرس -->
                            <div class="row g-4">
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">القسم</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-layer-group input-inside-icon"></i>
                                        <select name="section_id" id="section_id" class="form-select @error('section_id') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" onchange="loadMajorsBySection(this.value)" required data-was-required-halaqat="true">
                                            <option value="">اختر القسم</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" {{ old('section_id', $structuredProgram->section_id) == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('section_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">التخصص</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-graduation-cap input-inside-icon"></i>
                                        <select name="major_id" id="major_select" class="form-select @error('major_id') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" onchange="loadBooksByMajor(this.value)" required data-was-required-halaqat="true">
                                            <option value="">اختر التخصص</option>
                                            @foreach($majors as $major)
                                                <option value="{{ $major->id }}" data-section="{{ $major->section_id }}" {{ old('major_id', $structuredProgram->major_id) == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('major_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الكتاب</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-book-open input-inside-icon"></i>
                                        <select name="book_id" id="book_select" class="form-select @error('book_id') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required data-was-required-halaqat="true">
                                            <option value="">اختر الكتاب</option>
                                            @foreach($books as $book)
                                                <option value="{{ $book->id }}" data-major="{{ $book->major_id }}" {{ old('book_id', $structuredProgram->book_id) == $book->id ? 'selected' : '' }}>{{ $book->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('book_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الدرس</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-chalkboard-teacher input-inside-icon"></i>
                                        <input type="text" name="lesson" class="form-control @error('lesson') is-invalid @enderror" value="{{ old('lesson', $structuredProgram->lesson) }}" placeholder="أدخل اسم الدرس" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required data-was-required-halaqat="true">
                                    </div>
                                    @error('lesson')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Second Row: المحاضر المستوى اللغة دعم لغة الإشارة -->
                            <div class="row g-4 mt-2">
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المحاضر</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-user-tie input-inside-icon"></i>
                                        <select name="teacher_id" id="teacher_select" class="form-select @error('teacher_id') is-invalid @enderror" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                            <option value="">اختر المحاضر</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" data-masjid="{{ $teacher->masjid_id }}" {{ old('teacher_id', $structuredProgram->teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }} - {{ $teacher->masjid->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('teacher_id')
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
                                                <option value="{{ $level->id }}" {{ old('level_id', $structuredProgram->level_id) == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
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
                                                <option value="{{ $key }}" {{ old('language', $structuredProgram->language) == $key ? 'selected' : '' }}>{{ $language }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">دعم لغة الإشارة</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-hands input-inside-icon" style="color:#d4af37;"></i>
                                        <div class="form-check" style="background:white;padding:12px 45px 12px 15px;border-radius:12px;border:2px solid #d4af37;height:48px;display:flex;align-items:center;font-family:'Cairo',sans-serif;">
                                            <input class="form-check-input" type="checkbox" name="sign_language_support" value="1" id="sign_language_support" {{ old('sign_language_support', $structuredProgram->sign_language_support) ? 'checked' : '' }} style="border:2px solid #d4af37;transform:scale(1.2);margin:0;margin-left:8px;">
                                            <label class="form-check-label" for="sign_language_support" style="color:#174032;font-family:'Cairo',sans-serif;font-weight:600;margin:0;cursor:pointer;">
                                                دعم لغة الإشارة
                                            </label>
                                        </div>
                                    </div>
                                    @error('sign_language_support')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
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
                                        <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', $structuredProgram->start_time ? $structuredProgram->start_time->format('H:i') : '') }}" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                    </div>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">وقت النهاية</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-clock input-inside-icon"></i>
                                        <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', $structuredProgram->end_time ? $structuredProgram->end_time->format('H:i') : '') }}" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                    </div>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">تاريخ البداية</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-calendar-alt input-inside-icon"></i>
                                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $structuredProgram->start_date ? $structuredProgram->start_date->format('Y-m-d') : '') }}" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                    </div>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">تاريخ النهاية</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-calendar-alt input-inside-icon"></i>
                                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $structuredProgram->end_date ? $structuredProgram->end_date->format('Y-m-d') : '') }}" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;" required>
                                    </div>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Program Settings Section -->
                        <div class="form-section mb-5">
                            <h5 class="section-title mb-4" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;border-bottom:2px solid #d4af37;padding-bottom:8px;">إعدادات البرنامج</h5>
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">أيام الأسبوع <span style="color:#e74c3c">*</span></label>
                                    <div class="weekdays-checkboxes" style="display:flex;gap:15px;flex-wrap:wrap;align-items:center;background:#f8f9fa;padding:15px;border-radius:12px;border:2px solid #d4af37;">
                                        @php
                                            $weekdays = [
                                                'sunday' => 'الأحد',
                                                'monday' => 'الاثنين',
                                                'tuesday' => 'الثلاثاء',
                                                'wednesday' => 'الأربعاء',
                                                'thursday' => 'الخميس',
                                                'friday' => 'الجمعة',
                                                'saturday' => 'السبت'
                                            ];
                                            $selectedWeekdays = old('weekdays', $structuredProgram->weekdays ? (is_array($structuredProgram->weekdays) ? $structuredProgram->weekdays : json_decode($structuredProgram->weekdays, true)) : []);
                                        @endphp
                                        @foreach($weekdays as $key => $day)
                                            <div class="form-check" style="margin:0;min-width:80px;">
                                                <input class="form-check-input" type="checkbox" name="weekdays[]" value="{{ $key }}" id="weekday_{{ $key }}" {{ in_array($key, $selectedWeekdays) ? 'checked' : '' }} style="border:2px solid #d4af37;transform:scale(1.2);">
                                                <label class="form-check-label" for="weekday_{{ $key }}" style="color:#174032;font-family:'Cairo',sans-serif;font-weight:600;margin-right:8px;font-size:14px;">
                                                    {{ $day }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('weekdays')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
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
                                        <input type="url" name="broadcast_link" class="form-control @error('broadcast_link') is-invalid @enderror" value="{{ old('broadcast_link', $structuredProgram->broadcast_link) }}" placeholder="https://example.com/broadcast" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;">
                                    </div>
                                    @error('broadcast_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-4 mt-2">
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الوصف</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-align-left input-inside-icon" style="top:20px;"></i>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="أدخل وصف البرنامج" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;resize:vertical;">{{ old('description', $structuredProgram->description) }}</textarea>
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">ملاحظات</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-sticky-note input-inside-icon" style="top:20px;"></i>
                                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="4" placeholder="أدخل أي ملاحظات إضافية" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;resize:vertical;">{{ old('notes', $structuredProgram->notes) }}</textarea>
                                    </div>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
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
                                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $structuredProgram->date) }}" style="border-radius:12px;border:2px solid #d4af37;font-family:'Cairo',sans-serif;padding:12px 45px 12px 15px;">
                                    </div>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Prayer Times Table -->
                            <div class="prayer-table-container" style="background:#f8f9fa;padding:20px;border-radius:12px;border:2px solid #d4af37;overflow-x:auto;">
                                <table class="table table-bordered" style="margin-bottom:0;background:white;border-radius:8px;overflow:hidden;">
                                    <thead style="background:#174032;color:white;">
                                        <tr>
                                            <th style="text-align:center;font-family:'Cairo',sans-serif;font-weight:700;padding:15px;border:none;">الصلاة</th>
                                            <th style="text-align:center;font-family:'Cairo',sans-serif;font-weight:700;padding:15px;border:none;">الأذان</th>
                                            <th style="text-align:center;font-family:'Cairo',sans-serif;font-weight:700;padding:15px;border:none;">الإقامة</th>
                                            <th style="text-align:center;font-family:'Cairo',sans-serif;font-weight:700;padding:15px;border:none;">الإمام</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Fajr Prayer Row -->
                                        <tr>
                                            <td style="text-align:center;font-family:'Cairo',sans-serif;font-weight:600;padding:15px;background:#faf9f6;color:#174032;vertical-align:middle;">صلاة الفجر</td>
                                            <td style="padding:10px;">
                                                <input type="time" name="adhan_fajr" class="form-control @error('adhan_fajr') is-invalid @enderror" value="{{ old('adhan_fajr', $structuredProgram->adhan_fajr_formatted) }}" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('adhan_fajr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="iqama_fajr" class="form-control @error('iqama_fajr') is-invalid @enderror" value="{{ old('iqama_fajr', $structuredProgram->iqama_fajr_formatted) }}" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('iqama_fajr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="text" name="imam_fajr" class="form-control @error('imam_fajr') is-invalid @enderror" value="{{ old('imam_fajr', $structuredProgram->imam_fajr) }}" placeholder="اسم الإمام" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('imam_fajr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <!-- Dhuhr Prayer Row -->
                                        <tr>
                                            <td style="text-align:center;font-family:'Cairo',sans-serif;font-weight:600;padding:15px;background:#faf9f6;color:#174032;vertical-align:middle;">صلاة الظهر</td>
                                            <td style="padding:10px;">
                                                <input type="time" name="adhan_dhuhr" class="form-control @error('adhan_dhuhr') is-invalid @enderror" value="{{ old('adhan_dhuhr', $structuredProgram->adhan_dhuhr_formatted) }}" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('adhan_dhuhr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="iqama_dhuhr" class="form-control @error('iqama_dhuhr') is-invalid @enderror" value="{{ old('iqama_dhuhr', $structuredProgram->iqama_dhuhr_formatted) }}" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('iqama_dhuhr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="text" name="imam_dhuhr" class="form-control @error('imam_dhuhr') is-invalid @enderror" value="{{ old('imam_dhuhr', $structuredProgram->imam_dhuhr) }}" placeholder="اسم الإمام" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('imam_dhuhr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <!-- Asr Prayer Row -->
                                        <tr>
                                            <td style="text-align:center;font-family:'Cairo',sans-serif;font-weight:600;padding:15px;background:#faf9f6;color:#174032;vertical-align:middle;">صلاة العصر</td>
                                            <td style="padding:10px;">
                                                <input type="time" name="adhan_asr" class="form-control @error('adhan_asr') is-invalid @enderror" value="{{ old('adhan_asr', $structuredProgram->adhan_asr_formatted) }}" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('adhan_asr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="iqama_asr" class="form-control @error('iqama_asr') is-invalid @enderror" value="{{ old('iqama_asr', $structuredProgram->iqama_asr_formatted) }}" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('iqama_asr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="text" name="imam_asr" class="form-control @error('imam_asr') is-invalid @enderror" value="{{ old('imam_asr', $structuredProgram->imam_asr) }}" placeholder="اسم الإمام" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('imam_asr')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <!-- Maghrib Prayer Row -->
                                        <tr>
                                            <td style="text-align:center;font-family:'Cairo',sans-serif;font-weight:600;padding:15px;background:#faf9f6;color:#174032;vertical-align:middle;">صلاة المغرب</td>
                                            <td style="padding:10px;">
                                                <input type="time" name="adhan_maghrib" class="form-control @error('adhan_maghrib') is-invalid @enderror" value="{{ old('adhan_maghrib', $structuredProgram->adhan_maghrib_formatted) }}" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('adhan_maghrib')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="iqama_maghrib" class="form-control @error('iqama_maghrib') is-invalid @enderror" value="{{ old('iqama_maghrib', $structuredProgram->iqama_maghrib_formatted) }}" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('iqama_maghrib')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="text" name="imam_maghrib" class="form-control @error('imam_maghrib') is-invalid @enderror" value="{{ old('imam_maghrib', $structuredProgram->imam_maghrib) }}" placeholder="اسم الإمام" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('imam_maghrib')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <!-- Isha Prayer Row -->
                                        <tr>
                                            <td style="text-align:center;font-family:'Cairo',sans-serif;font-weight:600;padding:15px;background:#faf9f6;color:#174032;vertical-align:middle;">صلاة العشاء</td>
                                            <td style="padding:10px;">
                                                <input type="time" name="adhan_isha" class="form-control @error('adhan_isha') is-invalid @enderror" value="{{ old('adhan_isha', $structuredProgram->adhan_isha_formatted) }}" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('adhan_isha')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="iqama_isha" class="form-control @error('iqama_isha') is-invalid @enderror" value="{{ old('iqama_isha', $structuredProgram->iqama_isha_formatted) }}" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('iqama_isha')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="text" name="imam_isha" class="form-control @error('imam_isha') is-invalid @enderror" value="{{ old('imam_isha', $structuredProgram->imam_isha) }}" placeholder="اسم الإمام" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('imam_isha')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <!-- Friday Prayer Row -->
                                        <tr>
                                            <td style="text-align:center;font-family:'Cairo',sans-serif;font-weight:600;padding:15px;background:#faf9f6;color:#174032;vertical-align:middle;">صلاة الجمعة</td>
                                            <td style="padding:10px;">
                                                <input type="time" name="adhan_friday" class="form-control @error('adhan_friday') is-invalid @enderror" value="{{ old('adhan_friday', $structuredProgram->adhan_friday_formatted) }}" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('adhan_friday')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="time" name="iqama_friday" class="form-control @error('iqama_friday') is-invalid @enderror" value="{{ old('iqama_friday', $structuredProgram->iqama_friday_formatted) }}" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
                                                @error('iqama_friday')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td style="padding:10px;">
                                                <input type="text" name="imam_friday" class="form-control @error('imam_friday') is-invalid @enderror" value="{{ old('imam_friday', $structuredProgram->imam_friday) }}" placeholder="اسم الإمام" style="border-radius:8px;border:1px solid #d4af37;font-family:'Cairo',sans-serif;text-align:center;">
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
                                تحديث البرنامج
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
    padding: 2rem 1rem;
}

.programs-table-card {
    position: relative;
    overflow: hidden;
}

.programs-title {
    position: relative;
    z-index: 2;
}

.form-section {
    position: relative;
    z-index: 2;
}

.section-title {
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
}

.input-icon-wrapper {
    position: relative;
}

.input-inside-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #d4af37;
    z-index: 3;
    font-size: 1rem;
}

.form-control, .form-select {
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.form-control:focus, .form-select:focus {
    border-color: #174032;
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
}

.programs-btn {
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.programs-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.programs-btn-primary:hover {
    background: #c19b2e !important;
}

.programs-btn-secondary:hover {
    background: #5a6169 !important;
}

.invalid-feedback {
    font-family: 'Cairo', sans-serif;
    font-weight: 600;
}

.weekdays-checkboxes {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    align-items: center;
    background: #f8f9fa;
    padding: 15px;
    border-radius: 12px;
    border: 2px solid #d4af37;
}
.weekdays-checkboxes .form-check {
    margin: 0;
    min-width: 80px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.weekdays-checkboxes .form-check-input {
    border: 2px solid #d4af37;
    transform: scale(1.2);
    margin: 0;
}
.weekdays-checkboxes .form-check-input:checked {
    background-color: #d4af37;
    border-color: #d4af37;
}
.weekdays-checkboxes .form-check-label {
    color: #174032;
    font-family: 'Cairo', sans-serif;
    font-weight: 600;
    font-size: 14px;
    margin: 0;
    cursor: pointer;
}
@media (max-width: 768px) {
    .programs-page-container {
        padding: 1rem 0.5rem;
    }
    
    .programs-table-card {
        padding: 1.5rem 1rem;
    }
    
    .programs-title {
        font-size: 1.3rem;
    }
    
    .programs-btn {
        padding: 0.7rem 1.5rem !important;
        font-size: 0.9rem !important;
        margin: 0.5rem 0.25rem !important;
    }
    .weekdays-checkboxes {
        gap: 10px;
        padding: 12px;
    }
    .weekdays-checkboxes .form-check {
        min-width: 70px;
    }
    .weekdays-checkboxes .form-check-label {
        font-size: 13px;
    }
}
@media (max-width: 480px) {
    .weekdays-checkboxes {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    .weekdays-checkboxes .form-check {
        min-width: auto;
        width: 100%;
        justify-content: flex-start;
    }
}
</style>

<script>
// Load majors by section
function loadMajorsBySection(sectionId) {
    const majorSelect = document.getElementById('major_select');
    const bookSelect = document.getElementById('book_select');
    const majorOptions = majorSelect.querySelectorAll('option[data-section]');
    
    // Hide all major options first
    majorOptions.forEach(option => {
        option.style.display = 'none';
        option.selected = false;
    });
    
    // Show majors for selected section
    if (sectionId) {
        majorOptions.forEach(option => {
            if (option.getAttribute('data-section') === sectionId) {
                option.style.display = 'block';
            }
        });
    } else {
        // Show all majors if no section selected
        majorOptions.forEach(option => {
            option.style.display = 'block';
        });
    }
    
    // Reset major and book selection
    majorSelect.value = '';
    loadBooksByMajor('');
}

// Load books by major
function loadBooksByMajor(majorId) {
    const bookSelect = document.getElementById('book_select');
    const bookOptions = bookSelect.querySelectorAll('option[data-major]');
    
    // Hide all book options first
    bookOptions.forEach(option => {
        option.style.display = 'none';
        option.selected = false;
    });
    
    // Show books for selected major
    if (majorId) {
        bookOptions.forEach(option => {
            if (option.getAttribute('data-major') === majorId) {
                option.style.display = 'block';
            }
        });
    } else {
        // Show all books if no major selected
        bookOptions.forEach(option => {
            option.style.display = 'block';
        });
    }
    
    // Reset book selection
    bookSelect.value = '';
}

function loadTeachersByMasjid(masjidId) {
    const teacherSelect = document.getElementById('teacher_select');
    const teacherOptions = teacherSelect.querySelectorAll('option[data-masjid]');
    
    // Hide all teacher options first
    teacherOptions.forEach(option => {
        option.style.display = 'none';
        option.selected = false;
    });
    
    // Show teachers for selected masjid
    if (masjidId) {
        teacherOptions.forEach(option => {
            if (option.getAttribute('data-masjid') === masjidId) {
                option.style.display = 'block';
            }
        });
    } else {
        // Show all teachers if no masjid selected
        teacherOptions.forEach(option => {
            option.style.display = 'block';
        });
    }
    
    // Reset teacher selection
    teacherSelect.value = '';
}

function loadBuildingsByMasjid(masjidId) {
    const buildingSelect = document.getElementById('building_select');
    const buildingOptions = buildingSelect.querySelectorAll('option[data-masjid]');
    
    // Hide all building options first
    buildingOptions.forEach(option => {
        option.style.display = 'none';
        option.selected = false;
    });
    
    // Show buildings for selected masjid
    if (masjidId) {
        buildingOptions.forEach(option => {
            if (option.getAttribute('data-masjid') === masjidId) {
                option.style.display = 'block';
            }
        });
    } else {
        // Show all buildings if no masjid selected
        buildingOptions.forEach(option => {
            option.style.display = 'block';
        });
    }
    
    // Reset building selection
    buildingSelect.value = '';
}

// Function to toggle prayer fields visibility based on program type
function togglePrayerFields() {
    const programTypeSelect = document.getElementById('program_type_id');
    const prayerFieldsSection = document.getElementById('prayer-fields-section');
    
    if (programTypeSelect && prayerFieldsSection) {
        const selectedOption = programTypeSelect.options[programTypeSelect.selectedIndex];
        const programTypeName = selectedOption ? selectedOption.text : '';
        
        if (programTypeName === 'إمامة') {
            prayerFieldsSection.style.display = 'block';
            hideNonEssentialFields(true);
        } else {
            prayerFieldsSection.style.display = 'none';
            hideNonEssentialFields(false);
        }
    }
}

function hideNonEssentialFields(hide) {
    
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
                    section.style.display = hide ? 'none' : 'block';
                    
                    // Remove required attributes from all fields in this section
                    const fields = section.querySelectorAll('input, select, textarea');
                    fields.forEach(field => {
                        if (hide) {
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
    
    // Fallback: individual form sections to hide
    const fieldsToHide = [
        // Academic Content
        '.form-section:has(#section)',
        '.form-section:has(#major)',
        '.form-section:has(#book)',
        '.form-section:has(#lesson)',
        '.form-section:has(#level)',
        '.form-section:has(#language)',
        // Schedule and Timing
        '.form-section:has(#start_time)',
        '.form-section:has(#end_time)',
        '.form-section:has(#start_date)',
        '.form-section:has(#end_date)',
        '.form-section:has(#teacher)',
        '.form-section:has(#building)',
        // Program Settings
        '.form-section:has(#status)',
        '.form-section:has(input[name="weekdays[]"])',
        // Additional Information
        '.form-section:has(#broadcast_link)',
        '.form-section:has(#description)',
        '.form-section:has(#notes)',
        '.form-section:has(#sign_language_support)'
    ];

    // List of form fields that need their 'required' attribute toggled
    const requiredFields = [
        'select[name="section_id"]',
        'select[name="major_id"]',
        'select[name="book_id"]',
        'input[name="lesson"]',
        'select[name="level_id"]',
        'select[name="language"]',
        'input[name="start_time"]',
        'input[name="end_time"]',
        'input[name="start_date"]',
        'input[name="end_date"]',
        'select[name="teacher_id"]',
        'select[name="location_id"]',
        'select[name="status"]',
        'input[name="broadcast_link"]',
        'textarea[name="description"]',
        'textarea[name="notes"]'
    ];

    fieldsToHide.forEach(selector => {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => {
            element.style.display = hide ? 'none' : 'block';
        });
    });

    // Toggle required attributes for form fields
    requiredFields.forEach(selector => {
        const field = document.querySelector(selector);
        if (field) {
            if (hide) {
                // Store original required state and remove required attribute
                if (field.hasAttribute('required')) {
                    field.setAttribute('data-was-required', 'true');
                }
                field.removeAttribute('required');
            } else {
                // Restore required attribute if it was originally required
                if (field.getAttribute('data-was-required') === 'true') {
                    field.setAttribute('required', 'required');
                }
            }
        }
    });

    // Handle weekdays checkboxes separately
    const weekdayCheckboxes = document.querySelectorAll('input[name="weekdays[]"]');
    weekdayCheckboxes.forEach(checkbox => {
        if (hide) {
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
}

    // Toggle program type fields based on selection
    function toggleProgramTypeFields() {
        const programTypeSelect = document.getElementById('program_type_id');
        const programTitleField = document.getElementById('program_title_field');
        const programTitleInput = document.getElementById('program_title');
        
        if (!programTypeSelect || !programTitleField) return;
        
        const selectedOption = programTypeSelect.options[programTypeSelect.selectedIndex];
        const programTypeName = selectedOption ? selectedOption.text : '';
        
        // Check if it's حلقة تحفيظ
        const isHalaqat = programTypeName === 'حلقة تحفيظ';
        
        // Show/hide program title field
        if (isHalaqat) {
            programTitleField.style.display = 'block';
            programTitleInput.required = true;
        } else {
            programTitleField.style.display = 'none';
            programTitleInput.required = false;
        }
        
        // Hide/show academic fields for حلقة تحفيظ
        hideHalaqatFields(isHalaqat);
        
        // Handle prayer fields for إمامة
        togglePrayerFields();
    }
    
    // Hide specific fields for حلقة تحفيظ programs
    function hideHalaqatFields(isHalaqat) {
        const fieldsToHide = [
            'select[name="section_id"]',
            'select[name="major_id"]',
            'select[name="book_id"]',
            'input[name="lesson"]'
        ];
        
        fieldsToHide.forEach(selector => {
            const field = document.querySelector(selector);
            if (field) {
                const fieldContainer = field.closest('.col-lg-3, .col-md-6');
                if (fieldContainer) {
                    if (isHalaqat) {
                        fieldContainer.style.display = 'none';
                        // Store original required state and remove required attribute
                        if (field.hasAttribute('required') || field.hasAttribute('data-was-required-halaqat')) {
                            field.setAttribute('data-was-required-halaqat', 'true');
                        }
                        field.removeAttribute('required');
                    } else {
                        fieldContainer.style.display = 'block';
                        // Restore required attribute if it was originally required
                        if (field.getAttribute('data-was-required-halaqat') === 'true') {
                            field.setAttribute('required', 'required');
                        }
                    }
                }
            }
        });
    }

    // Initialize filters on page load
document.addEventListener('DOMContentLoaded', function() {
    const sectionSelect = document.getElementById('section_id');
    const majorSelect = document.getElementById('major_select');
    const masjidSelect = document.getElementById('masjid_id');
    
    // Initialize section/major/book filters
    if (sectionSelect.value) {
        loadMajorsBySection(sectionSelect.value);
        // Restore the selected major after filtering
        setTimeout(() => {
            const currentMajorId = '{{ old("major_id", $structuredProgram->major_id) }}';
            if (currentMajorId) {
                majorSelect.value = currentMajorId;
                loadBooksByMajor(currentMajorId);
                // Restore the selected book after filtering
                setTimeout(() => {
                    const currentBookId = '{{ old("book_id", $structuredProgram->book_id) }}';
                    if (currentBookId) {
                        document.getElementById('book_select').value = currentBookId;
                    }
                }, 50);
            }
        }, 50);
    }
    
    // Initialize masjid/teacher/building filters
    if (masjidSelect.value) {
        loadTeachersByMasjid(masjidSelect.value);
        loadBuildingsByMasjid(masjidSelect.value);
        // Restore the selected teacher and building after filtering
        setTimeout(() => {
            const currentTeacherId = '{{ old("teacher_id", $structuredProgram->teacher_id) }}';
            const currentLocationId = '{{ old("location_id", $structuredProgram->location_id) }}';
            if (currentTeacherId) {
                document.getElementById('teacher_select').value = currentTeacherId;
            }
            if (currentLocationId) {
                document.getElementById('building_select').value = currentLocationId;
            }
        }, 50);
    }
    
    // Initialize program type fields visibility
    const programTypeSelect = document.getElementById('program_type_id');
    if (programTypeSelect) {
        // Add event listener for program type changes
        programTypeSelect.addEventListener('change', toggleProgramTypeFields);
        
        // Check initial state on page load
        toggleProgramTypeFields();
    }
    
    // Add form submission debugging
    const form = document.getElementById('structuredProgramForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form is being submitted...');
            console.log('Form action:', form.action);
            console.log('Form method:', form.method);
            
            // Check for required fields
            const requiredFields = form.querySelectorAll('[required]');
            let hasEmptyRequired = false;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    console.log('Empty required field:', field.name, field);
                    hasEmptyRequired = true;
                }
            });
            
            if (hasEmptyRequired) {
                console.log('Form has empty required fields');
                e.preventDefault();
                alert('يرجى ملء جميع الحقول المطلوبة');
                return false;
            } else {
                console.log('All required fields are filled');
            }
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-left:0.5rem;"></i>جاري التحديث...';
            }
        });
    }
});
</script>
@endsection