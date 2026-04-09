@extends('layouts.admin-app')
@section('title', 'Admin Dashboard')
@section('content')
<div class="p-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-purple-100">Total Users</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalUsers }}</p>
                </div>
                <i class="fas fa-users text-5xl opacity-50"></i>
            </div>
        </div>
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-blue-100">Total Teams</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalTeams }}</p>
                </div>
                <i class="fas fa-building text-5xl opacity-50"></i>
            </div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-green-100">Training Sessions</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalTrainings }}</p>
                </div>
                <i class="fas fa-calendar-alt text-5xl opacity-50"></i>
            </div>
        </div>
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-yellow-100">Total Goals</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalGoals }}</p>
                </div>
                <i class="fas fa-futbol text-5xl opacity-50"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4">Recent Users</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr><th class="p-2 text-left">Name</th><th class="p-2 text-left">Email</th><th class="p-2 text-left">Role</th></tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $user)
                        <tr class="border-b">
                            <td class="p-2">{{ $user->name }}</td>
                            <td class="p-2 text-sm">{{ $user->email }}</td>
                            <td class="p-2"><span class="px-2 py-1 rounded text-xs bg-purple-200 text-purple-800">{{ ucfirst($user->role) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4">Recent Players</h2>
            <div class="space-y-3">
                @foreach($recentPlayers as $player)
                <div class="flex items-center space-x-3 border-b pb-2">
                    @if($player->image)
                        <img src="{{ asset('storage/' . $player->image) }}" class="w-8 h-8 rounded-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=667eea&color=fff&rounded=true&size=100" class="w-8 h-8 rounded-full">
                    @endif
                    <div>
                        <p class="font-semibold">{{ $player->name }}</p>
                        <p class="text-xs text-gray-500">{{ $player->position }} | #{{ $player->jersey_number }}</p>
                    </div>
                    <div class="ml-auto">
                        <span class="text-sm text-green-600">{{ $player->goals }} goals</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mt-6 bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4">System Overview</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-gray-50 rounded">
                <p class="text-2xl font-bold text-purple-600">{{ $activeTactics }}</p>
                <p class="text-sm text-gray-600">Active Tactics</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded">
                <p class="text-2xl font-bold text-blue-600">{{ $recentLogins }}</p>
                <p class="text-sm text-gray-600">Active Users (7d)</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded">
                <p class="text-2xl font-bold text-green-600">{{ $totalPlayers }}</p>
                <p class="text-sm text-gray-600">Total Players</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded">
                <p class="text-2xl font-bold text-yellow-600">{{ $totalGoals }}</p>
                <p class="text-sm text-gray-600">Total Goals</p>
            </div>
        </div>
    </div>
</div>
@endsection