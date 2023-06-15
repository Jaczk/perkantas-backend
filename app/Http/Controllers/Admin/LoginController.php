<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.auth');
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
            if (auth()->user()->roles == 1) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->roles == 0) {
                $request->session()->regenerate();
                return redirect()->route('admin.category');
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
