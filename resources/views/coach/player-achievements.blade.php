@extends('layouts.coach-app')
@section('title', 'Player Achievements - ' . $player->name)
@section('content')
<div class="p-6">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-6 rounded shadow-md">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-6 rounded shadow-md">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <!-- Player Info Card -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl shadow-lg p-4 mb-6 text-white">
        <div class="flex items-center space-x-4">
            @if($player->image)
                <img src="{{ asset('storage/' . $player->image) }}" class="w-14 h-14 rounded-full object-cover border-2 border-white">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=fff&color=667eea&rounded=true&size=100" class="w-14 h-14 rounded-full border-2 border-white">
            @endif
            <div>
                <h1 class="text-xl font-bold">{{ $player->name }}</h1>
                <p class="text-purple-100 text-sm">{{ $player->position }} | Jersey #{{ $player->jersey_number }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Assign New Achievement Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-3 bg-gradient-to-r from-green-600 to-teal-600">
                <h2 class="text-lg font-bold text-white">Assign New Achievement</h2>
            </div>
            <div class="p-4">
                <form action="{{ route('coach.players.achievements.assign', $player->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Select Achievement</label>
                        <select name="achievement_id" class="w-full border rounded-lg p-2 text-sm" required>
                            <option value="">Choose an achievement...</option>
                            @foreach($achievements as $achievement)
                                <option value="{{ $achievement->id }}">
                                    {{ $achievement->icon }} {{ $achievement->title }} ({{ $achievement->points }} pts)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Earned Date</label>
                        <input type="date" name="earned_date" value="{{ date('Y-m-d') }}" class="w-full border rounded-lg p-2 text-sm" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Notes (Optional)</label>
                        <textarea name="notes" rows="2" class="w-full border rounded-lg p-2 text-sm" placeholder="Add any notes about this achievement..."></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg text-sm hover:bg-green-700 transition">
                        <i class="fas fa-trophy mr-2"></i>Assign Achievement
                    </button>
                </form>
            </div>
        </div>

        <!-- Current Achievements Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-3 bg-gradient-to-r from-yellow-600 to-orange-600">
                <h2 class="text-lg font-bold text-white">
                    <i class="fas fa-medal mr-2"></i>Earned Achievements
                    <span class="text-sm opacity-80">({{ $playerAchievements->count() }} earned)</span>
                </h2>
            </div>
            <div class="p-4 max-h-96 overflow-y-auto">
                @if($playerAchievements->count() > 0)
                    <div class="space-y-3">
                        @foreach($playerAchievements as $achievement)
                        <div class="border rounded-lg p-3 hover:shadow-md transition" id="achievement-{{ $achievement->id }}">
                            <div class="flex justify-between items-start">
                                <div class="flex items-start space-x-3 flex-1">
                                    <div class="text-3xl">{{ $achievement->icon }}</div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-800 text-sm">{{ $achievement->title }}</h3>
                                        <p class="text-xs text-gray-500 earned-date" data-date="{{ $achievement->pivot->earned_date }}">
                                            Earned: {{ \Carbon\Carbon::parse($achievement->pivot->earned_date)->format('F j, Y') }}
                                        </p>
                                        @if($achievement->pivot->notes)
                                            <p class="text-xs text-gray-400 mt-1 notes-text">{{ $achievement->pivot->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-0.5 rounded text-xs bg-yellow-100 text-yellow-800">{{ $achievement->points }} pts</span>
                                    <button onclick="openEditModal({{ $achievement->id }}, '{{ $achievement->pivot->earned_date }}', '{{ addslashes($achievement->pivot->notes) }}')" 
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('coach.players.achievements.remove', [$player->id, $achievement->id]) }}" method="POST" onsubmit="return confirm('Remove this achievement?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs transition">
                                            <i class="fas fa-trash"></i> Del
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-medal text-4xl mb-2 opacity-50"></i>
                        <p class="text-sm">No achievements earned yet.</p>
                        <p class="text-xs">Assign achievements to this player.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Achievement Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Edit Achievement</h3>
            <form id="editAchievementForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Earned Date</label>
                    <input type="date" name="earned_date" id="edit_earned_date" class="w-full border rounded-lg p-2" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Notes</label>
                    <textarea name="notes" id="edit_notes" rows="3" class="w-full border rounded-lg p-2" placeholder="Add notes about this achievement..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update Achievement</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Achievement Summary Card -->
    <div class="mt-6 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg p-4 text-white">
        <h3 class="font-bold text-md mb-2">Achievement Summary</h3>
        <div class="grid grid-cols-3 gap-3">
            <div class="text-center">
                <p class="text-2xl font-bold">{{ $playerAchievements->count() }}</p>
                <p class="text-xs opacity-90">Total Achievements</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold">{{ $playerAchievements->sum('points') }}</p>
                <p class="text-xs opacity-90">Total Points</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold">{{ $playerAchievements->unique('type')->count() }}</p>
                <p class="text-xs opacity-90">Categories</p>
            </div>
        </div>
    </div>
</div>

<script>
function openEditModal(achievementId, earnedDate, notes) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editAchievementForm');
    const earnedDateInput = document.getElementById('edit_earned_date');
    const notesTextarea = document.getElementById('edit_notes');
    
    // Set form action URL
    form.action = '/coach/players/' + {{ $player->id }} + '/achievements/' + achievementId + '/update';
    
    // Set values
    earnedDateInput.value = earnedDate;
    notesTextarea.value = notes || '';
    
    // Show modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection