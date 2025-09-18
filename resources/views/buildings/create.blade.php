@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="programs-table-card" style="width:100%;background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:1.4rem 1.2rem;border-top:5px solid #d4af37;">
        <h2 style="font-weight:900;color:#174032;font-size:1.4rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:1.4rem;">الثوابت - إضافة مبنى</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.constants.buildings.store') }}" method="POST" class="mb-3">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اسم المسجد</label>
                    <select name="masjid_id" class="form-select" required style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">اختر المسجد</option>
                        @foreach($masjids as $m)
                            <option value="{{ $m->id }}" {{ old('masjid_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">رقم المبنى</label>
                    <input type="text" name="building_number" class="form-control" value="{{ old('building_number') }}" required style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الوجهة</label>
                    <input type="text" name="direction" class="form-control" value="{{ old('direction') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;" placeholder="مثال: شمال، جنوب ...">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">عدد الأدوار</label>
                    <input type="number" min="0" name="floors_count" class="form-control" value="{{ old('floors_count', 0) }}" required style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
                <div class="col-12">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الموقع</label>
                    <input type="text" name="labs_halls_count" class="form-control" value="{{ old('labs_halls_count') }}" required style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;" placeholder="أدخل الموقع">
                </div>
                <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                    <a href="{{ route('admin.constants.buildings.index') }}" class="btn btn-secondary" style="border-radius:8px;font-weight:700;font-family:'Cairo',sans-serif;">رجوع</a>
                    <button type="submit" class="btn btn-primary" style="border-radius:8px;background:#d4af37;color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">حفظ</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    .main-content { padding-right: 1rem; padding-left: 1rem; }
    .announcements-table-card .btn { transition: all 0.2s ease-in-out; }
    .announcements-table-card .btn:hover { transform: translateY(-1px); box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
</style>
