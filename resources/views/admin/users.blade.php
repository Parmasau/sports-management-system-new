@extends('layouts.admin-app')
@section('title', 'Manage Users')
@section('content')
<div class="p-8">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">System Users</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Role</th>
                        <th class="p-3 text-left">Joined</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $user->id }}</td>
                        <td class="p-3 font-semibold">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs 
                                @if($user->role == 'admin') bg-purple-200 text-purple-800
                                @elseif($user->role == 'coach') bg-blue-200 text-blue-800
                                @else bg-green-200 text-green-800 @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="p-3">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="p-3 text-center">
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center p-6 text-gray-500">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection