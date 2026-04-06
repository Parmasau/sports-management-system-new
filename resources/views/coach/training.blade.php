@extends('layouts.coach-app')
@section('title', 'Training Schedule')
@section('content')
<div class="p-8" x-data="{ showAdd: false, showEdit: false, editSession: {} }">

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">📅 Training Schedule</h2>
            <button @click="showAdd = true" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">+ Add Session</button>
        </div>

        @forelse($sessions as $session)
        <div class="flex justify-between items-center bg-gray-50 rounded-lg px-4 py-3 mb-2">
            <div>
                <div class="font-semibold">{{ $session->day }} - {{ \Carbon\Carbon::parse($session->time)->format('g:i A') }}</div>
                <div class="text-sm text-gray-500">{{ $session->type }} · {{ $session->location }}</div>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-xs font-medium px-3 py-1 rounded-full
                    {{ $session->status === 'scheduled' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $session->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $session->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $session->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                    {{ ucfirst($session->status) }}
                </span>
                <button @click="editSession = {{ $session->toJson() }}; showEdit = true"
                    class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">Edit</button>
                <form method="POST" action="{{ route('coach.training.destroy', $session) }}" onsubmit="return confirm('Remove session?')">
                    @csrf @method('DELETE')
                    <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Delete</button>
                </form>
            </div>
        </div>
        @empty
            <p class="text-gray-400 text-center py-8">No sessions yet. Schedule your first training.</p>
        @endforelse
    </div>

    <!-- Add Modal -->
    <div x-show="showAdd" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-transition>
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md" @click.outside="showAdd = false">
            <h3 class="text-xl font-bold mb-4">Add Training Session</h3>
            <form method="POST" action="{{ route('coach.training.store') }}" class="space-y-3">
                @csrf
                <input name="day" placeholder="Day (e.g. Monday)" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                <input name="time" type="time" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                <input name="type" placeholder="Session Type (e.g. Tactical Training)" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                <input name="location" placeholder="Location (e.g. Main Ground)" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                <select name="status" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option value="scheduled">Scheduled</option>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
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
            <h3 class="text-xl font-bold mb-4">Edit Session</h3>
            <form method="POST" :action="`/coach/training/${editSession.id}`" class="space-y-3">
                @csrf @method('PUT')
                <input name="day" :value="editSession.day" placeholder="Day" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <input name="time" type="time" :value="editSession.time" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <input name="type" :value="editSession.type" placeholder="Session Type" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <input name="location" :value="editSession.location" placeholder="Location" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <select name="status" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @foreach(['scheduled','pending','completed','cancelled'] as $s)
                        <option :selected="editSession.status === '{{ $s }}'" value="{{ $s }}">{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="showEdit = false" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
