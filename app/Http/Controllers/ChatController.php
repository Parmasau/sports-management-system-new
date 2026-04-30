<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all conversations for the current user
        $conversations = Conversation::where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->with(['userOne', 'userTwo'])
            ->orderBy('last_message_at', 'desc')
            ->get();
        
        $unreadCount = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();
        
        // Get all users for starting new conversations (excluding current user)
        $users = User::where('id', '!=', $user->id)->get();
        
        $role = $user->role;
        return view('chat.index', compact('conversations', 'unreadCount', 'users', 'role'));
    }

    public function conversation($userId)
    {
        $user = Auth::user();
        $otherUser = User::findOrFail($userId);
        
        // Get or create conversation - any authenticated user can chat with any other user
        $conversation = Conversation::where(function ($query) use ($user, $otherUser) {
            $query->where('user_one_id', $user->id)
                  ->where('user_two_id', $otherUser->id);
        })->orWhere(function ($query) use ($user, $otherUser) {
            $query->where('user_one_id', $otherUser->id)
                  ->where('user_two_id', $user->id);
        })->first();
        
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $user->id,
                'user_two_id' => $otherUser->id,
                'last_message_at' => now()
            ]);
        }
        
        // Mark messages as read
        Message::where('sender_id', $otherUser->id)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
        
        // Get messages
        $messages = Message::where(function ($query) use ($user, $otherUser) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $otherUser->id);
        })->orWhere(function ($query) use ($user, $otherUser) {
            $query->where('sender_id', $otherUser->id)
                  ->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')->get();
        
        // Get all conversations for sidebar
        $conversations = Conversation::where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->with(['userOne', 'userTwo'])
            ->orderBy('last_message_at', 'desc')
            ->get();
        
        $unreadCount = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();
        
        $users = User::where('id', '!=', $user->id)->get();
        
        $role = $user->role;
        return view('chat.conversation', compact('conversations', 'messages', 'otherUser', 'unreadCount', 'users', 'role'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);
        
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false
        ]);
        
        $user = Auth::user();
        $otherUser = User::find($request->receiver_id);
        
        $conversation = Conversation::where(function ($query) use ($user, $otherUser) {
            $query->where('user_one_id', $user->id)
                  ->where('user_two_id', $otherUser->id);
        })->orWhere(function ($query) use ($user, $otherUser) {
            $query->where('user_one_id', $otherUser->id)
                  ->where('user_two_id', $user->id);
        })->first();
        
        if (!$conversation) {
            Conversation::create([
                'user_one_id' => $user->id,
                'user_two_id' => $otherUser->id,
                'last_message_at' => now()
            ]);
        } else {
            $conversation->update(['last_message_at' => now()]);
        }
        
        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'content' => $message->message,
                'created_at' => $message->created_at->format('g:i A'),
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id
            ],
            'sender_name' => $user->name,
            'sender_role' => $user->role,
            'toast_message' => '✓ Message sent successfully!'
        ]);
    }

    public function getUnreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();
        
        return response()->json(['count' => $count]);
    }

    public function markAsRead($messageId)
    {
        $message = Message::findOrFail($messageId);
        
        if ($message->receiver_id == Auth::id()) {
            $message->update(['is_read' => true, 'read_at' => now()]);
        }
        
        return response()->json(['success' => true]);
    }
}