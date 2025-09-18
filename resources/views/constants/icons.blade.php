@extends('layouts.admin')

@section('content')
<x-breadcrumb :items="[
    ['title' => 'الثوابت'],
    ['title' => 'إدارة الرموز']
]" />
<div style="height:2.5rem;"></div>
<div class="w-100 px-4" style="max-width:1100px;margin:0 auto;min-height:80vh;">
    <!-- <h2 style="font-weight:900;color:#174032;font-size:1.6rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:1.25rem;">
        الثوابت - إدارة الرموز
    </h2> -->

    @if (session('success'))
        <div id="flashSuccess" class="alert alert-success" style="transition:opacity .5s ease;">{{ session('success') }}</div>
    @endif

    

    <div class="w-100 announcements-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:1.6rem 1.4rem;border-top:5px solid #d4af37;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 style="font-weight:900;color:#174032;font-size:1.4rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;margin:0;">الثوابت - إدارة الرموز واسم الهيئة</h2>
        </div>

        <!-- Icon Preview Area -->
        <div style="display:flex;flex-direction:column;align-items:center;gap:14px;margin:8px 0 18px 0;">
            <div style="width:180px;height:180px;border-radius:16px;border:1px solid #e5e7eb;background:
                linear-gradient(45deg,#f3f4f6 25%,transparent 25%),
                linear-gradient(-45deg,#f3f4f6 25%,transparent 25%),
                linear-gradient(45deg,transparent 75%,#f3f4f6 75%),
                linear-gradient(-45deg,transparent 75%,#f3f4f6 75%);
                background-size:20px 20px;background-position:0 0,0 10px,10px -10px,-10px 0;display:flex;align-items:center;justify-content:center;">
                @if($iconUrl)
                    <img id="iconPreview" src="{{ $iconUrl }}" alt="Sidebar Icon" style="max-width:150px;max-height:150px;object-fit:contain;background:#fff;border-radius:10px;padding:8px;">
                @else
                    <div id="iconPlaceholder" style="color:#64748b;text-align:center;">
                        <i class="fas fa-image" style="font-size:2.2rem;margin-bottom:6px;display:block;"></i>
                        <div>لا توجد أيقونة حالياً</div>
                    </div>
                @endif
            </div>
            <div style="color:#64748b;font-size:0.9rem;">حجم الصورة المقترح 128×128 بكسل (PNG أو SVG)</div>
            <div class="d-flex justify-content-center" style="margin-top:10px;">
                <button id="toggleEdit" type="button" class="btn btn-secondary" style="border-radius:8px;background:#174032;color:#fff;font-family:'Cairo',sans-serif;padding:0.55rem 1.5rem;font-size:0.98rem;min-width:160px;display:flex;align-items:center;justify-content:center;gap:8px;">
                    <i class="fas fa-edit"></i>
                    <span>تبديل الأيقونة</span>
                </button>
            </div>
        </div>

        <!-- Hidden form: triggered by the edit button -->
        <div id="editPanel" style="display:none;">
            <form id="iconForm" action="{{ route('constants.icons.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="sidebar_icon" id="sidebar_icon" accept="image/png,image/jpeg,image/jpg,image/svg+xml" style="display:none;">
                @error('sidebar_icon')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </form>
        </div>

        <hr style="margin: 1.4rem 0; border-top: 1px solid #e5e7eb;" />

        <!-- Site Name (اسم الهيئة) -->
        <div class="row g-3 align-items-end">
            <div class="col-12 col-md-9">
                <label for="site_name" class="form-label" style="color:#174032;font-weight:700;">اسم الهيئة</label>
                <form id="siteNameForm" action="{{ route('constants.site-name.update') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $siteName) }}" class="form-control" placeholder="أدخل اسم الهيئة" style="border-radius:10px;border:1px solid #cbd5e1;padding:0.55rem 0.75rem;">
                    <button type="submit" class="btn btn-success" style="border-radius:10px;background:#174032;color:#fff;font-weight:700;min-width:140px;">حفظ الاسم</button>
                </form>
                @error('site_name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                @if(session('success') && str_contains(session('success'), 'اسم الهيئة'))
                    <div class="alert alert-success mt-2">{{ session('success') }}</div>
                @endif
            </div>
            <div class="col-12 col-md-3">
                <div class="text-center" style="color:#64748b;">
                    <div style="font-size:0.9rem;">المعاينة</div>
                    <div id="siteNamePreview" style="margin-top:6px;font-weight:900;color:#174032;font-size:1.1rem;">{{ $siteName ?: '—' }}</div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    (function(){
        const toggleBtn = document.getElementById('toggleEdit');
        const editPanel = document.getElementById('editPanel');
        // no cancel button — we open the file picker directly
        const input = document.getElementById('sidebar_icon');
        const preview = document.getElementById('iconPreview');
        const placeholder = document.getElementById('iconPlaceholder');
        const flash = document.getElementById('flashSuccess');
        const siteNameInput = document.getElementById('site_name');
        const siteNamePreview = document.getElementById('siteNamePreview');

        function setExpanded(expanded){
            editPanel.style.display = expanded ? 'block' : 'none';
            toggleBtn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                if (input) input.click();
            });
        }
        // no cancel handler
        if (input) {
            input.addEventListener('change', (e) => {
                const file = e.target.files && e.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (ev) => {
                    if (preview) {
                        preview.src = ev.target.result;
                        preview.style.display = 'block';
                    }
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                };
                reader.readAsDataURL(file);
                // Auto submit after preview
                const form = document.getElementById('iconForm');
                if (form) form.submit();
            });
        }

        // Auto-dismiss success alert
        if (flash) {
            setTimeout(() => {
                flash.style.opacity = '0';
                setTimeout(() => flash.remove(), 600);
            }, 2500);
        }

        // Live preview for site name
        if (siteNameInput && siteNamePreview) {
            siteNameInput.addEventListener('input', () => {
                siteNamePreview.textContent = siteNameInput.value.trim() || '—';
            });
        }
    })();
</script>
@endsection
