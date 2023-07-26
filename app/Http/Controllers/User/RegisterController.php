<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('user.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|max:15',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $data = $request->except('_token');

        $isEmailExist = User::where('email', $request->email)->exists();

        if ($isEmailExist) {
            return back()->withErrors([
                'email' => 'Email ini sudah digunakan!'
            ])->withInput();
        }

        // Check if 'countryCode' input exists, and concatenate the phone number accordingly
        if ($request->has('countryCode')) {
            $phoneNumber = $request->input('countryCode') . $request->input('phone');
        } else {
            $phoneNumber = $request->input('phone');
        }

        $data['phone'] = $phoneNumber;
        $data['roles'] = 0;
        $data['password'] = Hash::make($request->password);

        User::create($data);

        return redirect()->route('user.dashboard');
    }
}
