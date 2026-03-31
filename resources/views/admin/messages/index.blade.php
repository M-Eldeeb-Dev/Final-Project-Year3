@extends('layouts.admin')
@section('page-title', 'Contact Messages')

@section('content')
<div class="mb-6 flex space-x-2">
    <a href="{{ route('admin.messages.index') }}"
       class="px-4 py-2 text-sm font-medium rounded-t-lg border-b-2 {{ !request('filter') ? 'border-gold text-gold bg-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
        All Messages
    </a>
    <a href="{{ route('admin.messages.index', ['filter' => 'unread']) }}"
       class="px-4 py-2 text-sm font-medium rounded-t-lg border-b-2 {{ request('filter') === 'unread' ? 'border-gold text-gold bg-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
        Unread <span class="ml-1 px-2 py-0.5 rounded-full text-xs {{ $unreadCount > 0 ? 'bg-red-500 text-white animate-pulse' : 'bg-gray-200 text-gray-600' }}">{{ $unreadCount }}</span>
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-t border-gray-100">
            <thead class="text-xs text-gray-500 bg-gray-50 uppercase border-b">
                <tr>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Sender</th>
                    <th class="px-4 py-3">Subject</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($messages as $message)
                    <tr class="hover:bg-gray-50 {{ !$message->is_read ? 'bg-blue-50/30' : '' }}">
                        <td class="px-4 py-3 text-center">
                            @if(!$message->is_read)
                                <span class="inline-block w-3 h-3 bg-blue-500 rounded-full shadow" title="Unread"></span>
                            @else
                                <span class="inline-block w-3 h-3 bg-gray-300 rounded-full" title="Read"></span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-bold {{ !$message->is_read ? 'text-gray-900' : 'text-gray-700' }}">{{ $message->name }}</div>
                            <div class="text-xs text-gray-500">{{ $message->email }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium {{ !$message->is_read ? 'text-gray-900' : 'text-gray-600' }} max-w-md truncate">{{ $message->subject }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $message->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('admin.messages.show', $message) }}" class="text-blue-600 hover:text-blue-900 text-xs font-semibold uppercase tracking-wider bg-white border border-blue-200 px-3 py-1.5 rounded transition">View</a>
                                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <p>No contact messages found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($messages->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection
