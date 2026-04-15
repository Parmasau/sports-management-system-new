@extends('layouts.coach-app')
@section('title', 'Edit Achievement')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Achievement</h2>
        
        <form action="{{ route('coach.achievements.update', $achievement->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-1">Title *</label>
                    <input type="text" name="title" value="{{ $achievement->title }}" class="w-full border rounded-lg p-2" required>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-1">Description *</label>
                    <textarea name="description" rows="3" class="w-full border rounded-lg p-2" required>{{ $achievement->description }}</textarea>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Icon (Emoji) *</label>
                    <input type="text" name="icon" value="{{ $achievement->icon }}" class="w-full border rounded-lg p-2" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Type *</label>
                    <select name="type" class="w-full border rounded-lg p-2" required>
                        <option value="individual" {{ $achievement->type == 'individual' ? 'selected' : '' }}>Individual</option>
                        <option value="team" {{ $achievement->type == 'team' ? 'selected' : '' }}>Team</option>
                        <option value="season" {{ $achievement->type == 'season' ? 'selected' : '' }}>Season</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Points *</label>
                    <input type="number" name="points" value="{{ $achievement->points }}" class="w-full border rounded-lg p-2" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Badge Color</label>
                    <select name="badge_color" class="w-full border rounded-lg p-2">
                        <option value="gold" {{ $achievement->badge_color == 'gold' ? 'selected' : '' }}>Gold</option>
                        <option value="silver" {{ $achievement->badge_color == 'silver' ? 'selected' : '' }}>Silver</option>
                        <option value="bronze" {{ $achievement->badge_color == 'bronze' ? 'selected' : '' }}>Bronze</option>
                        <option value="blue" {{ $achievement->badge_color == 'blue' ? 'selected' : '' }}>Blue</option>
                        <option value="green" {{ $achievement->badge_color == 'green' ? 'selected' : '' }}>Green</option>
                        <option value="purple" {{ $achievement->badge_color == 'purple' ? 'selected' : '' }}>Purple</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('coach.achievements') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update Achievement</button>
            </div>
        </form>
    </div>
</div>
@endsection