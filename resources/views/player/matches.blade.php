@extends('layouts.player-app')
@section('title', 'My Matches')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4">My Matches</h2>
        <div class="space-y-4">
            <div class="border-b pb-3"><p class="font-semibold">Red Dragons vs Blue Eagles</p><p class="text-gray-600">April 12, 2024 - 4:00 PM | Home Ground</p></div>
            <div class="border-b pb-3"><p class="font-semibold">Tigers United vs Red Dragons</p><p class="text-gray-600">April 18, 2024 - 6:30 PM | Away</p></div>
            <div class="border-b pb-3"><p class="font-semibold">Red Dragons vs Thunder FC</p><p class="text-gray-600">April 25, 2024 - 4:00 PM | Home Ground</p></div>
        </div>
    </div>
</div>
@endsection
