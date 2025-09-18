@extends('layouts.admin')

@section('content')
<x-breadcrumb :items="[
    ['title' => 'الثوابت'],
    ['title' => 'الكتب']
]" />
<div style="height:2.5rem;"></div>
<div class="container-fluid px-2">
    <div class="programs-table-card" style="width:100%;background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:1.4rem 1.2rem;border-top:5px solid #d4af37;">
        <h2 style="font-weight:900;color:#174032;font-size:1.4rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:1.4rem;">الثوابت - الكتب</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('constants.books.store') }}" class="mb-3">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">القسم</label>
                    <select id="section_id" name="section_id" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">اختر القسم</option>
                        @foreach($sections as $s)
                            <option value="{{ $s->id }}" {{ old('section_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">التخصص</label>
                    <select id="major_id" name="major_id" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">اختر التخصص</option>
                        @foreach($majors as $m)
                            <option value="{{ $m->id }}" data-section="{{ $m->section_id }}" {{ old('major_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">عنوان الكتاب</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="مثال: زاد المستقنع" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المؤلف (اختياري)</label>
                    <input type="text" name="author" value="{{ old('author') }}" class="form-control" placeholder="اسم المؤلف" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button class="btn btn-primary w-100" style="border-radius:8px;background:#d4af37;color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">إضافة</button>
                </div>
                <div class="col-12">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">وصف (اختياري)</label>
                    <input type="text" name="description" value="{{ old('description') }}" class="form-control" placeholder="وصف مختصر" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="announcements-table" style="width:100%;border-collapse:separate;border-spacing:0 0.5rem;font-size:1.07rem;font-family:'Cairo',sans-serif;">
                <thead>
                    <tr style="background:linear-gradient(135deg,#174032 0%,#174032 100%);color:#d4af37;font-weight:700;">
                        <th style="padding:1rem 0.5rem;text-align:center;">#</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">القسم</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">التخصص</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">العنوان</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">المؤلف</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">الوصف</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $b)
                    <tr class="announcements-row" style="background:#fff;transition:background 0.18s;border-radius:8px;">
                        <td style="padding:1rem;text-align:center;font-weight:500;">{{ $b->id }}</td>
                        <td style="padding:1rem;text-align:center;font-weight:600;">{{ $b->major?->section?->name }}</td>
                        <td style="padding:1rem;text-align:center;font-weight:600;">{{ $b->major?->name }}</td>
                        <td style="padding:1rem;text-align:center;font-weight:600;">{{ $b->title }}</td>
                        <td style="padding:1rem;text-align:center;">{{ $b->author }}</td>
                        <td style="padding:1rem;text-align:center;">{{ \Illuminate\Support\Str::limit($b->description, 60) }}</td>
                        <td class="text-center d-flex gap-2 justify-content-center">
                            <a href="{{ route('constants.books.edit', $b) }}" class="btn btn-sm btn-warning icon-btn" title="تعديل"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('constants.books.destroy', $b) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger icon-btn" title="حذف"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">لا توجد كتب مسجلة بعد</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    (function(){
        const sectionSelect = document.getElementById('section_id');
        const majorSelect = document.getElementById('major_id');
        const allMajorOptions = Array.from(majorSelect.options).map(o => ({value:o.value, text:o.text, section:o.getAttribute('data-section')}));

        function filterMajors() {
            const sectionId = sectionSelect.value;
            while (majorSelect.firstChild) majorSelect.removeChild(majorSelect.firstChild);
            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'اختر التخصص';
            majorSelect.appendChild(placeholder);
            allMajorOptions.forEach(opt => {
                if (!opt.value) return; // skip first placeholder
                if (!sectionId || opt.section === sectionId) {
                    const o = document.createElement('option');
                    o.value = opt.value;
                    o.textContent = opt.text;
                    o.setAttribute('data-section', opt.section);
                    if ("{{ old('major_id') }}" && "{{ old('major_id') }}" === opt.value && ("{{ old('section_id') }}" === '' || "{{ old('section_id') }}" === opt.section)) {
                        o.selected = true;
                    }
                    majorSelect.appendChild(o);
                }
            });
        }

        sectionSelect && sectionSelect.addEventListener('change', filterMajors);
        // Initialize on load
        filterMajors();
    })();
</script>
@endsection

<style>
    .main-content { padding-right: 1rem; padding-left: 1rem; }
    .announcements-table th, .announcements-table td { border: none !important; }
    .announcements-row:hover { background: #f8f9fa !important; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .announcements-table-card .btn { transition: all 0.2s ease-in-out; }
    .announcements-table-card .btn:hover { transform: translateY(-1px); box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
    .icon-btn { display: inline-flex; align-items: center; justify-content: center; height: 32px; min-width: 36px; padding: 0; line-height: 1; }
    .icon-btn i { pointer-events: none; }
</style>
