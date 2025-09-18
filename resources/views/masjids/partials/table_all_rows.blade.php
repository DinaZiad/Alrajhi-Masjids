@foreach($programs as $program)
    <tr class="hover:bg-soft-cream transition-colors duration-200 border-b border-border-subtle" 
        data-program-type="{{ $program->program_type }}" 
        data-field="{{ $program->field }}" 
        data-specialty="{{ $program->specialty }}" 
        data-location-id="{{ $program->location_id }}" 
        data-location-array="{{ is_array($program->location) ? implode(',', $program->location) : '' }}">
        <td class="px-4 py-3">{{ $program->book ?? '-' }}</td>
        <td class="px-4 py-3">{{ $program->field ?? '-' }}</td>
        <td class="px-4 py-3">{{ $program->specialty ?? '-' }}</td>
        <td class="px-4 py-3">{{ $program->level ?? '-' }}</td>
        <td class="px-4 py-3">{{ $program->status ?? '-' }}</td>
        <td class="px-4 py-3">{{ $program->start_time ? \Carbon\Carbon::parse($program->start_time)->format('h:i') . (\Carbon\Carbon::parse($program->start_time)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
<td class="px-4 py-3">{{ $program->end_time ? \Carbon\Carbon::parse($program->end_time)->format('h:i') . (\Carbon\Carbon::parse($program->end_time)->format('A') == 'AM' ? ' ص' : ' م') : '-' }}</td>
        <td class="px-4 py-3">{{ $program->attendance_type ?? '-' }}</td>
        <td class="px-4 py-3">{{ $program->language ?? '-' }}</td>
        <td class="px-4 py-3">{{ $program->notes ?? '-' }}</td>
        <td class="px-4 py-3">
            @if($program->locationRelation)
                <strong>{{ $program->locationRelation->name }}</strong>
            @endif
            @if(is_array($program->location) && count($program->location))
                : {{ implode('، ', $program->location) }}
            @endif
        </td>
        <td class="px-4 py-3">{{ $program->teacher ?? $program->instructor ?? $program->imam_name ?? '-' }}</td>
        <td class="px-4 py-3">
            @if($program->teacher_link)
                <a href="{{ $program->teacher_link }}" class="text-warm-gold hover:text-deep-forest transition-colors" target="_blank">
                    <i class="fas fa-play-circle"></i> مشاهدة
                </a>
            @elseif($program->instructor_link)
                <a href="{{ $program->instructor_link }}" class="text-warm-gold hover:text-deep-forest transition-colors" target="_blank">
                    <i class="fas fa-play-circle"></i> مشاهدة
                </a>
            @else
                -
            @endif
        </td>
    </tr>
@endforeach
@if($programs->count() == 0)
    <tr>
        <td colspan="13" class="px-4 py-8 text-center text-gray-500">لا توجد نتائج.</td>
    </tr>
@endif