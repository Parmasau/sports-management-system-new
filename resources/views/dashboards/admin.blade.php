@extends('layouts.admin-app')
@section('title', 'Admin Dashboard')
@section('content')
<div class="p-8">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-6 shadow-lg">
            <div class="text-3xl mb-2">👥</div>
            <div class="text-2xl font-bold">{{ $totalUsers }}</div>
            <div class="text-blue-100">Total Users</div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg p-6 shadow-lg">
            <div class="text-3xl mb-2">🏋️</div>
            <div class="text-2xl font-bold">{{ $totalCoaches }}</div>
            <div class="text-purple-100">Coaches</div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-6 shadow-lg">
            <div class="text-3xl mb-2">⚽</div>
            <div class="text-2xl font-bold">{{ $totalPlayers }}</div>
            <div class="text-green-100">Players</div>
        </div>
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg p-6 shadow-lg">
            <div class="text-3xl mb-2">🏟️</div>
            <div class="text-2xl font-bold">{{ $totalTeams }}</div>
            <div class="text-orange-100">Teams</div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <h2 class="text-xl font-bold mb-4">👥 Recent Users</h2>
            <table class="w-full text-sm">
                <thead class="bg-gray-50"><tr>
                    <th class="text-left p-2 font-semibold text-gray-600">Name</th>
                    <th class="text-left p-2 font-semibold text-gray-600">Role</th>
                    <th class="text-left p-2 font-semibold text-gray-600">Joined</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentUsers as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 font-medium">{{ $user->name }}</td>
                        <td class="p-2">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $user->role === 'coach' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $user->role === 'player' ? 'bg-green-100 text-green-700' : '' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="p-2 text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('admin.users') }}" class="mt-4 w-full bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded inline-block text-center text-sm">Manage All Users</a>
        </div>

        <!-- Upcoming Matches -->
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <h2 class="text-xl font-bold mb-4">📅 Upcoming Matches</h2>
            @forelse($upcomingMatches as $match)
            <div class="bg-gray-50 rounded-lg px-4 py-3 mb-2">
                <div class="font-semibold">{{ $match->home_team }} vs {{ $match->away_team }}</div>
                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y - g:i A') }}
                    @if($match->venue) · {{ $match->venue }} @endif
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-4">No upcoming matches scheduled.</p>
            @endforelse
            <a href="{{ route('admin.matches') }}" class="mt-4 w-full bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded inline-block text-center text-sm">Manage Matches</a>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <h2 class="text-xl font-bold mb-4">⚡ Quick Actions</h2>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.users') }}" class="flex items-center space-x-2 bg-purple-50 hover:bg-purple-100 text-purple-700 px-4 py-3 rounded-lg transition">
                    <i class="fas fa-users"></i><span class="text-sm font-medium">Users</span>
                </a>
                <a href="{{ route('admin.teams') }}" class="flex items-center space-x-2 bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-3 rounded-lg transition">
                    <i class="fas fa-shield-alt"></i><span class="text-sm font-medium">Teams</span>
                </a>
                <a href="{{ route('admin.health') }}" class="flex items-center space-x-2 bg-red-50 hover:bg-red-100 text-red-700 px-4 py-3 rounded-lg transition">
                    <i class="fas fa-heartbeat"></i><span class="text-sm font-medium">Health</span>
                </a>
                <a href="{{ route('admin.lineups') }}" class="flex items-center space-x-2 bg-green-50 hover:bg-green-100 text-green-700 px-4 py-3 rounded-lg transition">
                    <i class="fas fa-list-ol"></i><span class="text-sm font-medium">Lineups</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="flex items-center space-x-2 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 px-4 py-3 rounded-lg transition">
                    <i class="fas fa-chart-bar"></i><span class="text-sm font-medium">Reports</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="flex items-center space-x-2 bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-3 rounded-lg transition">
                    <i class="fas fa-cog"></i><span class="text-sm font-medium">Settings</span>
                </a>
            </div>
        </div>

        <!-- Teams Overview -->
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <h2 class="text-xl font-bold mb-4">🏟️ Teams Overview</h2>
            @php $teams = \App\Models\Team::latest()->take(4)->get(); @endphp
            @forelse($teams as $team)
            <div class="flex justify-between items-center bg-gray-50 rounded-lg px-4 py-3 mb-2">
                <span class="font-medium">{{ $team->name }}</span>
                <span class="text-sm text-gray-500">W:{{ $team->wins }} L:{{ $team->losses }} D:{{ $team->draws }}</span>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-4">No teams yet.</p>
            @endforelse
            <a href="{{ route('admin.teams') }}" class="mt-4 w-full bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded inline-block text-center text-sm">Manage Teams</a>
        </div>
    </div>
</div>
@endsection
