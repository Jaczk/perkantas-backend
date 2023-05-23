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
        $loans = Loan::withWhereHas('user')->get();

        return view('admin.loans', ['loans' => $loans]);
    }
    public function destroy($id)
    {
        
        Loan::find($id)->delete();

        return redirect()->route('admin.loan')->with('success', 'One item has been deleted !');
    }
}
