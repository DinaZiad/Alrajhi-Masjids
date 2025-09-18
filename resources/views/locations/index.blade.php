@extends('layouts.admin')

@section('content')
<div class="locations-page-container" style="max-width:1200px;margin:0 auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="locations-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;">قائمة المواقع</h2>
    </div>
    <div class="locations-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        <table class="locations-table" style="width:100%;border-collapse:separate;border-spacing:0 0.5rem;font-size:1.07rem;font-family:'Cairo',sans-serif;">
            <thead>
                <tr style="background:linear-gradient(135deg,#174032 0%,#174032 100%);color:#d4af37;font-weight:700;">
                    <th style="padding:1rem 0.5rem;text-align:center;">اسم الموقع</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">تفاصيل إضافية</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($locations as $location)
                <tr class="locations-row" style="background:#fff;transition:background 0.18s;">
                    <td style="padding:0.9rem 0.5rem;text-align:center;font-weight:500;">{{ $location->name }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">
                        @if(is_array($location->details) && count($location->details))
                            @foreach($location->details as $detail)
                                <span class="badge location-badge">{{ $detail }}</span>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">
                        <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-sm btn-warning" title="تعديل"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('locations.destroy', $location->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="حذف" onclick="return confirm('هل أنت متأكد من الحذف؟');"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<style>
    .locations-table th, .locations-table td { border: none !important; }
    .locations-row:hover { background: #faf9f6 !important; }
    .locations-add-btn {
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
    .locations-add-btn:focus, .locations-add-btn:hover {
        background: #174032 !important;
        color: #fff !important;
    }
    .location-badge {
        background: #174032 !important;
        color: #d4af37 !important;
        font-family: 'Cairo',sans-serif !important;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.38em 1.1em;
        font-size: 0.98em;
        margin: 0 0.18em;
        box-shadow: 0 1px 4px rgba(30,41,59,0.07);
        letter-spacing: 0.5px;
        border: 1.5px solid #d4af37;
        display: inline-block;
    }
    .locations-btn {
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
    .locations-btn-action {
        min-width: 92px;
        max-width: 92px;
        width: 92px;
        min-height: 28px;
        max-height: 28px;
        padding: 0.32rem 0 !important;
        font-size: 0.93rem !important;
    }
    .locations-btn:focus, .locations-btn:hover,
    .locations-btn-action:focus, .locations-btn-action:hover {
        border: 1.5px solid #174032 !important;
        background: #174032 !important;
        color: #fff !important;
    }
</style>
@endsection

@section('scripts')
@include('partials.delete-modal', ['entityType' => 'الموقع'])
@endsection 