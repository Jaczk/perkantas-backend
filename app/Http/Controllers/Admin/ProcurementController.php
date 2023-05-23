<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use Illuminate\Http\Request;
use App\Enums\ServerStatus;
use Illuminate\Validation\Rules\Enum;

class ProcurementController extends Controller
{
    public function index(){
        $procurements = Procurement::withWhereHas('user')->get();

        return view('admin.procurements', ['procurements'=>$procurements]);
    }

    public function edit($id){
        $procurements = Procurement::find($id);

        return view('admin.procurement-edit', ['procurements'=>$procurements]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $request->validate([
            'status' => [new Enum(ServerStatus::class)],
        ]);

        $procurement = Procurement::find($id);
        $procurement->update($data);
        return redirect()->route('admin.procurement')->with('success', 'Updated status success');
    }

    public function delete($id)
    {
        Procurement::find($id)->delete();

        return redirect()->route('admin.procurement')->with('success', 'One item has been deleted !');
    }
}
