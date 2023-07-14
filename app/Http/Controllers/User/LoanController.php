<?php

namespace App\Http\Controllers\User;

use Exception;
use Throwable;
use Carbon\Carbon;
use App\Models\Fine;
use App\Models\Good;
use App\Models\Loan;
use App\Models\User;
use App\Models\Item_Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

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

        $loans = Loan::with('item_loan')->where('user_id', $user->id)->where('is_returned', 0)->get();

        foreach ($loans as $loan) {
            // Check if the loan doesn't have any associated item loans
            if ($loan->item_loan->isEmpty()) {
                // Delete the loan
                $loan->forceDelete();
            }
        }

        // Calculate and update the fine for each loan
        $loans->each(function ($loan) {
            $fine = $this->calculateFine($loan->return_date);
            $loan->fine = $fine;
            $loan->save();
        });

        return view('user.loans', compact('items', 'filteredItems', 'user'));
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

    public function store(Request $request)
    {
        $data  = $request->except('_token');

        $data['user_id'] = auth()->user()->id;
        $data['return_date'] = Carbon::now()->addDays(1);
        $data['due_date'] = Carbon::now()->addDays(14);
        $data['period'] = Carbon::now()->format('Ym');

        $loan = Loan::create($data);
        
        return redirect()->route('user.loan-items', ['loanId' => Crypt::encrypt($loan->id)]);
    }

    public function listItems($loanId)
    {
        session()->put('loanId', Crypt::decrypt($loanId));

        $goods = Good::with('category')->where('is_available', 1)->get();

        return view('user.loan-items', compact('goods'));
    }

    public function addItems(Request $request, $id)
    {
        $data  = $request->except('_token');

        $good = Good::findOrFail($id);

        $data['loan_id'] = session()->get('loanId');
        $data['good_id'] = $good->id;
        $data['user_id'] = auth()->user()->id;

        Item_Loan::create($data);

        $good->update([
            'is_available' => 0
        ]);

        return redirect()->back()->with('refresh', true);
    }


    public function summary()
    {
        $loanId = session()->get('loanId');
        session()->flash('loanId', $loanId);

        return redirect()->route('user.user-summary');
    }

    public function userSummary()
    {
        $loanId = session()->get('loanId');

        $items = Item_Loan::with('good')
            ->where('loan_id', $loanId)
            ->get();

        return view('user.loan-summary', compact('items'));
    }

    public function deleteItems($id)
    {
        $item = Item_Loan::find($id);

        Good::find($item->good_id)->update([
            'is_available' => 1
        ]);

        $item->forceDelete();

        return redirect()->back()->with('refresh', true);
    }

    public function return()
    {
        $loans = Loan::withWhereHas('item_loan', function ($q) {
            $q->WhereHas('good');
        })
            ->where('user_id', auth()->user()->id)
            ->where('is_returned', 0)
            ->get();

        return view('user.user-return', compact('loans'));
    }

    public function returnItems($id)
    {
        try {
            $loan = Loan::find($id);

            $items = Item_Loan::with('good')
                ->where('loan_id', $loan->id)
                ->get();

            foreach ($items as $item) {
                Good::find($item->good->id)->update([
                    'is_available' => 1
                ]);
            }

            $loan->update([
                'is_returned' => 1
            ]);
            return redirect()->route('user.loan')->with('success', 'Pengembalian berhasil dilakukan!');
        } catch (Throwable $e) {
            report($e);
        }
    }
}
