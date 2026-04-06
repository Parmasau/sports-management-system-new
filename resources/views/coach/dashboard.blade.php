@extends('layouts.coach-app')
@section('title', 'Coach Dashboard')
@section('content')
<div class="p-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white"><div><p class="text-blue-100">Total Players</p><p class="text-3xl font-bold">22</p></div></div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white"><div><p class="text-green-100">Matches</p><p class="text-3xl font-bold">15</p></div></div>
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white"><div><p class="text-yellow-100">Wins</p><p class="text-3xl font-bold">8</p></div></div>
        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white"><div><p class="text-red-100">Win Rate</p><p class="text-3xl font-bold">53%</p></div></div>
    </div>
    <div class="bg-white rounded-lg shadow-lg p-6"><h2 class="text-xl font-bold mb-4">Welcome Coach {{ Auth::user()->name }}</h2><p>Manage your team, view player statistics, and plan training sessions.</p></div>
</div>
@endsection
