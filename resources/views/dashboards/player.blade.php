@extends('layouts.player-app')

@section('title', 'Player Dashboard')

@section('content')
    <div class="p-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-blue-100 text-sm">Matches Played</p>
                        <p class="text-3xl font-bold mt-2">24</p>
                    </div>
                    <i class="fas fa-futbol text-5xl opacity-50"></i>
                </div>
                <div class="mt-4">
                    <span class="text-sm">↑ 12% from last season</span>
                </div>
            </div>
            <div class="stat-card bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-green-100 text-sm">Goals Scored</p>
                        <p class="text-3xl font-bold mt-2">18</p>
                    </div>
                    <i class="fas fa-bullseye text-5xl opacity-50"></i>
                </div>
                <div class="mt-4">
                    <span class="text-sm">Top Scorer of the team</span>
                </div>
            </div>
            <div class="stat-card bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-yellow-100 text-sm">Assists</p>
                        <p class="text-3xl font-bold mt-2">12</p>
                    </div>
                    <i class="fas fa-hand-peace text-5xl opacity-50"></i>
                </div>
                <div class="mt-4">
                    <span class="text-sm">Team Player award</span>
                </div>
            </div>
            <div class="stat-card bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-red-100 text-sm">Man of Match</p>
                        <p class="text-3xl font-bold mt-2">5</p>
                    </div>
                    <i class="fas fa-trophy text-5xl opacity-50"></i>
                </div>
                <div class="mt-4">
                    <span class="text-sm">3 times this season</span>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Upcoming Matches -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-calendar-alt text-purple-600 mr-2"></i> Upcoming Matches
                </h2>
                <div class="space-y-4">
                    <div class="border-l-4 border-blue-500 pl-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold">Red Dragons vs Blue Eagles</p>
                                <p class="text-sm text-gray-500">April 12, 2024 - 4:00 PM</p>
                            </div>
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Home</span>
                        </div>
                    </div>
                    <div class="border-l-4 border-green-500 pl-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold">Tigers United vs Red Dragons</p>
                                <p class="text-sm text-gray-500">April 18, 2024 - 6:30 PM</p>
                            </div>
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Away</span>
                        </div>
                    </div>
                    <div class="border-l-4 border-purple-500 pl-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold">Red Dragons vs Thunder FC</p>
                                <p class="text-sm text-gray-500">April 25, 2024 - 4:00 PM</p>
                            </div>
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Home</span>
                        </div>
                    </div>
                </div>
                <button class="btn-primary w-full mt-4 text-white py-2 rounded-lg">
                    <a href="{{ route('player.matches') }}" class="block w-full h-full text-center">View Full Schedule</a>
                </button>
            </div>

            <!-- Recent Performance -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-line text-green-600 mr-2"></i> Recent Performance
                </h2>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Last Match Rating</span>
                            <span class="font-semibold text-green-600">8.5/10</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Training Attendance</span>
                            <span class="font-semibold">90%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 90%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Fitness Level</span>
                            <span class="font-semibold">92%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: 92%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Team -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-users text-blue-600 mr-2"></i> My Team
                </h2>
                <div class="text-center py-4">
                    <i class="fas fa-shield-alt text-6xl text-red-600 mb-3"></i>
                    <h3 class="text-2xl font-bold">Red Dragons FC</h3>
                    <p class="text-gray-600">Position: Forward | Jersey: #10</p>
                    <div class="mt-4 flex justify-center space-x-4">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-800">24</p>
                            <p class="text-xs text-gray-500">Matches</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-800">18</p>
                            <p class="text-xs text-gray-500">Goals</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-800">12</p>
                            <p class="text-xs text-gray-500">Assists</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Achievements -->
            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-lg shadow-lg p-6 text-white">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <i class="fas fa-trophy mr-2"></i> Recent Achievements
                </h2>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3 bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-medal text-2xl"></i>
                        <div>
                            <p class="font-semibold">Player of the Month</p>
                            <p class="text-sm opacity-90">March 2024</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-futbol text-2xl"></i>
                        <div>
                            <p class="font-semibold">Hat-trick Achievement</p>
                            <p class="text-sm opacity-90">vs Tigers United</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="mt-6 bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-clock text-purple-600 mr-2"></i> Recent Activity
            </h2>
            <div class="space-y-3">
                <div class="flex items-center space-x-3 border-b pb-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <div class="flex-1">
                        <p class="text-sm">You completed today's training session</p>
                        <p class="text-xs text-gray-500">2 hours ago</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3 border-b pb-3">
                    <i class="fas fa-calendar-check text-blue-500"></i>
                    <div class="flex-1">
                        <p class="text-sm">Match against Blue Eagles confirmed</p>
                        <p class="text-xs text-gray-500">Yesterday</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection