@extends('layouts.player-app')
@section('title', 'My Matches')
@section('content')
<div class="p-8">
    <!-- Upcoming Matches -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>Upcoming Matches
        </h2>
        
        @if($upcomingMatches->count() > 0)
        <div class="space-y-4">
            @foreach($upcomingMatches as $match)
            <div class="border-l-4 border-green-500 bg-green-50 rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-bold text-lg">vs {{ $match->opponent }}</p>
                        <p class="text-gray-600">
                            <i class="fas fa-calendar mr-2"></i>{{ $match->match_date->format('F j, Y') }}
                            <i class="fas fa-clock ml-3 mr-2"></i>{{ date('g:i A', strtotime($match->match_time)) }}
                        </p>
                        <p class="text-gray-500 text-sm mt-1">
                            <i class="fas fa-location-dot mr-1"></i>{{ $match->location }}
                            <span class="ml-3 px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">{{ ucfirst($match->type) }}</span>
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">Upcoming</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-calendar-times text-4xl mb-2 opacity-50"></i>
            <p>No upcoming matches scheduled.</p>
        </div>
        @endif
    </div>

    <!-- Recent Matches -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            <i class="fas fa-history text-blue-600 mr-2"></i>Recent Matches
        </h2>
        
        @if($pastMatches->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Opponent</th>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-center">Score</th>
                        <th class="p-3 text-center">Result</th>
                        <th class="p-3 text-center">Your Stats</th>
                        <th class="p-3 text-center">Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pastMatches as $match)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 font-semibold">vs {{ $match->opponent }}</td>
                        <td class="p-3 text-gray-600">{{ $match->match_date->format('M d, Y') }}</td>
                        <td class="p-3 text-center font-bold">
                            {{ $match->team_score }} - {{ $match->opponent_score }}
                        </td>
                        <td class="p-3 text-center">
                            @if($match->result == 'win')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Win</span>
                            @elseif($match->result == 'loss')
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Loss</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">Draw</span>
                            @endif
                        </td>
                        <td class="p-3 text-center">
                            <span class="text-green-600 font-bold">{{ $match->player_goals ?? 0 }}</span> goals,
                            <span class="text-blue-600">{{ $match->player_assists ?? 0 }}</span> assists
                        </td>
                        <td class="p-3 text-center">
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">{{ $match->player_rating ?? 0 }}/10</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-futbol text-4xl mb-2 opacity-50"></i>
            <p>No past matches available.</p>
        </div>
        @endif
    </div>
</div>
@endsection