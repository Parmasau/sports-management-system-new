@extends('layouts.admin-app')
@section('title', 'Reports')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">System Reports</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-blue-100 text-sm">Total Users</p>
                        <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                    </div>
                    <i class="fas fa-users text-4xl opacity-50"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-green-100 text-sm">Total Players</p>
                        <p class="text-3xl font-bold">{{ $totalPlayers }}</p>
                    </div>
                    <i class="fas fa-futbol text-4xl opacity-50"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-yellow-100 text-sm">Total Goals</p>
                        <p class="text-3xl font-bold">{{ $totalGoals }}</p>
                    </div>
                    <i class="fas fa-bullseye text-4xl opacity-50"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-purple-100 text-sm">Training Sessions</p>
                        <p class="text-3xl font-bold">{{ $totalTrainings }}</p>
                    </div>
                    <i class="fas fa-calendar-alt text-4xl opacity-50"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-red-100 text-sm">Total Teams</p>
                        <p class="text-3xl font-bold">{{ $totalTeams }}</p>
                    </div>
                    <i class="fas fa-building text-4xl opacity-50"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-indigo-100 text-sm">Total Matches</p>
                        <p class="text-3xl font-bold">{{ $totalMatches }}</p>
                    </div>
                    <i class="fas fa-trophy text-4xl opacity-50"></i>
                </div>
            </div>
        </div>
        
        <div class="mt-6 pt-6 border-t">
            <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-print mr-2"></i>Print Report
            </button>
        </div>
    </div>
</div>
@endsection