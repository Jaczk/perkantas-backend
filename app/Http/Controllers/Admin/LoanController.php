<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Good;
use App\Models\Loan;
use App\Models\User;
use App\Models\Item_Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoanController extends Controller
{
    public function index()
    {

        $loans = Loan::withWhereHas('item_loan', function ($q) {
            $q->WhereHas('good');
        })
            ->withWhereHas('user')
            ->get();

        $users = User::all();

        foreach ($users as $user) {
            $userLoan = Loan::where('user_id', $user->id)->get();

            $filteredLoans = $userLoan->filter(function ($loan) {
                return $loan->is_returned === 0;
            });
            
            $filteredLoans->each(function ($loan) {
                $fine = $this->calculateFine($loan->return_date);
                $loan->fine = $fine;
                $loan->save();
            });
        }

        foreach ($loans as $loan) {
            if ($loan->item_loan->isEmpty()) {
                // Delete the loan
                $loan->forceDelete();
            }
        }
        // dd($loans);
        return view('admin.loans-item', ['loans' => $loans]);
    }

    public function calculateFine($returnDate)
    {
        $fine = 0;

        if ($returnDate < Carbon::today()) {
            $diffInDays = Carbon::today()->diffInDays($returnDate);
            $fine = ($diffInDays + 1) * 5;
        }

        return $fine;
    }

    public function destroy($id)
    {

        Loan::find($id)->delete();

        return redirect()->route('admin.loan')->with('success', 'One item has been deleted !');
    }
}
