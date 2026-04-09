@extends('layouts.coach-app')
@section('title', 'Edit Player')
@section('content')
<div class="p-6">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded shadow-md">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-4xl mx-auto">
        <div class="px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600">
            <h2 class="text-xl font-bold text-white">
                <i class="fas fa-edit mr-2"></i>Edit Player: {{ $player->name }}
            </h2>
        </div>
        
        <form action="{{ route('coach.players.update', $player->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Full Name *</label>
                    <input type="text" name="name" value="{{ $player->name }}" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-yellow-500" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Email *</label>
                    <input type="email" name="email" value="{{ $player->email }}" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-yellow-500" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Current Image</label>
                    @if($player->image)
                        <img src="{{ asset('storage/' . $player->image) }}" class="w-16 h-16 rounded-full object-cover mb-2">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=3b82f6&color=fff&rounded=true&size=100" class="w-16 h-16 rounded-full mb-2">
                    @endif
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Change Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2">
                    <p class="text-xs text-gray-500 mt-1">Upload JPG, PNG (Max 2MB)</p>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Position *</label>
                    <select name="position" class="w-full border border-gray-300 rounded-lg p-2" required>
                        <option value="Goalkeeper" {{ $player->position == 'Goalkeeper' ? 'selected' : '' }}>Goalkeeper</option>
                        <option value="Defender" {{ $player->position == 'Defender' ? 'selected' : '' }}>Defender</option>
                        <option value="Midfielder" {{ $player->position == 'Midfielder' ? 'selected' : '' }}>Midfielder</option>
                        <option value="Forward" {{ $player->position == 'Forward' ? 'selected' : '' }}>Forward</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Jersey Number *</label>
                    <input type="number" name="jersey_number" value="{{ $player->jersey_number }}" class="w-full border border-gray-300 rounded-lg p-2" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Goals</label>
                    <input type="number" name="goals" value="{{ $player->goals }}" class="w-full border border-gray-300 rounded-lg p-2">
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Assists</label>
                    <input type="number" name="assists" value="{{ $player->assists }}" class="w-full border border-gray-300 rounded-lg p-2">
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Matches Played</label>
                    <input type="number" name="matches" value="{{ $player->matches }}" class="w-full border border-gray-300 rounded-lg p-2">
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Rating (0-10)</label>
                    <input type="number" step="0.1" name="rating" value="{{ $player->rating }}" class="w-full border border-gray-300 rounded-lg p-2">
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg p-2">
                        <option value="active" {{ $player->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="injured" {{ $player->status == 'injured' ? 'selected' : '' }}>Injured</option>
                        <option value="suspended" {{ $player->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Team</label>
                    <select name="team_id" class="w-full border border-gray-300 rounded-lg p-2">
                        <option value="">Select Team</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ $player->team_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <a href="{{ route('coach.players') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg transition">Cancel</a>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-save mr-2"></i>Update Player
                </button>
            </div>
        </form>
    </div>
</div>
@endsection