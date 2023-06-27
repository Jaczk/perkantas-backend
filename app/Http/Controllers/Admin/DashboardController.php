<?php

namespace App\Http\Controllers\Admin;

use App\Models\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Procurement;

class DashboardController extends Controller
{
    public function index()
    {
        $goods = Good::count();
        $procurements = Procurement::where('status', 'pending')->count();
        $loans = Loan::where('is_returned', 0)->count();
        // $loans = Loan::where('is_returned', 1)->count();

        return view('admin.dashboard', [
            'goods' => $goods,
            'procurements' => $procurements,
            'loans' => $loans]);
    }

}
