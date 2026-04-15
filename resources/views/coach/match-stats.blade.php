@extends('layouts.coach-app')
@section('title', 'Match Stats - ' . $match->opponent)
@section('content')
<div class="p-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600">
            <h2 class="text-lg font-bold text-white">Match Statistics: {{ $match->opponent }}</h2>
            <p class="text-blue-100 text-xs">{{ \Carbon\Carbon::parse($match->match_date)->format('F j, Y') }} | {{ $match->location }}</p>
        </div>
        
        <form action="{{ route('coach.matches.stats.store', $match->id) }}" method="POST">
            @csrf
            <div class="overflow-x-auto p-4">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-2 text-left">Player</th>
                            <th class="p-2 text-center w-16">Goals</th>
                            <th class="p-2 text-center w-16">Assists</th>
                            <th class="p-2 text-center w-20">Minutes</th>
                            <th class="p-2 text-center w-20">Rating (0-10)</th>
                            <th class="p-2 text-center w-20">MOM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($players as $player)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2">
                                <div class="flex items-center space-x-2">
                                    @if($player->image)
                                        <img src="{{ asset('storage/' . $player->image) }}" class="w-6 h-6 rounded-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=3b82f6&color=fff&rounded=true&size=100" class="w-6 h-6 rounded-full">
                                    @endif
                                    <span class="font-medium">{{ $player->name }}</span>
                                </div>
                            </td>
                            <td class="p-2 text-center">
                                <input type="number" name="stats[{{ $player->id }}][goals]" value="{{ $matchStats[$player->id]->goals ?? 0 }}" 
                                       class="w-16 border rounded px-1 py-1 text-center text-sm" min="0" max="10">
                            </td>
                            <td class="p-2 text-center">
                                <input type="number" name="stats[{{ $player->id }}][assists]" value="{{ $matchStats[$player->id]->assists ?? 0 }}" 
                                       class="w-16 border rounded px-1 py-1 text-center text-sm" min="0" max="10">
                            </td>
                            <td class="p-2 text-center">
                                <input type="number" name="stats[{{ $player->id }}][minutes_played]" value="{{ $matchStats[$player->id]->minutes_played ?? 0 }}" 
                                       class="w-20 border rounded px-1 py-1 text-center text-sm" min="0" max="120">
                            </td>
                            <td class="p-2 text-center">
                                <input type="number" name="stats[{{ $player->id }}][rating]" value="{{ $matchStats[$player->id]->rating ?? 0 }}" 
                                       class="w-20 border rounded px-1 py-1 text-center text-sm" step="0.1" min="0" max="10">
                            </td>
                            <td class="p-2 text-center">
                                <input type="checkbox" name="stats[{{ $player->id }}][man_of_match]" {{ isset($matchStats[$player->id]) && $matchStats[$player->id]->man_of_match ? 'checked' : '' }} 
                                       class="w-4 h-4">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 bg-gray-50 border-t flex justify-end space-x-2">
                <a href="{{ route('coach.matches') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg text-sm">Cancel</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                    <i class="fas fa-save mr-1"></i>Save Statistics
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

