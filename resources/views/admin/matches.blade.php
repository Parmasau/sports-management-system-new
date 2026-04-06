@extends('layouts.admin-app')
@section('title', 'Manage Matches')
@section('content')
<div class="p-8" x-data="{ showAdd: false, showEdit: false, editMatch: {} }">

    @if(session('success'))<div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>@endif

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">📅 Manage Matches</h2>
            <button @click="showAdd = true" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">+ Schedule Match</button>
        </div>

        @forelse($matches as $match)
        <div class="flex justify-between items-center bg-gray-50 rounded-lg px-4 py-3 mb-2">
            <div>
                <div class="font-semibold">{{ $match->home_team }} vs {{ $match->away_team }}</div>
                <div class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y - g:i A') }}
                    @if($match->venue) · {{ $match->venue }} @endif
                    @if($match->status === 'completed') · Score: {{ $match->home_score }} - {{ $match->away_score }} @endif
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-xs font-medium px-2 py-1 rounded-full
                    {{ $match->status === 'scheduled' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $match->status === 'live' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $match->status === 'completed' ? 'bg-gray-100 text-gray-700' : '' }}
                    {{ $match->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                    {{ ucfirst($match->status) }}
                </span>
                <button @click="editMatch = {{ $match->toJson() }}; showEdit = true"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</button>
                <form method="POST" action="{{ route('admin.matches.destroy', $match) }}" onsubmit="return confirm('Delete match?')">
                    @csrf @method('DELETE')
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-center py-8">No matches scheduled yet.</p>
        @endforelse
    </div>

    <!-- Add Modal -->
    <div x-show="showAdd" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-transition>
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md" @click.outside="showAdd = false">
            <h3 class="text-xl font-bold mb-4">Schedule Match</h3>
            <form method="POST" action="{{ route('admin.matches.store') }}" class="space-y-3">
                @csrf
                @if($teams->count())
                <select name="home_team" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="">Home Team</option>
                    @foreach($teams as $t)<option value="{{ $t->name }}">{{ $t->name }}</option>@endforeach
                </select>
                <select name="away_team" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="">Away Team</option>
                    @foreach($teams as $t)<option value="{{ $t->name }}">{{ $t->name }}</option>@endforeach
                </select>
                @else
                <input name="home_team" placeholder="Home Team" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                <input name="away_team" placeholder="Away Team" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                @endif
                <input name="match_date" type="datetime-local" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                <input name="venue" placeholder="Venue (optional)" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                <select name="status" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="scheduled">Scheduled</option>
                    <option value="live">Live</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="showAdd = false" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEdit" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-transition>
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md" @click.outside="showEdit = false">
            <h3 class="text-xl font-bold mb-4">Edit Match</h3>
            <form method="POST" :action="`/admin/matches/${editMatch.id}`" class="space-y-3">
                @csrf @method('PUT')
                <input name="home_team" :value="editMatch.home_team" placeholder="Home Team" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <input name="away_team" :value="editMatch.away_team" placeholder="Away Team" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <input name="match_date" type="datetime-local" :value="editMatch.match_date ? editMatch.match_date.slice(0,16) : ''" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <input name="venue" :value="editMatch.venue" placeholder="Venue" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <div class="grid grid-cols-2 gap-2">
                    <input name="home_score" type="number" :value="editMatch.home_score" placeholder="Home Score" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <input name="away_score" type="number" :value="editMatch.away_score" placeholder="Away Score" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <select name="status" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @foreach(['scheduled','live','completed','cancelled'] as $s)
                        <option :selected="editMatch.status === '{{ $s }}'" value="{{ $s }}">{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="showEdit = false" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
