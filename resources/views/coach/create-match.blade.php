@extends('layouts.coach-app')
@section('title', 'Schedule Match')
@section('content')
<div class="p-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-2xl mx-auto">
        <div class="px-4 py-3 bg-gradient-to-r from-green-600 to-teal-600">
            <h2 class="text-lg font-bold text-white">Schedule New Match</h2>
            <p class="text-green-100 text-xs">Create a new match fixture</p>
        </div>
        
        <form action="{{ route('coach.matches.store') }}" method="POST" class="p-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Opponent Team *</label>
                    <input type="text" name="opponent" class="w-full border rounded-lg p-2 text-sm" placeholder="Opponent team name" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Select Team *</label>
                    <select name="team_id" class="w-full border rounded-lg p-2 text-sm" required>
                        <option value="">Select Team</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Match Date *</label>
                    <input type="date" name="match_date" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Match Time *</label>
                    <input type="time" name="match_time" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Location *</label>
                    <input type="text" name="location" class="w-full border rounded-lg p-2 text-sm" placeholder="Stadium name" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Match Type *</label>
                    <select name="type" class="w-full border rounded-lg p-2 text-sm" required>
                        <option value="home">Home</option>
                        <option value="away">Away</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end space-x-2 mt-4">
                <a href="{{ route('coach.matches') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-1.5 rounded-lg text-sm">Cancel</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm">
                    <i class="fas fa-save mr-1"></i>Schedule Match
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

