<?php

namespace App\Http\Controllers\Admin;
use App\Models\Good;
use App\Models\Item_Loan;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::withWhereHas('item_loan', function ($q) {
            $q->WhereHas('good');
        })->withWhereHas('user')->get();

        // dd($loans);
        return view('admin.loans-item', ['loans' => $loans]);
    }
    public function destroy($id)
    {
        
        Loan::find($id)->delete();

        return redirect()->route('admin.loan')->with('success', 'One item has been deleted !');
    }
}
