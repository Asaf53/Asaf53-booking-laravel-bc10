<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /** @var \App\Models\User */
        $checkUser = Auth::user();
        if (!$checkUser->hasRole('superadmin')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'fullname' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'role' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->fullname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $role = Role::find($request->role);
        $user->syncRoles($role);
        if ($user->update($request->except('_token'))) return redirect()->route('users.index')->with('status', 'User updated successfully.');
        return redirect()->route('admin.users.index')->with('status', 'Failed to update user.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /** @var \App\Models\User */
        $checkUser = Auth::user();
        if (!$checkUser->hasRole('superadmin')) return redirect()->back()->with('status', 'You don`t have access to this page!!!');
        $user = User::findOrFail($id);
        if ($user->id != Auth::id()) {
            if ($user->delete()) return redirect()->back()->with('status', 'User deleted successfully.');
        }
        return redirect()->back()->with('status', 'Failed to delete user');
    }
}
