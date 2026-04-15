@extends('layouts.coach-app')
@section('title', 'Health Overview')
@section('content')
<div class="p-6">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-6 rounded shadow-md">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Header Section -->
    <div class="relative rounded-xl shadow-xl overflow-hidden mb-6">
        <div class="absolute inset-0 bg-gradient-to-r from-green-900 to-teal-900"></div>
        <div class="relative z-10 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Health & Fitness Overview</h2>
            <p class="text-green-200 text-sm mt-1">Monitor player health status and fitness levels</p>
        </div>
    </div>

    <!-- Stats Cards - Small Boxes -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-700"></div>
            <div class="relative z-10 p-3 flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs uppercase tracking-wide">Total Players</p>
                    <p class="text-2xl font-bold text-white">{{ $totalPlayers }}</p>
                </div>
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-white text-sm"></i>
                </div>
            </div>
        </div>
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-red-700"></div>
            <div class="relative z-10 p-3 flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-xs uppercase tracking-wide">Injured</p>
                    <p class="text-2xl font-bold text-white">{{ $injuredPlayers }}</p>
                </div>
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-ambulance text-white text-sm"></i>
                </div>
            </div>
        </div>
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-700"></div>
            <div class="relative z-10 p-3 flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-xs uppercase tracking-wide">Avg Fitness</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($avgFitness, 1) }}</p>
                </div>
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-heartbeat text-white text-sm"></i>
                </div>
            </div>
        </div>
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-yellow-600 to-yellow-700"></div>
            <div class="relative z-10 p-3 flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-xs uppercase tracking-wide">Healthy</p>
                    <p class="text-2xl font-bold text-white">{{ $totalPlayers - $injuredPlayers }}</p>
                </div>
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-smile text-white text-sm"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Players Health Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-green-600 to-teal-600">
            <h2 class="text-xl font-bold text-white">
                <i class="fas fa-notes-medical mr-2"></i>Players Health Status
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left text-xs font-semibold text-gray-600 uppercase">Player</th>
                        <th class="p-3 text-left text-xs font-semibold text-gray-600 uppercase">Position</th>
                        <th class="p-3 text-center text-xs font-semibold text-gray-600 uppercase">Weight</th>
                        <th class="p-3 text-center text-xs font-semibold text-gray-600 uppercase">BMI</th>
                        <th class="p-3 text-center text-xs font-semibold text-gray-600 uppercase">Heart Rate</th>
                        <th class="p-3 text-center text-xs font-semibold text-gray-600 uppercase">Injury</th>
                        <th class="p-3 text-center text-xs font-semibold text-gray-600 uppercase">Fitness</th>
                        <th class="p-3 text-center text-xs font-semibold text-gray-600 uppercase">Last Check</th>
                        <th class="p-3 text-center text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($players as $player)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-3">
                            <div class="flex items-center space-x-3">
                                @if($player->image)
                                    <img src="{{ asset('storage/' . $player->image) }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=3b82f6&color=fff&rounded=true&size=100" class="w-8 h-8 rounded-full">
                                @endif
                                <div>
                                    <p class="font-medium text-gray-800">{{ $player->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $player->position }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-3 text-sm text-gray-600">{{ $player->position }}</td>
                        <td class="p-3 text-center text-sm text-gray-600">{{ $player->latestHealthRecord->weight ?? '-' }} kg</td>
                        <td class="p-3 text-center text-sm text-gray-600">{{ $player->latestHealthRecord->bmi ?? '-' }}</td>
                        <td class="p-3 text-center text-sm text-gray-600">{{ $player->latestHealthRecord->heart_rate ?? '-' }} bpm</td>
                        <td class="p-3 text-center">
                            @php
                                $injuryStatus = $player->latestHealthRecord->injury_status ?? 'none';
                                $badgeClass = match($injuryStatus) {
                                    'none' => 'bg-green-100 text-green-700',
                                    'minor' => 'bg-yellow-100 text-yellow-700',
                                    'moderate' => 'bg-orange-100 text-orange-700',
                                    'severe' => 'bg-red-100 text-red-700',
                                    'recovering' => 'bg-blue-100 text-blue-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <span class="px-2 py-0.5 rounded text-xs {{ $badgeClass }}">{{ ucfirst($injuryStatus) }}</span>
                        </td>
                        <td class="p-3 text-center">
                            @php
                                $fitness = $player->latestHealthRecord->fitness_level ?? 'average';
                                $fitnessClass = match($fitness) {
                                    'excellent' => 'bg-green-100 text-green-700',
                                    'good' => 'bg-blue-100 text-blue-700',
                                    'average' => 'bg-yellow-100 text-yellow-700',
                                    'poor' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <span class="px-2 py-0.5 rounded text-xs {{ $fitnessClass }}">{{ ucfirst($fitness) }}</span>
                        </td>
                        <td class="p-3 text-center text-xs text-gray-500">{{ $player->latestHealthRecord ? $player->latestHealthRecord->record_date->format('Y-m-d') : '-' }}</td>
                        <td class="p-3 text-center">
                            <a href="{{ route('coach.players.health', $player->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs transition inline-flex items-center">
                                <i class="fas fa-notes-medical mr-1 text-xs"></i>View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection