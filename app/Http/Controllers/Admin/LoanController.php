<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Fine;
use App\Models\Good;
use App\Models\Loan;
use App\Models\User;
use App\Models\Item_Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LoanController extends Controller
{
    public function index(Request $request)
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
        $loanDrop = Loan::groupBy('period')->select('period')->get();
        $period = $request->period ?? Carbon::now()->format('Ym');
        $type = $request->type ?? 'peminjaman';
        //$period = Carbon::now()->format('Ym'); // Replace 'desired_period_value' with the desired period

        $chartData = $this->loanChart($period, $type);

        return view('admin.loans-item', [
            'loans' => $loans,
            'chartData' => $chartData,
            'period' => $period,
            'loanDrop' => $loanDrop,
            'type' => $type
        ]);
    }

    public function loanChartAjax($period)
    {
        $chartData = $this->loanChart($period);

        return response()->json($chartData);
    }

    public static function loanChart($period)
    {
        $loanChart = Loan::where('period', $period)
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date, COUNT(*) as count')
            ->get();

        $returnChart = Loan::where('period', $period)
            ->where('is_returned', 1)
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date, COUNT(*) as count')
            ->get();

        // Get distinct dates from both datasets
        $dates = collect($returnChart->pluck('date'))
            ->concat($loanChart->pluck('date'))
            ->unique();

        // Create an empty array to hold the chart data
        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Dikembalikan',
                    'data' => [],
                    'backgroundColor' => 'rgba(54, 162, 235, 1)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'fill' => false,
                    'type' => 'bar'
                ],
                [
                    'label' => 'Dipinjam',
                    'data' => [],
                    'backgroundColor' => 'rgba(255, 99, 132, 1)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'fill' => false,
                    'type' => 'bar'
                ]
            ]
        ];

        // Populate the chart data with the available return and loan values
        foreach ($dates as $date) {
            $returnCount = $returnChart->firstWhere('date', $date);
            $loanCount = $loanChart->firstWhere('date', $date);

            // Add the date to the labels array
            $chartData['labels'][] = $date;

            // Add the return count or 0 if not available
            if ($returnCount) {
                $chartData['datasets'][0]['data'][] = $returnCount->count;
            } else {
                $chartData['datasets'][0]['data'][] = 0;
            }

            // Add the loan count or 0 if not available
            if ($loanCount) {
                $chartData['datasets'][1]['data'][] = $loanCount->count;
            } else {
                $chartData['datasets'][1]['data'][] = 0;
            }
        }

        return $chartData;
    }


    public function calculateFine($returnDate)
    {
        $fine = 0;

        $fineValue = Fine::where('fine_name', 'loan_fine')->first();

        if ($returnDate < Carbon::today()) {
            $diffInDays = Carbon::today()->diffInDays($returnDate);
            $fine = ($diffInDays + 1) * $fineValue->value;
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
