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

    public function edit($id)
    {
        $user = User::find($id);

        return view('admin.user-edit',['user'=>$user]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');

        $request->validate([
            'phone' => 'required|string',
            'can_return' =>'required',
        ]);

        $user = User::find($id);

        $user->update($data);
        return redirect()->route('admin.user')->with('success', 'Berhasil memperbarui data pengguna');
    }

    public function userAccess()
    {
        User::where('roles', 0)->update(['can_return' => 0]);

        return redirect()->route('admin.user')->with('success', 'Reset akses peminjaman barang ke semua pengguna berhasil !');
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->route('admin.user')->with('success', 'Berhasil menghapus akun pengguna !');
    }


}
