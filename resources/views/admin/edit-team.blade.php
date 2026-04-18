@extends('layouts.admin-app')
@section('title', 'Edit Team')
@section('content')
<div class="p-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-2xl mx-auto">
        <div class="px-4 py-3 bg-gradient-to-r from-yellow-600 to-orange-600">
            <h2 class="text-lg font-bold text-white">Edit Team</h2>
        </div>
        
        <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" class="p-4">
            @csrf
            @method('PUT')
            
            <div class="space-y-3">
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Team Name</label>
                    <input type="text" name="name" value="{{ $team->name }}" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">City</label>
                    <input type="text" name="city" value="{{ $team->city }}" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Stadium</label>
                    <input type="text" name="stadium" value="{{ $team->stadium }}" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
            </div>
            
            <div class="flex justify-end space-x-2 mt-4">
                <a href="{{ route('admin.teams') }}" class="bg-gray-400 text-white px-3 py-1.5 rounded-lg text-sm">Cancel</a>
                <button type="submit" class="bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-sm">Update Team</button>
            </div>
        </form>
    </div>
</div>
@endsection

