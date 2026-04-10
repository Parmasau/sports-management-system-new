@extends('layouts.admin-app')
@section('title', 'Manage Matches')
@section('content')
<div class="p-8">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Schedule New Match</h2>
        
        <form action="{{ route('admin.matches.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            <input type="text" name="opponent" placeholder="Opponent Team" class="border rounded-lg p-2" required>
            <input type="date" name="match_date" class="border rounded-lg p-2" required>
            <input type="time" name="match_time" class="border rounded-lg p-2" required>
            <input type="text" name="location" placeholder="Location" class="border rounded-lg p-2" required>
            <select name="type" class="border rounded-lg p-2" required>
                <option value="home">Home</option>
                <option value="away">Away</option>
            </select>
            <select name="team_id" class="border rounded-lg p-2" required>
                <option value="">Select Team</option>
                @foreach(\App\Models\Team::all() as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 md:col-span-3">
                <i class="fas fa-plus mr-2"></i>Schedule Match
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">All Matches</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Opponent</th>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-left">Time</th>
                        <th class="p-3 text-left">Location</th>
                        <th class="p-3 text-center">Type</th>
                        <th class="p-3 text-center">Score</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($matches as $match)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 font-semibold">{{ $match->opponent }}</td>
                        <td class="p-3">{{ $match->match_date->format('M d, Y') }}</td>
                        <td class="p-3">{{ date('g:i A', strtotime($match->match_time)) }}</td>
                        <td class="p-3">{{ $match->location }}</td>
                        <td class="p-3 text-center">
                            <span class="px-2 py-1 rounded text-xs {{ $match->type == 'home' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($match->type) }}
                            </span>
                        </td>
                        <td class="p-3 text-center font-bold">{{ $match->team_score }} - {{ $match->opponent_score }}</td>
                        <td class="p-3 text-center">
                            <form action="{{ route('admin.matches.destroy', $match->id) }}" method="POST" onsubmit="return confirm('Delete this match?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center p-6 text-gray-500">No matches scheduled.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection