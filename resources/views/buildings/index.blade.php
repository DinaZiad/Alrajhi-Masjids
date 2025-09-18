@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="programs-table-card" style="width:100%;background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:1.4rem 1.2rem;border-top:5px solid #d4af37;">
        <h2 style="font-weight:900;color:#174032;font-size:1.4rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:1.4rem;">الثوابت - المباني</h2>

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

        <form method="POST" action="{{ route('admin.constants.buildings.store') }}" class="mb-3">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اسم المسجد</label>
                    <select name="masjid_id" class="form-select" required style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">اختر المسجد</option>
                        @foreach($masjids as $m)
                            <option value="{{ $m->id }}" {{ old('masjid_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">رقم المبنى</label>
                    <input type="text" name="building_number" class="form-control" value="{{ old('building_number') }}" required style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الوجهة</label>
                    <input type="text" name="direction" class="form-control" value="{{ old('direction') }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;" placeholder="مثال: شمال، جنوب ...">
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">عدد الأدوار</label>
                    <input type="number" min="0" name="floors_count" class="form-control" value="{{ old('floors_count', 0) }}" required style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الموقع</label>
                    <input type="text" name="labs_halls_count" class="form-control" value="{{ old('labs_halls_count') }}" required style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;" placeholder="أدخل الموقع">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button class="btn btn-primary w-100" style="border-radius:8px;background:#d4af37;color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">إضافة</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="announcements-table" style="width:100%;border-collapse:separate;border-spacing:0 0.5rem;font-size:1.07rem;font-family:'Cairo',sans-serif;">
                <thead>
                    <tr style="background:linear-gradient(135deg,#174032 0%,#174032 100%);color:#d4af37;font-weight:700;">
                        <th style="padding:1rem 0.5rem;text-align:center;">الرقم التسلسلي</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">اسم المسجد</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">رقم المبنى</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">الوجهة</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">عدد الأدوار</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">الموقع</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buildings as $b)
                    <tr class="announcements-row" style="background:#fff;transition:background 0.18s;border-radius:8px;">
                        <td style="padding:1rem;text-align:center;font-weight:500;">{{ $b->serial_number }}</td>
                        <td style="padding:1rem;text-align:center;">{{ $b->masjid?->name }}</td>
                        <td style="padding:1rem;text-align:center;font-weight:600;">{{ $b->building_number }}</td>
                        <td style="padding:1rem;text-align:center;">{{ $b->direction }}</td>
                        <td style="padding:1rem;text-align:center;">{{ $b->floors_count }}</td>
                        <td style="padding:1rem;text-align:center;">{{ $b->labs_halls_count }}</td>
                        <td class="text-center d-flex gap-2 justify-content-center">
                            <a href="{{ route('admin.constants.buildings.edit', $b) }}" class="btn btn-sm btn-warning icon-btn" title="تعديل"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.constants.buildings.destroy', $b) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger icon-btn" title="حذف"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">لا توجد مباني مسجلة بعد</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $buildings->links() }}
        </div>
    </div>
</div>
@endsection

<style>
    .main-content { padding-right: 1rem; padding-left: 1rem; }
    .announcements-table th, .announcements-table td { border: none !important; }
    .announcements-row:hover { background: #f8f9fa !important; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .icon-btn { display: inline-flex; align-items: center; justify-content: center; height: 32px; min-width: 36px; padding: 0; line-height: 1; }
    .icon-btn i { pointer-events: none; }
</style>
