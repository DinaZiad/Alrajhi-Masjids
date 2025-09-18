@extends('layouts.admin')
@section('content')
<div class="programs-page-container" style="max-width:1200px;margin:0 auto;">
    <div class="programs-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="programs-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;">برامج المسجد: {{ $masjid->name }}</h2>
            <a href="{{ route('masjids.programs.create', $masjid) }}" class="btn programs-add-btn">إضافة برنامج جديد</a>
        </div>
        <div class="filter-btns mb-4 text-center">
            <button class="btn programs-filter-btn active" data-target="scientific">الدروس العلمية</button>
            <button class="btn programs-filter-btn" data-target="halaqat">الحلقات التحفيظية</button>
            <button class="btn programs-filter-btn" data-target="imama">الأئمة</button>
            <button class="btn programs-filter-btn programs-filter-btn-all" data-target="all">عرض الكل</button>
        </div>
        <div class="table-section active" id="table-scientific">
            <h4 class="programs-section-title">الدروس العلمية</h4>
            <div class="table-responsive-x">
                <table class="programs-table">
                    <thead>         
                        <tr>
                            <th>الإجراءات</th>
                            <th>رابط البث</th>
                            <th>المحاضر</th>
                            <th>الموقع</th>
                            <th>الترجمة</th>
                            <th>اللغة</th>
                            <th>الحضور</th>
                            <th>الوقت من</th>
                            <th>الوقت إلى</th>
                            <th>الحالة</th>
                            <th>المستوى</th>
                            <th>التخصص</th>
                            <th>المجال</th>
                            <th>الكتاب</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs->where('program_type', 'درس علمي') as $program)
                        <tr>
                            <td style="padding:0.9rem 0.5rem;text-align:center;white-space:nowrap;">
                                <a href="{{ route('masjids.programs.edit', [$masjid, $program]) }}" class="btn btn-sm btn-warning" title="تعديل" style="margin-left: 0.25rem;"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('masjids.programs.destroy', [$masjid, $program]) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="حذف" onclick="return confirm('هل أنت متأكد من الحذف؟');"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                            <td><a href="{{ $program->teacher_link }}" target="_blank">{{ $program->teacher_link }}</a></td>
                            <td>{{ $program->teacher }}</td>
                            <td>
                                <div class="location-badge-row">
                                    @if($program->locationRelation)
                                        <span class="location-main-badge">{{ $program->locationRelation->name }}</span>
                                    @endif
                                    @if((is_array($program->location) && count($program->location)) || (!is_array($program->location) && $program->location))
                                        <span class="location-connector">
                                            <i class="fas fa-chevron-left"></i>
                                        </span>
                                    @endif
                                    @if(is_array($program->location) && count($program->location))
                                        @foreach($program->location as $loc)
                                            <span class="location-detail-badge">{{ $loc }}</span>
                                        @endforeach
                                    @elseif(!is_array($program->location) && $program->location)
                                        <span class="location-detail-badge">{{ $program->location }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $program->notes }}</td>
                            <td>{{ $program->attendance_type }}</td>
                            <td>{{ $program->start_time }}</td>
                            <td>{{ $program->end_time }}</td>
                            <td>{{ $program->status }}</td>
                            <td>{{ $program->level }}</td>
                            <td>{{ $program->specialty }}</td>
                            <td>{{ $program->field }}</td>
                            <td>{{ $program->book }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="table-section" id="table-halaqat">
            <h4 class="programs-section-title">الحلقات التحفيظية</h4>
            <div class="table-responsive-x">
                <table class="programs-table">
                    <thead>
                        <tr>
                            <th>الإجراءات</th>
                            <th>رابط البث</th>
                            <th>المعلم</th>
                            <th>الموقع</th>
                            <th>الترجمة</th>
                            <th>اللغة</th>
                            <th>الحضور</th>
                            <th>الوقت من</th>
                            <th>الوقت إلى</th>
                            <th>الحالة</th>
                            <th>المستوى</th>
                            <th>الحلقة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs->where('program_type', 'حلقة تحفيظ') as $program)
                        <tr>
                            <td style="padding:0.9rem 0.5rem;text-align:center;white-space:nowrap;">
                                <a href="{{ route('masjids.programs.edit', [$masjid, $program]) }}" class="btn btn-sm btn-warning" title="تعديل"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('masjids.programs.destroy', [$masjid, $program]) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="حذف" onclick="return confirm('هل أنت متأكد من الحذف؟');"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                            <td><a href="{{ $program->instructor_link }}" target="_blank">{{ $program->instructor_link }}</a></td>
                            <td>{{ $program->instructor }}</td>
                            <td>
                                <div class="location-badge-row">
                                    @if($program->locationRelation)
                                        <span class="location-main-badge">{{ $program->locationRelation->name }}</span>
                                    @endif
                                    @if((is_array($program->location) && count($program->location)) || (!is_array($program->location) && $program->location))
                                        <span class="location-connector">
                                            <i class="fas fa-chevron-left"></i>
                                        </span>
                                    @endif
                                    @if(is_array($program->location) && count($program->location))
                                        @foreach($program->location as $loc)
                                            <span class="location-detail-badge">{{ $loc }}</span>
                                        @endforeach
                                    @elseif(!is_array($program->location) && $program->location)
                                        <span class="location-detail-badge">{{ $program->location }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $program->notes }}</td>
                            <td>{{ $program->attendance_type }}</td>
                            <td>{{ $program->start_time }}</td>
                            <td>{{ $program->end_time }}</td>
                            <td>{{ $program->status }}</td>
                            <td>{{ $program->level }}</td>
                            <td>{{ $program->group }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="table-section" id="table-imama">
            <h4 class="programs-section-title">جدول الأئمة</h4>
            <div class="table-responsive-x">
                <table class="programs-table wide-table">
                    <thead>
                        <tr>
                            <th>الإجراءات</th>
                            <th>التاريخ</th>
                            <th>اليوم</th>
                            <th>أذان الفجر</th>
                            <th>إقامة الفجر</th>
                            <th>إمام الفجر</th>
                            <th>أذان الظهر</th>
                            <th>إقامة الظهر</th>
                            <th>إمام الظهر</th>
                            <th>أذان العصر</th>
                            <th>إقامة العصر</th>
                            <th>إمام العصر</th>
                            <th>أذان المغرب</th>
                            <th>إقامة المغرب</th>
                            <th>إمام المغرب</th>
                            <th>أذان العشاء</th>
                            <th>إقامة العشاء</th>
                            <th>إمام العشاء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs->where('program_type', 'إمامة') as $program)
                        <tr>
                            <td style="padding:0.9rem 0.5rem;text-align:center;white-space:nowrap;">
                                <a href="{{ route('masjids.programs.edit', [$masjid, $program]) }}" class="btn btn-sm btn-warning" title="تعديل"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('masjids.programs.destroy', [$masjid, $program]) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="حذف" onclick="return confirm('هل أنت متأكد من الحذف؟');"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                            <td>{{ $program->date }}</td>
                            <td>{{ $program->day }}</td>
                            <td>{{ $program->adhan_fajr }}</td>
                            <td>{{ $program->iqama_fajr }}</td>
                            <td>{{ $program->imam_fajr }}</td>
                            <td>{{ $program->adhan_dhuhr }}</td>
                            <td>{{ $program->iqama_dhuhr }}</td>
                            <td>{{ $program->imam_dhuhr }}</td>
                            <td>{{ $program->adhan_asr }}</td>
                            <td>{{ $program->iqama_asr }}</td>
                            <td>{{ $program->imam_asr }}</td>
                            <td>{{ $program->adhan_maghrib }}</td>
                            <td>{{ $program->iqama_maghrib }}</td>
                            <td>{{ $program->imam_maghrib }}</td>
                            <td>{{ $program->adhan_isha }}</td>
                            <td>{{ $program->iqama_isha }}</td>
                            <td>{{ $program->imam_isha }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    .programs-page-container { font-family: 'Cairo', sans-serif; }
    .programs-table-card { }
    .programs-title { }
    .programs-add-btn {
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
    .programs-add-btn:focus, .programs-add-btn:hover {
        background: #174032 !important;
        color: #fff !important;
    }
    .programs-filter-btn {
        border-radius: 8px;
        font-weight: 700;
        padding: 0.5rem 1.5rem;
        font-size: 1.07rem;
        border: 1.5px solid #174032;
        background: #fff;
        color: #174032;
        margin: 0 0.18em;
        transition: background 0.18s, color 0.18s;
    }
    .programs-filter-btn.active, .programs-filter-btn:focus, .programs-filter-btn:hover {
        background: #174032 !important;
        color: #d4af37 !important;
        border: 1.5px solid #174032 !important;
    }
    .programs-filter-btn-all {
        border: 1.5px solid #d4af37;
        color: #d4af37;
        background: #fff;
    }
    .programs-filter-btn-all.active, .programs-filter-btn-all:focus, .programs-filter-btn-all:hover {
        background: #d4af37 !important;
        color: #174032 !important;
        border: 1.5px solid #d4af37 !important;
    }
    .programs-section-title {
        font-family: 'Cairo', sans-serif;
        font-weight: 700;
        color: #174032;
        font-size: 1.18rem;
        margin-bottom: 1.2rem;
        border-bottom: 2px solid #d4af37;
        padding-bottom: 0.3rem;
        text-align: center;
    }
    .programs-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 1.07rem;
        font-family: 'Cairo',sans-serif;
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(30,41,59,0.07);
    }
    .programs-table th, .programs-table td {
        border: none !important;
        padding: 0.9rem 0.5rem;
        text-align: center;
        vertical-align: middle;
        background: transparent;
    }
    .programs-table thead tr {
        background: linear-gradient(135deg,#174032 0%,#174032 100%);
        color: #d4af37;
        font-weight: 700;
    }
    .programs-table thead tr:hover, .programs-table thead th:hover {
        background: linear-gradient(135deg,#174032 0%,#174032 100%) !important;
        color: #d4af37 !important;
    }
    .programs-table tr {
        background: #fff;
        transition: background 0.18s;
        position: relative;
    }
    .programs-table tbody tr:not(:last-child)::after {
        content: '';
        display: block;
        position: absolute;
        right: 1.5rem;
        left: 1.5rem;
        bottom: 0;
        height: 1.5px;
        background: linear-gradient(90deg,rgba(201,176,55,0.18) 0%,#d4af37 50%,rgba(201,176,55,0.18) 100%);
        border-radius: 1px;
    }
    .programs-table tr:hover {
        background: #f8f6f0 !important;
    }
    .programs-btn {
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
    .programs-btn-action {
        min-width: 92px;
        max-width: 92px;
        width: 92px;
        min-height: 28px;
        max-height: 28px;
        padding: 0.32rem 0 !important;
        font-size: 0.93rem !important;
    }
    .programs-btn:focus, .programs-btn:hover,
    .programs-btn-action:focus, .programs-btn-action:hover {
        border: 1.5px solid #174032 !important;
        background: #174032 !important;
        color: #fff !important;
    }
    .wide-table { min-width: 1200px; }
    .table-responsive-x { overflow-x: auto; width: 100%; }
    .table-section { display: none; }
    .table-section.active { display: block; }
    .location-main-badge {
        display: inline-block;
        background: #174032;
        color: #d4af37;
        font-family: 'Cairo',sans-serif;
        font-weight: 700;
        border-radius: 8px;
        padding: 0.32em 1em;
        font-size: 0.98em;
        margin-left: 0.18em;
        margin-right: 0.18em;
        border: 1.5px solid #d4af37;
        vertical-align: middle;
        white-space: nowrap;
    }
    .location-detail-badge {
        display: inline-block;
        background: #fffbe6;
        color: #174032;
        font-family: 'Cairo',sans-serif;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.28em 0.9em;
        font-size: 0.95em;
        margin-left: 0.12em;
        margin-right: 0.12em;
        border: 1.2px solid #d4af37;
        vertical-align: middle;
        white-space: nowrap;
    }
    .location-badge-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.18em;
        justify-content: center;
    }
    .location-connector {
        display: inline-flex;
        align-items: center;
        color: #d4af37;
        font-size: 1.1em;
        margin: 0 0.18em;
        padding-bottom: 2px;
        position: relative;
    }
    .location-connector i {
        font-weight: bold;
        font-size: 1.1em;
        vertical-align: middle;
        filter: drop-shadow(0 1px 2px rgba(201,176,55,0.12));
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btns = document.querySelectorAll('.filter-btns .btn');
        const sections = {
            scientific: document.getElementById('table-scientific'),
            halaqat: document.getElementById('table-halaqat'),
            imama: document.getElementById('table-imama'),
        };
        btns.forEach(btn => {
            btn.addEventListener('click', function() {
                btns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                // Hide all sections first
                Object.values(sections).forEach(sec => sec.classList.remove('active'));
                // Show selected section(s)
                if (this.dataset.target === 'all') {
                    Object.values(sections).forEach(sec => sec.classList.add('active'));
                } else {
                    sections[this.dataset.target].classList.add('active');
                }
            });
        });
        // On page load, show only the first section
        Object.values(sections).forEach((sec, i) => {
            if (i === 0) {
                sec.classList.add('active');
            } else {
                sec.classList.remove('active');
            }
        });
    });
</script>
@section('scripts')
@include('partials.delete-modal', ['entityType' => 'البرنامج'])
@endsection
@endsection 