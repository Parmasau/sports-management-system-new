@extends('layouts.coach-app')
@section('title', 'Match Management')
@section('content')
<div class="p-4">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 mb-4 rounded shadow-md text-sm">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Header -->
    <div class="relative rounded-xl shadow-lg overflow-hidden mb-4">
        <div class="absolute inset-0 bg-gradient-to-r from-green-900 to-teal-900"></div>
        <div class="relative z-10 px-4 py-3 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-white">Match Management</h2>
                <p class="text-green-200 text-xs">Schedule and manage matches</p>
            </div>
            <a href="{{ route('coach.matches.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg transition text-sm shadow-md">
                <i class="fas fa-plus mr-1"></i>Schedule Match
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-4">
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-700"></div>
            <div class="relative z-10 p-2 flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs">Total Matches</p>
                    <p class="text-xl font-bold text-white">{{ $matches->count() }}</p>
                </div>
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-white text-xs"></i>
                </div>
            </div>
        </div>
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-700"></div>
            <div class="relative z-10 p-2 flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-xs">Completed</p>
                    <p class="text-xl font-bold text-white">{{ $matches->where('status', 'completed')->count() }}</p>
                </div>
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-xs"></i>
                </div>
            </div>
        </div>
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-yellow-600 to-yellow-700"></div>
            <div class="relative z-10 p-2 flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-xs">Scheduled</p>
                    <p class="text-xl font-bold text-white">{{ $matches->where('status', 'scheduled')->count() }}</p>
                </div>
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-white text-xs"></i>
                </div>
            </div>
        </div>
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-purple-700"></div>
            <div class="relative z-10 p-2 flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-xs">Wins</p>
                    <p class="text-xl font-bold text-white">{{ $matches->where('result', 'win')->count() }}</p>
                </div>
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-trophy text-white text-xs"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Matches Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-4 py-2 bg-gradient-to-r from-green-600 to-teal-600">
            <h2 class="text-base font-bold text-white">Matches Schedule</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2 text-left text-xs font-semibold text-gray-600 uppercase">Opponent</th>
                        <th class="p-2 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        <th class="p-2 text-left text-xs font-semibold text-gray-600 uppercase">Time</th>
                        <th class="p-2 text-left text-xs font-semibold text-gray-600 uppercase">Location</th>
                        <th class="p-2 text-center text-xs font-semibold text-gray-600 uppercase">Score</th>
                        <th class="p-2 text-center text-xs font-semibold text-gray-600 uppercase">Result</th>
                        <th class="p-2 text-center text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="p-2 text-center text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($matches as $match)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-2 font-medium text-gray-800">{{ $match->opponent }}</td>
                        <td class="p-2 text-gray-600">{{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }}</td>
                        <td class="p-2 text-gray-600">{{ \Carbon\Carbon::parse($match->match_time)->format('g:i A') }}</td>
                        <td class="p-2 text-gray-600">{{ $match->location }} <span class="text-xs text-gray-400">({{ ucfirst($match->type) }})</span></td>
                        <td class="p-2 text-center font-bold">{{ $match->team_score }} - {{ $match->opponent_score }}</td>
                        <td class="p-2 text-center">
                            @if($match->result == 'win')
                                <span class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-xs">Win</span>
                            @elseif($match->result == 'loss')
                                <span class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded text-xs">Loss</span>
                            @elseif($match->result == 'draw')
                                <span class="bg-gray-100 text-gray-700 px-1.5 py-0.5 rounded text-xs">Draw</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded text-xs">Pending</span>
                            @endif
                        </td>
                        <td class="p-2 text-center">
                            @if($match->status == 'completed')
                                <span class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-xs">Completed</span>
                            @elseif($match->status == 'scheduled')
                                <span class="bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded text-xs">Scheduled</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded text-xs">Cancelled</span>
                            @endif
                        </td>
                        <td class="p-2 text-center">
                            <div class="flex justify-center space-x-1">
                                <a href="{{ route('coach.matches.edit', $match->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-1.5 py-0.5 rounded text-xs" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                @if($match->status == 'scheduled')
                                <a href="{{ route('coach.matches.stats', $match->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-1.5 py-0.5 rounded text-xs" title="Enter Stats">
                                    <i class="fas fa-chart-line text-xs"></i>
                                </a>
                                @endif
                                <form action="{{ route('coach.matches.destroy', $match->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this match?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-1.5 py-0.5 rounded text-xs" title="Delete">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center p-6 text-gray-500">
                            <i class="fas fa-calendar-times text-3xl mb-2 opacity-50"></i>
                            <p class="text-sm">No matches scheduled.</p>
                            <a href="{{ route('coach.matches.create') }}" class="text-blue-600 hover:underline text-sm">Schedule your first match</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

