<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $data['username'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['username' => 'Credensial tidak valid'])->withInput();
        }

        session(["user_id" => $user->id, "user_name" => $user->nama, "user_role" => $user->role]);

        return redirect()->intended(route('dashboard'));
    }

    public function logout()
    {
        session()->forget(['user_id', 'user_name', 'user_role']);
        session()->invalidate();
        return redirect()->route('login');
    }
}
