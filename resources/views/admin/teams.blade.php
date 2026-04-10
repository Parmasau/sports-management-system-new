@extends('layouts.admin-app')
@section('title', 'Manage Teams')
@section('content')
<div class="p-8">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Team</h2>
        
        <form action="{{ route('admin.teams.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf
            <input type="text" name="name" placeholder="Team Name" class="border rounded-lg p-2" required>
            <input type="text" name="city" placeholder="City" class="border rounded-lg p-2" required>
            <input type="text" name="stadium" placeholder="Stadium" class="border rounded-lg p-2" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Add Team
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Existing Teams</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($teams as $team)
            <div class="border rounded-lg p-4 hover:shadow-lg transition">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-lg text-blue-600">{{ $team->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $team->city }}</p>
                        <p class="text-xs text-gray-500">{{ $team->stadium }}</p>
                    </div>
                    <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" onsubmit="return confirm('Delete this team?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center p-6 text-gray-500">No teams found.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection