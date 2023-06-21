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

        $loanItems = Loan::where('user_id', $user->id)->get();

        $filteredLoan = $loanItems->filter(function ($loan) {
            return $loan->is_returned === 0;
        });

        $filteredLoan->each(function ($item) {
            $fine = $this->calculateFine($item->return_date);
            $item->fine = $fine;
            $item->save();
        });

        $totalFine = $filteredLoan->sum('fine');

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
