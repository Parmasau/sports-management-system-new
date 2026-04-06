@extends('layouts.admin-app')
@section('title', 'Reports')
@section('content')
<div class="p-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-50 rounded-lg p-6"><div class="text-3xl mb-2">👥</div><div class="text-2xl font-bold">{{ $totalUsers }}</div><div class="text-gray-600">Total Users</div></div>
        <div class="bg-gray-50 rounded-lg p-6"><div class="text-3xl mb-2">⚽</div><div class="text-2xl font-bold">{{ $totalPlayers }}</div><div class="text-gray-600">Players</div></div>
        <div class="bg-gray-50 rounded-lg p-6"><div class="text-3xl mb-2">🏟️</div><div class="text-2xl font-bold">{{ $totalTeams }}</div><div class="text-gray-600">Teams</div></div>
        <div class="bg-gray-50 rounded-lg p-6"><div class="text-3xl mb-2">📅</div><div class="text-2xl font-bold">{{ $totalMatches }}</div><div class="text-gray-600">Matches</div></div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Top Scorers -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold mb-4">🥇 Top Scorers</h2>
            @forelse($topScorers as $i => $player)
            <div class="flex justify-between items-center bg-gray-50 rounded-lg px-4 py-3 mb-2">
                <div class="flex items-center space-x-3">
                    <span class="text-lg font-bold text-gray-400">#{{ $i + 1 }}</span>
                    <div>
                        <div class="font-semibold">{{ $player->name }}</div>
                        <div class="text-sm text-gray-500">{{ $player->position }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-bold text-green-600">{{ $player->goals }} goals</div>
                    <div class="text-xs text-gray-400">{{ $player->assists }} assists</div>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-4">No player data yet.</p>
            @endforelse
        </div>

        <!-- Recent Matches -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold mb-4">📅 Recent Matches</h2>
            @forelse($recentMatches as $match)
            <div class="flex justify-between items-center bg-gray-50 rounded-lg px-4 py-3 mb-2">
                <div>
                    <div class="font-semibold">{{ $match->home_team }} vs {{ $match->away_team }}</div>
                    <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }}</div>
                </div>
                <div class="text-right">
                    @if($match->status === 'completed')
                        <div class="font-bold">{{ $match->home_score }} - {{ $match->away_score }}</div>
                    @endif
                    <span class="text-xs px-2 py-1 rounded-full
                        {{ $match->status === 'completed' ? 'bg-gray-100 text-gray-600' : 'bg-blue-100 text-blue-600' }}">
                        {{ ucfirst($match->status) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-4">No matches yet.</p>
            @endforelse
        </div>

        <!-- Health Summary -->
        <div class="bg-white rounded-lg shadow-sm p-6 md:col-span-2">
            <h2 class="text-xl font-bold mb-4">🏥 Health Summary</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach(['fit' => ['green','✅'], 'injured' => ['red','🤕'], 'observation' => ['yellow','⚠️'], 'recovering' => ['blue','🔄']] as $status => [$color, $icon])
                <div class="bg-{{ $color }}-50 border border-{{ $color }}-200 rounded-lg p-4 text-center">
                    <div class="text-2xl mb-1">{{ $icon }}</div>
                    <div class="text-xl font-bold text-{{ $color }}-600">
                        {{ \App\Models\HealthRecord::where('status', $status)->count() }}
                    </div>
                    <div class="text-sm text-gray-500">{{ ucfirst($status) }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
