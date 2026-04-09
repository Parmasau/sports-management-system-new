@extends('layouts.coach-app')
@section('title', 'Training Sessions')
@section('content')
<div class="p-8">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Training Sessions</h2>
            <a href="{{ route('coach.training.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Schedule Training
            </a>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @forelse($trainings as $training)
            <div class="border rounded-lg p-4 hover:shadow-lg transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            @if($training->type == 'fitness')
                                <i class="fas fa-heartbeat text-red-500 text-xl mr-2"></i>
                            @elseif($training->type == 'tactical')
                                <i class="fas fa-chalkboard-user text-blue-500 text-xl mr-2"></i>
                            @elseif($training->type == 'technical')
                                <i class="fas fa-futbol text-green-500 text-xl mr-2"></i>
                            @else
                                <i class="fas fa-bed text-purple-500 text-xl mr-2"></i>
                            @endif
                            <h3 class="text-xl font-bold">{{ ucfirst($training->type) }} Training</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div><i class="fas fa-calendar mr-1"></i> {{ $training->day }}</div>
                            <div><i class="fas fa-clock mr-1"></i> {{ $training->time }}</div>
                            <div><i class="fas fa-location-dot mr-1"></i> {{ $training->location }}</div>
                        </div>
                        <div class="mt-2">
                            <span class="px-2 py-1 rounded text-xs 
                                @if($training->status == 'scheduled') bg-yellow-100 text-yellow-800
                                @elseif($training->status == 'completed') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($training->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('coach.training.edit', $training->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('coach.training.destroy', $training->id) }}" method="POST" onsubmit="return confirm('Delete this training session?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center p-8 text-gray-500">
                No training sessions scheduled. <a href="{{ route('coach.training.create') }}" class="text-blue-600">Create one</a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection