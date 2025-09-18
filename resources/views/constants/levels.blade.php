@extends('layouts.admin')

@section('content')
<x-breadcrumb :items="[
    ['title' => 'الثوابت'],
    ['title' => 'المستويات']
]" />
<div style="height:2.5rem;"></div>
<div class="container-fluid px-2">
    <div class="programs-table-card" style="width:100%;background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:1.4rem 1.2rem;border-top:5px solid #d4af37;">
        <h2 style="font-weight:900;color:#174032;font-size:1.4rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:1.4rem;">الثوابت - المستويات</h2>

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

        <form method="POST" action="{{ route('constants.levels.store') }}" class="mb-3">
            @csrf
            <div class="row g-3">
                <div class="col-md-6 col-lg-5">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اسم المستوى</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="مثال: المستوى الأول" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
                <div class="col-md-5 col-lg-6">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">رمز المستوى</label>
                    <input type="number" name="symbol" value="{{ old('symbol') }}" class="form-control" placeholder="مثال: 1" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
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
                        <th style="padding:1rem 0.5rem;text-align:center;">#</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">الاسم</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">الرمز</th>
                        <th style="padding:1rem 0.5rem;text-align:center;">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($levels as $l)
                    <tr class="announcements-row" style="background:#fff;transition:background 0.18s;border-radius:8px;">
                        <td style="padding:1rem;text-align:center;font-weight:500;">{{ $l->id }}</td>
                        <td style="padding:1rem;text-align:center;font-weight:600;">{{ $l->name }}</td>
                        <td style="padding:1rem;text-align:center;">{{ $l->symbol }}</td>
                        <td class="text-center d-flex gap-2 justify-content-center">
                            <a href="{{ route('constants.levels.edit', $l) }}" class="btn btn-sm btn-warning icon-btn" title="تعديل"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('constants.levels.destroy', $l) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger icon-btn" title="حذف"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">لا توجد مستويات مسجلة بعد</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<style>
    /* Page-local: widen working area on Levels */
    .main-content { padding-right: 1rem; padding-left: 1rem; }
    .announcements-table th, .announcements-table td { 
        border: none !important; 
    }
    .announcements-row:hover {
        background: #f8f9fa !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .announcements-table-card .btn { transition: all 0.2s ease-in-out; }
    .announcements-table-card .btn:hover { transform: translateY(-1px); box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
    .icon-btn { display: inline-flex; align-items: center; justify-content: center; height: 32px; min-width: 36px; padding: 0; line-height: 1; }
    .icon-btn i { pointer-events: none; }
</style>
