@extends('layouts.coach-app')
@section('title', 'Coach Dashboard')
@section('content')
<div class="p-4">
    <!-- Stats Cards with Background Images -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Players Card -->
        <div class="relative rounded-xl shadow-lg p-6 text-white overflow-hidden transform transition hover:scale-105 group"
             style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-blue-100 text-sm">Total Players</p>
                        <p class="text-4xl font-bold mt-2">{{ $totalPlayers }}</p>
                    </div>
                    <i class="fas fa-users text-6xl opacity-30"></i>
                </div>
            </div>
        </div>
        
        <!-- Active Players Card -->
        <div class="relative rounded-xl shadow-lg p-6 text-white overflow-hidden transform transition hover:scale-105"
             style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
            <div class="absolute inset-0 bg-black/20 hover:bg-black/30 transition"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-green-100 text-sm">Active Players</p>
                        <p class="text-4xl font-bold mt-2">{{ $activePlayers }}</p>
                    </div>
                    <i class="fas fa-user-check text-6xl opacity-30"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Goals Card -->
        <div class="relative rounded-xl shadow-lg p-6 text-white overflow-hidden transform transition hover:scale-105"
             style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="absolute inset-0 bg-black/20 hover:bg-black/30 transition"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-yellow-100 text-sm">Total Goals</p>
                        <p class="text-4xl font-bold mt-2">{{ $totalGoals }}</p>
                    </div>
                    <i class="fas fa-futbol text-6xl opacity-30"></i>
                </div>
            </div>
        </div>
        
        <!-- Active Tactics Card -->
        <div class="relative rounded-xl shadow-lg p-6 text-white overflow-hidden transform transition hover:scale-105"
             style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="absolute inset-0 bg-black/20 hover:bg-black/30 transition"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-purple-100 text-sm">Active Tactics</p>
                        <p class="text-4xl font-bold mt-2">{{ $activeTactics }}</p>
                    </div>
                    <i class="fas fa-chalkboard-user text-6xl opacity-30"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Players Card -->
        <div class="relative rounded-xl shadow-xl overflow-hidden group"
             style="background: url('https://images.unsplash.com/photo-1543326727-cf6c39e8f84c?q=80&w=2070&auto=format&fit=crop') center/cover;">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/90 to-purple-900/90"></div>
            <div class="relative z-10 p-6">
                <h2 class="text-xl font-bold mb-4 text-white">
                    <i class="fas fa-users text-yellow-400 mr-2"></i> Recent Players
                </h2>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($recentPlayers as $player)
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 hover:bg-white/20 transition">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                @if($player->image)
                                    <img src="{{ asset('storage/' . $player->image) }}" class="w-10 h-10 rounded-full object-cover border-2 border-yellow-400">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=667eea&color=fff&rounded=true&size=100" class="w-10 h-10 rounded-full border-2 border-yellow-400">
                                @endif
                                <div>
                                    <span class="font-semibold text-white">{{ $player->name }}</span>
                                    <p class="text-xs text-gray-300">{{ $player->position }} | #{{ $player->jersey_number }}</p>
                                </div>
                            </div>
                            <a href="{{ route('coach.players.edit', $player->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-yellow-600 transition">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-white">
                        <i class="fas fa-user-slash text-4xl mb-2 opacity-70"></i>
                        <p>No players yet.</p>
                        <a href="{{ route('coach.players.create') }}" class="text-yellow-400 hover:underline">Add your first player</a>
                    </div>
                    @endforelse
                </div>
                <a href="{{ route('coach.players') }}" class="inline-block w-full mt-4 bg-yellow-500 text-white py-2 rounded-lg text-center hover:bg-yellow-600 transition">
                    <i class="fas fa-eye mr-2"></i>Manage All Players
                </a>
            </div>
        </div>

        <!-- Upcoming Training Card -->
        <div class="relative rounded-xl shadow-xl overflow-hidden group"
             style="background: url('https://images.unsplash.com/photo-1522778119026-d364fcefaca0?q=80&w=2070&auto=format&fit=crop') center/cover;">
            <div class="absolute inset-0 bg-gradient-to-br from-green-900/90 to-blue-900/90"></div>
            <div class="relative z-10 p-6">
                <h2 class="text-xl font-bold mb-4 text-white">
                    <i class="fas fa-calendar-alt text-yellow-400 mr-2"></i> Upcoming Training
                </h2>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($upcomingTrainings as $training)
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 hover:bg-white/20 transition">
                        <p class="font-semibold text-white">{{ ucfirst($training->type) }} Training</p>
                        <p class="text-sm text-gray-300">{{ $training->day }} | {{ $training->time }}</p>
                        <p class="text-xs text-gray-400"><i class="fas fa-location-dot mr-1"></i>{{ $training->location }}</p>
                    </div>
                    @empty
                    <div class="text-center py-8 text-white">
                        <i class="fas fa-calendar-times text-4xl mb-2 opacity-70"></i>
                        <p>No upcoming training.</p>
                        <a href="{{ route('coach.training.create') }}" class="text-yellow-400 hover:underline">Schedule one</a>
                    </div>
                    @endforelse
                </div>
                <a href="{{ route('coach.training') }}" class="inline-block w-full mt-4 bg-yellow-500 text-white py-2 rounded-lg text-center hover:bg-yellow-600 transition">
                    <i class="fas fa-eye mr-2"></i>View All Training
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Row Cards -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Team Performance Card -->
        <div class="relative rounded-xl shadow-xl overflow-hidden group"
             style="background: url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=2070&auto=format&fit=crop') center/cover;">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-900/90 to-red-900/90"></div>
            <div class="relative z-10 p-6">
                <h3 class="font-bold text-white mb-4"><i class="fas fa-chart-line text-yellow-400 mr-2"></i>Team Performance</h3>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-sm text-white mb-1">
                            <span>Win Rate</span>
                            <span class="font-semibold">53%</span>
                        </div>
                        <div class="w-full bg-white/30 rounded-full h-2">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width:53%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm text-white mb-1">
                            <span>Team Morale</span>
                            <span class="font-semibold">85%</span>
                        </div>
                        <div class="w-full bg-white/30 rounded-full h-2">
                            <div class="bg-green-400 h-2 rounded-full" style="width:85%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm text-white mb-1">
                            <span>Training Attendance</span>
                            <span class="font-semibold">78%</span>
                        </div>
                        <div class="w-full bg-white/30 rounded-full h-2">
                            <div class="bg-blue-400 h-2 rounded-full" style="width:78%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Top Scorer Card -->
        <div class="relative rounded-xl shadow-xl overflow-hidden group"
             style="background: url('https://images.unsplash.com/photo-1489944440615-453fc2b6a9a9?q=80&w=2070&auto=format&fit=crop') center/cover;">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-900/90 to-pink-900/90"></div>
            <div class="relative z-10 p-6">
                <h3 class="font-bold text-white mb-4"><i class="fas fa-trophy text-yellow-400 mr-2"></i>Top Scorer</h3>
                @if($topScorer)
                    <div class="flex items-center space-x-3">
                        @if($topScorer->image)
                            <img src="{{ asset('storage/' . $topScorer->image) }}" class="w-14 h-14 rounded-full object-cover border-2 border-yellow-400">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($topScorer->name) }}&background=667eea&color=fff&rounded=true&size=100" class="w-14 h-14 rounded-full border-2 border-yellow-400">
                        @endif
                        <div>
                            <p class="font-bold text-white text-lg">{{ $topScorer->name }}</p>
                            <p class="text-sm text-yellow-400">{{ $topScorer->goals }} goals in {{ $topScorer->matches ?? 0 }} matches</p>
                        </div>
                    </div>
                @else
                    <p class="text-gray-300 text-center py-4">No data available</p>
                @endif
            </div>
        </div>
        
        <!-- Quick Actions Card -->
        <div class="relative rounded-xl shadow-xl overflow-hidden group"
             style="background: url('https://images.unsplash.com/photo-1526232761682-d26e07ac358d?q=80&w=2070&auto=format&fit=crop') center/cover;">
            <div class="absolute inset-0 bg-gradient-to-br from-teal-900/90 to-cyan-900/90"></div>
            <div class="relative z-10 p-6">
                <h3 class="font-bold text-white mb-4"><i class="fas fa-clock text-yellow-400 mr-2"></i>Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('coach.players.create') }}" class="flex items-center space-x-3 text-white hover:bg-white/20 transition p-3 rounded-lg">
                        <i class="fas fa-user-plus w-5 text-yellow-400"></i>
                        <span>Add New Player</span>
                    </a>
                    <a href="{{ route('coach.training.create') }}" class="flex items-center space-x-3 text-white hover:bg-white/20 transition p-3 rounded-lg">
                        <i class="fas fa-calendar-plus w-5 text-yellow-400"></i>
                        <span>Schedule Training</span>
                    </a>
                    <a href="{{ route('coach.tactics.create') }}" class="flex items-center space-x-3 text-white hover:bg-white/20 transition p-3 rounded-lg">
                        <i class="fas fa-chalkboard w-5 text-yellow-400"></i>
                        <span>Create New Tactic</span>
                    </a>
                    <a href="{{ route('coach.stats') }}" class="flex items-center space-x-3 text-white hover:bg-white/20 transition p-3 rounded-lg">
                        <i class="fas fa-chart-line w-5 text-yellow-400"></i>
                        <span>View Player Stats</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection