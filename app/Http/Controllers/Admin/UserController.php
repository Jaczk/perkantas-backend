<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        
        return view('admin.users',['users'=>$users]);
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->route('admin.user')->with('success', 'One user has been deleted !');
    }
}
