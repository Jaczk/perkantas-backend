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
        $newItem = Good::where('condition', 'new')->count();
        $normalItem = Good::where('condition', 'used')->count();
        $userActive = User::where('can_return', 1)->where('roles', 0)->count();

        $period = Carbon::now()->format('Ym'); // Replace 'desired_period_value' with the desired period

        $chartData = $this->procurementChart($period);

        // Set the initial selected period
        $selectedPeriod = $period;

        $procurementPeriod = Procurement::where('period', $period)
            ->groupBy('goods_name')
            ->select('goods_name', DB::raw('COUNT(*) as count'))
            ->get();

        return view('admin.dashboard', compact(
            'goods',
            'procurements',
            'loans',
            'returnLate',
            'brokenItem',
            'newItem',
            'normalItem',
            'userActive',
            'chartData',
            'selectedPeriod',
            'procurementPeriod',
            'selectedPeriod'
        ));
    }

    public static function procurementChart($period)
    {
        $data = Procurement::where('period', $period)
            ->groupBy('goods_name')
            ->select('goods_name', DB::raw('COUNT(*) as count'))
            ->get();

        $chartData = [
            'labels' => $data->pluck('goods_name'),
            'values' => $data->pluck('count'),
            'period' => $period,
        ];

        return $chartData;
    }
}
