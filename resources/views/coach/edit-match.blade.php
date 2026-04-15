@extends('layouts.coach-app')
@section('title', 'Edit Match')
@section('content')
<div class="p-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-2xl mx-auto">
        <div class="px-4 py-3 bg-gradient-to-r from-yellow-600 to-orange-600">
            <h2 class="text-lg font-bold text-white">Edit Match</h2>
            <p class="text-yellow-100 text-xs">Update match details and score</p>
        </div>
        
        <form action="{{ route('coach.matches.update', $match->id) }}" method="POST" class="p-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Opponent Team *</label>
                    <input type="text" name="opponent" value="{{ $match->opponent }}" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Our Team *</label>
                    <select name="team_id" class="w-full border rounded-lg p-2 text-sm" required>
                        <option value="">Select Team</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ $match->team_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Match Date *</label>
                    <input type="date" name="match_date" value="{{ $match->match_date }}" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Match Time *</label>
                    <input type="time" name="match_time" value="{{ $match->match_time }}" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Location *</label>
                    <input type="text" name="location" value="{{ $match->location }}" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Match Type *</label>
                    <select name="type" class="w-full border rounded-lg p-2 text-sm" required>
                        <option value="home" {{ $match->type == 'home' ? 'selected' : '' }}>Home</option>
                        <option value="away" {{ $match->type == 'away' ? 'selected' : '' }}>Away</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Team Score</label>
                    <input type="number" name="team_score" value="{{ $match->team_score }}" class="w-full border rounded-lg p-2 text-sm" min="0">
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Opponent Score</label>
                    <input type="number" name="opponent_score" value="{{ $match->opponent_score }}" class="w-full border rounded-lg p-2 text-sm" min="0">
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Result</label>
                    <select name="result" class="w-full border rounded-lg p-2 text-sm">
                        <option value="pending" {{ $match->result == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="win" {{ $match->result == 'win' ? 'selected' : '' }}>Win</option>
                        <option value="loss" {{ $match->result == 'loss' ? 'selected' : '' }}>Loss</option>
                        <option value="draw" {{ $match->result == 'draw' ? 'selected' : '' }}>Draw</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border rounded-lg p-2 text-sm">
                        <option value="scheduled" {{ $match->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="completed" {{ $match->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $match->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end space-x-2 mt-4">
                <a href="{{ route('coach.matches') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-1.5 rounded-lg text-sm">Cancel</a>
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1.5 rounded-lg text-sm">
                    <i class="fas fa-save mr-1"></i>Update Match
                </button>
            </div>
        </form>
    </div>
</div>
@endsection