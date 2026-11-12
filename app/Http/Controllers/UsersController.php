<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    // =====================================
    // DISPLAY ALL USERS
    // =====================================

    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        $totalUsers = User::count();

        $adminUsers = User::where('role', 'admin')->count();

        $regularUsers = User::where('role', '!=', 'admin')->count();

        return view('users.index', compact(
            'users',
            'totalUsers',
            'adminUsers',
            'regularUsers'
        ));
    }


    // =====================================
    // SHOW CREATE USER FORM
    // =====================================

    public function create()
    {
        return view('users.create');
    }


    // =====================================
    // SAVE NEW USER
    // =====================================

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully!');
    }


    // =====================================
    // SHOW EDIT USER FORM
    // =====================================

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }


    // =====================================
    // UPDATE USER INFORMATION
    // =====================================

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'role' => 'required|in:admin,user',

            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // PREVENT CHANGING YOUR OWN ROLE
        if (
            (string) $user->id === (string) auth()->id() &&
            $user->role !== $data['role']
        ) {
            return back()->withInput()->withErrors([
                'role' => 'You cannot change your own administrator role.',
            ]);
        }

        // PREVENT REMOVING THE LAST ADMIN
        if (
            $user->role === 'admin' &&
            $data['role'] !== 'admin' &&
            User::where('role', 'admin')->count() <= 1
        ) {
            return back()->withInput()->withErrors([
                'role' => 'You cannot remove the last administrator.',
            ]);
        }

        // UPDATE PASSWORD ONLY IF PROVIDED
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully!');
    }


    // =====================================
    // UPDATE USER ROLE
    // =====================================

    public function updateRole(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        // PREVENT CHANGING YOUR OWN ROLE
        if ((string) $user->id === (string) auth()->id()) {
            return back()->withErrors([
                'role' => 'You cannot change your own administrator role.',
            ]);
        }

        // PREVENT REMOVING THE LAST ADMIN
        if (
            $user->role === 'admin' &&
            $data['role'] !== 'admin' &&
            User::where('role', 'admin')->count() <= 1
        ) {
            return back()->withErrors([
                'role' => 'You cannot remove the last administrator.',
            ]);
        }

        $user->role = $data['role'];

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User role updated successfully!');
    }


    // =====================================
    // DELETE USER
    // =====================================

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // PREVENT DELETING YOUR OWN ACCOUNT
        if ((string) $user->id === (string) auth()->id()) {
            return back()->withErrors([
                'delete' => 'You cannot delete your own account.',
            ]);
        }

        // PROTECT THE LAST ADMIN
        if (
            $user->role === 'admin' &&
            User::where('role', 'admin')->count() <= 1
        ) {
            return back()->withErrors([
                'delete' => 'You cannot delete the last administrator.',
            ]);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully!');
    }
}
