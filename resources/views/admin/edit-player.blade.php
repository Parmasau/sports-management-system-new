@extends('layouts.admin-app')
@section('title', 'Edit Player')
@section('content')
<div class="p-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-2xl mx-auto">
        <div class="px-4 py-3 bg-gradient-to-r from-yellow-600 to-orange-600">
            <h2 class="text-lg font-bold text-white">Edit Player: {{ $player->name }}</h2>
        </div>
        
        <form action="{{ route('admin.players.update', $player->id) }}" method="POST" enctype="multipart/form-data" class="p-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Full Name *</label>
                    <input type="text" name="name" value="{{ $player->name }}" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Email *</label>
                    <input type="email" name="email" value="{{ $player->email }}" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Current Image</label>
                    @if($player->image)
                        <img src="{{ asset('storage/' . $player->image) }}" class="w-12 h-12 rounded-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=3b82f6&color=fff&rounded=true&size=100" class="w-12 h-12 rounded-full">
                    @endif
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Change Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full border rounded-lg p-2 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Position *</label>
                    <select name="position" class="w-full border rounded-lg p-2 text-sm" required>
                        <option value="Goalkeeper" {{ $player->position == 'Goalkeeper' ? 'selected' : '' }}>Goalkeeper</option>
                        <option value="Defender" {{ $player->position == 'Defender' ? 'selected' : '' }}>Defender</option>
                        <option value="Midfielder" {{ $player->position == 'Midfielder' ? 'selected' : '' }}>Midfielder</option>
                        <option value="Forward" {{ $player->position == 'Forward' ? 'selected' : '' }}>Forward</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Jersey Number *</label>
                    <input type="number" name="jersey_number" value="{{ $player->jersey_number }}" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Goals</label>
                    <input type="number" name="goals" value="{{ $player->goals }}" class="w-full border rounded-lg p-2 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Assists</label>
                    <input type="number" name="assists" value="{{ $player->assists }}" class="w-full border rounded-lg p-2 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Matches Played</label>
                    <input type="number" name="matches" value="{{ $player->matches }}" class="w-full border rounded-lg p-2 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Rating</label>
                    <input type="number" step="0.1" name="rating" value="{{ $player->rating }}" class="w-full border rounded-lg p-2 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border rounded-lg p-2 text-sm">
                        <option value="active" {{ $player->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="injured" {{ $player->status == 'injured' ? 'selected' : '' }}>Injured</option>
                        <option value="suspended" {{ $player->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Team</label>
                    <select name="team_id" class="w-full border rounded-lg p-2 text-sm">
                        <option value="">Select Team</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ $player->team_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end space-x-2 mt-4">
                <a href="{{ route('admin.players') }}" class="bg-gray-400 text-white px-3 py-1.5 rounded-lg text-sm">Cancel</a>
                <button type="submit" class="bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-sm">Update Player</button>
            </div>
        </form>
    </div>
</div>
@endsection

