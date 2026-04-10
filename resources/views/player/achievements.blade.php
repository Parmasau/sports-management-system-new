@extends('layouts.player-app')
@section('title', 'Achievements')
@section('content')
<div class="p-8">
    <!-- Achievement Progress -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            <i class="fas fa-chart-line text-blue-600 mr-2"></i>Achievement Progress
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90">Goal Scorer</p>
                <p class="text-2xl font-bold">{{ $progress['goal_milestones']['current'] }} Goals</p>
                @if($progress['goal_milestones']['next'])
                    <div class="mt-2">
                        <div class="w-full bg-white/30 rounded-full h-2">
                            <div class="bg-white h-2 rounded-full" style="width: {{ $progress['goal_milestones']['progress'] }}%"></div>
                        </div>
                        <p class="text-xs mt-1">{{ $progress['goal_milestones']['progress'] }}% to {{ $progress['goal_milestones']['next'] }} goals</p>
                    </div>
                @else
                    <p class="text-sm mt-2">🏆 Legendary!</p>
                @endif
            </div>
            
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90">Match Milestones</p>
                <p class="text-2xl font-bold">{{ $progress['match_milestones']['current'] }} Matches</p>
                @if($progress['match_milestones']['next'])
                    <div class="mt-2">
                        <div class="w-full bg-white/30 rounded-full h-2">
                            <div class="bg-white h-2 rounded-full" style="width: {{ $progress['match_milestones']['progress'] }}%"></div>
                        </div>
                        <p class="text-xs mt-1">{{ $progress['match_milestones']['progress'] }}% to {{ $progress['match_milestones']['next'] }} matches</p>
                    </div>
                @else
                    <p class="text-sm mt-2">🏆 Veteran Player!</p>
                @endif
            </div>
            
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg p-4 text-white">
                <p class="text-sm opacity-90">Player Rating</p>
                <p class="text-2xl font-bold">{{ $progress['rating_milestones']['current'] }}/10</p>
                <div class="mt-2">
                    <div class="w-full bg-white/30 rounded-full h-2">
                        <div class="bg-white h-2 rounded-full" style="width: {{ $progress['rating_milestones']['progress'] }}%"></div>
                    </div>
                    <p class="text-xs mt-1">{{ $progress['rating_milestones']['progress'] }}% to {{ $progress['rating_milestones']['next'] }}/10</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Earned Achievements -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            <i class="fas fa-trophy text-yellow-600 mr-2"></i>Earned Achievements
            <span class="text-sm text-gray-500 ml-2">({{ $earnedAchievements->count() }} earned)</span>
        </h2>
        
        @if($earnedAchievements->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($earnedAchievements as $achievement)
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg p-4 border border-yellow-300">
                <div class="flex items-start space-x-3">
                    <div class="text-4xl">{{ $achievement->icon }}</div>
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-gray-800">{{ $achievement->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $achievement->description }}</p>
                        <p class="text-xs text-yellow-600 mt-1">Earned: {{ $achievement->pivot->earned_date->format('F j, Y') }}</p>
                    </div>
                    <div class="text-2xl">🏆</div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-medal text-4xl mb-2 opacity-50"></i>
            <p>No achievements earned yet.</p>
            <p class="text-sm">Keep playing to unlock achievements!</p>
        </div>
        @endif
    </div>

    <!-- Available Achievements -->
    @if($availableAchievements->count() > 0)
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            <i class="fas fa-lock text-gray-600 mr-2"></i>Locked Achievements
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($availableAchievements as $achievement)
            <div class="bg-gray-100 rounded-lg p-4 opacity-75">
                <div class="flex items-start space-x-3">
                    <div class="text-4xl grayscale">{{ $achievement->icon }}</div>
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-gray-600">{{ $achievement->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $achievement->description }}</p>
                        <p class="text-xs text-gray-400 mt-1">+{{ $achievement->points }} points</p>
                    </div>
                    <div class="text-2xl">🔒</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection