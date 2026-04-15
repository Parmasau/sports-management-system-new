@extends('layouts.player-app')
@section('title', 'My Health')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">My Health Records</h2>
        
        @if($latestHealth)
        <div class="bg-gradient-to-r from-green-500 to-blue-600 rounded-lg p-6 text-white mb-6">
            <h3 class="text-xl font-bold mb-3">Latest Health Status</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-sm opacity-80">Date</p>
                    <p class="font-bold">{{ $latestHealth->record_date->format('Y-m-d') }}</p>
                </div>
                <div>
                    <p class="text-sm opacity-80">Weight</p>
                    <p class="font-bold">{{ $latestHealth->weight ?? 'N/A' }} kg</p>
                </div>
                <div>
                    <p class="text-sm opacity-80">BMI</p>
                    <p class="font-bold">{{ $latestHealth->bmi ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm opacity-80">Fitness</p>
                    <p class="font-bold">{{ ucfirst($latestHealth->fitness_level ?? 'N/A') }}</p>
                </div>
            </div>
            @if($latestHealth->injury_status != 'none')
            <div class="mt-4 p-3 bg-red-500/30 rounded-lg">
                <p class="font-semibold">Injury Status: {{ ucfirst($latestHealth->injury_status) }}</p>
                <p class="text-sm">{{ $latestHealth->injury_details }}</p>
            </div>
            @endif
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-left">Weight</th>
                        <th class="p-3 text-left">BMI</th>
                        <th class="p-3 text-left">Heart Rate</th>
                        <th class="p-3 text-left">BP</th>
                        <th class="p-3 text-left">Injury</th>
                        <th class="p-3 text-left">Fitness</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($healthRecords as $record)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $record->record_date->format('Y-m-d') }}</td>
                        <td class="p-3">{{ $record->weight ?? '-' }} kg</td>
                        <td class="p-3">{{ $record->bmi ?? '-' }}</td>
                        <td class="p-3">{{ $record->heart_rate ?? '-' }}</td>
                        <td class="p-3">{{ $record->blood_pressure_systolic }}/{{ $record->blood_pressure_diastolic }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs 
                                @if($record->injury_status == 'none') bg-green-100 text-green-800
                                @elseif($record->injury_status == 'minor') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($record->injury_status) }}
                            </span>
                        </td>
                        <td class="p-3">{{ ucfirst($record->fitness_level) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $healthRecords->links() }}
    </div>
</div>
@endsection

