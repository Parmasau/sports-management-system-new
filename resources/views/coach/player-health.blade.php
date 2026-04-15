@extends('layouts.coach-app')
@section('title', 'Health Records - ' . $player->name)
@section('content')
<div class="p-6">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-6 rounded shadow-md">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Player Info Card -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-4 mb-6 text-white">
        <div class="flex items-center space-x-4">
            @if($player->image)
                <img src="{{ asset('storage/' . $player->image) }}" class="w-14 h-14 rounded-full object-cover border-2 border-white">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=fff&color=667eea&rounded=true&size=100" class="w-14 h-14 rounded-full border-2 border-white">
            @endif
            <div>
                <h1 class="text-xl font-bold">{{ $player->name }}</h1>
                <p class="text-blue-100 text-sm">{{ $player->position }} | Jersey #{{ $player->jersey_number }}</p>
            </div>
        </div>
    </div>

    <!-- Latest Health Status -->
    @if($latestHealth)
    <div class="bg-gradient-to-r from-green-500 to-teal-500 rounded-xl shadow-lg p-4 mb-6 text-white">
        <h3 class="text-lg font-bold mb-3">Current Health Status</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
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
        <div class="mt-3 p-2 bg-red-500/30 rounded-lg">
            <p class="font-semibold text-sm">⚠️ Injury: {{ ucfirst($latestHealth->injury_status) }}</p>
            <p class="text-xs">{{ $latestHealth->injury_details }}</p>
        </div>
        @endif
    </div>
    @endif

    <!-- Add Health Record Form -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <div class="px-6 py-3 bg-gradient-to-r from-green-600 to-teal-600">
            <h2 class="text-lg font-bold text-white">Add Health Record</h2>
        </div>
        <div class="p-4">
            <form action="{{ route('coach.players.health.store', $player->id) }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Record Date</label>
                        <input type="date" name="record_date" class="w-full border rounded-lg p-2 text-sm" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Weight (kg)</label>
                        <input type="number" step="0.1" name="weight" class="w-full border rounded-lg p-2 text-sm" placeholder="Weight">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Height (cm)</label>
                        <input type="number" step="0.1" name="height" class="w-full border rounded-lg p-2 text-sm" placeholder="Height">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Heart Rate</label>
                        <input type="number" name="heart_rate" class="w-full border rounded-lg p-2 text-sm" placeholder="bpm">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">BP Systolic</label>
                        <input type="number" name="blood_pressure_systolic" class="w-full border rounded-lg p-2 text-sm" placeholder="Systolic">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">BP Diastolic</label>
                        <input type="number" name="blood_pressure_diastolic" class="w-full border rounded-lg p-2 text-sm" placeholder="Diastolic">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Injury Status</label>
                        <select name="injury_status" class="w-full border rounded-lg p-2 text-sm">
                            <option value="none">None</option>
                            <option value="minor">Minor</option>
                            <option value="moderate">Moderate</option>
                            <option value="severe">Severe</option>
                            <option value="recovering">Recovering</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Fitness Level</label>
                        <select name="fitness_level" class="w-full border rounded-lg p-2 text-sm">
                            <option value="poor">Poor</option>
                            <option value="average">Average</option>
                            <option value="good">Good</option>
                            <option value="excellent">Excellent</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Injury Details</label>
                        <textarea name="injury_details" class="w-full border rounded-lg p-2 text-sm" rows="2" placeholder="Injury details..."></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Medical Notes</label>
                        <textarea name="medical_notes" class="w-full border rounded-lg p-2 text-sm" rows="2" placeholder="Medical notes..."></textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition">
                        <i class="fas fa-save mr-2"></i>Add Record
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Health Records History -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-3 bg-gradient-to-r from-gray-700 to-gray-800">
            <h2 class="text-lg font-bold text-white">Health History</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2 text-left text-xs font-semibold text-gray-600">Date</th>
                        <th class="p-2 text-left text-xs font-semibold text-gray-600">Weight</th>
                        <th class="p-2 text-left text-xs font-semibold text-gray-600">BMI</th>
                        <th class="p-2 text-left text-xs font-semibold text-gray-600">Heart Rate</th>
                        <th class="p-2 text-left text-xs font-semibold text-gray-600">BP</th>
                        <th class="p-2 text-left text-xs font-semibold text-gray-600">Injury</th>
                        <th class="p-2 text-left text-xs font-semibold text-gray-600">Fitness</th>
                        <th class="p-2 text-center text-xs font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($healthRecords as $record)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 text-sm">{{ $record->record_date->format('Y-m-d') }}</td>
                        <td class="p-2 text-sm">{{ $record->weight ?? '-' }} kg</td>
                        <td class="p-2 text-sm">{{ $record->bmi ?? '-' }}</td>
                        <td class="p-2 text-sm">{{ $record->heart_rate ?? '-' }} bpm</td>
                        <td class="p-2 text-sm">{{ $record->blood_pressure_systolic }}/{{ $record->blood_pressure_diastolic }}</td>
                        <td class="p-2">
                            <span class="px-2 py-0.5 rounded text-xs 
                                @if($record->injury_status == 'none') bg-green-100 text-green-700
                                @elseif($record->injury_status == 'minor') bg-yellow-100 text-yellow-700
                                @elseif($record->injury_status == 'moderate') bg-orange-100 text-orange-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($record->injury_status) }}
                            </span>
                        </td>
                        <td class="p-2">
                            <span class="px-2 py-0.5 rounded text-xs 
                                @if($record->fitness_level == 'excellent') bg-green-100 text-green-700
                                @elseif($record->fitness_level == 'good') bg-blue-100 text-blue-700
                                @elseif($record->fitness_level == 'average') bg-yellow-100 text-yellow-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($record->fitness_level) }}
                            </span>
                        </td>
                        <td class="p-2 text-center">
                            <a href="{{ route('coach.players.health.edit', [$player->id, $record->id]) }}" class="bg-yellow-500 text-white px-2 py-1 rounded text-xs inline-block mr-1 hover:bg-yellow-600">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('coach.players.health.destroy', [$player->id, $record->id]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 bg-gray-50 border-t">
            {{ $healthRecords->links() }}
        </div>
    </div>
</div>
@endsection