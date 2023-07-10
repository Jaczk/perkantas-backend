<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Good;
use App\Models\Loan;
use App\Models\User;
use App\Models\Item_Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {

        $loans = Loan::withWhereHas('item_loan', function ($q) {
            $q->WhereHas('good');
        })
            ->withWhereHas('user')
            ->get();

        $users = User::all();

        foreach ($users as $user) {
            $userLoan = Loan::where('user_id', $user->id)->get();

            $filteredLoans = $userLoan->filter(function ($loan) {
                return $loan->is_returned === 0;
            });

            $filteredLoans->each(function ($loan) {
                $fine = $this->calculateFine($loan->return_date);
                $loan->fine = $fine;
                $loan->save();
            });
        }

        foreach ($loans as $loan) {
            if ($loan->item_loan->isEmpty()) {
                // Delete the loan
                $loan->forceDelete();
            }
        }
        $period = 202306;
        //$period = Carbon::now()->format('Ym'); // Replace 'desired_period_value' with the desired period

        $loanChart = Loan::where('period', $period)
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date, COUNT(*) as count')
            ->get();

        $returnChart = Loan::where('period', $period)
            ->where('is_returned', 1)
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date, COUNT(*) as count')
            ->get();

        return view('admin.loans-item', [
            'loans' => $loans,
            'loanChart' => $loanChart,
            'returnChart' => $returnChart,
            'period' => $period
        ]);
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

    public function return($id)
    {
        $items = Item_Loan::with('good')
            ->where('loan_id', $id)
            ->whereHas('loan', function ($q) {
                $q->where('is_returned', 0);
            })
            ->get();

        foreach ($items as $item) {
            Good::find($item->good->id)->update([
                'is_available' => 1
            ]);
        }
        $loan = Loan::find($id);
        $loan->update([
            'is_returned' => 1
        ]);

        return redirect()->route('admin.loans')->with('success', 'Berhasil menyelesaikan peminjaman');
    }


    public function destroy($id)
    {

        Loan::find($id)->delete();

        return redirect()->route('admin.loans')->with('success', 'Berhasil menghapus peminjaman');
    }
}
