<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use Illuminate\Http\Request;

class ProcurementController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;

        $procurements  = Procurement::where('user_id', $userId)
        ->orderBy('created_at', 'DESC')->get();

        return view('user.procurement',['procurements' => $procurements]);
    }

    public function store(Request $request)
    {
        $data  = $request->except('_token');

        $request->validate([
            'goods_name' => 'required|string',
            'gooods_amount' => 'required|integer|size:2',
            'description' => ''
        ]);

        Procurement::create($data);
        return redirect()->route('user.procurement')->with('success','Barang berhasil diajukan !');
    }

    public function destroy($id)
    {
        Procurement::find($id)->delete();

        return redirect()->route('user.procurement')->with('success', 'Satu item berhasil dihapus !');
    }
}
