<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::withCount('orders')
            ->when(request('role'),   fn($q) => $q->where('role', request('role')))
            ->when(request('search'), fn($q) =>
                $q->where('name',  'like', '%'.request('search').'%')
                  ->orWhere('email','like', '%'.request('search').'%'))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $orders = $user->orders()->with('items')->latest()->take(10)->get();
        return view('admin.users.show', compact('user', 'orders'));
    }

    public function updateRole(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $request->validate(['role' => ['required', 'in:admin,customer']]);
        $user->update(['role' => $request->role]);

        return back()->with('success', "User role updated to {$request->role}.");
    }
}
