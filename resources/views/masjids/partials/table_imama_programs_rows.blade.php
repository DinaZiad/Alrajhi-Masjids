@foreach($programs as $program)
<tr>
    <td>{{ $program->date ? \Carbon\Carbon::parse($program->date)->format('Y-m-d') : '-' }}</td>
    <td>{{ $program->adhan_fajr ? \Carbon\Carbon::parse($program->adhan_fajr)->format('h:i') . (\Carbon\Carbon::parse($program->adhan_fajr)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->iqama_fajr ? \Carbon\Carbon::parse($program->iqama_fajr)->format('h:i') . (\Carbon\Carbon::parse($program->iqama_fajr)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->imam_fajr ?? '-' }}</td>
    <td>{{ $program->adhan_dhuhr ? \Carbon\Carbon::parse($program->adhan_dhuhr)->format('h:i') . (\Carbon\Carbon::parse($program->adhan_dhuhr)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->iqama_dhuhr ? \Carbon\Carbon::parse($program->iqama_dhuhr)->format('h:i') . (\Carbon\Carbon::parse($program->iqama_dhuhr)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->imam_dhuhr ?? '-' }}</td>
    <td>{{ $program->adhan_asr ? \Carbon\Carbon::parse($program->adhan_asr)->format('h:i') . (\Carbon\Carbon::parse($program->adhan_asr)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->iqama_asr ? \Carbon\Carbon::parse($program->iqama_asr)->format('h:i') . (\Carbon\Carbon::parse($program->iqama_asr)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->imam_asr ?? '-' }}</td>
    <td>{{ $program->adhan_maghrib ? \Carbon\Carbon::parse($program->adhan_maghrib)->format('h:i') . (\Carbon\Carbon::parse($program->adhan_maghrib)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->iqama_maghrib ? \Carbon\Carbon::parse($program->iqama_maghrib)->format('h:i') . (\Carbon\Carbon::parse($program->iqama_maghrib)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->imam_maghrib ?? '-' }}</td>
    <td>{{ $program->adhan_isha ? \Carbon\Carbon::parse($program->adhan_isha)->format('h:i') . (\Carbon\Carbon::parse($program->adhan_isha)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->iqama_isha ? \Carbon\Carbon::parse($program->iqama_isha)->format('h:i') . (\Carbon\Carbon::parse($program->iqama_isha)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->imam_isha ?? '-' }}</td>
    <td>{{ $program->adhan_friday ? \Carbon\Carbon::parse($program->adhan_friday)->format('h:i') . (\Carbon\Carbon::parse($program->adhan_friday)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->iqama_friday ? \Carbon\Carbon::parse($program->iqama_friday)->format('h:i') . (\Carbon\Carbon::parse($program->iqama_friday)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->imam_friday ?? '-' }}</td>
    <td>
        @if($program->status == 'لم تبدأ')
            <span style="color: #6c757d;">لم تبدأ</span>
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
</tr>
@endforeach
@if($programs->isEmpty())
<tr>
    <td colspan="20" class="text-center" style="padding: 2rem; color: #6c757d; font-style: italic;">لا توجد برامج إمامة</td>
</tr>
@endif