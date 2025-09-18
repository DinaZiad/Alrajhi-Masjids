@extends('layouts.admin')

@section('content')
<x-breadcrumb :items="[
    ['title' => 'الثوابت'],
    ['title' => 'المجالات', 'url' => route('constants.program-types')],
    ['title' => 'تعديل المجال']
]" />
<div style="height:2.5rem;"></div>
<div class="container-fluid px-2">
    <div class="programs-table-card" style="width:100%;background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:1.4rem 1.2rem;border-top:5px solid #d4af37;">
        <h2 style="font-weight:900;color:#174032;font-size:1.4rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:1.4rem;">تعديل المجال</h2>

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

        <form method="POST" action="{{ route('constants.program-types.update', $programType) }}" class="mb-3">
            @csrf
            @method('PUT')
            <div class="row g-3 align-items-end">
                <div class="col-md-10">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اسم المجال</label>
                    <input type="text" name="name" value="{{ old('name', $programType->name) }}" class="form-control" placeholder="مثال: درس علمي" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <a href="{{ route('constants.program-types') }}" class="btn btn-secondary w-50" style="border-radius:8px;">رجوع</a>
                    <button class="btn btn-primary w-50" style="border-radius:8px;background:#d4af37;color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">حفظ</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
