@foreach($programs as $program)
<tr data-program-type="{{ $program->program_type }}" 
    data-field="{{ $program->field }}" 
    data-specialty="{{ $program->specialty }}" 
    data-location-id="{{ $program->location_id }}" 
    data-location-array="{{ is_array($program->location) ? implode(',', $program->location) : '' }}">
    <td><a href="{{ $program->instructor_link }}" target="_blank">{{ $program->instructor_link }}</a></td>
    <td>{{ $program->instructor }}</td>
    <td>
        @if($program->locationRelation)
            <strong>{{ $program->locationRelation->name }}</strong>
        @endif
        @if(is_array($program->location) && count($program->location))
            : {{ implode('، ', $program->location) }}
        @endif
    </td>
    <td>{{ $program->notes }}</td>
    <td>{{ $program->attendance_type }}</td>
    <td>{{ $program->attendance_type }}</td>
    <td>{{ $program->start_time ? \Carbon\Carbon::parse($program->start_time)->format('h:i') . (\Carbon\Carbon::parse($program->start_time)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->end_time ? \Carbon\Carbon::parse($program->end_time)->format('h:i') . (\Carbon\Carbon::parse($program->end_time)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
    <td>{{ $program->status }}</td>
    <td>{{ $program->level }}</td>
    <td>{{ $program->group }}</td>
</tr>
@endforeach
@if($programs->isEmpty())
<tr><td colspan="11" class="text-center">لا توجد نتائج.</td></tr>
@endif