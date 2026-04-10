@extends('layouts.player-app')
@section('title', 'My Team')
@section('content')
<div class="p-8">
    @if($team)
    <!-- Team Info -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg p-6 mb-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">{{ $team->name }}</h1>
                <p class="text-blue-100 mt-1">{{ $team->city }} | {{ $team->stadium }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm opacity-90">Team Record</p>
                <p class="text-2xl font-bold">{{ $teamStats['wins'] ?? 0 }}W - {{ $teamStats['losses'] ?? 0 }}L - {{ $teamStats['draws'] ?? 0 }}D</p>
            </div>
        </div>
    </div>

    <!-- Team Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $teamStats['total_matches'] ?? 0 }}</p>
            <p class="text-sm text-gray-600">Total Matches</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $teamStats['total_goals'] ?? 0 }}</p>
            <p class="text-sm text-gray-600">Team Goals</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-yellow-600">{{ $teamStats['win_rate'] ?? 0 }}%</p>
            <p class="text-sm text-gray-600">Win Rate</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-2xl font-bold text-purple-600">{{ $teammates->count() + 1 }}</p>
            <p class="text-sm text-gray-600">Squad Size</p>
        </div>
    </div>

    <!-- Teammates -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            <i class="fas fa-users text-blue-600 mr-2"></i>Teammates
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Current Player -->
            <div class="bg-yellow-50 rounded-lg p-3 text-center border-2 border-yellow-400">
                @if($player->image)
                    <img src="{{ asset('storage/' . $player->image) }}" class="w-16 h-16 rounded-full mx-auto object-cover mb-2">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=ffd700&color=000&rounded=true&size=100" class="w-16 h-16 rounded-full mx-auto mb-2">
                @endif
                <p class="font-semibold text-sm">{{ $player->name }}</p>
                <p class="text-xs text-gray-600">{{ $player->position }} | #{{ $player->jersey_number }}</p>
                <span class="text-xs bg-yellow-400 text-black px-2 py-0.5 rounded mt-1 inline-block">You</span>
            </div>
            
            <!-- Teammates -->
            @foreach($teammates as $teammate)
            <div class="bg-gray-50 rounded-lg p-3 text-center hover:shadow-lg transition">
                @if($teammate->image)
                    <img src="{{ asset('storage/' . $teammate->image) }}" class="w-16 h-16 rounded-full mx-auto object-cover mb-2">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($teammate->name) }}&background=3b82f6&color=fff&rounded=true&size=100" class="w-16 h-16 rounded-full mx-auto mb-2">
                @endif
                <p class="font-semibold text-sm">{{ $teammate->name }}</p>
                <p class="text-xs text-gray-600">{{ $teammate->position }} | #{{ $teammate->jersey_number }}</p>
                <div class="flex justify-center space-x-2 mt-1">
                    <span class="text-xs text-green-600">{{ $teammate->goals }} G</span>
                    <span class="text-xs text-blue-600">{{ $teammate->assists }} A</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-lg p-12 text-center">
        <i class="fas fa-users-slash text-6xl text-gray-400 mb-4"></i>
        <p class="text-xl text-gray-600">You haven't been assigned to a team yet.</p>
        <p class="text-gray-500 mt-2">The coach will assign you to a team soon.</p>
    </div>
    @endif
</div>
@endsection