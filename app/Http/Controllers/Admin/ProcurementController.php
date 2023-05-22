<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use Illuminate\Http\Request;

class ProcurementController extends Controller
{
    public function index(){
        $procurements = Procurement::all();

        return view('admin.procurements', ['procurements'=>$procurements]);
    }
    public function delete($id){

        Procurement::find($id)->delete();

        return redirect()->route('admin.procurement')->with('success', 'One item has been deleted !');
    }
}
