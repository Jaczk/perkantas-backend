<?php

namespace App\Http\Controllers\Admin;

use App\Models\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item_Loan;
use App\Models\Loan;
use App\Models\Procurement;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $goods = Good::count();
        $procurements = Procurement::where('status', 'pending')->count();
        $loans = Loan::withWhereHas('item_loan', function ($q) {
            $q->WhereHas('good');})
            ->withWhereHas('user')
            ->where('is_returned', 0)->count();
        $returnLate = Loan::where('is_returned', 0)
            ->whereDate('return_date', '<', Carbon::today())
            ->count();
        $brokenItem = Good::where('condition', 'broken')->count();
        $userActive = User::where('can_return', 1)->where('roles', 0)->count();

        return view('admin.dashboard', [
            'goods' => $goods,
            'procurements' => $procurements,
            'loans' => $loans,
            'returnLate' => $returnLate,
            'brokenItem' => $brokenItem,
            'userActive' => $userActive
        ]);
    }
}
