@extends('layouts.admin')

@section('content')
<x-breadcrumb :items="[
    ['title' => 'الثوابت'],
    ['title' => 'المساجد']
]" />
<div style="height:2.5rem;"></div>
<div class="masjids-page-container" style="max-width:1200px;margin:0 auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="masjids-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;">قائمة المساجد</h2>
        <div class="d-flex align-items-center gap-3">
           
           
            <a href="{{ route('masjids.create') }}" class="btn masjids-add-btn" style="font-size:0.9rem;padding:0.5rem 1rem;">
                <i class="fas fa-plus me-2"></i>إضافة مسجد جديد
            </a>
        </div>
    </div>
    <div class="masjids-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        <table class="masjids-table" style="width:100%;border-collapse:separate;border-spacing:0 0.5rem;font-size:1.07rem;font-family:'Cairo',sans-serif;">
            <thead>
                <tr style="background:linear-gradient(135deg,#174032 0%,#174032 100%);color:#d4af37;font-weight:700;">
                    <th style="padding:1rem 0.5rem;text-align:center;">اسم المسجد</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">المساحة</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">الطاقة الاستيعابية</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">عدد الأبواب</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">عدد الأروقة</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">عدد المصليات</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">عدد الطائفين/ساعة</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">البرامج</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($masjids as $loopIndex => $masjid)
                <tr class="masjids-row" style="background:#fff;transition:background 0.18s;">
                    <td style="padding:0.9rem 0.5rem;text-align:center;font-weight:500;">{{ $masjid->name }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $masjid->total_area }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $masjid->capacity }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $masjid->gate_count }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $masjid->wing_count }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $masjid->prayer_hall_count }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $masjid->tawaf_per_hour }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">
                        <div class="masjids-programs-btns" style="display:flex;flex-direction:column;gap:0.25rem;align-items:center;justify-content:center;">
                            <!-- Buttons removed as requested -->
                        </div>
                    </td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">
                        <div class="d-flex justify-content-center" style="min-width:90px;white-space:nowrap;">
                            <a href="{{ route('masjids.edit', $masjid->id) }}" class="btn btn-sm btn-warning mx-1" title="تعديل"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('masjids.destroy', $masjid->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger mx-1" title="حذف" onclick="return confirm('هل أنت متأكد من الحذف؟');"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<style>
    .masjids-table th, .masjids-table td { border: none !important; }
    .masjids-row:hover { background: #faf9f6 !important; }
    .masjids-add-btn {
        border-radius: 8px;
        font-weight: 700;
        padding: 0.7rem 2.1rem;
        font-size: 1.07rem;
        box-shadow: 0 2px 8px rgba(30,41,59,0.07);
        border: none;
        background: #d4af37;
        color: #174032;
        transition: background 0.18s, color 0.18s;
    }
    .masjids-add-btn:focus, .masjids-add-btn:hover {
        background: #174032 !important;
        color: #fff !important;
    }
    .masjids-btn, .masjids-btn-program {
        border-radius: 8px !important;
        font-weight: 600 !important;
        padding: 0.32rem 0 !important;
        font-family: 'Cairo',sans-serif !important;
        margin: 0.08rem 0 !important;
        min-width: 92px;
        max-width: 92px;
        width: 92px;
        min-height: 28px;
        max-height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.93rem !important;
        border: 1.5px solid #174032 !important;
    }
    .masjids-btn-program {
        min-width: 92px;
        max-width: 92px;
        width: 92px;
        min-height: 28px;
        max-height: 28px;
        padding: 0.32rem 0 !important;
        font-size: 0.93rem !important;
    }
    .masjids-btn:focus, .masjids-btn:hover,
    .masjids-btn-program:focus, .masjids-btn-program:hover {
        border: 1.5px solid #174032 !important;
        background: #174032 !important;
        color: #fff !important;
    }
</style>
@endsection

@section('scripts')
@include('partials.delete-modal', ['entityType' => 'المسجد'])
@endsection