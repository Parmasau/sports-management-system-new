@extends('layouts.coach-app')
@section('title', 'Health Records')
@section('content')
<div class="p-8" x-data="{ showAdd: false, showEdit: false, editRecord: {} }">

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="text-3xl mb-2">✅</div>
            <div class="text-2xl font-bold text-green-600">{{ $records->where('status','fit')->count() }}</div>
            <div class="text-gray-600">Fit</div>
        </div>
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="text-3xl mb-2">🤕</div>
            <div class="text-2xl font-bold text-red-500">{{ $records->where('status','injured')->count() }}</div>
            <div class="text-gray-600">Injured</div>
        </div>
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="text-3xl mb-2">⚠️</div>
            <div class="text-2xl font-bold text-yellow-500">{{ $records->where('status','observation')->count() }}</div>
            <div class="text-gray-600">Observation</div>
        </div>
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="text-3xl mb-2">🔄</div>
            <div class="text-2xl font-bold text-blue-500">{{ $records->where('status','recovering')->count() }}</div>
            <div class="text-gray-600">Recovering</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">🏥 Health Records</h2>
            <button @click="showAdd = true" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">+ Add Record</button>
        </div>

        @forelse($records as $record)
        <div class="flex justify-between items-center bg-gray-50 rounded-lg px-4 py-3 mb-2">
            <div>
                <div class="font-semibold">{{ $record->player->name ?? 'Unknown' }}</div>
                <div class="text-sm text-gray-500">{{ $record->note }}
                    @if($record->since) · Since: {{ $record->since }} @endif
                    @if($record->estimated_return) · Return: {{ $record->estimated_return }} @endif
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-xs font-medium px-2 py-1 rounded-full
                    {{ $record->status === 'fit' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $record->status === 'injured' ? 'bg-red-100 text-red-700' : '' }}
                    {{ $record->status === 'observation' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $record->status === 'recovering' ? 'bg-blue-100 text-blue-700' : '' }}">
                    {{ ucfirst($record->status) }}
                </span>
                <button @click="editRecord = {{ $record->toJson() }}; showEdit = true"
                    class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">Update</button>
                <form method="POST" action="{{ route('coach.health.destroy', $record) }}" onsubmit="return confirm('Delete record?')">
                    @csrf @method('DELETE')
                    <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Delete</button>
                </form>
            </div>
        </div>
        @empty
            <p class="text-gray-400 text-center py-8">No health records yet.</p>
        @endforelse
    </div>

    <!-- Add Modal -->
    <div x-show="showAdd" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-transition>
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md" @click.outside="showAdd = false">
            <h3 class="text-xl font-bold mb-4">Add Health Record</h3>
            <form method="POST" action="{{ route('coach.health.store') }}" class="space-y-3">
                @csrf
                <select name="player_id" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option value="">Select Player</option>
                    @foreach($players as $player)
                        <option value="{{ $player->id }}">{{ $player->name }} ({{ $player->position }})</option>
                    @endforeach
                </select>
                <textarea name="note" placeholder="Condition / Injury Note" required rows="2"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                <select name="status" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option value="fit">Fit</option>
                    <option value="injured">Injured</option>
                    <option value="observation">Under Observation</option>
                    <option value="recovering">Recovering</option>
                </select>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs text-gray-500">Since</label>
                        <input name="since" type="date" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Est. Return</label>
                        <input name="estimated_return" type="date" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                </div>
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
            <h3 class="text-xl font-bold mb-4">Update Health Record</h3>
            <form method="POST" :action="`/coach/health/${editRecord.id}`" class="space-y-3">
                @csrf @method('PUT')
                <textarea name="note" :value="editRecord.note" placeholder="Condition / Injury Note" required rows="2"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400"></textarea>
                <select name="status" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @foreach(['fit','injured','observation','recovering'] as $s)
                        <option :selected="editRecord.status === '{{ $s }}'" value="{{ $s }}">{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs text-gray-500">Since</label>
                        <input name="since" type="date" :value="editRecord.since" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Est. Return</label>
                        <input name="estimated_return" type="date" :value="editRecord.estimated_return" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>
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
