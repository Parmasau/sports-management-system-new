@extends('layouts.coach-app')
@section('title', 'Add New Player')
@section('content')
<div class="p-6">
    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-2xl mx-auto">
        <div class="px-6 py-4 bg-gradient-to-r from-green-600 to-green-700">
            <h2 class="text-xl font-bold text-white">
                <i class="fas fa-user-plus mr-2"></i>Add New Player
            </h2>
            <p class="text-green-100 text-sm mt-1">Enter player details to add to squad</p>
        </div>
        
        <form action="{{ route('coach.players.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-green-500" placeholder="Enter player name" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-green-500" placeholder="player@example.com" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Player Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2">
                    <p class="text-xs text-gray-500 mt-1">Upload JPG, PNG (Max 2MB)</p>
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Position *</label>
                    <select name="position" class="w-full border border-gray-300 rounded-lg p-2" required>
                        <option value="">Select Position</option>
                        <option value="Goalkeeper" {{ old('position') == 'Goalkeeper' ? 'selected' : '' }}>Goalkeeper</option>
                        <option value="Defender" {{ old('position') == 'Defender' ? 'selected' : '' }}>Defender</option>
                        <option value="Midfielder" {{ old('position') == 'Midfielder' ? 'selected' : '' }}>Midfielder</option>
                        <option value="Forward" {{ old('position') == 'Forward' ? 'selected' : '' }}>Forward</option>
                    </select>
                    @error('position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Jersey Number *</label>
                    <input type="number" name="jersey_number" value="{{ old('jersey_number') }}" class="w-full border border-gray-300 rounded-lg p-2" required>
                    @error('jersey_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Team</label>
                    <select name="team_id" class="w-full border border-gray-300 rounded-lg p-2">
                        <option value="">Select Team</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                    @error('team_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <a href="{{ route('coach.players') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg transition">Cancel</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-save mr-2"></i>Add Player
                </button>
            </div>
        </form>
    </div>
</div>
@endsection