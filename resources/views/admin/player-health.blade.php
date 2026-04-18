@foreach($healthRecords as $record)
<tr class="hover:bg-gray-50">
    <td class="p-2">{{ $record->record_date->format('Y-m-d') }}</td>
    <td class="p-2">{{ $record->weight ?? '-' }} kg</td>
    <td class="p-2">{{ $record->bmi ?? '-' }}</td>
    <td class="p-2">{{ $record->heart_rate ?? '-' }} bpm</td>
    <td class="p-2">{{ $record->blood_pressure_systolic }}/{{ $record->blood_pressure_diastolic }}</td>
    <td class="p-2">
        <span class="px-1.5 py-0.5 rounded text-xs 
            @if($record->injury_status == 'none') bg-green-100 text-green-700
            @elseif($record->injury_status == 'minor') bg-yellow-100 text-yellow-700
            @else bg-red-100 text-red-700 @endif">
            {{ ucfirst($record->injury_status) }}
        </span>
    </td>
    <td class="p-2">
        <span class="px-1.5 py-0.5 rounded text-xs 
            @if($record->fitness_level == 'excellent') bg-green-100 text-green-700
            @elseif($record->fitness_level == 'good') bg-blue-100 text-blue-700
            @elseif($record->fitness_level == 'average') bg-yellow-100 text-yellow-700
            @else bg-red-100 text-red-700 @endif">
            {{ ucfirst($record->fitness_level) }}
        </span>
    </td>
    <td class="p-2 text-center">
        <div class="flex justify-center space-x-1">
            <a href="{{ route('admin.players.health.edit', [$player->id, $record->id]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-1.5 py-0.5 rounded text-xs">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.players.health.delete', [$player->id, $record->id]) }}" method="POST" onsubmit="return confirm('Delete this health record?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-1.5 py-0.5 rounded text-xs">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
@endforeach