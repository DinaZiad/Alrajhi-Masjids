@extends('layouts.admin')

@section('title', 'عرض البرنامج المنظم')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 15px; border: none; background: linear-gradient(145deg, #ffffff 0%, #ffffff 100%);">
                <div class="card-header" style="background: linear-gradient(135deg, #174032 0%, #174032 100%); color: #d4af37; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-0" style="font-family: 'Cairo', sans-serif; font-weight: 900; font-size: 1.25rem;">
                                <i class="fas fa-eye me-2"></i>
                                عرض البرنامج المنظم: {{ $structuredProgram->title }}
                            </h3>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('admin.structured-programs.edit', $structuredProgram->id) }}" class="btn me-2" 
                               style="background: #d4af37; color: #174032; border: none; border-radius: 8px; padding: 0.5rem 1rem; font-family: 'Cairo', sans-serif; font-weight: 700;">
                                <i class="fas fa-edit me-1"></i>
                                تعديل
                            </a>
                            <a href="{{ route('admin.structured-programs.index') }}" class="btn" 
                               style="background: #e8e8e8; color: #2c3e50; border: none; border-radius: 8px; padding: 0.5rem 1rem; font-family: 'Cairo', sans-serif; font-weight: 700;">
                                <i class="fas fa-arrow-right me-1"></i>
                                العودة
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <div class="row g-4">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <div class="card h-100" style="border: 1px solid #d4af37; border-radius: 10px;">
                                <div class="card-header" style="background: rgba(212, 175, 55, 0.1); border-bottom: 1px solid #d4af37; font-family: 'Cairo', sans-serif; font-weight: 700; color: #174032;">
                                    <i class="fas fa-info-circle me-2"></i>
                                    المعلومات الأساسية
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">عنوان البرنامج:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->title }}</p>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">المسجد:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->masjid->name ?? 'غير محدد' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">الفترة:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->period ?? 'غير محدد' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">الحالة:</label>
                                            <p class="mb-2">
                                                @if($structuredProgram->status == 'active')
                                                    <span class="badge" style="background: #28a745; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-family: 'Cairo', sans-serif;">نشط</span>
                                                @elseif($structuredProgram->status == 'inactive')
                                                    <span class="badge" style="background: #6c757d; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-family: 'Cairo', sans-serif;">غير نشط</span>
                                                @elseif($structuredProgram->status == 'suspended')
                                                    <span class="badge" style="background: #ffc107; color: #212529; padding: 0.5rem 1rem; border-radius: 20px; font-family: 'Cairo', sans-serif;">معلق</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">أيام الأسبوع:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->formatted_weekdays ?: 'غير محدد' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information -->
                        <div class="col-md-6">
                            <div class="card h-100" style="border: 1px solid #d4af37; border-radius: 10px;">
                                <div class="card-header" style="background: rgba(212, 175, 55, 0.1); border-bottom: 1px solid #d4af37; font-family: 'Cairo', sans-serif; font-weight: 700; color: #174032;">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    المعلومات الأكاديمية
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">القسم:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->section->name ?? 'غير محدد' }}</p>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">التخصص:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->major->name ?? 'غير محدد' }}</p>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">الكتاب:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->book->title ?? 'غير محدد' }}</p>
                                            @if($structuredProgram->book && $structuredProgram->book->author)
                                                <small class="text-muted" style="font-family: 'Cairo', sans-serif;">المؤلف: {{ $structuredProgram->book->author }}</small>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">الدرس:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->lesson ?? 'غير محدد' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">المستوى:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->level->name ?? 'غير محدد' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Time and Location Information -->
                        <div class="col-md-6">
                            <div class="card h-100" style="border: 1px solid #d4af37; border-radius: 10px;">
                                <div class="card-header" style="background: rgba(212, 175, 55, 0.1); border-bottom: 1px solid #d4af37; font-family: 'Cairo', sans-serif; font-weight: 700; color: #174032;">
                                    <i class="fas fa-clock me-2"></i>
                                    الوقت والموقع
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">وقت البداية:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->start_time ? \Carbon\Carbon::parse($structuredProgram->start_time)->format('H:i') : 'غير محدد' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">وقت النهاية:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->end_time ? \Carbon\Carbon::parse($structuredProgram->end_time)->format('H:i') : 'غير محدد' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">تاريخ البداية:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->start_date ? \Carbon\Carbon::parse($structuredProgram->start_date)->format('Y-m-d') : 'غير محدد' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">تاريخ النهاية:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->end_date ? \Carbon\Carbon::parse($structuredProgram->end_date)->format('Y-m-d') : 'غير محدد' }}</p>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">الموقع:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->location->name ?? 'غير محدد' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Instructor and Language Information -->
                        <div class="col-md-6">
                            <div class="card h-100" style="border: 1px solid #d4af37; border-radius: 10px;">
                                <div class="card-header" style="background: rgba(212, 175, 55, 0.1); border-bottom: 1px solid #d4af37; font-family: 'Cairo', sans-serif; font-weight: 700; color: #174032;">
                                    <i class="fas fa-user-tie me-2"></i>
                                    المحاضر واللغة
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">المحاضر:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->teacher->name ?? 'غير محدد' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">اللغة:</label>
                                            <p class="mb-2" style="font-family: 'Cairo', sans-serif;">{{ $structuredProgram->language ?? 'غير محدد' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">لغة الإشارة:</label>
                                            <p class="mb-2">
                                                @if($structuredProgram->sign_language_support)
                                                    <span class="badge" style="background: #28a745; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-family: 'Cairo', sans-serif;">
                                                        <i class="fas fa-check me-1"></i>
                                                        مدعوم
                                                    </span>
                                                @else
                                                    <span class="badge" style="background: #6c757d; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-family: 'Cairo', sans-serif;">
                                                        <i class="fas fa-times me-1"></i>
                                                        غير مدعوم
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                        @if($structuredProgram->broadcast_link)
                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">رابط البث:</label>
                                                <p class="mb-2">
                                                    <a href="{{ $structuredProgram->broadcast_link }}" target="_blank" 
                                                       class="btn btn-sm" 
                                                       style="background: #17a2b8; color: white; border: none; border-radius: 5px; font-family: 'Cairo', sans-serif;">
                                                        <i class="fas fa-external-link-alt me-1"></i>
                                                        فتح رابط البث
                                                    </a>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description and Notes -->
                        @if($structuredProgram->description || $structuredProgram->notes)
                            <div class="col-12">
                                <div class="card" style="border: 1px solid #d4af37; border-radius: 10px;">
                                    <div class="card-header" style="background: rgba(212, 175, 55, 0.1); border-bottom: 1px solid #d4af37; font-family: 'Cairo', sans-serif; font-weight: 700; color: #174032;">
                                        <i class="fas fa-file-alt me-2"></i>
                                        الوصف والملاحظات
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            @if($structuredProgram->description)
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">وصف البرنامج:</label>
                                                    <p class="mb-2" style="font-family: 'Cairo', sans-serif; line-height: 1.6;">{{ $structuredProgram->description }}</p>
                                                </div>
                                            @endif
                                            @if($structuredProgram->notes)
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold" style="color: #174032; font-family: 'Cairo', sans-serif;">ملاحظات:</label>
                                                    <p class="mb-2" style="font-family: 'Cairo', sans-serif; line-height: 1.6;">{{ $structuredProgram->notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="col-12">
                            <div class="text-center mt-4">
                                <a href="{{ route('admin.structured-programs.edit', $structuredProgram->id) }}" class="btn btn-lg me-3" 
                                   style="background: linear-gradient(135deg, #d4af37 0%, #d4af37 100%); color: #174032; border: none; border-radius: 10px; padding: 0.75rem 2rem; font-family: 'Cairo', sans-serif; font-weight: 700;">
                                    <i class="fas fa-edit me-2"></i>
                                    تعديل البرنامج
                                </a>
                                <a href="{{ route('admin.structured-programs.index') }}" class="btn btn-lg" 
                                   style="background: #e8e8e8; color: #2c3e50; border: none; border-radius: 10px; padding: 0.75rem 2rem; font-family: 'Cairo', sans-serif; font-weight: 700;">
                                    <i class="fas fa-arrow-right me-2"></i>
                                    العودة للقائمة
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.badge {
    font-family: 'Cairo', sans-serif;
    font-weight: 600;
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
@endpush