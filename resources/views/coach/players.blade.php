@extends('layouts.coach-app')
@section('title', 'Manage Players')
@section('content')
<div class="p-8" x-data="{ showAdd: false, showEdit: false, editPlayer: {} }">

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">👥 Manage Players</h2>
            <button @click="showAdd = true" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">+ Add Player</button>
        </div>

        @forelse($players as $player)
        <div class="flex justify-between items-center bg-gray-50 rounded-lg px-4 py-3 mb-2">
            <div>
                <div class="font-semibold">{{ $player->name }}</div>
                <div class="text-sm text-gray-500">{{ $player->position }} · #{{ $player->jersey_number }} · {{ $player->matches }} matches · {{ $player->goals }} goals</div>
            </div>
            <div class="flex space-x-2">
                <button @click="editPlayer = {{ $player->toJson() }}; showEdit = true"
                    class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">Edit</button>
                <form method="POST" action="{{ route('coach.players.destroy', $player) }}" onsubmit="return confirm('Remove player?')">
                    @csrf @method('DELETE')
                    <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Remove</button>
                </form>
            </div>
        </div>
        @empty
            <p class="text-gray-400 text-center py-8">No players yet. Add your first player.</p>
        @endforelse
    </div>

    <!-- Add Modal -->
    <div x-show="showAdd" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-transition>
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md" @click.outside="showAdd = false">
            <h3 class="text-xl font-bold mb-4">Add Player</h3>
            <form method="POST" action="{{ route('coach.players.store') }}" class="space-y-3">
                @csrf
                <input name="name" placeholder="Full Name" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                <select name="position" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option value="">Select Position</option>
                    @foreach(['Goalkeeper','Defender','Midfielder','Forward'] as $pos)
                        <option value="{{ $pos }}">{{ $pos }}</option>
                    @endforeach
                </select>
                <input name="jersey_number" type="number" placeholder="Jersey Number" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                <div class="grid grid-cols-3 gap-2">
                    <input name="matches" type="number" placeholder="Matches" value="0" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <input name="goals" type="number" placeholder="Goals" value="0" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <input name="assists" type="number" placeholder="Assists" value="0" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>
                <input name="rating" type="number" step="0.1" min="0" max="10" placeholder="Rating (0-10)" value="0" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="showAdd = false" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEdit" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-transition>
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md" @click.outside="showEdit = false">
            <h3 class="text-xl font-bold mb-4">Edit Player</h3>
            <form method="POST" :action="`/coach/players/${editPlayer.id}`" class="space-y-3">
                @csrf @method('PUT')
                <input name="name" :value="editPlayer.name" placeholder="Full Name" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <select name="position" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @foreach(['Goalkeeper','Defender','Midfielder','Forward'] as $pos)
                        <option :selected="editPlayer.position === '{{ $pos }}'" value="{{ $pos }}">{{ $pos }}</option>
                    @endforeach
                </select>
                <input name="jersey_number" type="number" :value="editPlayer.jersey_number" placeholder="Jersey Number" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <div class="grid grid-cols-3 gap-2">
                    <input name="matches" type="number" :value="editPlayer.matches" placeholder="Matches" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <input name="goals" type="number" :value="editPlayer.goals" placeholder="Goals" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <input name="assists" type="number" :value="editPlayer.assists" placeholder="Assists" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <input name="rating" type="number" step="0.1" min="0" max="10" :value="editPlayer.rating" placeholder="Rating" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="showEdit = false" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
