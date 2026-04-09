@extends('layouts.coach-app')
@section('title', 'Edit Training')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Training Session</h2>
        
        <form action="{{ route('coach.training.update', $training->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Day *</label>
                <input type="text" name="day" value="{{ $training->day }}" class="w-full border rounded-lg p-2" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Time *</label>
                <input type="text" name="time" value="{{ $training->time }}" class="w-full border rounded-lg p-2" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Training Type *</label>
                <select name="type" class="w-full border rounded-lg p-2" required>
                    <option value="fitness" {{ $training->type == 'fitness' ? 'selected' : '' }}>Fitness</option>
                    <option value="tactical" {{ $training->type == 'tactical' ? 'selected' : '' }}>Tactical</option>
                    <option value="technical" {{ $training->type == 'technical' ? 'selected' : '' }}>Technical</option>
                    <option value="recovery" {{ $training->type == 'recovery' ? 'selected' : '' }}>Recovery</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Location *</label>
                <input type="text" name="location" value="{{ $training->location }}" class="w-full border rounded-lg p-2" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Status</label>
                <select name="status" class="w-full border rounded-lg p-2">
                    <option value="scheduled" {{ $training->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="completed" {{ $training->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $training->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('coach.training') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update Training</button>
            </div>
        </form>
    </div>
</div>
@endsection