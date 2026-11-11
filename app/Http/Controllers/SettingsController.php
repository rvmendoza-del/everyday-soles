<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class SettingsController extends Controller
{
    // DISPLAY SETTINGS PAGE
    public function index()
    {
        $user = auth()->user();

        return view('settings.index', compact('user'));
    }

    // UPDATE PROFILE
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $existingEmail = User::where('email', $data['email'])
            ->where('_id', '!=', $user->getKey())
            ->exists();

        if ($existingEmail) {
            return back()->withErrors([
                'email' => 'This email address is already registered.',
            ])->withInput();
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();

        return redirect()
            ->route('settings.index')
            ->with('success', 'Profile updated successfully!');
    }

    // CHANGE PASSWORD
    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->numbers(),
            ],
        ]);

        $user = auth()->user();

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Your current password is incorrect.',
            ]);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()
            ->route('settings.index')
            ->with('success', 'Password changed successfully!');
    }
}
