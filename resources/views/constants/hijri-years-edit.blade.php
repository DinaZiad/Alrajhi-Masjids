@extends('layouts.admin')

@section('content')
<x-breadcrumb :items="[
    ['title' => 'الثوابت'],
    ['title' => 'السنوات الهجرية', 'url' => route('constants.hijri-years')],
    ['title' => 'تعديل السنة الهجرية']
]" />
<div style="height:2.5rem;"></div>
<div class="container-fluid px-2" style="min-height:80vh; display:flex; align-items:center; justify-content:center;">
    <div class="programs-table-card" style="width:100%;background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:1.4rem 1.2rem;border-top:5px solid #d4af37;">
        <h2 style="font-weight:900;color:#174032;font-size:1.4rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:1.4rem;">تعديل السنة الهجرية</h2>

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

        <form method="POST" action="{{ route('constants.hijri-years.update', $hijriYear) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">السنة الهجرية</label>
                    <input type="number" name="year" value="{{ old('year', $hijriYear->year) }}" class="form-control" placeholder="1446" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">بداية السنة (ميلادي)</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $hijriYear->start_date) }}" class="form-control" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">نهاية السنة (ميلادي)</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $hijriYear->end_date) }}" class="form-control" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                </div>
            </div>
            <div class="d-flex align-items-center mt-4">
                <button class="btn btn-primary" style="min-width: 140px; padding: 0.6rem 1.5rem; border-radius: 8px; background: #d4af37; color: #174032; font-weight: 700; font-family: 'Cairo', sans-serif; border: 2px solid #d4af37;">حفظ</button>
                <a href="{{ route('constants.hijri-years') }}" class="btn ms-auto" style="border-radius:8px;background:#e2e8f0;color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">عودة</a>
            </div>
        </form>
        </div>
    </div>
@endsection
