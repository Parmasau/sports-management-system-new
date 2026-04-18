@extends('layouts.admin-app')
@section('title', 'Manage Matches')
@section('content')
<div class="p-4">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 mb-4 rounded shadow-md text-sm">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <div class="px-4 py-3 bg-gradient-to-r from-green-600 to-teal-600 flex justify-between items-center">
            <h2 class="text-lg font-bold text-white">Schedule New Match</h2>
            <button onclick="document.getElementById('addMatchModal').classList.remove('hidden')" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-sm">
                <i class="fas fa-plus mr-1"></i>Add Match
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600">
            <h2 class="text-lg font-bold text-white">All Matches</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2 text-left">Opponent</th>
                        <th class="p-2 text-left">Date</th>
                        <th class="p-2 text-left">Time</th>
                        <th class="p-2 text-left">Location</th>
                        <th class="p-2 text-center">Score</th>
                        <th class="p-2 text-center">Result</th>
                        <th class="p-2 text-center">Status</th>
                        <th class="p-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matches as $match)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2 font-medium">{{ $match->opponent }}</td>
                        <td class="p-2">{{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }}</td>
                        <td class="p-2">{{ \Carbon\Carbon::parse($match->match_time)->format('g:i A') }}</td>
                        <td class="p-2">{{ $match->location }} <span class="text-xs text-gray-400">({{ ucfirst($match->type) }})</span></td>
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
                                <button onclick="editMatch({{ $match->id }})" class="bg-yellow-500 hover:bg-yellow-600 text-white px-1.5 py-0.5 rounded text-xs">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.matches.destroy', $match->id) }}" method="POST" onsubmit="return confirm('Delete this match?')" class="inline">
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

<!-- Add Match Modal -->
<div id="addMatchModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full">
        <h3 class="text-xl font-bold mb-4">Schedule New Match</h3>
        <form action="{{ route('admin.matches.store') }}" method="POST">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium mb-1">Opponent Team</label>
                    <input type="text" name="opponent" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Select Team</label>
                    <select name="team_id" class="w-full border rounded-lg p-2" required>
                        <option value="">Select Team</option>
                        @foreach(\App\Models\Team::all() as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Match Date</label>
                    <input type="date" name="match_date" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Match Time</label>
                    <input type="time" name="match_time" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Location</label>
                    <input type="text" name="location" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Match Type</label>
                    <select name="type" class="w-full border rounded-lg p-2" required>
                        <option value="home">Home</option>
                        <option value="away">Away</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="document.getElementById('addMatchModal').classList.add('hidden')" class="bg-gray-400 text-white px-4 py-2 rounded-lg">Cancel</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Schedule Match</button>
            </div>
        </form>
    </div>
</div>

<script>
function editMatch(id) {
    window.location.href = '/admin/matches/' + id + '/edit';
}
</script>
@endsection