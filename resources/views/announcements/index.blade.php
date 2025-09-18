@extends('layouts.admin')

@section('content')
<x-breadcrumb :items="[
    ['title' => 'الإعلانات']
]" />
<div style="height:2.5rem;"></div>
<div class="announcements-page-container" style="max-width:1200px;margin:0 auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="announcements-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;">قائمة الإعلانات</h2>
    </div>
    <div class="announcements-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        <table class="announcements-table" style="width:100%;border-collapse:separate;border-spacing:0 0.5rem;font-size:1.07rem;font-family:'Cairo',sans-serif;">
            <thead>
                <tr style="background:linear-gradient(135deg,#174032 0%,#174032 100%);color:#d4af37;font-weight:700;">
                    <th style="padding:1rem 0.5rem;text-align:center;">#</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">المحتوى</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">عاجل؟</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">المسجد</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">تاريخ البدء</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">تاريخ الانتهاء</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($announcements as $announcement)
                <tr class="announcements-row" style="background:#fff;transition:background 0.18s;">
                    <td style="padding:0.9rem 0.5rem;text-align:center;font-weight:500;">{{ $announcement->id }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $announcement->content }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">
                        @if($announcement->is_urgent)
                            <span class="urgent-indicator" title="إعلان عاجل" style="display:inline-block;vertical-align:middle;">
                                <span class="pulse-gold"></span>
                                <i class="fas fa-bolt" style="color:#C9B037;font-size:1.25em;vertical-align:middle;"></i>
                            </span>
                        @else
                            <span class="not-urgent-indicator" title="غير عاجل" style="display:inline-block;vertical-align:middle;">
                                <span style="display:inline-block;width:18px;height:18px;border-radius:50%;background:#e0e0e0;line-height:18px;text-align:center;font-size:1.1em;color:#b0b0b0;">–</span>
                            </span>
                        @endif
                    </td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $announcement->masjid ? $announcement->masjid->name : '-' }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $announcement->display_start_at }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $announcement->display_end_at }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">
                        <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-sm btn-warning" title="تعديل"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="حذف" onclick="return confirm('هل أنت متأكد من الحذف؟');"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">لا توجد إعلانات حالياً.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if(isset($announcements) && $announcements->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</div>
<style>
    .announcements-table th, .announcements-table td { border: none !important; }
    .announcements-row:hover { background: #faf9f6 !important; }
    .announcements-add-btn {
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
    .announcements-add-btn:focus, .announcements-add-btn:hover {
        background: #174032 !important;
        color: #fff !important;
    }
    .announcements-btn {
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
    .announcements-btn-action {
        min-width: 92px;
        max-width: 92px;
        width: 92px;
        min-height: 28px;
        max-height: 28px;
        padding: 0.32rem 0 !important;
        font-size: 0.93rem !important;
    }
    .announcements-btn:focus, .announcements-btn:hover,
    .announcements-btn-action:focus, .announcements-btn-action:hover {
        border: 1.5px solid #174032 !important;
        background: #174032 !important;
        color: #fff !important;
    }
    .urgent-indicator {
        position: relative;
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .pulse-gold {
        position: absolute;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(201,176,55,0.18);
        animation: pulse-gold 1.2s infinite;
        z-index: 0;
    }
    @keyframes pulse-gold {
        0% { transform: scale(0.9); opacity: 0.7; }
        70% { transform: scale(1.2); opacity: 0.15; }
        100% { transform: scale(0.9); opacity: 0.7; }
    }
    .urgent-indicator i {
        position: relative;
        z-index: 1;
        filter: drop-shadow(0 1px 2px rgba(201,176,55,0.18));
    }
    .not-urgent-indicator span {
        font-weight: bold;
        background: #e0e0e0;
        color: #b0b0b0;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: inline-block;
        line-height: 18px;
        text-align: center;
        font-size: 1.1em;
    }
</style>
@endsection

@section('scripts')
@include('partials.delete-modal', ['entityType' => 'الإعلان'])
@endsection