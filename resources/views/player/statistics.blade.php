@extends('layouts.player-app')
@section('title', 'My Statistics')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Player Statistics</h2>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded"><p class="text-3xl font-bold text-blue-600">24</p><p>Matches</p></div>
            <div class="text-center p-4 bg-green-50 rounded"><p class="text-3xl font-bold text-green-600">18</p><p>Goals</p></div>
            <div class="text-center p-4 bg-yellow-50 rounded"><p class="text-3xl font-bold text-yellow-600">12</p><p>Assists</p></div>
            <div class="text-center p-4 bg-red-50 rounded"><p class="text-3xl font-bold text-red-600">5</p><p>MotM</p></div>
        </div>
    </div>
</div>
@endsection

