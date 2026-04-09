@extends('layouts.coach-app')
@section('title', 'Edit Tactic')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Tactic</h2>
        
        <form action="{{ route('coach.tactics.update', $tactic->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Formation *</label>
                <input type="text" name="formation" value="{{ $tactic->formation }}" class="w-full border rounded-lg p-2" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Pressing Style *</label>
                <select name="pressing_style" class="w-full border rounded-lg p-2" required>
                    <option value="High Press" {{ $tactic->pressing_style == 'High Press' ? 'selected' : '' }}>High Press</option>
                    <option value="Medium Press" {{ $tactic->pressing_style == 'Medium Press' ? 'selected' : '' }}>Medium Press</option>
                    <option value="Low Press" {{ $tactic->pressing_style == 'Low Press' ? 'selected' : '' }}>Low Press</option>
                    <option value="Counter Press" {{ $tactic->pressing_style == 'Counter Press' ? 'selected' : '' }}>Counter Press</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Attacking Focus *</label>
                <select name="attacking_focus" class="w-full border rounded-lg p-2" required>
                    <option value="Wide Attack" {{ $tactic->attacking_focus == 'Wide Attack' ? 'selected' : '' }}>Wide Attack</option>
                    <option value="Central Attack" {{ $tactic->attacking_focus == 'Central Attack' ? 'selected' : '' }}>Central Attack</option>
                    <option value="Counter Attack" {{ $tactic->attacking_focus == 'Counter Attack' ? 'selected' : '' }}>Counter Attack</option>
                    <option value="Possession" {{ $tactic->attacking_focus == 'Possession' ? 'selected' : '' }}>Possession</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Set Pieces</label>
                <textarea name="set_pieces" rows="3" class="w-full border rounded-lg p-2">{{ $tactic->set_pieces }}</textarea>
            </div>
            
            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ $tactic->is_active ? 'checked' : '' }} class="mr-2">
                    <span class="text-gray-700 font-semibold">Active Tactic</span>
                </label>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('coach.tactics') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update Tactic</button>
            </div>
        </form>
    </div>
</div>
@endsection