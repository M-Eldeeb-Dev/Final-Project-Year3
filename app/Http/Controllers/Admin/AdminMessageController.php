<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()
            ->when(request('filter') === 'unread', fn($q) => $q->where('is_read', false))
            ->paginate(20);

        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('admin.messages.index', compact('messages', 'unreadCount'));
    }

    public function show(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return view('admin.messages.show', compact('message'));
    }

    public function markRead(ContactMessage $message)
    {
        $message->update(['is_read' => !$message->is_read]);
        return back()->with('success', 'Message status updated.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')
               ->with('success', 'Message deleted.');
    }
}
