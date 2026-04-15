@extends('layouts.coach-app')
@section('title', 'Create Achievement')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Achievement</h2>
        
        <form action="{{ route('coach.achievements.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-1">Title *</label>
                    <input type="text" name="title" class="w-full border rounded-lg p-2" placeholder="e.g., First Goal, Hat-trick Hero" required>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-1">Description *</label>
                    <textarea name="description" rows="3" class="w-full border rounded-lg p-2" placeholder="Describe what the player needs to do to earn this achievement" required></textarea>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Icon (Emoji) *</label>
                    <input type="text" name="icon" class="w-full border rounded-lg p-2" placeholder="e.g., ⚽, 🏆, 🎯" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Type *</label>
                    <select name="type" class="w-full border rounded-lg p-2" required>
                        <option value="individual">Individual</option>
                        <option value="team">Team</option>
                        <option value="season">Season</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Points *</label>
                    <input type="number" name="points" class="w-full border rounded-lg p-2" placeholder="0" required>
                </div>
                
                <div>
    <label class="block text-gray-700 font-semibold mb-1">Badge Color</label>
    <select name="badge_color" class="w-full border rounded-lg p-2">
        <option value="gold">Gold</option>
        <option value="silver">Silver</option>
        <option value="bronze">Bronze</option>
        <option value="blue">Blue</option>
        <option value="green">Green</option>
        <option value="purple">Purple</option>
    </select>
</div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('coach.achievements') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Create Achievement</button>
            </div>
        </form>
    </div>
</div>
@endsection

