@extends('layouts.coach-app')
@section('title', 'Schedule Training')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Schedule New Training Session</h2>
        
        <form action="{{ route('coach.training.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Day *</label>
                <input type="text" name="day" class="w-full border rounded-lg p-2" placeholder="e.g., Monday, April 15, 2024" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Time *</label>
                <input type="text" name="time" class="w-full border rounded-lg p-2" placeholder="e.g., 8:00 AM - 10:00 AM" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Training Type *</label>
                <select name="type" class="w-full border rounded-lg p-2" required>
                    <option value="fitness">Fitness</option>
                    <option value="tactical">Tactical</option>
                    <option value="technical">Technical</option>
                    <option value="recovery">Recovery</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Location *</label>
                <input type="text" name="location" class="w-full border rounded-lg p-2" placeholder="e.g., Main Training Ground" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Status</label>
                <select name="status" class="w-full border rounded-lg p-2">
                    <option value="scheduled">Scheduled</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('coach.training') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Schedule Training</button>
            </div>
        </form>
    </div>
</div>
@endsection