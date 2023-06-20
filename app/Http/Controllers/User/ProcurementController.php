<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Procurement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;


class ProcurementController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;

        $procurements  = Procurement::where('user_id', $userId)
        ->orderBy('created_at', 'DESC')->get();

        return view('user.procurement',['procurements' => $procurements]);
    }

    public function edit($id)
    {
        $procurements = Procurement::where('user_id', Auth()->user()->id)->find($id);

        return view('user.procurement-add', ['procurements'=>$procurements]);
    }

    public function add()
    {
        return view('user.procurement-add');
    }

    public function store(Request $request)
    {
        $data  = $request->except('_token');

        $request->validate([
            'goods_name' => 'required|string',
            'goods_amount' => 'required|integer|between:1,99',
            'description' => 'required|string|max:255',
        ]);

        $data['user_id'] = auth()->user()->id;
        $data['period'] = Carbon::now()->format('Ym');

        Procurement::create($data);
        return redirect()->route('user.procurement')->with('success_message', 'Pengajuan berhasil diajukan!');

    }

    public function destroy($id)
    {
        Procurement::find($id)->delete();

        return redirect()->route('user.procurement')->with('success', 'Satu item berhasil dihapus !');
    }
}
