<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Good;
use App\Models\Loan;
use App\Models\User;
use App\Models\Item_Loan;
use App\Models\Procurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $goods = Good::count();
        $procurements = Procurement::where('status', 'not_added')->count();
        $loans = Loan::withWhereHas('item_loan', function ($q) {
                $q->whereHas('good');
            })
            ->withWhereHas('user')
            ->where('is_returned', 0)->count();
        $returnLate = Loan::withWhereHas('item_loan', function ($q) {
                $q->whereHas('good');
            })
            ->where('is_returned', 0)
            ->whereDate('return_date', '<', Carbon::today())
            ->count();
        $brokenItem = Good::where('condition', 'broken')->count();
        $userActive = User::where('can_return', 1)->where('roles', 0)->count();
        
        $period = 'desired_period_value'; // Replace 'desired_period_value' with the desired period
        
        $chartData = $this->procurementChart($period);

        return view('admin.dashboard', compact(
            'goods',
            'procurements',
            'loans',
            'returnLate',
            'brokenItem',
            'userActive',
            'chartData'
        ));
    }

    public function procurementChart($period)
    {
        $data = Procurement::where('period', $period)
            ->groupBy('goods_name')
            ->select('goods_name', DB::raw('count(*) as count'))
            ->get();

        $chartData = [
            'labels' => $data->pluck('goods_name'),
            'values' => $data->pluck('count'),
        ];

        return $chartData;
    }
}

