@extends('layouts.player-app')
@section('title', 'My Profile')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <div class="text-center">
            @if($player->image)
                <img src="{{ asset('storage/' . $player->image) }}" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=667eea&color=fff&size=128" class="w-32 h-32 rounded-full mx-auto mb-4">
            @endif
            <h2 class="text-2xl font-bold">{{ $player->name }}</h2>
            <p class="text-gray-600">{{ $player->email }}</p>
            <p class="text-purple-600 font-semibold mt-2">{{ $player->position }}</p>
        </div>
        <div class="mt-6 border-t pt-4 grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-500 text-sm">Jersey Number</p>
                <p class="font-semibold text-lg">#{{ $player->jersey_number }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Status</p>
                <p class="font-semibold text-lg">
                    <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">{{ ucfirst($player->status) }}</span>
                </p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Member Since</p>
                <p class="font-semibold">{{ Auth::user()->created_at->format('F j, Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Team</p>
                <p class="font-semibold">{{ $player->team ? $player->team->name : 'Not Assigned' }}</p>
            </div>
        </div>
        <div class="mt-6 border-t pt-4">
            <h3 class="font-bold mb-2">Performance Stats</h3>
            <div class="grid grid-cols-4 gap-2 text-center">
                <div class="bg-blue-50 p-2 rounded">
                    <p class="text-2xl font-bold text-blue-600">{{ $player->matches ?? 0 }}</p>
                    <p class="text-xs text-gray-600">Matches</p>
                </div>
                <div class="bg-green-50 p-2 rounded">
                    <p class="text-2xl font-bold text-green-600">{{ $player->goals ?? 0 }}</p>
                    <p class="text-xs text-gray-600">Goals</p>
                </div>
                <div class="bg-yellow-50 p-2 rounded">
                    <p class="text-2xl font-bold text-yellow-600">{{ $player->assists ?? 0 }}</p>
                    <p class="text-xs text-gray-600">Assists</p>
                </div>
                <div class="bg-purple-50 p-2 rounded">
                    <p class="text-2xl font-bold text-purple-600">{{ $player->rating ?? 0 }}</p>
                    <p class="text-xs text-gray-600">Rating</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection