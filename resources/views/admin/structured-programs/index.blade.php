@extends('layouts.admin')

@section('content')
@include('components.breadcrumb', [
    'items' => [
        ['title' => 'البيانات', 'url' => route('data.programs')],
        ['title' => 'عرض البيانات']
    ]
])
<div style="height:2.5rem;"></div>

<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin:0 auto 1.5rem;max-width:1200px;border-radius:12px;">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin:0 auto 1.5rem;max-width:1200px;border-radius:12px;">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container perms-container perms-wide no-bg" style="max-width:100%;">
    <div class="programs-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:1.4rem 1.2rem;border-top:5px solid #d4af37;">
        <div class="mb-4">
            <h2 style="font-weight:900;color:#174032;font-size:1.4rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;">البرامج المنظمة</h2>
        </div>
        <!-- Filters -->
        <form method="GET" action="{{ route('admin.structured-programs.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المسجد</label>
                    <select name="masjid_id" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">الكل</option>
                        @foreach($masjids as $masjid)
                            <option value="{{ $masjid->id }}" {{ request('masjid_id') == $masjid->id ? 'selected' : '' }}>{{ $masjid->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">نوع البرنامج</label>
                    <select name="program_type_id" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">الكل</option>
                        @foreach($programTypes as $programType)
                            <option value="{{ $programType->id }}" {{ request('program_type_id') == $programType->id ? 'selected' : '' }}>{{ $programType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">القسم</label>
                    <select name="section_id" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">الكل</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">التخصص</label>
                    <select name="major_id" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">الكل</option>
                        @foreach($majors as $major)
                            <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الحالة</label>
                    <select name="status" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                            <option value="">جميع الحالات</option>
                            <option value="لم تبدأ" {{ request('status') == 'لم تبدأ' ? 'selected' : '' }}>لم تبدأ</option>
                            <option value="في الموعد" {{ request('status') == 'في الموعد' ? 'selected' : '' }}>في الموعد</option>
                            <option value="بدأت" {{ request('status') == 'بدأت' ? 'selected' : '' }}>بدأت</option>
                            <option value="تأجلت" {{ request('status') == 'تأجلت' ? 'selected' : '' }}>تأجلت</option>
                            <option value="اختبار" {{ request('status') == 'اختبار' ? 'selected' : '' }}>اختبار</option>
                            <option value="انتهت" {{ request('status') == 'انتهت' ? 'selected' : '' }}>انتهت</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المحاضر</label>
                    <input type="text" name="teacher" value="{{ request('teacher') }}" class="form-control" placeholder="اكتب اسم المحاضر" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;" />
                </div>
            </div>
            <div class="d-flex justify-content-center gap-2 mt-2">
                <button class="btn btn-primary" style="border-radius:8px;background:#d4af37;color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">تصفية</button>
                <a href="{{ route('admin.structured-programs.index') }}" class="btn btn-secondary" style="border-radius:8px;background:#174032;color:#fff;font-family:'Cairo',sans-serif;">إعادة تعيين</a>
            </div>
        </form>

        <!-- Unified Programs Table -->
        @if($programs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle programs-table unified-table">
                    <thead class="table-head">
                         <tr>
                             <th>#</th>
                             <th>نوع البرنامج</th>
                             <th>الحالة</th>
                             <th>الملاحظات</th>
                             <th class="actions-col">إجراءات</th>
                         </tr>
                     </thead>
                    <tbody>
                        @foreach($programs as $index => $program)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $program->programType->name ?? 'غير محدد' }}</td>
                              
                                <td class="editable-cell" data-field="status" data-id="{{ $program->id }}">
                                 @if($program->programType && $program->programType->name === 'إمامة')
                                     <span class="display-value" style="color: #6c757d; font-style: italic;">-</span>
                                 @else
                                     <span class="display-value" data-start-time="{{ $program->start_time }}" data-end-time="{{ $program->end_time }}" data-original-status="{{ $program->status ?? 'غير محدد' }}" data-weekdays="{{ json_encode($program->weekdays ?? []) }}">{{ $program->status ?? 'غير محدد' }}</span>
                                     <input type="text" class="edit-input form-control" style="display: none;" value="{{ $program->status ?? 'غير محدد' }}">
                                 @endif
                             </td>
                             <td class="editable-cell" data-field="notes" data-id="{{ $program->id }}">
                                 <span class="display-value">{{ $program->notes ?? 'لا توجد ملاحظات' }}</span>
                                 <input type="text" class="edit-input form-control" style="display: none;" value="{{ $program->notes }}">
                             </td>
                                <td class="actions-col">
                                    @if($program->programType && $program->programType->name === 'إمامة')
                                        <a href="{{ route('admin.structured-programs.edit', $program) }}" class="btn btn-sm btn-warning" title="تعديل"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.structured-programs.destroy', $program) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="حذف" onclick="return confirm('هل أنت متأكد من حذف هذا البرنامج؟');"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-info edit-toggle" title="تعديل سريع">
                                            <i class="fas fa-bell"></i>
                                        </button>
                                        <a href="{{ route('admin.structured-programs.edit', $program) }}" class="btn btn-sm btn-warning" title="تعديل"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.structured-programs.destroy', $program) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="حذف" onclick="return confirm('هل أنت متأكد من حذف هذا البرنامج؟');"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $programs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

<style>
    /* 3 columns on desktop to create two rows with 3 filters each */

    /* Force each legacy .col-span-4 to occupy one column within this grid */


    /* Table polish */
    .programs-table { font-family: 'Cairo', sans-serif; border-collapse: separate; border-spacing: 0 .5rem; width: 100%; }
    .programs-table td, .programs-table th { vertical-align: middle; padding: 10px 12px; }
    .programs-table .table-head { background: linear-gradient(135deg,#174032 0%,#174032 100%); color: #d4af37; position: sticky; top: 0; z-index: 2; }
    .programs-table .table-head th { position: sticky; top: 0; background: linear-gradient(135deg,#174032 0%,#174032 100%); color: #d4af37; text-wrap: nowrap; }
    .programs-table tbody tr { background: #fff; transition: background 0.18s; }
    .programs-table tbody tr:hover { background: #faf9f6 !important; }
    .programs-table .actions-col { text-align: center; min-width: 150px; position: sticky; right: 0; background: #fff; z-index: 1; box-shadow: -6px 0 10px -6px rgba(0,0,0,0.08); }
    .programs-table thead .actions-col { right: 0; z-index: 3; }
    /* Removed pill styling for cleaner table appearance */
    .programs-table .btn { padding: 4px 8px; margin-right: 0.25rem; }

    /* Make the table wrapper scroll so sticky header/column work */
    .table-responsive { overflow: visible; max-height: none; }

    /* Unified table specific styles */
    .unified-table { font-size: 0.85rem; }
    .unified-table .prayer-times-cell,
    .unified-table .imams-cell {
        text-align: right;
        padding: 8px 12px;
        max-width: 200px;
        font-size: 0.75rem;
    }
    .prayer-times-compact,
    .imams-compact {
        font-size: 0.7rem;
        line-height: 1.3;
    }
    .prayer-times-compact div,
    .imams-compact div {
        margin-bottom: 2px;
        white-space: nowrap;
    }
    .prayer-times-compact strong,
    .imams-compact strong {
        color: #174032;
        font-weight: 600;
    }

    /* Imama table specific styles */
    .imama-table { min-width: 1800px; font-size: 0.85rem; }
    .imama-table th, .imama-table td { padding: 8px 6px; white-space: nowrap; }
    .imama-table .table-responsive { overflow-x: auto; }
    
    /* Inline editing styles */
    .editable-cell {
        position: relative;
        cursor: pointer;
    }
    
    .editable-cell .edit-input {
        width: 100%;
        border: 2px solid #007bff;
        border-radius: 4px;
        padding: 5px 8px;
        font-size: 0.9rem;
        background-color: #fff;
        z-index: 10;
    }
    
    .editable-cell .edit-input:focus {
        outline: none;
        border-color: #0056b3;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .edit-toggle.active {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }
    
    tr.editing {
        background-color: #f8f9fa !important;
    }
    
    tr.editing .editable-cell {
        background-color: #e3f2fd;
    }
    
    /* Dynamic status colors */
    .status-في-الموعد {
        color: #1e3a8a;
        font-weight: bold;
    }
    
    .status-بدأت {
        color: #28a745;
        font-weight: bold;
    }
    
    .status-انتهت {
        color: #dc3545;
        font-weight: bold;
    }
    
    .status-تأجلت {
        color: #60a5fa;
        font-weight: bold;
    }
    
    .status-اختبار {
        color: #dc2626;
        font-weight: bold;
    }
    
    .status-غير-محدد {
        color: #6c757d;
        font-weight: bold;
    }
    
    /* Responsive tweaks: hide less-critical columns on narrow screens */
    @media (max-width: 767.98px) {
        .programs-table th:nth-child(4), .programs-table td:nth-child(4) { display: none; } /* القسم */
        .programs-table th:nth-child(5), .programs-table td:nth-child(5) { display: none; } /* التخصص */
        
        /* For Imama table on mobile, show only essential columns */
        .imama-table { font-size: 0.75rem; }
        .imama-table th, .imama-table td { padding: 6px 4px; }
    }
</style>

@push('scripts')
<script>
$(document).ready(function() {
    let editingRow = null;

    // Toggle edit mode for a row
    $(document).on('click', '.edit-toggle', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const row = $(this).closest('tr');
        const button = $(this);

        if (editingRow && editingRow[0] !== row[0]) {
            // Cancel editing on other row
            cancelEdit(editingRow);
        }

        if (row.hasClass('editing')) {
            // Save changes
            saveChanges(row, button);
        } else {
            // Enter edit mode
            enterEditMode(row, button);
        }
    });

    function enterEditMode(row, button) {
        editingRow = row;
        row.addClass('editing');
        button.addClass('active');
        button.find('i').removeClass('fa-edit').addClass('fa-save');
        button.attr('title', 'حفظ التغييرات');

        row.find('.editable-cell').each(function() {
            const cell = $(this);
            const displayValue = cell.find('.display-value');
            const editInput = cell.find('.edit-input');
            
            // Set input value to current display value
            const currentText = displayValue.text().trim();
            if (currentText === 'لا توجد ملاحظات' || currentText === 'غير محدد') {
                editInput.val('');
            } else {
                editInput.val(currentText);
            }
            
            displayValue.hide();
            editInput.show().focus();
        });
    }

    function saveChanges(row, button) {
        const programId = row.find('.editable-cell').first().data('id');
        const promises = [];

        row.find('.editable-cell').each(function() {
            const cell = $(this);
            const field = cell.data('field');
            const editInput = cell.find('.edit-input');
            const newValue = editInput.val().trim();
            const displayValue = cell.find('.display-value');
            const oldValue = displayValue.text().trim();

            // Normalize old value for comparison
            let normalizedOldValue = oldValue;
            if (oldValue === 'لا توجد ملاحظات' || oldValue === 'غير محدد') {
                normalizedOldValue = '';
            }

            // Only update if value changed
            if (newValue !== normalizedOldValue) {
                const promise = $.ajax({
                    url: `/admin/structured-programs/${programId}/inline-update`,
                    method: 'PATCH',
                    data: {
                        field: field,
                        value: newValue,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }
                });
                promises.push(promise);
            }
        });

        if (promises.length > 0) {
            Promise.all(promises)
                .then(function(responses) {
                    // Update display values
                    row.find('.editable-cell').each(function() {
                        const cell = $(this);
                        const editInput = cell.find('.edit-input');
                        const displayValue = cell.find('.display-value');
                        const newValue = editInput.val().trim();
                        
                        if (newValue === '') {
                            if (cell.data('field') === 'notes') {
                                displayValue.text('لا توجد ملاحظات');
                            } else {
                                displayValue.text('غير محدد');
                            }
                        } else {
                            displayValue.text(newValue);
                        }
                    });
                    
                    exitEditMode(row, button);
                })
                .catch(function(error) {
                    console.error('Error saving changes:', error);
                    if (typeof toastr !== 'undefined') {
                        toastr.error('حدث خطأ أثناء حفظ التغييرات');
                    } else {
                        alert('حدث خطأ أثناء حفظ التغييرات');
                    }
                });
        } else {
            exitEditMode(row, button);
        }
    }

    function cancelEdit(row) {
        const button = row.find('.edit-toggle');
        exitEditMode(row, button);
    }

    function exitEditMode(row, button) {
        editingRow = null;
        row.removeClass('editing');
        button.removeClass('active');
        button.find('i').removeClass('fa-save').addClass('fa-edit');
        button.attr('title', 'تعديل سريع');

        row.find('.editable-cell').each(function() {
            const cell = $(this);
            const displayValue = cell.find('.display-value');
            const editInput = cell.find('.edit-input');
            
            editInput.hide();
            displayValue.show();
        });
    }

    // Handle escape key to cancel editing
    $(document).keyup(function(e) {
        if (e.keyCode === 27 && editingRow) { // Escape key
            cancelEdit(editingRow);
        }
    });

    // Time-based status updates
    function getCurrentTime() {
        const now = new Date();
        return now.getHours() * 60 + now.getMinutes(); // Convert to minutes since midnight
    }
    
    function parseTimeToMinutes(timeString) {
        if (!timeString || timeString === '-') return null;
        
        // Handle both time format (15:26) and datetime format (2025-09-30 15:26:00)
        let timePart;
        if (timeString.includes(' ')) {
            // Datetime format: extract time part
            timePart = timeString.split(' ')[1];
        } else {
            // Time format: use as is
            timePart = timeString;
        }
        
        const [hours, minutes] = timePart.split(':').map(Number);
        return hours * 60 + minutes;
    }
    
    function getDynamicProgramStatus(program) {
        const currentTime = getCurrentTime();
        const startTime = parseTimeToMinutes(program.start_time);
        const endTime = parseTimeToMinutes(program.end_time);
        
        if (startTime === null || endTime === null) {
            return program.original_status || 'غير محدد';
        }
        
        // Check if today is a valid weekday for this program
        const currentWeekday = new Date().toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase();
        const programWeekdays = program.weekdays || [];
        
        // If program has specific weekdays and today is not one of them, return original status
        if (programWeekdays.length > 0 && !programWeekdays.includes(currentWeekday)) {
            return program.original_status || 'غير محدد';
        }
        
        // If program has ended, show "انتهت" regardless of database status
        if (currentTime > endTime) {
            return 'انتهت';
        }
        
        // If program has started but not ended, show "بدأت"
        if (currentTime >= startTime && currentTime <= endTime) {
            return 'بدأت';
        }
        
        // For programs that haven't started yet, only change "لم تبدأ" to "في الموعد"
        // Keep other statuses as they are (including "في الموعد" from database)
        if (program.original_status === 'لم تبدأ') {
            return 'في الموعد';
        }
        
        // Return original status for all other cases (including manual statuses and "في الموعد")
        return program.original_status || 'غير محدد';
    }
    
    function updateProgramStatuses() {
        $('.editable-cell[data-field="status"] .display-value').each(function() {
            const $span = $(this);
            const startTime = $span.data('start-time');
            const endTime = $span.data('end-time');
            const originalStatus = $span.data('original-status');
            const weekdaysData = $span.data('weekdays');
            
            // Skip if this is an إمامة program (no data attributes means it's إمامة)
            if (!startTime && !endTime && !originalStatus) {
                return;
            }
            
            // Parse weekdays data
            let weekdays = [];
            if (weekdaysData) {
                try {
                    weekdays = typeof weekdaysData === 'string' ? JSON.parse(weekdaysData) : weekdaysData;
                } catch (e) {
                    weekdays = [];
                }
            }
            
            const program = {
                start_time: startTime,
                end_time: endTime,
                original_status: originalStatus,
                weekdays: weekdays
            };
            
            const dynamicStatus = getDynamicProgramStatus(program);
            $span.text(dynamicStatus);
            
            // Apply color based on status
            $span.removeClass('status-في-الموعد status-بدأت status-انتهت status-تأجلت status-اختبار status-غير-محدد');
            $span.addClass('status-' + dynamicStatus.replace(/\s+/g, '-'));
        });
    }
    
    // Update statuses every 30 seconds
    setInterval(updateProgramStatuses, 30000);
    
    // Initial update
    updateProgramStatuses();
});
</script>
@endpush