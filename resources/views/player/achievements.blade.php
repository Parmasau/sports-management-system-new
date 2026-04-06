@extends('layouts.player-app')
@section('title', 'Achievements')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6">🏆 My Achievements</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                <div class="text-5xl mb-3">🥇</div>
                <h3 class="text-lg font-bold text-yellow-700">Top Scorer</h3>
                <p class="text-sm text-gray-600 mt-1">Season 2023/24</p>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                <div class="text-5xl mb-3">⭐</div>
                <h3 class="text-lg font-bold text-blue-700">Man of the Match</h3>
                <p class="text-sm text-gray-600 mt-1">Awarded 2 times</p>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                <div class="text-5xl mb-3">🏆</div>
                <h3 class="text-lg font-bold text-green-700">League Winner</h3>
                <p class="text-sm text-gray-600 mt-1">Spring Cup 2024</p>
            </div>
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 text-center">
                <div class="text-5xl mb-3">🎯</div>
                <h3 class="text-lg font-bold text-purple-700">Most Assists</h3>
                <p class="text-sm text-gray-600 mt-1">5 assists this season</p>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
                <div class="text-5xl mb-3">🔥</div>
                <h3 class="text-lg font-bold text-red-700">Hat-trick Hero</h3>
                <p class="text-sm text-gray-600 mt-1">vs Blue Eagles FC</p>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                <div class="text-5xl mb-3">💪</div>
                <h3 class="text-lg font-bold text-gray-700">100% Attendance</h3>
                <p class="text-sm text-gray-600 mt-1">Full season training</p>
            </div>
        </div>
    </div>
</div>
@endsection
