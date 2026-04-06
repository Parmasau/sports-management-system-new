@extends('layouts.admin-app')
@section('title', 'Admin Dashboard')
@section('content')
<div class="p-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white"><div><p class="text-purple-100">Total Users</p><p class="text-3xl font-bold">{{ $totalUsers }}</p></div></div>
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white"><div><p class="text-blue-100">Admins</p><p class="text-3xl font-bold">{{ $totalAdmins }}</p></div></div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white"><div><p class="text-green-100">Coaches</p><p class="text-3xl font-bold">{{ $totalCoaches }}</p></div></div>
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white"><div><p class="text-yellow-100">Players</p><p class="text-3xl font-bold">{{ $totalPlayers }}</p></div></div>
    </div>
    <div class="bg-white rounded-lg shadow-lg p-6"><h2 class="text-xl font-bold mb-4">Recent Users</h2>
        <table class="w-full"> <thead class="bg-gray-100"> <tr> <th class="p-2 text-left">Name</th> <th class="p-2 text-left">Email</th> <th class="p-2 text-left">Role</th> </tr> </thead> <tbody>
            @foreach($recentUsers as $user)
            <tr class="border-b"> <td class="p-2">{{ $user->name }}</td> <td class="p-2">{{ $user->email }}</td> <td class="p-2">{{ ucfirst($user->role) }}</td> </tr>
            @endforeach
        </tbody> </table>
    </div>
</div>
@endsection
