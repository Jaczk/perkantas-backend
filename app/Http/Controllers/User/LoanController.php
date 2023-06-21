<?php

namespace App\Http\Controllers\User;

use Exception;
use Carbon\Carbon;
use App\Models\Good;
use App\Models\Loan;
use App\Models\User;
use App\Models\Item_Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Throwable;

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

        // Calculate and update the fine for each loan
        $filteredItems->each(function ($item) {
            $fine = $this->calculateFine($item->loan->return_date);
            $item->loan->fine = $fine;
            $item->loan->save();
        });

        return view('user.loans', compact('items', 'filteredItems', 'user'));
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


    public function addItems(Request $request, $id)
    {
        $data  = $request->except('_token');

        $good = Good::findOrFail($id);

        $data['loan_id'] = session()->get('loanId');
        $data['good_id'] = $good->id;
        $data['user_id'] = auth()->user()->id;

        Item_Loan::create($data);

        Good::find($id)->update([
            'is_available' => 0
        ]);

        return redirect()->back()->with('refresh', true);
    }

    public function listItems($loanId)
    {
        session()->put('loanId', $loanId);

        $goods = Good::with('category')->where('is_available', 1)->get();

        return view('user.loan-items', compact('goods'));
    }

    public function store(Request $request)
    {
        $data  = $request->except('_token');

        $data['user_id'] = auth()->user()->id;
        $data['return_date'] = Carbon::now()->addDays(7);
        $data['due_date'] = Carbon::now()->addDays(14);
        $data['period'] = Carbon::now()->format('Ym');

        $loan = Loan::create($data);

        return redirect()->route('user.loan-items', ['loanId' => $loan->id]);
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

        Good::find($item->good->id)->update([
            'is_available' => 1
        ]);

        $item->delete();

        return redirect()->back()->with('refresh', true);
    }
}
