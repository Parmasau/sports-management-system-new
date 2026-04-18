@extends('layouts.admin-app')
@section('title', 'Edit Health Record')
@section('content')
<div class="p-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-2xl mx-auto">
        <div class="px-4 py-3 bg-gradient-to-r from-yellow-600 to-orange-600">
            <h2 class="text-lg font-bold text-white">Edit Health Record for {{ $player->name }}</h2>
        </div>
        
        <form action="{{ route('admin.players.health.update', [$player->id, $healthRecord->id]) }}" method="POST" class="p-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Record Date</label>
                    <input type="date" name="record_date" value="{{ $healthRecord->record_date->format('Y-m-d') }}" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Weight (kg)</label>
                    <input type="number" step="0.1" name="weight" value="{{ $healthRecord->weight }}" class="w-full border rounded-lg p-2 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Height (cm)</label>
                    <input type="number" step="0.1" name="height" value="{{ $healthRecord->height }}" class="w-full border rounded-lg p-2 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Heart Rate (bpm)</label>
                    <input type="number" name="heart_rate" value="{{ $healthRecord->heart_rate }}" class="w-full border rounded-lg p-2 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Blood Pressure (Systolic)</label>
                    <input type="number" name="blood_pressure_systolic" value="{{ $healthRecord->blood_pressure_systolic }}" class="w-full border rounded-lg p-2 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Blood Pressure (Diastolic)</label>
                    <input type="number" name="blood_pressure_diastolic" value="{{ $healthRecord->blood_pressure_diastolic }}" class="w-full border rounded-lg p-2 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Injury Status</label>
                    <select name="injury_status" class="w-full border rounded-lg p-2 text-sm" required>
                        <option value="none" {{ $healthRecord->injury_status == 'none' ? 'selected' : '' }}>None</option>
                        <option value="minor" {{ $healthRecord->injury_status == 'minor' ? 'selected' : '' }}>Minor</option>
                        <option value="moderate" {{ $healthRecord->injury_status == 'moderate' ? 'selected' : '' }}>Moderate</option>
                        <option value="severe" {{ $healthRecord->injury_status == 'severe' ? 'selected' : '' }}>Severe</option>
                        <option value="recovering" {{ $healthRecord->injury_status == 'recovering' ? 'selected' : '' }}>Recovering</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Fitness Level</label>
                    <select name="fitness_level" class="w-full border rounded-lg p-2 text-sm" required>
                        <option value="poor" {{ $healthRecord->fitness_level == 'poor' ? 'selected' : '' }}>Poor</option>
                        <option value="average" {{ $healthRecord->fitness_level == 'average' ? 'selected' : '' }}>Average</option>
                        <option value="good" {{ $healthRecord->fitness_level == 'good' ? 'selected' : '' }}>Good</option>
                        <option value="excellent" {{ $healthRecord->fitness_level == 'excellent' ? 'selected' : '' }}>Excellent</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Injury Details</label>
                    <textarea name="injury_details" class="w-full border rounded-lg p-2 text-sm" rows="2">{{ $healthRecord->injury_details }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Medical Notes</label>
                    <textarea name="medical_notes" class="w-full border rounded-lg p-2 text-sm" rows="2">{{ $healthRecord->medical_notes }}</textarea>
                </div>
            </div>
            
            <div class="flex justify-end space-x-2 mt-4">
                <a href="{{ route('admin.players.health', $player->id) }}" class="bg-gray-400 text-white px-3 py-1.5 rounded-lg text-sm">Cancel</a>
                <button type="submit" class="bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-sm">Update Record</button>
            </div>
        </form>
    </div>
</div>
@endsection

