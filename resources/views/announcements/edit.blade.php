@extends('layouts.admin')

@section('content')
<x-breadcrumb :items="[
    ['title' => 'الإعلانات', 'url' => route('announcements.index')],
    ['title' => 'تعديل إعلان']
]" />
<div style="height:2.5rem;"></div>
<div class="announcements-page-container" style="max-width:1200px;margin:0 auto;">
    <div class="announcements-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        <h2 class="announcements-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:2rem;">تعديل إعلان</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('announcements.update', $announcement) }}" method="POST" id="announcementForm">
        @csrf
        @method('PUT')
        <div class="mb-3">
                <label for="content" class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المحتوى <span class="required-field" style="color:#E74C3C;font-weight:700;">*</span></label>
                <textarea name="content" id="content" class="form-control" rows="4" required placeholder="أدخل محتوى الإعلان هنا..." style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">{{ old('content', $announcement->content) }}</textarea>
                <div class="error-message" id="content_error"></div>
        </div>
            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="display_start_at" class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">تاريخ البدء</label>
                    <input type="datetime-local" name="display_start_at" id="display_start_at" class="form-control" value="{{ old('display_start_at', $announcement->display_start_at ? date('Y-m-d\TH:i', strtotime($announcement->display_start_at)) : '') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                    <div class="error-message" id="display_start_at_error"></div>
        </div>
                <div class="col-md-6">
                    <label for="display_end_at" class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">تاريخ الانتهاء</label>
                    <input type="datetime-local" name="display_end_at" id="display_end_at" class="form-control" value="{{ old('display_end_at', $announcement->display_end_at ? date('Y-m-d\TH:i', strtotime($announcement->display_end_at)) : '') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                    <div class="error-message" id="display_end_at_error"></div>
        </div>
        </div>
        <div class="mb-3">
                <label for="masjid_id" class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المسجد <span class="required-field" style="color:#E74C3C;font-weight:700;">*</span></label>
                <select name="masjid_id" id="masjid_id" class="form-control" required style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                <option value="">اختر المسجد</option>
                @foreach($masjids as $masjid)
                    <option value="{{ $masjid->id }}" {{ old('masjid_id', $announcement->masjid_id) == $masjid->id ? 'selected' : '' }}>{{ $masjid->name }}</option>
                @endforeach
            </select>
                <div class="error-message" id="masjid_id_error"></div>
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_urgent" id="is_urgent" value="1" {{ old('is_urgent', $announcement->is_urgent) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_urgent" style="color:#174032;font-family:'Cairo',sans-serif;">إعلان عاجل</label>
            </div>
        </div>
            <div class="d-flex justify-content-center gap-3 mt-4">
                <button type="submit" class="btn btn-primary" id="submitBtn" style="border-radius:8px;background:#d4af37;color:#174032;font-weight:700;font-family:'Cairo',sans-serif;padding:0.7rem 2.1rem;font-size:1.07rem;min-width:140px;">
                    <i class="fas fa-check-circle me-2"></i> تحديث الإعلان
                </button>
                <a href="{{ route('announcements.index') }}" class="btn btn-secondary" style="border-radius:8px;background:#174032;color:#fff;font-family:'Cairo',sans-serif;padding:0.7rem 2.1rem;font-size:1.07rem;min-width:140px;">
                    <i class="fas fa-times me-2"></i> إلغاء
                </a>
        </div>
    </form>
    </div>
</div>
<style>
    .announcements-page-container { font-family: 'Cairo', sans-serif; }
    .announcements-table-card input.form-control:focus, .announcements-table-card select.form-control:focus, .announcements-table-card textarea.form-control:focus {
        border-color: #174032;
        box-shadow: 0 0 0 2px #d4af37;
        outline: none;
    }
    .announcements-table-card .btn-primary:focus, .announcements-table-card .btn-primary:hover {
        background: #174032 !important;
        color: #fff !important;
        border: 1.5px solid #174032 !important;
    }
    .announcements-table-card .btn-secondary:focus, .announcements-table-card .btn-secondary:hover {
        background: #d4af37 !important;
        color: #174032 !important;
        border: 1.5px solid #d4af37 !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('announcementForm');
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            const btn = this;
            const rect = btn.getBoundingClientRect();
            const ripple = document.createElement('span');
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            ripple.className = 'ripple';
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
        form.addEventListener('submit', function(e) {
            let isValid = true;
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            document.querySelectorAll('.form-control').forEach(el => el.classList.remove('error'));
            const content = document.getElementById('content');
            if (!content.value.trim()) {
                content.classList.add('error');
                document.getElementById('content_error').textContent = 'هذا الحقل مطلوب';
                isValid = false;
            }
            if (!isValid) {
                e.preventDefault();
            }
        });
        document.querySelectorAll('.form-control').forEach(field => {
            field.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.classList.add('error');
                    const errorEl = document.getElementById(`${this.name}_error`);
                    if (errorEl) {
                        errorEl.textContent = 'هذا الحقل مطلوب';
                    }
                } else {
                    this.classList.remove('error');
                    const errorEl = document.getElementById(`${this.name}_error`);
                    if (errorEl) {
                        errorEl.textContent = '';
                    }
                }
            });
        });
    });
</script>
@endsection
