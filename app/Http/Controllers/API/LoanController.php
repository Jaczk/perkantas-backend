<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $period = $request->input('period');
        $status = $request->input('status');
        $limit = $request->input('limit', 10);

        $loanQuery = Loan::with(['user'])->whereHas('user', function ($query) {
            $query->where('user_id', Auth::user()->id);
        });

        //Get Single Loan data
        if ($id) {
            $loan = $loanQuery->find($id);

            if ($loan) {
                return ResponseFormatter::success(
                    $loan,
                    'Data peminjaman berhasil diambil'
                );
                return ResponseFormatter::error(
                    null,
                    'Data peminjaman tidak berhasil diambil',
                    404
                );
            }
        }

        //Get All Loan data
        $loans = $loanQuery;

        if ($period) {
            $loans->where('period', $period);
        }

        if ($status) {
            $loans->where('status', $status);
        }

        return ResponseFormatter::success(
            $loans->paginate($limit),
            'Data list peminjaman berhasil diambil'
        );
    }

    
}
