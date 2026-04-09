@extends('layouts.player-app')
@section('title', 'Player Dashboard')
@section('content')
<div class="p-8">
    <!-- Player Info -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center space-x-4">
            @if($player->image)
                <img src="{{ asset('storage/' . $player->image) }}" class="w-20 h-20 rounded-full object-cover">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=667eea&color=fff&rounded=true&size=100" class="w-20 h-20 rounded-full">
            @endif
            <div>
                <h2 class="text-2xl font-bold">{{ $player->name }}</h2>
                <p class="text-gray-600">{{ $player->position }} | Jersey #{{ $player->jersey_number }}</p>
                <p class="text-sm text-gray-500">{{ $player->email }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div><p class="text-blue-100">Matches</p><p class="text-3xl font-bold">{{ $player->matches ?? 0 }}</p></div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div><p class="text-green-100">Goals</p><p class="text-3xl font-bold">{{ $player->goals ?? 0 }}</p></div>
        </div>
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div><p class="text-yellow-100">Assists</p><p class="text-3xl font-bold">{{ $player->assists ?? 0 }}</p></div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div><p class="text-purple-100">Rating</p><p class="text-3xl font-bold">{{ $player->rating ?? 0 }}</p></div>
        </div>
    </div>

    <!-- Team Formation Field -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Team Formation</h2>
        
        @php
            $activeTactic = App\Models\Tactic::where('is_active', true)->first();
            $teamPlayers = App\Models\Player::where('team_id', $player->team_id)->get();
            
            // Map players to positions (simplified - you can enhance this)
            $positionedPlayers = [];
            if($activeTactic) {
                $positionMap = $activeTactic->getPositionMap();
                $playerIndex = 0;
                foreach($positionMap as $position => $index) {
                    if(isset($teamPlayers[$playerIndex])) {
                        $positionedPlayers[$position] = [
                            'id' => $teamPlayers[$playerIndex]->id,
                            'name' => $teamPlayers[$playerIndex]->name,
                            'image' => $teamPlayers[$playerIndex]->image,
                            'position' => $teamPlayers[$playerIndex]->position
                        ];
                    }
                    $playerIndex++;
                }
            }
        @endphp
        
        @if($activeTactic)
            <x-soccer-field 
                :formation="$activeTactic->formation" 
                :activePlayerId="$player->id"
                :players="$positionedPlayers" />
            
            <div class="mt-4 text-center">
                <p class="text-gray-600">Current Formation: <strong class="text-blue-600">{{ $activeTactic->formation }}</strong></p>
                <p class="text-sm text-gray-500 mt-1">{{ $activeTactic->pressing_style }} | {{ $activeTactic->attacking_focus }}</p>
                <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-map-marker-alt mr-1"></i> 
                        Your position is highlighted in <span class="font-bold text-yellow-600">yellow</span> on the field
                    </p>
                </div>
            </div>
        @else
            <div class="text-center p-8 text-gray-500">
                No active tactic. Please wait for the coach to set a formation.
            </div>
        @endif
    </div>
    
    <!-- Teammates List -->
    <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Teammates</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($teamPlayers as $teammate)
                @if($teammate->id != $player->id)
                <div class="border rounded-lg p-3 text-center hover:shadow-lg transition">
                    @if($teammate->image)
                        <img src="{{ asset('storage/' . $teammate->image) }}" class="w-16 h-16 rounded-full mx-auto object-cover mb-2">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($teammate->name) }}&background=667eea&color=fff&rounded=true&size=100" class="w-16 h-16 rounded-full mx-auto mb-2">
                    @endif
                    <p class="font-semibold text-sm">{{ $teammate->name }}</p>
                    <p class="text-xs text-gray-500">{{ $teammate->position }} | #{{ $teammate->jersey_number }}</p>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection