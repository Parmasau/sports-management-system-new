@extends('layouts.player-app')
@section('title', 'My Statistics')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Player Statistics</h2>
        
        @if($player->position == 'Not Assigned')
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded">
            <i class="fas fa-info-circle mr-2"></i> Your statistics will appear here once the coach updates your profile.
        </div>
        @endif
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <p class="text-3xl font-bold text-blue-600">{{ $player->matches ?? 0 }}</p>
                <p class="text-sm text-gray-600">Matches</p>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <p class="text-3xl font-bold text-green-600">{{ $player->goals ?? 0 }}</p>
                <p class="text-sm text-gray-600">Goals</p>
            </div>
            <div class="text-center p-4 bg-yellow-50 rounded-lg">
                <p class="text-3xl font-bold text-yellow-600">{{ $player->assists ?? 0 }}</p>
                <p class="text-sm text-gray-600">Assists</p>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <p class="text-3xl font-bold text-purple-600">{{ $player->rating ?? 0 }}</p>
                <p class="text-sm text-gray-600">Rating</p>
            </div>
        </div>
        
        <div class="border-t pt-4">
            <h3 class="font-bold text-gray-800 mb-3">Season Performance</h3>
            <div class="space-y-2">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Goals per Match</span>
                        <span>{{ $player->matches > 0 ? round($player->goals / $player->matches, 2) : 0 }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $player->matches > 0 ? min(100, ($player->goals / $player->matches) * 20) : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Assists per Match</span>
                        <span>{{ $player->matches > 0 ? round($player->assists / $player->matches, 2) : 0 }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $player->matches > 0 ? min(100, ($player->assists / $player->matches) * 20) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection