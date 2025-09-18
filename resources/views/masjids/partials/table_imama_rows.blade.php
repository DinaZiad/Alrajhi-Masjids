@foreach($programs as $program)
<tr data-program-type="{{ $program->program_type }}" 
    data-field="{{ $program->field }}" 
    data-specialty="{{ $program->specialty }}" 
    data-location-id="{{ $program->location_id }}" 
    data-location-array="{{ is_array($program->location) ? implode(',', $program->location) : '' }}">
    <td>{{ $program->date }}</td>
    <td>{{ $program->day }}</td>
    <td>{{ $program->imam_fajr }}</td>
    <td>{{ $program->adhan_fajr ? \Carbon\Carbon::parse($program->adhan_fajr)->format('h:i') . (\Carbon\Carbon::parse($program->adhan_fajr)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->iqama_fajr ? \Carbon\Carbon::parse($program->iqama_fajr)->format('h:i') . (\Carbon\Carbon::parse($program->iqama_fajr)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->imam_dhuhr }}</td>
    <td>{{ $program->adhan_dhuhr ? \Carbon\Carbon::parse($program->adhan_dhuhr)->format('h:i') . (\Carbon\Carbon::parse($program->adhan_dhuhr)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->iqama_dhuhr ? \Carbon\Carbon::parse($program->iqama_dhuhr)->format('h:i') . (\Carbon\Carbon::parse($program->iqama_dhuhr)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->imam_asr }}</td>
    <td>{{ $program->adhan_asr ? \Carbon\Carbon::parse($program->adhan_asr)->format('h:i') . (\Carbon\Carbon::parse($program->adhan_asr)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->iqama_asr ? \Carbon\Carbon::parse($program->iqama_asr)->format('h:i') . (\Carbon\Carbon::parse($program->iqama_asr)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->imam_maghrib }}</td>
    <td>{{ $program->adhan_maghrib ? \Carbon\Carbon::parse($program->adhan_maghrib)->format('h:i') . (\Carbon\Carbon::parse($program->adhan_maghrib)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->iqama_maghrib ? \Carbon\Carbon::parse($program->iqama_maghrib)->format('h:i') . (\Carbon\Carbon::parse($program->iqama_maghrib)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->imam_isha }}</td>
    <td>{{ $program->adhan_isha ? \Carbon\Carbon::parse($program->adhan_isha)->format('h:i') . (\Carbon\Carbon::parse($program->adhan_isha)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->iqama_isha ? \Carbon\Carbon::parse($program->iqama_isha)->format('h:i') . (\Carbon\Carbon::parse($program->iqama_isha)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
</tr>
@endforeach
@if($programs->isEmpty())
<tr><td colspan="17" class="text-center">لا توجد نتائج.</td></tr> 
@endif
