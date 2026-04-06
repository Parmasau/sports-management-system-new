@extends('layouts.player-app')
@section('title', 'My Profile')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <div class="flex items-center space-x-6 mb-8">
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=667eea&color=fff&size=100&rounded=true" class="w-24 h-24 rounded-full">
            <div>
                <h2 class="text-2xl font-bold">{{ Auth::user()->name }}</h2>
                <p class="text-gray-500">Player · Forward · #10</p>
                <p class="text-gray-400 text-sm">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-lg transition">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
