@extends('layouts.admin')

@section('content')
<x-breadcrumb :items="[
    ['title' => 'الثوابت'],
    ['title' => 'الكتب', 'url' => route('constants.books')],
    ['title' => 'تعديل الكتاب']
]" />
<div style="height:2.5rem;"></div>
<div class="container-fluid px-2" style="min-height:80vh; display:flex; align-items:center; justify-content:center;">
    <div class="programs-table-card" style="width:100%;background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:1.4rem 1.2rem;border-top:5px solid #d4af37;">
        <h2 style="font-weight:900;color:#174032;font-size:1.4rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:1.4rem;">تعديل الكتاب</h2>

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

        <form method="POST" action="{{ route('constants.books.update', $book) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">القسم</label>
                    <select id="section_id" name="section_id" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">اختر القسم</option>
                        @foreach($sections as $s)
                            <option value="{{ $s->id }}" {{ old('section_id', optional($book->major)->section_id) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">التخصص</label>
                    <select id="major_id" name="major_id" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">اختر التخصص</option>
                        @foreach($majors as $m)
                            <option value="{{ $m->id }}" data-section="{{ $m->section_id }}" {{ old('major_id', $book->major_id) == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">عنوان الكتاب</label>
                    <input type="text" name="title" value="{{ old('title', $book->title) }}" class="form-control" placeholder="عنوان الكتاب" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المؤلف (اختياري)</label>
                    <input type="text" name="author" value="{{ old('author', $book->author) }}" class="form-control" placeholder="اسم المؤلف" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
                <div class="col-12">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">وصف (اختياري)</label>
                    <textarea name="description" rows="3" class="form-control" placeholder="وصف مختصر" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">{{ old('description', $book->description) }}</textarea>
                </div>
            </div>
            <div class="d-flex align-items-center mt-4">
                <button class="btn btn-primary" style="min-width: 140px; padding: 0.6rem 1.5rem; border-radius: 8px; background: #d4af37; color: #174032; font-weight: 700; font-family: 'Cairo', sans-serif; border: 2px solid #d4af37;">حفظ</button>
                <a href="{{ route('constants.books') }}" class="btn ms-auto" style="border-radius:8px;background:#e2e8f0;color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">عودة</a>
            </div>
        </form>
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
                    if ("{{ old('major_id', $book->major_id) }}" === opt.value) {
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
