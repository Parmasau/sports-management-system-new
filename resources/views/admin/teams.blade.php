@extends('layouts.admin-app')
@section('title', 'Manage Teams')
@section('content')
<div class="p-8" x-data="{ showAdd: false, showEdit: false, editTeam: {} }">

    @if(session('success'))<div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>@endif

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">🏟️ Manage Teams</h2>
            <button @click="showAdd = true" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">+ Add Team</button>
        </div>

        @forelse($teams as $team)
        <div class="flex justify-between items-center bg-gray-50 rounded-lg px-4 py-3 mb-2">
            <div>
                <div class="font-semibold">{{ $team->name }}</div>
                <div class="text-sm text-gray-500">
                    Coach: {{ $team->coach ?? 'N/A' }} ·
                    W:{{ $team->wins }} L:{{ $team->losses }} D:{{ $team->draws }}
                </div>
            </div>
            <div class="flex space-x-2">
                <button @click="editTeam = {{ $team->toJson() }}; showEdit = true"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</button>
                <form method="POST" action="{{ route('admin.teams.destroy', $team) }}" onsubmit="return confirm('Delete team?')">
                    @csrf @method('DELETE')
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-center py-8">No teams yet.</p>
        @endforelse
    </div>

    <!-- Add Modal -->
    <div x-show="showAdd" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-transition>
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md" @click.outside="showAdd = false">
            <h3 class="text-xl font-bold mb-4">Add Team</h3>
            <form method="POST" action="{{ route('admin.teams.store') }}" class="space-y-3">
                @csrf
                <input name="name" placeholder="Team Name" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                <input name="coach" placeholder="Coach Name" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                <input name="badge_color" placeholder="Badge Color (e.g. red)" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                <div class="grid grid-cols-3 gap-2">
                    <input name="wins" type="number" placeholder="Wins" value="0" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <input name="losses" type="number" placeholder="Losses" value="0" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <input name="draws" type="number" placeholder="Draws" value="0" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="showAdd = false" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEdit" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-transition>
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md" @click.outside="showEdit = false">
            <h3 class="text-xl font-bold mb-4">Edit Team</h3>
            <form method="POST" :action="`/admin/teams/${editTeam.id}`" class="space-y-3">
                @csrf @method('PUT')
                <input name="name" :value="editTeam.name" placeholder="Team Name" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <input name="coach" :value="editTeam.coach" placeholder="Coach Name" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <input name="badge_color" :value="editTeam.badge_color" placeholder="Badge Color" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <div class="grid grid-cols-3 gap-2">
                    <input name="wins" type="number" :value="editTeam.wins" placeholder="Wins" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <input name="losses" type="number" :value="editTeam.losses" placeholder="Losses" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <input name="draws" type="number" :value="editTeam.draws" placeholder="Draws" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="showEdit = false" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
