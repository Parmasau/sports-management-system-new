@extends('layouts.admin-app')
@section('title', 'Lineups')
@section('content')
<div class="p-8" x-data="{ showAdd: false }">

    @if(session('success'))<div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>@endif

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">📋 Lineups</h2>
            <button @click="showAdd = true" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">+ Create Lineup</button>
        </div>

        @forelse($lineups as $lineup)
        <div class="bg-gray-50 rounded-lg px-4 py-4 mb-3">
            <div class="flex justify-between items-start">
                <div>
                    <div class="font-bold text-lg">{{ $lineup->match_name }}</div>
                    <div class="text-sm text-gray-500 mb-2">Formation: {{ $lineup->formation }}</div>
                    <div class="flex flex-wrap gap-1">
                        @foreach($lineup->starting_xi as $entry)
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">{{ $entry }}</span>
                        @endforeach
                    </div>
                    @if(count($lineup->substitutes))
                    <div class="flex flex-wrap gap-1 mt-1">
                        @foreach($lineup->substitutes as $sub)
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">SUB: {{ $sub }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
                <form method="POST" action="{{ route('admin.lineups.destroy', $lineup) }}" onsubmit="return confirm('Delete lineup?')">
                    @csrf @method('DELETE')
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-center py-8">No lineups yet.</p>
        @endforelse
    </div>

    <!-- Create Lineup Modal -->
    <div x-show="showAdd" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 overflow-y-auto py-8" x-transition>
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg mx-4" @click.outside="showAdd = false">
            <h3 class="text-xl font-bold mb-4">Create Lineup</h3>
            <form method="POST" action="{{ route('admin.lineups.store') }}" class="space-y-3">
                @csrf
                <input name="match_name" placeholder="Match Name (e.g. vs Blue Eagles)" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                <select name="formation" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="">Select Formation</option>
                    @foreach(['4-3-3','4-4-2','3-5-2','5-3-2','4-2-3-1'] as $f)
                        <option value="{{ $f }}">{{ $f }}</option>
                    @endforeach
                </select>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Starting XI (select exactly 11)</label>
                    <div class="grid grid-cols-2 gap-1 max-h-48 overflow-y-auto border rounded-lg p-2">
                        @foreach($players as $player)
                        <label class="flex items-center space-x-2 p-1 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="starting_xi[]" value="{{ $player->position }}: {{ $player->name }} #{{ $player->jersey_number }}" class="accent-purple-500">
                            <span class="text-sm">{{ $player->name }} <span class="text-gray-400">({{ $player->position }})</span></span>
                        </label>
                        @endforeach
                        @if($players->isEmpty())<p class="text-gray-400 text-sm col-span-2 text-center py-2">No players added yet.</p>@endif
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Substitutes</label>
                    <div class="grid grid-cols-2 gap-1 max-h-32 overflow-y-auto border rounded-lg p-2">
                        @foreach($players as $player)
                        <label class="flex items-center space-x-2 p-1 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="substitutes[]" value="{{ $player->name }} #{{ $player->jersey_number }}" class="accent-yellow-500">
                            <span class="text-sm">{{ $player->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="showAdd = false" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white">Save Lineup</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
