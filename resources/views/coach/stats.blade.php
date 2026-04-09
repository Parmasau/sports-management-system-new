@extends('layouts.coach-app')
@section('title', 'Player Statistics')
@section('content')
<div class="p-8">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Player Performance Statistics</h2>
        
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-4 text-white text-center">
                <p class="text-sm">Top Scorer</p>
                <p class="text-2xl font-bold">{{ $topScorer ? $topScorer->name : 'N/A' }}</p>
                <p>{{ $topScorer ? $topScorer->goals . ' goals' : '' }}</p>
            </div>
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white text-center">
                <p class="text-sm">Most Assists</p>
                <p class="text-2xl font-bold">{{ $topAssist ? $topAssist->name : 'N/A' }}</p>
                <p>{{ $topAssist ? $topAssist->assists . ' assists' : '' }}</p>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white text-center">
                <p class="text-sm">Best Rating</p>
                <p class="text-2xl font-bold">{{ $bestRating ? $bestRating->name : 'N/A' }}</p>
                <p>{{ $bestRating ? $bestRating->rating . '/10' : '' }}</p>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white text-center">
                <p class="text-sm">Most Matches</p>
                <p class="text-2xl font-bold">{{ $mostMatches ? $mostMatches->name : 'N/A' }}</p>
                <p>{{ $mostMatches ? $mostMatches->matches . ' matches' : '' }}</p>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Player</th>
                        <th class="p-3 text-left">Position</th>
                        <th class="p-3 text-center">Matches</th>
                        <th class="p-3 text-center">Goals</th>
                        <th class="p-3 text-center">Assists</th>
                        <th class="p-3 text-center">Rating</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($players as $player)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">
                            <div class="flex items-center space-x-3">
                                @if($player->image)
                                    <img src="{{ asset('storage/' . $player->image) }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=667eea&color=fff&rounded=true&size=100" class="w-8 h-8 rounded-full">
                                @endif
                                <span class="font-semibold">{{ $player->name }}</span>
                            </div>
                        </td>
                        <td class="p-3">{{ $player->position }}</td>
                        <td class="p-3 text-center">{{ $player->matches }}</td>
                        <td class="p-3 text-center text-green-600 font-bold">{{ $player->goals }}</td>
                        <td class="p-3 text-center">{{ $player->assists }}</td>
                        <td class="p-3 text-center">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">{{ $player->rating }}</span>
                        </td>
                        <td class="p-3 text-center">
                            <button onclick="openEditModal({{ $player->id }}, {{ $player->goals }}, {{ $player->assists }}, {{ $player->matches }}, {{ $player->rating }})" 
                                    class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                <i class="fas fa-edit"></i> Update Stats
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center p-6">No player data available</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Stats Modal -->
<div id="statsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full">
        <h3 class="text-xl font-bold mb-4">Update Player Statistics</h3>
        <form id="statsForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="block text-gray-700 mb-2">Goals</label>
                <input type="number" name="goals" id="goals" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-gray-700 mb-2">Assists</label>
                <input type="number" name="assists" id="assists" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-gray-700 mb-2">Matches Played</label>
                <input type="number" name="matches" id="matches" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Rating (0-10)</label>
                <input type="number" step="0.1" name="rating" id="rating" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, goals, assists, matches, rating) {
    document.getElementById('statsForm').action = '/coach/stats/' + id;
    document.getElementById('goals').value = goals;
    document.getElementById('assists').value = assists;
    document.getElementById('matches').value = matches;
    document.getElementById('rating').value = rating;
    document.getElementById('statsModal').classList.remove('hidden');
    document.getElementById('statsModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('statsModal').classList.add('hidden');
    document.getElementById('statsModal').classList.remove('flex');
}
</script>
@endsection