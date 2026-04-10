@extends('layouts.player-app')
@section('title', 'Player Dashboard')
@section('content')
<div class="p-8">
    <!-- Profile Status Alert -->
    @if(!$isProfileComplete)
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded shadow-md">
        <div class="flex items-center">
            <i class="fas fa-info-circle text-xl mr-3"></i>
            <div>
                <p class="font-semibold">Profile Pending Setup</p>
                <p class="text-sm">Your profile is awaiting completion by the coach or admin. You'll see your stats here once updated.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Player Info Card -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center space-x-4">
            @if($player->image)
                <img src="{{ asset('storage/' . $player->image) }}" class="w-20 h-20 rounded-full object-cover">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=667eea&color=fff&rounded=true&size=100" class="w-20 h-20 rounded-full">
            @endif
            <div>
                <h2 class="text-2xl font-bold">{{ $player->name }}</h2>
                <p class="text-gray-600">{{ $player->position }} | Jersey #{{ $player->jersey_number > 0 ? $player->jersey_number : 'Not Assigned' }}</p>
                <p class="text-sm text-gray-500">{{ $player->email }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div><p class="text-blue-100">Matches</p><p class="text-3xl font-bold">{{ $stats['matches'] }}</p></div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div><p class="text-green-100">Goals</p><p class="text-3xl font-bold">{{ $stats['goals'] }}</p></div>
        </div>
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div><p class="text-yellow-100">Assists</p><p class="text-3xl font-bold">{{ $stats['assists'] }}</p></div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div><p class="text-purple-100">Rating</p><p class="text-3xl font-bold">{{ $stats['rating'] }}</p></div>
        </div>
    </div>

    <!-- Team Formation Field (Only show if profile is complete) -->
    @if($isProfileComplete && $activeTactic)
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Team Formation</h2>
        <x-soccer-field 
            :formation="$activeTactic->formation" 
            :activePlayerId="$player->id"
            :players="[]" />
        <div class="mt-4 text-center">
            <p class="text-gray-600">Current Formation: <strong class="text-blue-600">{{ $activeTactic->formation }}</strong></p>
            <p class="text-sm text-gray-500 mt-1">{{ $activeTactic->pressing_style }} | {{ $activeTactic->attacking_focus }}</p>
        </div>
    </div>
    @endif

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4">Recent Activity</h2>
        <div class="space-y-3">
            @forelse($recentActivities as $activity)
            <div class="flex items-center space-x-3 border-b pb-3">
                <i class="fas fa-{{ $activity['icon'] }} text-{{ $activity['type'] == 'success' ? 'green' : 'yellow' }}-500"></i>
                <div class="flex-1">
                    <p class="text-sm">{{ $activity['message'] }}</p>
                </div>
            </div>
            @empty
            <div class="text-center py-6 text-gray-500">
                <i class="fas fa-clock text-4xl mb-2 opacity-50"></i>
                <p>No recent activity. Check back after your first match!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection