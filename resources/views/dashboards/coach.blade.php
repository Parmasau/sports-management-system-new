@extends('layouts.coach-app')
@section('title', 'Coach Dashboard')
@section('content')
@php
    $players   = \App\Models\Player::count();
    $matches   = \App\Models\GameMatch::count();
    $wins      = \App\Models\GameMatch::where('status','completed')->count();
    $sessions  = \App\Models\TrainingSession::where('status','scheduled')->count();
    $recentPlayers = \App\Models\Player::latest()->take(3)->get();
    $upcomingMatches = \App\Models\GameMatch::where('status','scheduled')->orderBy('match_date')->take(3)->get();
    $nextSessions = \App\Models\TrainingSession::where('status','scheduled')->take(3)->get();
    $injured = \App\Models\HealthRecord::where('status','injured')->with('player')->take(3)->get();
@endphp
<div class="p-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="text-3xl mb-2">👥</div>
            <div class="text-2xl font-bold">{{ $players }}</div>
            <div class="text-gray-600">Total Players</div>
        </div>
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="text-3xl mb-2">⚽</div>
            <div class="text-2xl font-bold">{{ $matches }}</div>
            <div class="text-gray-600">Total Matches</div>
        </div>
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="text-3xl mb-2">🏆</div>
            <div class="text-2xl font-bold">{{ $wins }}</div>
            <div class="text-gray-600">Completed</div>
        </div>
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="text-3xl mb-2">📅</div>
            <div class="text-2xl font-bold">{{ $sessions }}</div>
            <div class="text-gray-600">Scheduled Sessions</div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Players -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">👥 Recent Players</h2>
            @forelse($recentPlayers as $p)
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <div>
                    <div class="font-semibold">{{ $p->name }}</div>
                    <div class="text-sm text-gray-500">{{ $p->position }} · #{{ $p->jersey_number }}</div>
                </div>
                <span class="text-sm text-gray-400">{{ $p->goals }}G / {{ $p->assists }}A</span>
            </div>
            @empty
            <p class="text-gray-400 text-sm">No players added yet.</p>
            @endforelse
            <a href="{{ route('coach.players') }}" class="mt-3 w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 inline-block text-center text-sm">Manage Players</a>
        </div>

        <!-- Upcoming Matches -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">📅 Upcoming Matches</h2>
            @forelse($upcomingMatches as $m)
            <div class="border-b pb-2 mb-2">
                <div class="font-semibold">{{ $m->home_team }} vs {{ $m->away_team }}</div>
                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($m->match_date)->format('M d, Y - g:i A') }}</div>
            </div>
            @empty
            <p class="text-gray-400 text-sm">No upcoming matches.</p>
            @endforelse
            <a href="{{ route('coach.lineup') }}" class="mt-3 w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 inline-block text-center text-sm">Manage Lineups</a>
        </div>

        <!-- Training -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">🏋️ Training Sessions</h2>
            @forelse($nextSessions as $s)
            <div class="border-b pb-2 mb-2">
                <div class="font-semibold">{{ $s->day }} - {{ \Carbon\Carbon::parse($s->time)->format('g:i A') }}</div>
                <div class="text-sm text-gray-500">{{ $s->type }} · {{ $s->location }}</div>
            </div>
            @empty
            <p class="text-gray-400 text-sm">No sessions scheduled.</p>
            @endforelse
            <a href="{{ route('coach.training') }}" class="mt-3 w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 inline-block text-center text-sm">Schedule Training</a>
        </div>

        <!-- Injured Players -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">🤕 Injured Players</h2>
            @forelse($injured as $r)
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <div>
                    <div class="font-semibold">{{ $r->player->name ?? 'Unknown' }}</div>
                    <div class="text-sm text-gray-500">{{ $r->note }}</div>
                </div>
                <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">Injured</span>
            </div>
            @empty
            <p class="text-gray-400 text-sm">All players are fit! ✅</p>
            @endforelse
            <a href="{{ route('coach.health') }}" class="mt-3 w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 inline-block text-center text-sm">View Health Records</a>
        </div>
    </div>
</div>
@endsection
