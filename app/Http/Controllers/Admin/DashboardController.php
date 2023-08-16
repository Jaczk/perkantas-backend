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
    public function index(Request $request)
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
        $userActive = User::where('can_return', 1)->where('role_id', 2)->count();

        $procurementDrop = Procurement::groupBy('period')->select('period')->get();

        $period = $request->period ?? Carbon::now()->format('Ym');
        $chartData = $this->procurementChartAjax($request->period);

        $itemChartData = $this->itemLoanChartAjax($request->period);

        $itemDrop = Loan::groupBy('period')->select('period')->get();

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
            'procurementDrop',
            'itemChartData',
            'itemDrop',
            'period'

        ));
    }

    public function procurementChartAjax($period)
    {
        $chartData = $this->procurementChart($period);

        return response()->json($chartData);
    }


    public static function procurementChart($period)
    {
        $data = Procurement::where('period', $period)
            ->groupBy('goods_name')
            ->select('goods_name', DB::raw('COUNT(*) as count'), DB::raw('SUM(goods_amount) as total'))
            ->get();

        $chartData = [
            'labels' => $data->pluck('goods_name')->toArray(),
            'datasets' => [
                [
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => [
                        '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
                        '#9BE8D8', '#CBFFA9', '#9BCDD2', '#E1AEFF', '#0079FF', '#FDCEDF', '#B799FF',
                        '#D25380', '#E3F2C1', '#6C9BCF', '#408E91'
                    ]
                ]
            ]
        ];

        return $chartData;
    }

    public function itemLoanChartAjax($period)
    {
        $itemChartData = $this->itemLoanChart($period);

        return response()->json($itemChartData);
    }

    public static function itemLoanChart($period)
    {
        $data = Item_Loan::whereHas('loan', function ($q) use ($period) {
            $q->where('period', $period);
        })->join('goods', 'item__loans.good_id', '=', 'goods.id')
            ->groupBy('goods.goods_name')
            ->select('goods.goods_name', DB::raw('COUNT(*) as count'))
            ->get();

        $itemChartData = [
            'labels' => $data->pluck('goods_name')->toArray(),
            'datasets' => [
                [
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => [
                        '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
                        '#9BE8D8', '#CBFFA9', '#9BCDD2', '#E1AEFF', '#0079FF', '#FDCEDF', '#B799FF',
                        '#D25380', '#E3F2C1', '#6C9BCF', '#408E91'
                    ]
                ]
            ]
        ];

        return $itemChartData;
    }
}
