<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('user.auth');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        // $credentials['roles'] = '1';

        if (Auth::attempt($credentials)) {
            if (auth()->user()->role_id == 1) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->role_id == 2) {
                $request->session()->regenerate();
                return redirect()->route('user.dashboard');
            }
        }

        return back()->withErrors([
            'error' => 'Login failed'
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
