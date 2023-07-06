<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\User;
use App\Models\Item_Loan;
use App\Models\Procurement;
use Illuminate\Http\Request;
use App\Models\Good as Goods;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $goods = Goods::where('is_available', 1)->count();
        $procurements = Procurement::where('user_id', auth()->user()->id)->count();
        $items = Item_Loan::whereHas('loan', function ($q) {
            $q->where('user_id', Auth::user()->id)->where('is_returned', 0);
        })->count();
        $user = User::findOrFail(auth()->user()->id); // Find the user by ID

        $loans = Loan::with('item_loan')->where('user_id', $user->id)->where('is_returned', 0)->get();

        foreach ($loans as $loan) {
            // Check if the loan doesn't have any associated item loans
            if ($loan->item_loan->isEmpty()) {
                // Delete the loan
                $loan->forceDelete();
            }
        }

        $loanFines = Loan::where('user_id', $user->id)->where('is_returned', 0)->get();

        $loanFines->each(function ($loan) {
            $fine = $this->calculateFine($loan->return_date);
            $loan->fine = $fine;
            $loan->save();
        });

        $totalFine = $loanFines->sum('fine');

        $user->total_fine = $totalFine;
        $user->save(); // Save the updated total fine value for the user

        return view('user.dashboard', compact('goods', 'procurements', 'items', 'user', 'totalFine'));
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
}
