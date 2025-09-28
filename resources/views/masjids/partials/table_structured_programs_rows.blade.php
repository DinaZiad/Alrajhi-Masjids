@foreach($programs as $program)
<tr>
    @if(isset($isHalaqat) && $isHalaqat)
        <td>{{ $program->title ?? '-' }}</td>
        <td>{{ $program->level ? $program->level->name : '-' }}</td>
        <td>
            @if($program->status == 'لم تبدأ')
                <span style="color: #1e3a8a;">في الموعد</span>
            @elseif($program->status == 'في الموعد')
                <span style="color: #1e3a8a;">في الموعد</span>
            @elseif($program->status == 'بدأت')
                <span style="color: #28a745;">بدأت</span>
            @elseif($program->status == 'تأجلت')
                <span style="color: #60a5fa;">تأجلت</span>
            @elseif($program->status == 'اختبار')
                <span style="color: #dc2626;">اختبار</span>
            @elseif($program->status == 'انتهت')
                <span style="color: #dc3545;">انتهت</span>
            @else
                <span style="color: #6c757d;">{{ $program->status }}</span>
            @endif
        </td>
        <td>{{ $program->start_time ? \Carbon\Carbon::parse($program->start_time)->format('h:i') . (\Carbon\Carbon::parse($program->start_time)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
        <td>{{ $program->end_time ? \Carbon\Carbon::parse($program->end_time)->format('h:i') . (\Carbon\Carbon::parse($program->end_time)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
        <td>{{ $program->language ?? '-' }}</td>
        <td>{{ $program->notes ?? '-' }}</td>
        <td>{{ $program->location->building_number ?? '-' }}</td>
        <td>{{ $program->teacher->name ?? '-' }}</td>
        <td>
            @if($program->broadcast_link)
                <a href="{{ $program->broadcast_link }}" class="text-warm-gold hover:text-deep-forest transition-colors" target="_blank">
                    <i class="fas fa-play-circle"></i> مشاهدة
                </a>
            @else
                -
            @endif
        </td>
    @else
        <td>{{ $program->book ? $program->book->title : '-' }}</td>
        <td>{{ $program->section->name ?? '-' }}</td>
        <td>{{ $program->major->name ?? '-' }}</td>
        <td>{{ $program->level ? $program->level->name : '-' }}</td>
        <td>
            @if($program->status == 'لم تبدأ')
                <span style="color: #1e3a8a;">في الموعد</span>
            @elseif($program->status == 'في الموعد')
                <span style="color: #1e3a8a;">في الموعد</span>
            @elseif($program->status == 'بدأت')
                <span style="color: #28a745;">بدأت</span>
            @elseif($program->status == 'تأجلت')
                <span style="color: #60a5fa;">تأجلت</span>
            @elseif($program->status == 'اختبار')
                <span style="color: #dc2626;">اختبار</span>
            @elseif($program->status == 'انتهت')
                <span style="color: #dc3545;">انتهت</span>
            @else
                <span style="color: #6c757d;">{{ $program->status }}</span>
            @endif
        </td>
        <td>{{ $program->start_time ? \Carbon\Carbon::parse($program->start_time)->format('h:i') . (\Carbon\Carbon::parse($program->start_time)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
        <td>{{ $program->end_time ? \Carbon\Carbon::parse($program->end_time)->format('h:i') . (\Carbon\Carbon::parse($program->end_time)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
        <td>{{ $program->language ?? '-' }}</td>
        <td>{{ $program->notes ?? '-' }}</td>
        <td>{{ $program->location->building_number ?? '-' }}</td>
        <td>{{ $program->teacher->name ?? '-' }}</td>
        <td>
            @if($program->broadcast_link)
                <a href="{{ $program->broadcast_link }}" class="text-warm-gold hover:text-deep-forest transition-colors" target="_blank">
                    <i class="fas fa-play-circle"></i> مشاهدة
                </a>
            @else
                -
            @endif
        </td>
    @endif
</tr>
@endforeach
@if($programs->isEmpty())
<tr>
    <td colspan="{{ isset($isHalaqat) && $isHalaqat ? '10' : '12' }}" class="text-center" style="padding: 2rem; color: #6c757d; font-style: italic;">لا توجد برامج منظمة</td>
</tr>
@endif