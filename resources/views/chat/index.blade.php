@extends('layouts.' . $role . '-app')
@section('title', 'Messages')
@section('content')
<div class="p-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600">
            <h2 class="text-lg font-bold text-white">
                <i class="fas fa-comments mr-2"></i>Messages
                @if($unreadCount > 0)
                    <span class="ml-2 bg-red-500 text-white px-2 py-0.5 rounded-full text-xs">{{ $unreadCount }}</span>
                @endif
            </h2>
        </div>
        
        <div class="flex h-[600px]">
            <!-- Users Sidebar -->
            <div class="w-80 border-r overflow-y-auto bg-gray-50">
                <div class="p-3 border-b">
                    <h3 class="font-semibold text-gray-700 text-sm">Start New Conversation</h3>
                </div>
                <div class="p-3 border-b">
                    <select id="newChatUser" class="w-full border rounded-lg p-2 text-sm">
                        <option value="">Select a user to message...</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ ucfirst($u->role) }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="p-3 border-b">
                    <h3 class="font-semibold text-gray-700 text-sm">All Conversations</h3>
                </div>
                
                <div id="conversationsList">
                    @foreach($conversations as $conv)
                        @php
                            if($role == 'admin') {
                                $otherUser = Auth::id() == $conv->user_one_id ? $conv->userTwo : $conv->userOne;
                            } else {
                                $otherUser = $conv->user_one_id == Auth::id() ? $conv->userTwo : $conv->userOne;
                            }
                            $unread = \App\Models\Message::where('sender_id', $otherUser->id)
                                ->where('receiver_id', Auth::id())
                                ->where('is_read', false)
                                ->count();
                            $lastMsg = \App\Models\Message::where(function($q) use ($conv) {
                                $q->where('sender_id', $conv->user_one_id)->where('receiver_id', $conv->user_two_id);
                            })->orWhere(function($q) use ($conv) {
                                $q->where('sender_id', $conv->user_two_id)->where('receiver_id', $conv->user_one_id);
                            })->latest()->first();
                        @endphp
                        <a href="{{ route('chat.conversation', $otherUser->id) }}" 
                           class="block p-3 border-b hover:bg-gray-100 transition">
                            <div class="flex items-center space-x-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($otherUser->name) }}&background=667eea&color=fff&rounded=true&size=100" class="w-10 h-10 rounded-full">
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <p class="font-semibold text-gray-800 text-sm">{{ $otherUser->name }}</p>
                                        @if($unread > 0)
                                            <span class="bg-red-500 text-white px-2 py-0.5 rounded-full text-xs">{{ $unread }}</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500">{{ ucfirst($otherUser->role) }}</p>
                                    @if($lastMsg)
                                        <p class="text-xs text-gray-400 truncate">{{ Str::limit($lastMsg->message, 40) }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                    
                    @if(count($conversations) == 0)
                        <div class="p-4 text-center text-gray-500">
                            <i class="fas fa-comments text-4xl mb-2 opacity-50"></i>
                            <p>No conversations yet.</p>
                            <p class="text-sm">Start a new conversation above.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Welcome Section -->
            <div class="flex-1 flex items-center justify-center bg-gray-50">
                <div class="text-center">
                    <i class="fas fa-comments text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Select a conversation to start messaging</p>
                    <p class="text-sm text-gray-400 mt-2">Or start a new conversation from the left panel</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('newChatUser').addEventListener('change', function() {
    if(this.value) {
        window.location.href = '/chat/conversation/' + this.value;
    }
});
</script>
@endsection