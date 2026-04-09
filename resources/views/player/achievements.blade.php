@extends('layouts.player-app')
@section('title', 'Achievements')
@section('content')
<div class="p-8">
    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-lg shadow-lg p-6 text-white">
        <h2 class="text-2xl font-bold mb-4">🏆 My Achievements</h2>
        <div class="space-y-3">
            <div class="bg-white bg-opacity-20 rounded-lg p-3"><i class="fas fa-medal mr-2"></i> Player of the Month - March 2024</div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3"><i class="fas fa-futbol mr-2"></i> Hat-trick Achievement - vs Tigers United</div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3"><i class="fas fa-trophy mr-2"></i> Top Scorer Award - Season 2023</div>
        </div>
    </div>
</div>
@endsection