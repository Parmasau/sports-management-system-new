@extends('layouts.coach-app')
@section('title', 'Create Tactic')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Tactic</h2>
        
        <form action="{{ route('coach.tactics.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Formation *</label>
                <input type="text" name="formation" class="w-full border rounded-lg p-2" placeholder="e.g., 4-3-3, 4-4-2, 3-5-2" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Pressing Style *</label>
                <select name="pressing_style" class="w-full border rounded-lg p-2" required>
                    <option value="">Select Pressing Style</option>
                    <option value="High Press">High Press</option>
                    <option value="Medium Press">Medium Press</option>
                    <option value="Low Press">Low Press</option>
                    <option value="Counter Press">Counter Press</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Attacking Focus *</label>
                <select name="attacking_focus" class="w-full border rounded-lg p-2" required>
                    <option value="">Select Attacking Focus</option>
                    <option value="Wide Attack">Wide Attack</option>
                    <option value="Central Attack">Central Attack</option>
                    <option value="Counter Attack">Counter Attack</option>
                    <option value="Possession">Possession</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Set Pieces</label>
                <textarea name="set_pieces" rows="3" class="w-full border rounded-lg p-2" placeholder="Corner kicks, free kicks strategies..."></textarea>
            </div>
            
            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="mr-2">
                    <span class="text-gray-700 font-semibold">Active Tactic</span>
                </label>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('coach.tactics') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Create Tactic</button>
            </div>
        </form>
    </div>
</div>
@endsection