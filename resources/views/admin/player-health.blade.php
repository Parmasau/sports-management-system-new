@extends('layouts.admin-app')
@section('title', 'Player Health Records')
@section('content')
<div class="p-4">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 mb-4 rounded shadow-md text-sm">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Player Info -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl shadow-lg p-4 mb-6 text-white">
        <div class="flex items-center space-x-4">
            @if($player->image)
                <img src="{{ asset('storage/' . $player->image) }}" class="w-12 h-12 rounded-full object-cover border-2 border-white">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=fff&color=667eea&rounded=true&size=100" class="w-12 h-12 rounded-full border-2 border-white">
            @endif
            <div>
                <h1 class="text-lg font-bold">{{ $player->name }}</h1>
                <p class="text-purple-100 text-xs">{{ $player->position }} | Jersey #{{ $player->jersey_number }}</p>
            </div>
        </div>
    </div>

    <!-- Latest Health Status -->
    @if($latestHealth)
    <div class="bg-gradient-to-r from-green-500 to-teal-500 rounded-xl shadow-lg p-4 mb-6 text-white">
        <h3 class="font-bold text-sm mb-2">Current Health Status</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2 text-sm">
            <div>
                <p class="text-xs opacity-80">Last Check</p>
                <p class="font-bold text-sm">{{ $latestHealth->record_date->format('Y-m-d') }}</p>
            </div>
            <div>
                <p class="text-xs opacity-80">Weight</p>
                <p class="font-bold text-sm">{{ $latestHealth->weight ?? 'N/A' }} kg</p>
            </div>
            <div>
                <p class="text-xs opacity-80">BMI</p>
                <p class="font-bold text-sm">{{ $latestHealth->bmi ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs opacity-80">Heart Rate</p>
                <p class="font-bold text-sm">{{ $latestHealth->heart_rate ?? 'N/A' }} bpm</p>
            </div>
            <div>
                <p class="text-xs opacity-80">BP</p>
                <p class="font-bold text-sm">{{ $latestHealth->blood_pressure_systolic }}/{{ $latestHealth->blood_pressure_diastolic }}</p>
            </div>
        </div>
        @if($latestHealth->injury_status != 'none')
        <div class="mt-2 p-2 bg-red-500/30 rounded-lg">
            <p class="font-semibold text-xs">⚠️ Injury: {{ ucfirst($latestHealth->injury_status) }}</p>
            <p class="text-xs">{{ $latestHealth->injury_details }}</p>
        </div>
        @endif
    </div>
    @endif

    <!-- Health Records History -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-4 py-2 bg-gradient-to-r from-gray-700 to-gray-800">
            <h2 class="text-sm font-bold text-white">Health History</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2 text-left text-xs">Date</th>
                        <th class="p-2 text-left text-xs">Weight</th>
                        <th class="p-2 text-left text-xs">BMI</th>
                        <th class="p-2 text-left text-xs">Heart Rate</th>
                        <th class="p-2 text-left text-xs">BP</th>
                        <th class="p-2 text-left text-xs">Injury</th>
                        <th class="p-2 text-left text-xs">Fitness</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-2 bg-gray-50 border-t">
            {{ $healthRecords->links() }}
        </div>
    </div>
</div>
@endsection

