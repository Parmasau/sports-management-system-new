@extends('layouts.coach-app')
@section('title', 'Manage Players')
@section('content')
<div class="p-6">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded shadow-md">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards - Small Boxes -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Total Players Card -->
        <div class="relative rounded-lg shadow-md overflow-hidden group cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-700"></div>
            <div class="relative z-10 p-3 flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs uppercase tracking-wide">Total Players</p>
                    <p class="text-2xl font-bold text-white">{{ $players->count() }}</p>
                </div>
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-white text-sm"></i>
                </div>
            </div>
        </div>

        <!-- Active Players Card -->
        <div class="relative rounded-lg shadow-md overflow-hidden group cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-700"></div>
            <div class="relative z-10 p-3 flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-xs uppercase tracking-wide">Active Players</p>
                    <p class="text-2xl font-bold text-white">{{ $players->where('status', 'active')->count() }}</p>
                </div>
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-check text-white text-sm"></i>
                </div>
            </div>
        </div>

        <!-- Injured Players Card -->
        <div class="relative rounded-lg shadow-md overflow-hidden group cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-red-700"></div>
            <div class="relative z-10 p-3 flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-xs uppercase tracking-wide">Injured</p>
                    <p class="text-2xl font-bold text-white">{{ $players->where('status', 'injured')->count() }}</p>
                </div>
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-ambulance text-white text-sm"></i>
                </div>
            </div>
        </div>

        <!-- Total Goals Card -->
        <div class="relative rounded-lg shadow-md overflow-hidden group cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-r from-yellow-600 to-yellow-700"></div>
            <div class="relative z-10 p-3 flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-xs uppercase tracking-wide">Total Goals</p>
                    <p class="text-2xl font-bold text-white">{{ $players->sum('goals') }}</p>
                </div>
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-futbol text-white text-sm"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Players List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">
                    <i class="fas fa-users mr-2"></i>Player Squad
                </h2>
                <a href="{{ route('coach.players.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-sm transition flex items-center">
                    <i class="fas fa-plus mr-1"></i>Add Player
                </a>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left text-xs font-semibold text-gray-600 uppercase">Player</th>
                        <th class="p-3 text-left text-xs font-semibold text-gray-600 uppercase">Position</th>
                        <th class="p-3 text-left text-xs font-semibold text-gray-600 uppercase">Jersey</th>
                        <th class="p-3 text-center text-xs font-semibold text-gray-600 uppercase">Goals</th>
                        <th class="p-3 text-center text-xs font-semibold text-gray-600 uppercase">Assists</th>
                        <th class="p-3 text-center text-xs font-semibold text-gray-600 uppercase">Rating</th>
                        <th class="p-3 text-center text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="p-3 text-center text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($players as $player)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-3">
                            <div class="flex items-center space-x-3">
                                @if($player->image)
                                    <img src="{{ asset('storage/' . $player->image) }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=3b82f6&color=fff&rounded=true&size=100" class="w-8 h-8 rounded-full">
                                @endif
                                <div>
                                    <p class="font-medium text-gray-800">{{ $player->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $player->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-3 text-sm text-gray-600">{{ $player->position }}</td>
                        <td class="p-3 text-sm text-gray-600">#{{ $player->jersey_number }}</td>
                        <td class="p-3 text-center">
                            <span class="text-sm font-bold text-green-600">{{ $player->goals }}</span>
                        </td>
                        <td class="p-3 text-center text-sm text-gray-600">{{ $player->assists }}</td>
                        <td class="p-3 text-center">
                            <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-xs">{{ $player->rating }}</span>
                        </td>
                        <td class="p-3 text-center">
                            @if($player->status == 'active')
                                <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded text-xs">Active</span>
                            @elseif($player->status == 'injured')
                                <span class="bg-red-100 text-red-800 px-2 py-0.5 rounded text-xs">Injured</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded text-xs">Suspended</span>
                            @endif
                        </td>
                        <td class="p-3 text-center">
                            <div class="flex justify-center space-x-1">
                                <a href="{{ route('coach.players.edit', $player->id) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs transition flex items-center">
                                    <i class="fas fa-edit mr-1 text-xs"></i>Edit
                                </a>
                                <form action="{{ route('coach.players.destroy', $player->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this player?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs transition flex items-center">
                                        <i class="fas fa-trash mr-1 text-xs"></i>Del
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center p-8 text-gray-500">
                            <i class="fas fa-user-slash text-4xl mb-2 opacity-50"></i>
                            <p>No players found.</p>
                            <a href="{{ route('coach.players.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">Add your first player</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Footer Stats -->
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            <div class="grid grid-cols-4 gap-3">
                <div class="text-center">
                    <p class="text-lg font-bold text-blue-600">{{ $players->count() }}</p>
                    <p class="text-xs text-gray-500">Total</p>
                </div>
                <div class="text-center">
                    <p class="text-lg font-bold text-green-600">{{ $players->where('status', 'active')->count() }}</p>
                    <p class="text-xs text-gray-500">Active</p>
                </div>
                <div class="text-center">
                    <p class="text-lg font-bold text-yellow-600">{{ $players->sum('goals') }}</p>
                    <p class="text-xs text-gray-500">Goals</p>
                </div>
                <div class="text-center">
                    <p class="text-lg font-bold text-purple-600">{{ round($players->avg('rating'), 1) }}</p>
                    <p class="text-xs text-gray-500">Avg Rating</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection