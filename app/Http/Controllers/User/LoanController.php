<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item_Loan;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(auth()->user()->id); // Find the user by ID

        $items = Item_Loan::with(['loan', 'good'])
            ->whereHas('loan', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->get();

        $filteredItems = $items->filter(function ($item) {
            return $item->loan->is_returned === 0;
        });

        return view('user.loans', compact('items', 'filteredItems', 'user'));
    }
}
