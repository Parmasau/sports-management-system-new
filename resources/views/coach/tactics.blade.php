@extends('layouts.coach-app')
@section('title', 'Tactics')
@section('content')
<div class="p-8">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tactics List -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Match Tactics</h2>
                <a href="{{ route('coach.tactics.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>Create Tactic
                </a>
            </div>

            <div class="space-y-4 max-h-96 overflow-y-auto">
                @forelse($tactics as $tactic)
                <div class="border rounded-lg p-4 hover:shadow-lg transition {{ $loop->first ? 'bg-blue-50 border-blue-500' : '' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-lg font-bold text-blue-600">{{ $tactic->formation }}</h3>
                                <span class="px-2 py-1 rounded text-xs 
                                    @if($tactic->is_active) bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $tactic->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div><strong>Pressing:</strong> {{ $tactic->pressing_style }}</div>
                                <div><strong>Attack Focus:</strong> {{ $tactic->attacking_focus }}</div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2"><strong>Set Pieces:</strong> {{ Str::limit($tactic->set_pieces, 50) }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('coach.tactics.show', $tactic->id) }}" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                <i class="fas fa-eye"></i> View Field
                            </a>
                            <a href="{{ route('coach.tactics.edit', $tactic->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('coach.tactics.destroy', $tactic->id) }}" method="POST" onsubmit="return confirm('Delete this tactic?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center p-8 text-gray-500">
                    No tactics created. <a href="{{ route('coach.tactics.create') }}" class="text-blue-600">Create your first tactic</a>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Formation Preview -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Formation Preview</h2>
            @if($tactics->where('is_active', true)->first())
                @php $activeTactic = $tactics->where('is_active', true)->first(); @endphp
                <x-soccer-field :formation="$activeTactic->formation" />
                <div class="mt-4 text-center text-gray-600">
                    <p class="text-sm">Currently Active: <strong class="text-blue-600">{{ $activeTactic->formation }}</strong></p>
                    <p class="text-xs mt-1">{{ $activeTactic->pressing_style }} | {{ $activeTactic->attacking_focus }}</p>
                </div>
            @else
                <div class="text-center p-8 text-gray-500">
                    No active tactic. Please activate a tactic to see formation preview.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection