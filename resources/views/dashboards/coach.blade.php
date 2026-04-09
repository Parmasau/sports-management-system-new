@extends('layouts.coach-app')

@section('title', 'Coach Dashboard')

@section('content')
    <div class="p-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="text-3xl mb-2">👥</div>
                <div class="text-2xl font-bold">22</div>
                <div class="text-blue-100">Total Players</div>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="text-3xl mb-2">⚽</div>
                <div class="text-2xl font-bold">15</div>
                <div class="text-green-100">Matches This Season</div>
            </div>
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="text-3xl mb-2">🏆</div>
                <div class="text-2xl font-bold">8</div>
                <div class="text-yellow-100">Wins</div>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="text-3xl mb-2">⭐</div>
                <div class="text-2xl font-bold">4.5</div>
                <div class="text-purple-100">Team Rating</div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">👥 Manage Players</h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center border-b pb-2">
                        <span>John Doe</span>
                        <button class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600"><a href="{{ route('coach.stats') }}" class="block w-full h-full text-center">View Stats</a></button>
                    </div>
                    <div class="flex justify-between items-center border-b pb-2">
                        <span>Jane Smith</span>
                        <button class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600"><a href="{{ route('coach.stats') }}" class="block w-full h-full text-center">View Stats</a></button>
                    </div>
                    <div class="flex justify-between items-center border-b pb-2">
                        <span>Mike Johnson</span>
                        <button class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600"><a href="{{ route('coach.stats') }}" class="block w-full h-full text-center">View Stats</a></button>
                    </div>
                </div>
                <button class="mt-4 w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"><a href="{{ route('coach.players') }}" class="block w-full h-full text-center">Add New Player</a></button>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">⚽ Training Schedule</h2>
                <div class="space-y-3">
                    <div class="border-b pb-2">
                        <div class="flex justify-between">
                            <span class="font-semibold">Morning Session</span>
                            <span>8:00 AM - 10:00 AM</span>
                        </div>
                        <span class="text-sm text-gray-600">Fitness & Conditioning</span>
                    </div>
                    <div class="border-b pb-2">
                        <div class="flex justify-between">
                            <span class="font-semibold">Afternoon Session</span>
                            <span>3:00 PM - 5:00 PM</span>
                        </div>
                        <span class="text-sm text-gray-600">Tactical Training</span>
                    </div>
                </div>
                <button class="mt-4 w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"><a href="{{ route('coach.training') }}" class="block w-full h-full text-center">Schedule Training</a></button>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">📋 Upcoming Matches</h2>
                <div class="space-y-3">
                    <div class="border-b pb-2">
                        <div class="font-semibold">vs Team B</div>
                        <div class="text-sm text-gray-600">April 12, 2024 - 4:00 PM</div>
                        <button class="mt-1 bg-blue-500 text-white px-3 py-1 rounded text-sm"><a href="{{ route('coach.tactics') }}" class="block w-full h-full text-center">Set Lineup</a></button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">📊 Player Performance</h2>
                <div class="space-y-2">
                    <div>
                        <div class="flex justify-between text-sm">
                            <span>Top Scorer</span>
                            <span>John Doe - 12 goals</span>
                        </div>
                        <div class="flex justify-between text-sm mt-2">
                            <span>Most Assists</span>
                            <span>Jane Smith - 8 assists</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection