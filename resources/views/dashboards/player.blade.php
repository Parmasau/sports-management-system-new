@extends('layouts.player-app')
@section('title', 'Player Dashboard')
@section('content')
@php
    $upcomingMatches = \App\Models\GameMatch::where('status','scheduled')->orderBy('match_date')->take(3)->get();
    $nextSessions    = \App\Models\TrainingSession::where('status','scheduled')->take(2)->get();
    $myLineups       = \App\Models\Lineup::latest()->take(2)->get();
    $healthStatus    = \App\Models\HealthRecord::latest()->first();
@endphp
<div class="p-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="text-3xl mb-2">⚽</div>
            <div class="text-2xl font-bold">{{ \App\Models\GameMatch::count() }}</div>
            <div class="text-gray-600">Total Matches</div>
        </div>
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="text-3xl mb-2">📅</div>
            <div class="text-2xl font-bold">{{ \App\Models\GameMatch::where('status','scheduled')->count() }}</div>
            <div class="text-gray-600">Upcoming</div>
        </div>
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="text-3xl mb-2">🏋️</div>
            <div class="text-2xl font-bold">{{ \App\Models\TrainingSession::where('status','scheduled')->count() }}</div>
            <div class="text-gray-600">Training Sessions</div>
        </div>
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="text-3xl mb-2">📋</div>
            <div class="text-2xl font-bold">{{ \App\Models\Lineup::count() }}</div>
            <div class="text-gray-600">Lineups Set</div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Upcoming Matches -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">📅 Upcoming Matches</h2>
            @forelse($upcomingMatches as $m)
            <div class="border-b pb-2 mb-2">
                <div class="font-semibold">{{ $m->home_team }} vs {{ $m->away_team }}</div>
                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($m->match_date)->format('M d, Y - g:i A') }}</div>
                @if($m->venue)<div class="text-sm text-green-600">{{ $m->venue }}</div>@endif
            </div>
            @empty
            <p class="text-gray-400 text-sm">No upcoming matches scheduled.</p>
            @endforelse
            <a href="{{ route('player.matches') }}" class="mt-3 w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 inline-block text-center text-sm">View All Matches</a>
        </div>

        <!-- Latest Lineup -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">📋 Latest Lineups</h2>
            @forelse($myLineups as $lineup)
            <div class="border-b pb-2 mb-2">
                <div class="font-semibold">{{ $lineup->match_name }}</div>
                <div class="text-sm text-gray-500">Formation: {{ $lineup->formation }} · {{ count($lineup->starting_xi) }} players</div>
            </div>
            @empty
            <p class="text-gray-400 text-sm">No lineups set yet.</p>
            @endforelse
            <a href="{{ route('player.team') }}" class="mt-3 w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 inline-block text-center text-sm">View My Team</a>
        </div>

        <!-- Training Schedule -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">🏋️ Training Schedule</h2>
            @forelse($nextSessions as $s)
            <div class="border-b pb-2 mb-2">
                <div class="font-semibold">{{ $s->day }} - {{ \Carbon\Carbon::parse($s->time)->format('g:i A') }}</div>
                <div class="text-sm text-gray-500">{{ $s->type }} · {{ $s->location }}</div>
            </div>
            @empty
            <p class="text-gray-400 text-sm">No sessions scheduled.</p>
            @endforelse
            <a href="{{ route('player.statistics') }}" class="mt-3 w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 inline-block text-center text-sm">View My Stats</a>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">⚙️ Quick Actions</h2>
            <div class="space-y-2">
                <a href="{{ route('player.statistics') }}" class="w-full bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 inline-block text-center text-sm">My Statistics</a>
                <a href="{{ route('player.achievements') }}" class="w-full bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 inline-block text-center text-sm">My Achievements</a>
                <a href="{{ route('player.profile') }}" class="w-full bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 inline-block text-center text-sm">Update Profile</a>
            </div>
        </div>
    </div>
</div>
@endsection
