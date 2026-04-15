@extends('layouts.coach-app')
@section('title', 'Manage Players')
@section('content')
<div class="p-4">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 mb-4 rounded shadow-md text-sm">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Header Section - Compact -->
    <div class="relative rounded-xl shadow-lg overflow-hidden mb-4">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900 to-cyan-900"></div>
        <div class="relative z-10 px-4 py-3 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-white">Player Squad</h2>
                <p class="text-blue-200 text-xs">Manage all players, view stats and performance</p>
            </div>
            <a href="{{ route('coach.players.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg transition text-sm shadow-md">
                <i class="fas fa-plus mr-1"></i>Add Player
            </a>
        </div>
    </div>

    <!-- Stats Cards - Smaller Boxes -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-4">
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-700"></div>
            <div class="relative z-10 p-2 flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs">Total Players</p>
                    <p class="text-xl font-bold text-white">{{ $players->count() }}</p>
                </div>
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-white text-xs"></i>
                </div>
            </div>
        </div>
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-700"></div>
            <div class="relative z-10 p-2 flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-xs">Active</p>
                    <p class="text-xl font-bold text-white">{{ $players->where('status', 'active')->count() }}</p>
                </div>
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-check text-white text-xs"></i>
                </div>
            </div>
        </div>
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-red-700"></div>
            <div class="relative z-10 p-2 flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-xs">Injured</p>
                    <p class="text-xl font-bold text-white">{{ $players->where('status', 'injured')->count() }}</p>
                </div>
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-ambulance text-white text-xs"></i>
                </div>
            </div>
        </div>
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-yellow-600 to-yellow-700"></div>
            <div class="relative z-10 p-2 flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-xs">Goals</p>
                    <p class="text-xl font-bold text-white">{{ $players->sum('goals') }}</p>
                </div>
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-futbol text-white text-xs"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Players Table - Compact -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600">
            <h2 class="text-base font-bold text-white">
                <i class="fas fa-users mr-2"></i>Players List
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2 text-left text-xs font-semibold text-gray-600 uppercase">Player</th>
                        <th class="p-2 text-left text-xs font-semibold text-gray-600 uppercase">Pos</th>
                        <th class="p-2 text-center text-xs font-semibold text-gray-600 uppercase">#</th>
                        <th class="p-2 text-center text-xs font-semibold text-gray-600 uppercase">G</th>
                        <th class="p-2 text-center text-xs font-semibold text-gray-600 uppercase">A</th>
                        <th class="p-2 text-center text-xs font-semibold text-gray-600 uppercase">Rat</th>
                        <th class="p-2 text-center text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="p-2 text-center text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($players as $player)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-2">
                            <div class="flex items-center space-x-2">
                                @if($player->image)
                                    <img src="{{ asset('storage/' . $player->image) }}" class="w-6 h-6 rounded-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=3b82f6&color=fff&rounded=true&size=100" class="w-6 h-6 rounded-full">
                                @endif
                                <div>
                                    <p class="font-medium text-gray-800 text-xs">{{ Str::limit($player->name, 15) }}</p>
                                    <p class="text-xs text-gray-500">{{ Str::limit($player->email, 15) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-2 text-xs text-gray-600">{{ $player->position }}</td>
                        <td class="p-2 text-center text-xs text-gray-600">{{ $player->jersey_number }}</td>
                        <td class="p-2 text-center text-xs font-bold text-green-600">{{ $player->goals }}</td>
                        <td class="p-2 text-center text-xs text-gray-600">{{ $player->assists }}</td>
                        <td class="p-2 text-center">
                            <span class="bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded text-xs">{{ $player->rating }}</span>
                        </td>
                        <td class="p-2 text-center">
                            @if($player->status == 'active')
                                <span class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-xs">Active</span>
                            @elseif($player->status == 'injured')
                                <span class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded text-xs">Injured</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded text-xs">Suspended</span>
                            @endif
                        </td>
                        <td class="p-2 text-center">
                            <div class="flex justify-center space-x-1">
                                <a href="{{ route('coach.players.edit', $player->id) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-1.5 py-0.5 rounded text-xs transition" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <a href="{{ route('coach.players.health', $player->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-1.5 py-0.5 rounded text-xs transition" title="Health">
                                    <i class="fas fa-heartbeat text-xs"></i>
                                </a>
                                <a href="{{ route('coach.players.achievements', $player->id) }}" 
                                   class="bg-purple-500 hover:bg-purple-600 text-white px-1.5 py-0.5 rounded text-xs transition" title="Achievements">
                                    <i class="fas fa-trophy text-xs"></i>
                                </a>
                                <form action="{{ route('coach.players.destroy', $player->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this player?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-1.5 py-0.5 rounded text-xs transition" title="Delete">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center p-6 text-gray-500">
                            <i class="fas fa-user-slash text-3xl mb-2 opacity-50"></i>
                            <p class="text-sm">No players found.</p>
                            <a href="{{ route('coach.players.create') }}" class="text-blue-600 hover:underline text-sm">Add your first player</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Footer Stats - Compact -->
        <div class="px-4 py-2 bg-gray-50 border-t border-gray-200">
            <div class="grid grid-cols-4 gap-2">
                <div class="text-center">
                    <p class="text-base font-bold text-blue-600">{{ $players->count() }}</p>
                    <p class="text-xs text-gray-500">Total</p>
                </div>
                <div class="text-center">
                    <p class="text-base font-bold text-green-600">{{ $players->where('status', 'active')->count() }}</p>
                    <p class="text-xs text-gray-500">Active</p>
                </div>
                <div class="text-center">
                    <p class="text-base font-bold text-yellow-600">{{ $players->sum('goals') }}</p>
                    <p class="text-xs text-gray-500">Goals</p>
                </div>
                <div class="text-center">
                    <p class="text-base font-bold text-purple-600">{{ round($players->avg('rating'), 1) }}</p>
                    <p class="text-xs text-gray-500">Avg Rating</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection