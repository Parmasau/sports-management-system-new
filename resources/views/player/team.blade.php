@extends('layouts.player-app')
@section('title', 'My Team')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6 text-center">
        <i class="fas fa-shield-alt text-6xl text-red-600 mb-3"></i>
        <h2 class="text-3xl font-bold">Red Dragons FC</h2>
        <p class="text-gray-600 mt-2">Position: Forward | Jersey: #10</p>
        <div class="mt-6 grid grid-cols-3 gap-4 max-w-md mx-auto">
            <div><p class="text-2xl font-bold">24</p><p class="text-sm text-gray-500">Matches</p></div>
            <div><p class="text-2xl font-bold">18</p><p class="text-sm text-gray-500">Goals</p></div>
            <div><p class="text-2xl font-bold">12</p><p class="text-sm text-gray-500">Assists</p></div>
        </div>
    </div>
</div>
@endsection
