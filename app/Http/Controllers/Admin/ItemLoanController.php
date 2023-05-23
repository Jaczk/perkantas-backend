<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item_Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemLoanController extends Controller
{
    public function index()
    {
        $loans = Item_Loan::with([
            'loan',
            'good',
        ])->get();

        dd($loans);

        // return view('admin.loans', ['loans'=> $loans]);
    }
    public function destroy($id)
    {
        
        Item_Loan::find($id)->delete();

        return redirect()->route('admin.loan')->with('success', 'One item has been deleted !');
    }
}
