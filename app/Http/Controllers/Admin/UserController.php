<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        foreach ($users as $user) {

            $loans = Loan::where('user_id', $user->id)->with('item_loan')->get();

            $filteredLoan = $loans->filter(function ($loan) {
                return $loan->is_returned === 0;
            });

            $filteredLoan->each(function ($loan) {

                if ($loan->item_loan->isEmpty()) {
                    // Delete the loan
                    $loan->delete();
                }

                $fine = $this->calculateFine($loan->return_date);
                $loan->fine = $fine;
                $loan->save();
            });

            $totalFine = $filteredLoan->sum('fine');

            $user->total_fine = $totalFine;
            $user->save();
        }

        return view('admin.users', ['users' => $users, 'loans' => $loans, 'filteredLoan' => $filteredLoan]);
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

    public function edit($id)
    {
        $user = User::find($id);

        return view('admin.user-edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');

        $request->validate([
            'phone' => 'required|string',
            'can_return' => 'required',
        ]);

        $user = User::find($id);

        $user->update($data);
        return redirect()->route('admin.user')->with('success', 'User updated successfully');
    }

    public function userAccess()
    {
        User::where('roles', 0)->update(['can_return' => 0]);

        return redirect()->route('admin.user')->with('success', 'Reset access to all users succesfully!');
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->route('admin.user')->with('success', 'One user has been deleted !');
    }
}
