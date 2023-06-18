<?php

namespace App\Http\Controllers\User;

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
        $goods = Goods::where('is_available', '=', 1)->count();
        $procurements = Procurement::where('user_id', auth()->user()->id)->count();
        $items = Item_Loan::query()->whereHas('loan', function ($q) {
            $q->where('user_id', Auth::user()->id)->where('is_returned', '=', 0);
        })->count();
        return view('user.dashboard', [
            'goods' => $goods,
            'procurements' => $procurements,
            'items' => $items,
        ]);
    }
}
