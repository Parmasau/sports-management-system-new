@extends('layouts.admin-app')
@section('title', 'Manage Players')
@section('content')
<div class="p-4">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 mb-4 rounded shadow-md text-sm">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-4 py-3 bg-gradient-to-r from-purple-600 to-pink-600 flex justify-between items-center">
            <h2 class="text-lg font-bold text-white">All Players</h2>
            <a href="{{ route('admin.players.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-sm">
                <i class="fas fa-plus mr-1"></i>Add Player
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2 text-left">Player</th>
                        <th class="p-2 text-left">Position</th>
                        <th class="p-2 text-center">Jersey</th>
                        <th class="p-2 text-center">Goals</th>
                        <th class="p-2 text-center">Assists</th>
                        <th class="p-2 text-center">Rating</th>
                        <th class="p-2 text-center">Status</th>
                        <th class="p-2 text-center">Team</th>
                        <th class="p-2 text-center">Actions</th>
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
                                <div>
                                    <p class="font-medium">{{ $player->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $player->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-2">{{ $player->position }}</td>
                        <td class="p-2 text-center">{{ $player->jersey_number }}</td>
                        <td class="p-2 text-center font-bold text-green-600">{{ $player->goals }}</td>
                        <td class="p-2 text-center">{{ $player->assists }}</td>
                        <td class="p-2 text-center">{{ $player->rating }}</td>
                        <td class="p-2 text-center">
                            @if($player->status == 'active')
                                <span class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-xs">Active</span>
                            @elseif($player->status == 'injured')
                                <span class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded text-xs">Injured</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded text-xs">Suspended</span>
                            @endif
                        </td>
                        <td class="p-2 text-center">{{ $player->team ? $player->team->name : 'Unassigned' }}</td>
                        <td class="p-2 text-center">
                            <div class="flex justify-center space-x-1">
                                <a href="{{ route('admin.players.edit', $player->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-1.5 py-0.5 rounded text-xs">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.players.health', $player->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-1.5 py-0.5 rounded text-xs">
                                    <i class="fas fa-heartbeat"></i>
                                </a>
                                <form action="{{ route('admin.players.destroy', $player->id) }}" method="POST" onsubmit="return confirm('Delete this player?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-1.5 py-0.5 rounded text-xs">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

