@extends('layouts.admin-app')
@section('title', 'Manage Users')
@section('content')
<div class="p-8" x-data="{ showAdd: false, showEdit: false, editUser: {} }">

    @if(session('success'))<div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg">{{ session('error') }}</div>@endif

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">👥 All Users</h2>
            <button @click="showAdd = true" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">+ Add User</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50"><tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Name</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Email</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Role</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Joined</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Actions</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $user->role === 'coach' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $user->role === 'player' ? 'bg-green-100 text-green-700' : '' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 flex space-x-2">
                            <button @click="editUser = {{ $user->toJson() }}; showEdit = true"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">Edit</button>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete user?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    <div x-show="showAdd" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-transition>
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md" @click.outside="showAdd = false">
            <h3 class="text-xl font-bold mb-4">Add User</h3>
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-3">
                @csrf
                <input name="name" placeholder="Full Name" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                <input name="email" type="email" placeholder="Email" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                <select name="role" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="player">Player</option>
                    <option value="coach">Coach</option>
                    <option value="admin">Admin</option>
                </select>
                <input name="password" type="password" placeholder="Password (min 8)" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
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
            <h3 class="text-xl font-bold mb-4">Edit User</h3>
            <form method="POST" :action="`/admin/users/${editUser.id}`" class="space-y-3">
                @csrf @method('PUT')
                <input name="name" :value="editUser.name" placeholder="Full Name" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <input name="email" type="email" :value="editUser.email" placeholder="Email" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <select name="role" required class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @foreach(['player','coach','admin'] as $r)
                        <option :selected="editUser.role === '{{ $r }}'" value="{{ $r }}">{{ ucfirst($r) }}</option>
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
