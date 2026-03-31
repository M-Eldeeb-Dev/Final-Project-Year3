@extends('layouts.admin')
@section('page-title')
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.messages.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Back</a>
        <span>Message Details</span>
    </div>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-8 border border-gray-100">
        <div class="flex justify-between items-start mb-6 pb-6 border-b border-gray-100">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $message->subject }}</h2>
                <div class="flex items-center space-x-3 text-sm text-gray-600">
                    <span class="font-semibold text-gray-900">{{ $message->name }}</span>
                    <span class="text-gray-300">&bull;</span>
                    <a href="mailto:{{ $message->email }}" class="text-gold hover:underline">{{ $message->email }}</a>
                </div>
            </div>
            <div class="text-right">
                <span class="text-xs text-gray-500 block mb-2">{{ $message->created_at->format('M d, Y h:i a') }}</span>
                <form action="{{ route('admin.messages.read', $message) }}" method="POST" class="inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="text-xs px-3 py-1 rounded-full border {{ $message->is_read ? 'border-gray-300 text-gray-500 hover:bg-gray-50' : 'border-blue-300 text-blue-600 bg-blue-50 hover:bg-blue-100' }} transition">
                        {{ $message->is_read ? 'Mark as Unread' : 'Mark as Read' }}
                    </button>
                </form>
            </div>
        </div>

        <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-wrap font-sans mb-10">
            {{ $message->message }}
        </div>

        <div class="pt-6 border-t border-gray-100 flex justify-between items-center">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}" class="bg-gray-800 hover:bg-black text-white px-6 py-2 rounded text-sm font-semibold transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Reply via Email
            </a>

            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message permanently?');">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Delete Message
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
