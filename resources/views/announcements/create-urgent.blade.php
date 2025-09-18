@extends('layouts.admin')

@section('content')
<x-breadcrumb :items="[
    ['title' => 'الإعلانات', 'url' => route('announcements.index')],
    ['title' => 'إضافة إعلان عاجل']
]" />
<div style="height:2.5rem;"></div>
<div class="announcements-page-container" style="max-width:1200px;margin:0 auto;">
    <div class="announcements-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        <h2 class="announcements-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:2rem;">إضافة إعلان عاجل</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('announcements.urgent.store') }}" method="POST" id="urgentAnnouncementForm">
            @csrf
            
            <div class="mb-4">
                <label for="content" class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">
                    محتوى الإعلان العاجل <span class="required-field" style="color:#E74C3C;font-weight:700;">*</span>
                </label>
                
                <!-- Rich Text Toolbar -->
                <div class="editor-toolbar mb-2" style="border: 1px solid #d4af37; border-radius: 8px 8px 0 0; background: #f8f9fa; padding: 5px 10px;">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('bold')" title="عريض">
                        <i class="fas fa-bold"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('italic')" title="مائل">
                        <i class="fas fa-italic"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('underline')" title="تحته خط">
                        <i class="fas fa-underline"></i>
                    </button>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('justifyLeft')" title="محاذاة لليسار">
                            <i class="fas fa-align-right"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('justifyCenter')" title="توسيط">
                            <i class="fas fa-align-center"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('justifyRight')" title="محاذاة لليمين">
                            <i class="fas fa-align-left"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('insertUnorderedList')" title="قائمة نقطية">
                        <i class="fas fa-list-ul"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('insertOrderedList')" title="قائمة رقمية">
                        <i class="fas fa-list-ol"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('createLink')" title="إدراج رابط">
                        <i class="fas fa-link"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('unlink')" title="إزالة رابط">
                        <i class="fas fa-unlink"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('removeFormat')" title="إزالة التنسيق">
                        <i class="fas fa-eraser"></i>
                    </button>
                </div>
                
                <!-- Content Editable Area -->
                <div id="editor" 
                     contenteditable="true" 
                     style="min-height: 200px; border: 1px solid #d4af37; border-top: none; border-radius: 0 0 8px 8px; padding: 15px; outline: none;"
                     oninput="updateTextarea()">
                    {!! old('content', '') !!}
                </div>
                <textarea name="content" id="content" class="d-none" required>{!! old('content', '') !!}</textarea>
                <div class="error-message" id="content_error"></div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="display_start_at" class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">
                        تاريخ ووقت البدء
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        <input type="datetime-local" name="display_start_at" id="display_start_at" 
                               class="form-control" value="{{ old('display_start_at') }}" 
                               style="border-radius: 8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                    </div>
                    <div class="error-message" id="display_start_at_error"></div>
                </div>
                
                <div class="col-md-6">
                    <label for="display_end_at" class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">
                        تاريخ ووقت الانتهاء
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        <input type="datetime-local" name="display_end_at" id="display_end_at" 
                               class="form-control" value="{{ old('display_end_at') }}" 
                               style="border-radius: 8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                    </div>
                    <div class="error-message" id="display_end_at_error"></div>
                </div>
            </div>

            <div class="mb-4">
                <label for="masjid_id" class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">
                    المسجد <span class="required-field" style="color:#E74C3C;font-weight:700;">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-mosque"></i></span>
                    <select name="masjid_id" id="masjid_id" class="form-control" required 
                            style="border-radius: 8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">اختر المسجد</option>
                        @foreach($masjids as $masjid)
                            <option value="{{ $masjid->id }}" {{ old('masjid_id') == $masjid->id ? 'selected' : '' }}>
                                {{ $masjid->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="error-message" id="masjid_id_error"></div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-5">
                <a href="{{ route('announcements.index') }}" class="btn btn-secondary" style="border-radius: 8px;padding:0.5rem 1.5rem;">
                    <i class="fas fa-arrow-right ml-2"></i> رجوع
                </a>
                <button type="submit" class="btn btn-warning" style="background-color: #FFC107; border: none; color: #000; font-weight: bold; border-radius: 8px; padding: 0.5rem 2rem;">
                    <i class="fas fa-bolt ml-2"></i> نشر الإعلان العاجل
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Format text using document.execCommand
    function formatText(command, value = null) {
        document.getElementById('editor').focus();
        
        // Special handling for creating links
        if (command === 'createLink') {
            const url = prompt('أدخل عنوان الرابط:', 'https://');
            if (url) {
                document.execCommand('createLink', false, url);
            }
            return;
        }
        
        // Execute the command
        document.execCommand(command, false, value);
        updateTextarea();
    }
    
    // Update the hidden textarea with the editor content
    function updateTextarea() {
        document.getElementById('content').value = document.getElementById('editor').innerHTML;
    }
    
    // Handle form submission
    document.getElementById('urgentAnnouncementForm').addEventListener('submit', function(e) {
        // Update the hidden textarea with the editor content
        updateTextarea();
        
        // Basic validation
        const content = document.getElementById('content').value.trim();
        const masjidId = document.getElementById('masjid_id').value;
        
        if (!content) {
            e.preventDefault();
            document.getElementById('content_error').textContent = 'يرجى إدخال محتوى الإعلان';
            return false;
        }
        
        if (!masjidId) {
            e.preventDefault();
            document.getElementById('masjid_id_error').textContent = 'يرجى اختيار المسجد';
            return false;
        }
        
        return true;
    });
    
    // Clear error when field is focused
    document.querySelectorAll('input, select, textarea, #editor').forEach(input => {
        input.addEventListener('focus', function() {
            const errorElement = document.getElementById('content_error');
            if (errorElement) errorElement.textContent = '';
        });
    });
    
    // Initialize the textarea with the editor content
    document.addEventListener('DOMContentLoaded', function() {
        updateTextarea();
    });
</script>

<style>
    .announcements-page-container { font-family: 'Cairo', sans-serif; }
    .announcements-table-card input.form-control:focus,
    .announcements-table-card select.form-control:focus,
    .announcements-table-card textarea.form-control:focus {
        border-color: #174032;
        box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.5);
    }
    .required-field { color: #E74C3C; }
    .error-message { color: #E74C3C; font-size: 0.875rem; margin-top: 0.25rem; }
    .tox-tinymce { border: 1.5px solid #d4af37 !important; border-radius: 8px !important; }
    .tox-statusbar { border-top: 1px solid #d4af37 !important; }
    .tox-toolbar__primary { background: #f8f9fa !important; }
</style>
@endsection
