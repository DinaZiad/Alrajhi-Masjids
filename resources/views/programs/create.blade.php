@extends('layouts.admin')

@section('content')
<div class="programs-page-container" style="max-width:1200px;margin:0 auto;">
    <div class="programs-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        <h2 class="programs-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:2rem;">إضافة برنامج جديد</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('masjids.programs.store', 0) }}" id="programForm">
            @csrf
            <!-- Top row: 3 inputs across full width -->
            <div class="grid-12">
                <div class="col-span-4 mb-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المسجد <span style="color:#e74c3c">*</span></label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-mosque input-inside-icon"></i>
                        <select name="masjid_id" id="masjid_id" class="form-select" required style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                            <option value="">اختر المسجد</option>
                            @foreach($masjids as $masjid)
                                <option value="{{ $masjid->id }}" {{ (isset($masjidModel) && $masjidModel && $masjidModel->id == $masjid->id) ? 'selected' : '' }}>{{ $masjid->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-span-4 mb-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">نوع البرنامج <span style="color:#e74c3c">*</span></label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-layer-group input-inside-icon"></i>
                        <select name="program_type" id="program_type" class="form-select" required style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                            <option value="">اختر النوع</option>
                            @foreach($programTypes as $type)
                                <option value="{{ $type }}" {{ old('program_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-span-4 mb-3" id="row1-name-wrapper">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اسم البرنامج <span style="color:#e74c3c">*</span></label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-book input-inside-icon"></i>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="أدخل اسم البرنامج" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                    </div>
                </div>
            </div>
            <div id="common-fields">
                <!-- Row 2: 5 inputs (2+2+3+2+3) -->
                <div class="grid-12">
                    <div class="col-span-2 mb-3">
                        <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الحالة <span style="color:#e74c3c">*</span></label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-toggle-on input-inside-icon"></i>
                            <input type="text" name="status" class="form-control" value="{{ old('status') }}" placeholder="أدخل حالة البرنامج" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                    </div>
                    <div class="col-span-2 mb-3">
                        <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المستوى <span style="color:#e74c3c">*</span></label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-signal input-inside-icon"></i>
                            <input type="text" name="level" class="form-control" value="{{ old('level') }}" placeholder="أدخل مستوى البرنامج" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                    </div>
                    <div class="col-span-3 mb-3">
                        <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">نوع الحضور</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-users input-inside-icon"></i>
                            <input type="text" name="attendance_type" class="form-control" value="{{ old('attendance_type') }}" placeholder="أدخل نوع الحضور" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                    </div>
                    <div class="col-span-2 mb-3">
                        <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الوقت من</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-clock input-inside-icon"></i>
                            <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                    </div>
                    <div class="col-span-3 mb-3">
                        <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الوقت إلى</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-clock input-inside-icon"></i>
                            <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                    </div>
                </div>

                <!-- Row 3: 4 inputs (4+4+4) with notes taking 4 -->
                <div class="grid-12" id="location-field">
                    <div class="col-span-4 mb-3">
                        <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الموقع</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-map-marker-alt input-inside-icon"></i>
                            <select name="location_id" id="location_id" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                                <option value="">اختر الموقع</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" data-details='@json($location->details)' {{ old('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-span-4 mb-3">
                        <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">تفاصيل الموقع</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-map input-inside-icon"></i>
                            <select name="location_detail[]" id="location_detail" class="form-select" multiple style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                                <option value="">اختر تفاصيل الموقع</option>
                                @php
                                    $selectedLocation = $locations->find(old('location_id'));
                                    $details = $selectedLocation ? $selectedLocation->details : [];
                                    $currentDetails = is_array(old('location')) ? old('location') : (array) old('location');
                                @endphp
                                @if($details)
                                    @foreach($details as $detail)
                                        <option value="{{ $detail }}" {{ in_array($detail, $currentDetails) ? 'selected' : '' }}>{{ $detail }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-span-4 mb-3">
                        <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="3" style="height:100%;border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
            <!-- Day selector visible for all types -->
            <div class="grid-12">
                <div class="col-span-4 mb-3" id="day-field">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اليوم</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-calendar-day input-inside-icon"></i>
                        <select name="day" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                            <option value="">اختر اليوم</option>
                            @foreach(['الأحد','الإثنين','الثلاثاء','الأربعاء','الخميس','الجمعة','السبت'] as $day)
                                <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div id="type-fields">
                <!-- درس علمي -->
                <div class="type-specific" data-type="درس علمي" style="display: none;">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المجال</label>
                            <input type="text" name="field" class="form-control" value="{{ old('field') }}" placeholder="أدخل المجال" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">التخصص</label>
                            <input type="text" name="specialty" class="form-control" value="{{ old('specialty') }}" placeholder="أدخل التخصص" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الكتاب المستخدم</label>
                            <input type="text" name="book" class="form-control" value="{{ old('book') }}" placeholder="أدخل اسم الكتاب" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اسم الشيخ</label>
                            <input type="text" name="teacher" class="form-control" value="{{ old('teacher') }}" placeholder="أدخل اسم الشيخ" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">رابط البث</label>
                            <input type="text" name="teacher_link" class="form-control" value="{{ old('teacher_link') }}" placeholder="أدخل رابط البث" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                    </div>
                </div>
                <!-- حلقة تحفيظ -->
                <div class="type-specific" data-type="حلقة تحفيظ" style="display: none;">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اسم الحلقة</label>
                            <input type="text" name="group" class="form-control" value="{{ old('group') }}" placeholder="أدخل اسم الحلقة" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اسم المعلم</label>
                            <input type="text" name="instructor" class="form-control" value="{{ old('instructor') }}" placeholder="أدخل اسم المعلم" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">رابط البث أو الملف</label>
                            <input type="text" name="instructor_link" class="form-control" value="{{ old('instructor_link') }}" placeholder="أدخل الرابط" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                    </div>
                </div>
                <!-- إمامة -->
                <div class="type-specific" data-type="إمامة" style="display: none;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">التاريخ</label>
                            <input type="date" name="date" class="form-control" value="{{ old('date') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-6 mb-3"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">أذان الفجر</label>
                            <input type="time" name="adhan_fajr" class="form-control" value="{{ old('adhan_fajr') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">إقامة الفجر</label>
                            <input type="time" name="iqama_fajr" class="form-control" value="{{ old('iqama_fajr') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">إمام الفجر</label>
                            <input type="text" name="imam_fajr" class="form-control" value="{{ old('imam_fajr') }}" placeholder="اسم الإمام" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">أذان الظهر</label>
                            <input type="time" name="adhan_dhuhr" class="form-control" value="{{ old('adhan_dhuhr') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">إقامة الظهر</label>
                            <input type="time" name="iqama_dhuhr" class="form-control" value="{{ old('iqama_dhuhr') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">إمام الظهر</label>
                            <input type="text" name="imam_dhuhr" class="form-control" value="{{ old('imam_dhuhr') }}" placeholder="اسم الإمام" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">أذان العصر</label>
                            <input type="time" name="adhan_asr" class="form-control" value="{{ old('adhan_asr') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">إقامة العصر</label>
                            <input type="time" name="iqama_asr" class="form-control" value="{{ old('iqama_asr') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">إمام العصر</label>
                            <input type="text" name="imam_asr" class="form-control" value="{{ old('imam_asr') }}" placeholder="اسم الإمام" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">أذان المغرب</label>
                            <input type="time" name="adhan_maghrib" class="form-control" value="{{ old('adhan_maghrib') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">إقامة المغرب</label>
                            <input type="time" name="iqama_maghrib" class="form-control" value="{{ old('iqama_maghrib') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">إمام المغرب</label>
                            <input type="text" name="imam_maghrib" class="form-control" value="{{ old('imam_maghrib') }}" placeholder="اسم الإمام" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">أذان العشاء</label>
                            <input type="time" name="adhan_isha" class="form-control" value="{{ old('adhan_isha') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">إقامة العشاء</label>
                            <input type="time" name="iqama_isha" class="form-control" value="{{ old('iqama_isha') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">إمام العشاء</label>
                            <input type="text" name="imam_isha" class="form-control" value="{{ old('imam_isha') }}" placeholder="اسم الإمام" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-3 mt-4">
                <button type="submit" class="btn btn-primary" style="border-radius:8px;background:#d4af37;color:#174032;font-weight:700;font-family:'Cairo',sans-serif;padding:0.7rem 2.1rem;font-size:1.07rem;min-width:140px;">إضافة البرنامج</button>
                <a href="{{ route('masjids.programs.index', $masjid) }}" class="btn btn-secondary" style="border-radius:8px;background:#174032;color:#fff;font-family:'Cairo',sans-serif;padding:0.7rem 2.1rem;font-size:1.07rem;min-width:140px;">إلغاء</a>
            </div>
        </form>
    </div>
</div>
<style>
    .programs-page-container { font-family: 'Cairo', sans-serif; }
    .programs-table-card input.form-control:focus, .programs-table-card select.form-select:focus {
        border-color: #174032;
        box-shadow: 0 0 0 2px #d4af37;
        outline: none;
    }
    /* 12-col grid utilities */
    .grid-12 {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 16px;
    }
    .col-span-2 { grid-column: span 2; }
    .col-span-3 { grid-column: span 3; }
    .col-span-4 { grid-column: span 4; }
    .col-span-6 { grid-column: span 6; }
    .col-span-12 { grid-column: span 12; }
    @media (max-width: 991.98px) {
        .grid-12 { grid-template-columns: repeat(6, 1fr); }
        .col-span-4 { grid-column: span 6; }
        .col-span-3 { grid-column: span 6; }
        .col-span-2 { grid-column: span 3; }
    }
    @media (max-width: 575.98px) {
        .grid-12 { grid-template-columns: 1fr; }
        .col-span-2, .col-span-3, .col-span-4, .col-span-6, .col-span-12 { grid-column: 1 / -1; }
    }
    .input-icon-wrapper {
        position: relative;
    }
    .input-inside-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #C9B037;
        font-size: 1.1em;
        pointer-events: none;
        z-index: 2;
    }
    .input-icon-wrapper input.form-control, .input-icon-wrapper select.form-select {
        padding-right: 3.2rem;
    }
    .programs-table-card .btn-primary:focus, .programs-table-card .btn-primary:hover {
        background: #174032 !important;
        color: #fff !important;
        border: 1.5px solid #174032 !important;
    }
    .programs-table-card .btn-secondary:focus, .programs-table-card .btn-secondary:hover {
        background: #d4af37 !important;
        color: #174032 !important;
        border: 1.5px solid #d4af37 !important;
    }
</style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('program_type');
            const typeFields = document.querySelectorAll('.type-specific');
            const commonFields = document.getElementById('common-fields');
            const locationField = document.getElementById('location-field');
            const locationId = document.getElementById('location_id');
            const locationDetail = document.getElementById('location_detail');
            const masjidSelect = document.getElementById('masjid_id');
            const row1NameWrapper = document.getElementById('row1-name-wrapper');

        // Show/hide type-specific fields
        function updateTypeFields() {
            typeFields.forEach(function(div) {
                div.style.display = 'none';
                if (div.getAttribute('data-type') === typeSelect.value) {
                    div.style.display = '';
                }
            });
            if (typeSelect.value === 'إمامة') {
                commonFields.style.display = 'none';
                locationField.style.display = 'none';
                if (row1NameWrapper) row1NameWrapper.style.display = 'none';
            } else {
                commonFields.style.display = '';
                locationField.style.display = '';
                if (row1NameWrapper) row1NameWrapper.style.display = '';
            }
        }
        typeSelect.addEventListener('change', updateTypeFields);
        updateTypeFields();

        // Update location details dropdown on location change
            locationId.addEventListener('change', function() {
                const selected = locationId.options[locationId.selectedIndex];
                let details = selected.getAttribute('data-details');
                locationDetail.innerHTML = '<option value="">اختر تفاصيل الموقع</option>';
                if (details) {
                    try {
                        // Fix for HTML-encoded quotes
                        details = details.replace(/&quot;/g, '"');
                        let arr = JSON.parse(details);
                        // If it's a string (e.g. "A,B,C"), split it
                        if (typeof arr === 'string') {
                            arr = arr.split(',').map(s => s.trim()).filter(Boolean);
                        } else if (arr && typeof arr === 'object' && !Array.isArray(arr)) {
                            arr = Object.values(arr);
                        }
                        if (Array.isArray(arr)) {
                            arr.filter(val => val && val.trim() !== '').forEach(function(val) {
                                locationDetail.innerHTML += `<option value="${val}">${val}</option>`;
                            });
                            locationDetail.disabled = false;
                        } else {
                            locationDetail.disabled = true;
                        }
                    } catch (e) {
                        locationDetail.disabled = true;
                    }
                } else {
                    locationDetail.disabled = true;
                }
            });
        });
    </script>
@endsection 