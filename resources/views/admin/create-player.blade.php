@extends('layouts.admin-app')
@section('title', 'Add Player')
@section('content')
<div class="p-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-2xl mx-auto">
        <div class="px-4 py-3 bg-gradient-to-r from-green-600 to-teal-600">
            <h2 class="text-lg font-bold text-white">Add New Player</h2>
        </div>
        
        <form action="{{ route('admin.players.store') }}" method="POST" enctype="multipart/form-data" class="p-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Full Name *</label>
                    <input type="text" name="name" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Email *</label>
                    <input type="email" name="email" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Player Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full border rounded-lg p-2 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Position *</label>
                    <select name="position" class="w-full border rounded-lg p-2 text-sm" required>
                        <option value="Goalkeeper">Goalkeeper</option>
                        <option value="Defender">Defender</option>
                        <option value="Midfielder">Midfielder</option>
                        <option value="Forward">Forward</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Jersey Number *</label>
                    <input type="number" name="jersey_number" class="w-full border rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Team</label>
                    <select name="team_id" class="w-full border rounded-lg p-2 text-sm">
                        <option value="">Select Team</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end space-x-2 mt-4">
                <a href="{{ route('admin.players') }}" class="bg-gray-400 text-white px-3 py-1.5 rounded-lg text-sm">Cancel</a>
                <button type="submit" class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-sm">Add Player</button>
            </div>
        </form>
    </div>
</div>
@endsection

