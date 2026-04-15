@extends('layouts.coach-app')
@section('title', 'Manage Achievements')
@section('content')
<div class="p-4">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 mb-4 rounded shadow-md text-sm">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Header Section - Compact -->
    <div class="relative rounded-xl shadow-lg overflow-hidden mb-4">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-900 to-pink-900"></div>
        <div class="relative z-10 px-4 py-3 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-white">Achievements Library</h2>
                <p class="text-purple-200 text-xs">Manage and assign achievements to players</p>
            </div>
            <a href="{{ route('coach.achievements.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg transition text-sm shadow-md">
                <i class="fas fa-plus mr-1"></i>Create
            </a>
        </div>
    </div>

    <!-- Stats Cards - Small Boxes -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-4">
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-purple-700"></div>
            <div class="relative z-10 p-2 flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-xs">Total</p>
                    <p class="text-xl font-bold text-white">{{ $achievements->count() }}</p>
                </div>
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-trophy text-white text-xs"></i>
                </div>
            </div>
        </div>
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-700"></div>
            <div class="relative z-10 p-2 flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-xs">Individual</p>
                    <p class="text-xl font-bold text-white">{{ $achievements->where('type', 'individual')->count() }}</p>
                </div>
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white text-xs"></i>
                </div>
            </div>
        </div>
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-700"></div>
            <div class="relative z-10 p-2 flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs">Team</p>
                    <p class="text-xl font-bold text-white">{{ $achievements->where('type', 'team')->count() }}</p>
                </div>
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-white text-xs"></i>
                </div>
            </div>
        </div>
        <div class="relative rounded-lg shadow-md overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-yellow-600 to-yellow-700"></div>
            <div class="relative z-10 p-2 flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-xs">Points</p>
                    <p class="text-xl font-bold text-white">{{ $achievements->sum('points') }}</p>
                </div>
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-white text-xs"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Achievements Grid - Compact -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600">
            <h2 class="text-base font-bold text-white">
                <i class="fas fa-medal mr-2"></i>Achievements Collection
            </h2>
        </div>
        
        <div class="p-3">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2">
                @foreach($achievements as $achievement)
                <div class="group relative bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                    <!-- Badge Color Strip -->
                    <div class="h-0.5 w-full 
                        @if($achievement->badge_color == 'gold') bg-gradient-to-r from-yellow-400 to-yellow-600
                        @elseif($achievement->badge_color == 'silver') bg-gradient-to-r from-gray-300 to-gray-500
                        @elseif($achievement->badge_color == 'bronze') bg-gradient-to-r from-orange-400 to-orange-600
                        @elseif($achievement->badge_color == 'blue') bg-gradient-to-r from-blue-400 to-blue-600
                        @elseif($achievement->badge_color == 'green') bg-gradient-to-r from-green-400 to-green-600
                        @else bg-gradient-to-r from-purple-400 to-purple-600 @endif">
                    </div>
                    
                    <div class="p-2">
                        <div class="flex justify-between items-start mb-1">
                            <div class="text-xl">{{ $achievement->icon }}</div>
                            <span class="px-1.5 py-0.5 rounded text-xs font-semibold
                                @if($achievement->type == 'individual') bg-blue-100 text-blue-700
                                @elseif($achievement->type == 'team') bg-green-100 text-green-700
                                @else bg-purple-100 text-purple-700 @endif">
                                {{ ucfirst(substr($achievement->type, 0, 1)) }}
                            </span>
                        </div>
                        
                        <h3 class="text-xs font-bold text-gray-800 mb-0.5 line-clamp-1">{{ Str::limit($achievement->title, 20) }}</h3>
                        <p class="text-xs text-gray-500 mb-2 line-clamp-1">{{ Str::limit($achievement->description, 30) }}</p>
                        
                        <div class="flex justify-between items-center pt-1 border-t border-gray-200">
                            <div class="flex items-center space-x-0.5">
                                <i class="fas fa-star text-yellow-500 text-xs"></i>
                                <span class="font-bold text-xs text-gray-700">{{ $achievement->points }}</span>
                            </div>
                            <div class="flex space-x-1">
                                <a href="{{ route('coach.achievements.edit', $achievement->id) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-1.5 py-0.5 rounded text-xs transition">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('coach.achievements.destroy', $achievement->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this achievement?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-1.5 py-0.5 rounded text-xs transition">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Footer Stats -->
        <div class="px-4 py-2 bg-gray-50 border-t border-gray-200">
            <div class="grid grid-cols-4 gap-2">
                <div class="text-center">
                    <p class="text-base font-bold text-purple-600">{{ $achievements->count() }}</p>
                    <p class="text-xs text-gray-500">Total</p>
                </div>
                <div class="text-center">
                    <p class="text-base font-bold text-blue-600">{{ $achievements->where('type', 'individual')->count() }}</p>
                    <p class="text-xs text-gray-500">Individual</p>
                </div>
                <div class="text-center">
                    <p class="text-base font-bold text-green-600">{{ $achievements->where('type', 'team')->count() }}</p>
                    <p class="text-xs text-gray-500">Team</p>
                </div>
                <div class="text-center">
                    <p class="text-base font-bold text-yellow-600">{{ $achievements->sum('points') }}</p>
                    <p class="text-xs text-gray-500">Points</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection