<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Good;
use App\Models\Loan;
use App\Models\User;
use App\Models\Item_Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        return view('user.loans', compact('items', 'filteredItems', 'user'));
    }

    public function addItems(Request $request, $id)
    {
        $data  = $request->except('_token');

        $loanId = session('loan_id');
        $good = Good::findOrFail($id);

        $data['loan_id'] = $loanId;
        $data['good_id'] = $good->id;
        $data['user_id'] = auth()->user()->id;

        Item_Loan::create($data);

        Good::find($id)->update([
            'is_available' => 0
        ]);
    }

    public function store(Request $request)
    {
        $data  = $request->except('_token');

        $data['user_id'] = auth()->user()->id;
        $data['return_date'] = Carbon::now()->addDays(7);
        $data['due_date'] = Carbon::now()->addDays(14);
        $data['period'] = Carbon::now()->format('Ym');

        $loan = Loan::create($data);

        session()->put('loan_id', $loan->id);
        // Store the data or perform any other necessary actions

        return redirect()->route('user.loan-create')->with('success', 'Peminjaman Berhasil Dilakukan!');
    }

    public function return()
    {
        $loans = Loan::with('item_loan')
            ->whereHas('item_loan', function ($q) {
                $q->WhereHas('good');
            })
            ->where('user_id', auth()->user()->id)
            ->where('is_returned', 0)
            ->get();

        return view('user.user-return', compact('loans'));
    }

    public function returnItems($id)
    {
        $loan = Loan::findOrFail($id);

        $loan->update([
            'is_returned' => 1
        ]);

        $items = Item_Loan::with('good')
            ->where('loan_id', $loan->id)
            ->get();

        foreach ($items as $item) {
            Good::find($item->good_id)->update([
                'is_available' => 1
            ]);
        }
        return redirect()->route('user.loan')->with('success', 'Pengembalian berhasil dilakukan!');
    }
}
