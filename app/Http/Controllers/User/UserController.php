<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function userAccess()
    {
        User::where('roles', 0)->update(['can_return' => 0]);

        return redirect()->route('admin.user')->with('success', 'Reset access to all users succesfully!');
    }
}
