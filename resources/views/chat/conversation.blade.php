@extends('layouts.' . $role . '-app')
@section('title', 'Chat with ' . $otherUser->name)
@section('content')
<div class="p-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('chat.index') }}" class="text-white hover:text-gray-200">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($otherUser->name) }}&background=fff&color=667eea&rounded=true&size=100" class="w-10 h-10 rounded-full">
                    <div>
                        <h2 class="text-lg font-bold text-white">{{ $otherUser->name }}</h2>
                        <p class="text-xs text-blue-200">{{ ucfirst($otherUser->role) }}</p>
                    </div>
                </div>
                <div class="text-white text-sm">
                    <i class="fas fa-circle text-green-500 text-xs"></i> Online
                </div>
            </div>
        </div>
        
        <div class="flex h-[550px]">
            <!-- Conversations Sidebar -->
            <div class="w-80 border-r overflow-y-auto bg-gray-50">
                <div class="p-3 border-b">
                    <h3 class="font-semibold text-gray-700 text-sm">All Conversations</h3>
                </div>
                @foreach($conversations as $conv)
                    @php
                        if($role == 'admin') {
                            $convUser = Auth::id() == $conv->user_one_id ? $conv->userTwo : $conv->userOne;
                        } else {
                            $convUser = $conv->user_one_id == Auth::id() ? $conv->userTwo : $conv->userOne;
                        }
                        $unread = \App\Models\Message::where('sender_id', $convUser->id)
                            ->where('receiver_id', Auth::id())
                            ->where('is_read', false)
                            ->count();
                        $lastMsg = \App\Models\Message::where(function($q) use ($conv) {
                            $q->where('sender_id', $conv->user_one_id)->where('receiver_id', $conv->user_two_id);
                        })->orWhere(function($q) use ($conv) {
                            $q->where('sender_id', $conv->user_two_id)->where('receiver_id', $conv->user_one_id);
                        })->latest()->first();
                    @endphp
                    <a href="{{ route('chat.conversation', $convUser->id) }}" 
                       class="block p-3 border-b hover:bg-gray-100 transition {{ $convUser->id == $otherUser->id ? 'bg-blue-50' : '' }}">
                        <div class="flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($convUser->name) }}&background=667eea&color=fff&rounded=true&size=100" class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <p class="font-semibold text-gray-800 text-sm">{{ $convUser->name }}</p>
                                    @if($unread > 0)
                                        <span class="bg-red-500 text-white px-2 py-0.5 rounded-full text-xs">{{ $unread }}</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500">{{ ucfirst($convUser->role) }}</p>
                                @if($lastMsg)
                                    <p class="text-xs text-gray-400 truncate">{{ Str::limit($lastMsg->message, 30) }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <!-- Chat Area -->
            <div class="flex-1 flex flex-col">
                <!-- Messages -->
                <div id="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-3">
                    @foreach($messages as $message)
                        <div class="flex {{ $message->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs lg:max-w-md">
                                <div class="rounded-lg p-3 {{ $message->sender_id == Auth::id() ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-800' }}">
                                    <p class="text-sm">{{ $message->message }}</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $message->created_at->format('g:i A') }}
                                    @if($message->sender_id == Auth::id())
                                        @if($message->is_read)
                                            <i class="fas fa-check-double text-blue-500 ml-1"></i>
                                        @else
                                            <i class="fas fa-check text-gray-400 ml-1"></i>
                                        @endif
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Message Input -->
                <div class="border-t p-4 bg-gray-50">
                    <form id="messageForm" class="flex space-x-2">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                        <input type="text" name="message" id="messageInput" 
                               class="flex-1 border rounded-lg p-2 text-sm focus:outline-none focus:border-blue-500" 
                               placeholder="Type your message..." required>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-paper-plane"></i> Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Notification Toast -->
<div id="toastNotification" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 hidden items-center space-x-2 transition-all duration-300 transform translate-x-full">
    <i class="fas fa-check-circle"></i>
    <span id="toastMessage">Message sent successfully!</span>
</div>

<style>
    .toast-show {
        transform: translateX(0) !important;
        display: flex !important;
    }
</style>

<script>
    const messagesContainer = document.getElementById('messagesContainer');
    const messageInput = document.getElementById('messageInput');
    const messageForm = document.getElementById('messageForm');
    const toast = document.getElementById('toastNotification');
    const toastMessage = document.getElementById('toastMessage');
    
    // Auto-scroll to bottom
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    
    function showToast(message) {
        toastMessage.textContent = message;
        toast.classList.remove('hidden');
        toast.classList.add('toast-show');
        
        setTimeout(() => {
            toast.classList.remove('toast-show');
            toast.classList.add('hidden');
        }, 3000);
    }
    
    // Send message
    messageForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        if(!message) return;
        
        const receiverId = document.querySelector('input[name="receiver_id"]').value;
        
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        
        try {
            const response = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    receiver_id: receiverId,
                    message: message
                })
            });
            
            const data = await response.json();
            
            if(data.success) {
                showToast(data.toast_message || '✓ Message sent successfully!');
                
                const messageHtml = `
                    <div class="flex justify-end">
                        <div class="max-w-xs lg:max-w-md">
                            <div class="rounded-lg p-3 bg-blue-500 text-white">
                                <p class="text-sm">${escapeHtml(message)}</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-right">Just now <i class="fas fa-check text-gray-400"></i></p>
                        </div>
                    </div>
                `;
                messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                messageInput.value = '';
                
                setTimeout(() => location.reload(), 1000);
            }
        } catch(error) {
            console.error('Error:', error);
            showToast('Failed to send message');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send';
        }
    });
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            messageForm.dispatchEvent(new Event('submit'));
        }
    });
    
    // Check for new messages every 5 seconds
    setInterval(() => {
        fetch('/chat/unread-count')
            .then(res => res.json())
            .then(data => {
                if(data.count > 0) {
                    const badge = document.querySelector('.bg-red-500.rounded-full');
                    if(badge) {
                        badge.textContent = data.count;
                        badge.style.display = 'inline-block';
                    }
                    if(data.count > 0 && window.confirm('New messages received! Refresh to see them?')) {
                        location.reload();
                    }
                }
            })
            .catch(err => console.error('Error:', err));
    }, 10000);
</script>
@endsection