@extends('layouts.admin-app')
@section('title', 'Manage Teams')
@section('content')
<div class="p-4">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 mb-4 rounded shadow-md text-sm">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Add Team Form -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <div class="px-4 py-3 bg-gradient-to-r from-blue-600 to-cyan-600">
            <h2 class="text-lg font-bold text-white">Add New Team</h2>
        </div>
        <div class="p-4">
            <form action="{{ route('admin.teams.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                @csrf
                <input type="text" name="name" placeholder="Team Name" class="border rounded-lg p-2 text-sm" required>
                <input type="text" name="city" placeholder="City" class="border rounded-lg p-2 text-sm" required>
                <input type="text" name="stadium" placeholder="Stadium" class="border rounded-lg p-2 text-sm" required>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm">
                    <i class="fas fa-plus mr-1"></i>Add Team
                </button>
            </form>
        </div>
    </div>

    <!-- Teams List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-4 py-3 bg-gradient-to-r from-purple-600 to-pink-600">
            <h2 class="text-lg font-bold text-white">All Teams</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
            @forelse($teams as $team)
            <div class="border rounded-lg p-3 hover:shadow-lg transition">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-md text-blue-600">{{ $team->name }}</h3>
                        <p class="text-xs text-gray-600">{{ $team->city }}</p>
                        <p class="text-xs text-gray-500">{{ $team->stadium }}</p>
                    </div>
                    <div class="flex space-x-1">
                        <a href="{{ route('admin.teams.edit', $team->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" onsubmit="return confirm('Delete this team?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                <i class="fas fa-trash"></i> Del
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center p-8 text-gray-500">
                <i class="fas fa-building text-4xl mb-2 opacity-50"></i>
                <p>No teams found.</p>
                <p class="text-sm">Add your first team using the form above.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection