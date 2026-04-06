@extends('layouts.coach-app')
@section('title', 'Tactics')
@section('content')
<div class="p-8" x-data="{ showAdd: false, showEdit: false, editTactic: {} }">

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">🎯 Tactics</h2>
            <button @click="showAdd = true" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">+ Add Tactic</button>
        </div>

        @forelse($tactics as $tactic)
        <div class="bg-gray-50 rounded-lg px-4 py-4 mb-3">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center space-x-2 mb-1">
                        <span class="font-bold text-lg">{{ $tactic->formation }}</span>
                        @if($tactic->is_active)
                            <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded-full">Active</span>
                        @endif
                    </div>
                    <div class="text-sm text-gray-500 space-y-1">
                        <div><span class="font-medium">Pressing:</span> {{ $tactic->pressing_style }}</div>
                        <div><span class="font-medium">Attack:</span> {{ $tactic->attacking_focus }}</div>
                        <div><span class="font-medium">Set Pieces:</span> {{ $tactic->set_pieces }}</div>
                    </div>
                </div>
                <div class="flex flex-col space-y-2 items-end">
                    @if(!$tactic->is_active)
                    <form method="POST" action="{{ route('coach.tactics.activate', $tactic) }}">
                        @csrf @method('PATCH')
                        <button class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Set Active</button>
                    </form>
                    @endif
                    <button @click="editTactic = {{ $tactic->toJson() }}; showEdit = true"
                        class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">Edit</button>
                    <form method="POST" action="{{ route('coach.tactics.destroy', $tactic) }}" onsubmit="return confirm('Delete tactic?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
            <p class="text-gray-400 text-center py-8">No tactics yet. Add your first tactic.</p>
        @endforelse
    </div>

    <!-- Add Modal -->
    <div x-show="showAdd" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-transition>
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md" @click.outside="showAdd = false">
            <h3 class="text-xl font-bold mb-4">Add Tactic</h3>
            <form method="POST" action="{{ route('coach.tactics.store') }}" class="space-y-3">
                @csrf
                <select name="formation" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option value="">Select Formation</option>
                    @foreach(['4-3-3','4-4-2','3-5-2','5-3-2','4-2-3-1','3-4-3'] as $f)
                        <option value="{{ $f }}">{{ $f }}</option>
                    @endforeach
                </select>
                <input name="pressing_style" placeholder="Pressing Style" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                <input name="attacking_focus" placeholder="Attacking Focus" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                <input name="set_pieces" placeholder="Set Pieces Strategy" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="showAdd = false" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEdit" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-transition>
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md" @click.outside="showEdit = false">
            <h3 class="text-xl font-bold mb-4">Edit Tactic</h3>
            <form method="POST" :action="`/coach/tactics/${editTactic.id}`" class="space-y-3">
                @csrf @method('PUT')
                <select name="formation" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @foreach(['4-3-3','4-4-2','3-5-2','5-3-2','4-2-3-1','3-4-3'] as $f)
                        <option :selected="editTactic.formation === '{{ $f }}'" value="{{ $f }}">{{ $f }}</option>
                    @endforeach
                </select>
                <input name="pressing_style" :value="editTactic.pressing_style" placeholder="Pressing Style" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <input name="attacking_focus" :value="editTactic.attacking_focus" placeholder="Attacking Focus" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <input name="set_pieces" :value="editTactic.set_pieces" placeholder="Set Pieces" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="showEdit = false" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
