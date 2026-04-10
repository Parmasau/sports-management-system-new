@extends('layouts.admin-app')
@section('title', 'My Profile')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <div class="text-center">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=667eea&color=fff&size=128" class="w-32 h-32 rounded-full mx-auto mb-4">
            <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
            <p class="text-gray-600">{{ $user->email }}</p>
            <p class="text-purple-600 font-semibold mt-2">{{ ucfirst($user->role) }}</p>
        </div>
        <div class="mt-6 border-t pt-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500 text-sm">Member Since</p>
                    <p class="font-semibold">{{ $user->created_at->format('F j, Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Last Updated</p>
                    <p class="font-semibold">{{ $user->updated_at->format('F j, Y') }}</p>
                </div>
            </div>
        </div>
        <div class="mt-6 text-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
