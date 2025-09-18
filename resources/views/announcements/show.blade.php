@extends('layouts.admin')

@section('content')
<x-breadcrumb :items="[
    ['title' => 'الإعلانات', 'url' => route('announcements.index')],
    ['title' => 'تفاصيل الإعلان']
]" />
<div style="height:2.5rem;"></div>
<div class="announcements-page-container" style="max-width:1200px;margin:0 auto;">
    <div class="announcements-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        <h2 class="announcements-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:2rem;">تفاصيل الإعلان</h2>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المعرف:</label>
                <p style="font-family:'Cairo',sans-serif;">{{ $announcement->id }}</p>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المحتوى:</label>
                <p style="font-family:'Cairo',sans-serif;">{{ $announcement->content }}</p>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">تاريخ البدء:</label>
                <p style="font-family:'Cairo',sans-serif;">{{ $announcement->display_start_at }}</p>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">تاريخ الانتهاء:</label>
                <p style="font-family:'Cairo',sans-serif;">{{ $announcement->display_end_at }}</p>
            </div>
        </div>
        
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('announcements.edit', $announcement) }}" class="btn btn-warning" style="border-radius:8px;background:#d4af37;color:#174032;font-weight:700;font-family:'Cairo',sans-serif;padding:0.7rem 2.1rem;font-size:1.07rem;min-width:140px;">
                <i class="fas fa-edit me-2"></i> تعديل
            </a>
            <a href="{{ route('announcements.index') }}" class="btn btn-secondary" style="border-radius:8px;background:#174032;color:#fff;font-family:'Cairo',sans-serif;padding:0.7rem 2.1rem;font-size:1.07rem;min-width:140px;">
                <i class="fas fa-arrow-right me-2"></i> رجوع
            </a>
        </div>
    </div>
</div>
@endsection
