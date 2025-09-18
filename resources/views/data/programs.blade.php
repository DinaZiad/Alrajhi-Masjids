@extends('layouts.admin')

@section('content')
@include('components.breadcrumb', [
    'items' => [
        ['title' => 'البيانات', 'url' => route('data.programs')],
        ['title' => 'عرض البيانات']
    ]
])
<div style="height:2.5rem;"></div>
<div class="container perms-container perms-wide no-bg" style="max-width:100%;">
    <div class="programs-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:1.4rem 1.2rem;border-top:5px solid #d4af37;">
        <h2 style="font-weight:900;color:#174032;font-size:1.4rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:1.4rem;">عرض البيانات - جميع البرامج</h2>

        <!-- Filters -->
        <form method="GET" action="{{ route('data.programs') }}" class="mb-3">
            <div class="filters-grid">
                <div class="col-span-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المسجد</label>
                    <select name="masjid_id" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">الكل</option>
                        @foreach($masjids as $m)
                            <option value="{{ $m->id }}" {{ (string)$masjidId === (string)$m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">نوع البرنامج</label>
                    <select name="program_type" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">الكل</option>
                        @foreach($programTypes as $type)
                            <option value="{{ $type }}" {{ (string)$programType === (string)$type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الموقع</label>
                    <select name="location_id" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">الكل</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ (string)$locationId === (string)$loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الحالة</label>
                    <input type="text" name="status" value="{{ $status }}" class="form-control" placeholder="ابحث في الحالة" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;" />
                </div>
                <div class="col-span-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">المعلم / المدرس</label>
                    <input type="text" name="teacher" value="{{ $teacher }}" class="form-control" placeholder="اكتب اسم المعلم" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;" />
                </div>
                <div class="col-span-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">التخصص / المجال</label>
                    <input type="text" name="major" value="{{ $major }}" class="form-control" placeholder="اكتب التخصص أو المجال" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;" />
                </div>
                <div class="col-span-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الكتاب</label>
                    <input type="text" name="book" value="{{ $book }}" class="form-control" placeholder="اكتب اسم الكتاب" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;" />
                </div>
                <div class="col-span-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اليوم</label>
                    <select name="day" class="form-select" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                        <option value="">الكل</option>
                        @foreach($days as $d)
                            <option value="{{ $d }}" {{ (string)$day === (string)$d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الوقت من</label>
                    <input type="time" name="time_from" value="{{ $timeFrom }}" class="form-control" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;" />
                </div>
                <div class="col-span-4 mb-2">
                    <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">الوقت إلى</label>
                    <input type="time" name="time_to" value="{{ $timeTo }}" class="form-control" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;" />
                </div>
            </div>
            <div class="d-flex justify-content-center gap-2 mt-2">
                <button class="btn btn-primary" style="border-radius:8px;background:#d4af37;color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">تصفية</button>
                <a href="{{ route('data.programs') }}" class="btn btn-secondary" style="border-radius:8px;background:#174032;color:#fff;font-family:'Cairo',sans-serif;">إعادة تعيين</a>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle programs-table">
                <thead class="table-head">
                    <tr>
                        <th>#</th>
                        <th>المسجد</th>
                        <th>النوع</th>
                        <th>الاسم</th>
                        <th>الحالة</th>
                        <th>المستوى</th>
                        <th>نوع الحضور</th>
                        <th>اليوم</th>
                        <th class="text-center">من</th>
                        <th class="text-center">إلى</th>
                        <th class="text-center">أضيف في</th>
                        <th>ملاحظات</th>
                        <th class="actions-col">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programs as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ optional($p->masjid)->name }}</td>
                            <td>{{ $p->program_type }}</td>
                            <td>{{ $p->name }}</td>
                            <td>
                                <span class="pill pill-status" title="{{ $p->status }}">{{ $p->status ?: '—' }}</span>
                            </td>
                            <td>{{ $p->level }}</td>
                            <td>
                                <span class="pill pill-attendance" title="{{ $p->attendance_type }}">{{ $p->attendance_type ?: '—' }}</span>
                            </td>
                            <td>{{ $p->day }}</td>
                            <td class="text-center">{{ $p->start_time }}</td>
                            <td class="text-center">{{ $p->end_time }}</td>
                            <td class="text-center">{{ $p->created_at?->format('Y-m-d') }}</td>
                            <td style="min-width:220px;">
                                <div class="note-preview" data-program-id="{{ $p->id }}" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:260px;">
                                    {{ \Illuminate\Support\Str::limit($p->notes, 80) ?: '—' }}
                                </div>
                                <div class="note-editor mt-2" data-program-id="{{ $p->id }}" style="display:none;">
                                    <textarea class="form-control note-text" rows="2" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;resize:vertical;">{{ $p->notes }}</textarea>
                                    <div class="d-flex justify-content-end gap-2 mt-1">
                                        <button type="button" class="btn btn-sm btn-success save-note" data-program-id="{{ $p->id }}" style="background:#174032;border-color:#174032;">حفظ</button>
                                        <button type="button" class="btn btn-sm btn-light cancel-note" data-program-id="{{ $p->id }}">إلغاء</button>
                                    </div>
                                </div>
                            </td>
                            <td class="actions-col">
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <a href="{{ route('masjids.programs.edit', [$p->masjid_id, $p->id]) }}" class="btn btn-sm btn-outline-primary" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('masjids.programs.destroy', [$p->masjid_id, $p->id]) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="return_url" value="{{ request()->fullUrl() }}">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-outline-warning toggle-note" title="تعديل الملاحظة" data-program-id="{{ $p->id }}">
                                        <i class="fas fa-bell"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="text-center">لا توجد بيانات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $programs->links() }}
        </div>
    </div>
</div>
<style>
    /* 5 columns on desktop to keep all filters within two rows */
    .filters-grid { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 10px; align-items: end; }
    /* Force each legacy .col-span-4 to occupy one column within this grid */
    .filters-grid > .col-span-4 { grid-column: span 1; }
    /* Tablet: 4 columns */
    @media (max-width: 1199.98px) { .filters-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
    /* Mobile: 2 columns */
    @media (max-width: 575.98px) { .filters-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }

    /* Table polish */
    .programs-table { font-family: 'Cairo', sans-serif; border-collapse: separate; border-spacing: 0 .5rem; width: 100%; }
    .programs-table td, .programs-table th { vertical-align: middle; padding: 10px 12px; }
    .programs-table .table-head { background: linear-gradient(135deg,#174032 0%,#174032 100%); color: #d4af37; position: sticky; top: 0; z-index: 2; }
    .programs-table .table-head th { position: sticky; top: 0; background: linear-gradient(135deg,#174032 0%,#174032 100%); color: #d4af37; text-wrap: nowrap; }
    .programs-table tbody tr { background: #fff; transition: background 0.18s; }
    .programs-table tbody tr:hover { background: #faf9f6 !important; }
    .programs-table .actions-col { text-align: center; min-width: 150px; position: sticky; right: 0; background: #fff; z-index: 1; box-shadow: -6px 0 10px -6px rgba(0,0,0,0.08); }
    .programs-table thead .actions-col { right: 0; z-index: 3; }
    .programs-table .pill { display: inline-block; padding: 2px 10px; border-radius: 999px; font-size: 0.85rem; border: 1px solid #d4af37; background: #fff8e1; color: #174032; }
    .programs-table .pill-attendance { background: #eef7f2; border-color: #a8d5bf; }
    .programs-table .pill-status { background: #fff8e1; border-color: #d4af37; }
    .programs-table .btn { padding: 4px 8px; }
    .programs-table .note-preview { max-width: 260px; }

    /* Make the table wrapper scroll so sticky header/column work */
    .table-responsive { overflow: visible; max-height: none; }

    /* Responsive tweaks: hide less-critical columns on narrow screens */
    @media (max-width: 767.98px) {
        .programs-table th:nth-child(6), .programs-table td:nth-child(6) { display: none; } /* المستوى */
        .programs-table th:nth-child(11), .programs-table td:nth-child(11) { display: none; } /* أضيف في */
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const token = '{{ csrf_token() }}';
        function toggleEditor(id, show) {
            const editor = document.querySelector('.note-editor[data-program-id="' + id + '"]');
            const preview = document.querySelector('.note-preview[data-program-id="' + id + '"]');
            if (!editor || !preview) return;
            if (show === undefined) show = editor.style.display === 'none';
            editor.style.display = show ? '' : 'none';
            preview.style.display = show ? 'none' : '';
        }
        document.querySelectorAll('.toggle-note').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-program-id');
                toggleEditor(id, true);
            });
        });
        document.querySelectorAll('.cancel-note').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-program-id');
                toggleEditor(id, false);
            });
        });
        document.querySelectorAll('.save-note').forEach(btn => {
            btn.addEventListener('click', async function () {
                const id = this.getAttribute('data-program-id');
                const editor = document.querySelector('.note-editor[data-program-id="' + id + '"]');
                const textarea = editor ? editor.querySelector('.note-text') : null;
                if (!textarea) return;
                const notes = textarea.value;
                try {
                    const res = await fetch(`{{ url('/admin/data/programs') }}/${id}/note`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                        },
                        body: JSON.stringify({ notes })
                    });
                    if (!res.ok) throw new Error('Network error');
                    const data = await res.json();
                    const preview = document.querySelector('.note-preview[data-program-id="' + id + '"]');
                    if (preview) {
                        const text = (data.notes || '').trim();
                        preview.textContent = text ? (text.length > 80 ? text.slice(0, 77) + '…' : text) : '—';
                    }
                    toggleEditor(id, false);
                } catch (e) {
                    alert('تعذر حفظ الملاحظة');
                }
            });
        });
    });
</script>
@endsection
