<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();

        foreach ($users as $user) {

            $loans = Loan::where('user_id', $user->id)->with('item_loan')->get();

            $filteredLoan = $loans->filter(function ($loan) {
                return $loan->is_returned === 0;
            });

            $filteredLoan->each(function ($loan) {

                if ($loan->item_loan->isEmpty()) {
                    // Delete the loan
                    $loan->forceDelete();
                }

                $fine = $this->calculateFine($loan->return_date);
                $loan->fine = $fine;
                $loan->save();
            });

            $totalFine = $filteredLoan->sum('fine');

            $user['total_fine'] = $totalFine;
            $user->save();
        }

        return view('admin.users', ['users' => $users, 'loans' => $loans, 'filteredLoan' => $filteredLoan]);
    }
    
    
    public function calculateFine($returnDate)
    {
        $fine = 0;

        $date = substr($returnDate, 0, 10);

        $filteredReturnDate = $date . " 00:00:00";
        $fineValue = Fine::where('fine_name', 'loan_fine')->first();

        if ($filteredReturnDate < Carbon::today()) {
            $diffInDays = Carbon::today()->diffInDays($filteredReturnDate);
            $fine = ($diffInDays ) * $fineValue->value;
        }

        return $fine;
    }

    public function edit($id)
    {
        $decryptId = Crypt::decryptString($id);
        $user = User::find($decryptId);
        $roles = Role::all();
        return view('admin.user-edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');

        $request->validate([
            'role_id'=> 'required',
            'phone' => 'required|max:15|regex:/^\+62\d{0,}$/',
            'can_return' => 'required'
        ]);

        $user = User::find($id);

        $user->update($data);
        return redirect()->route('admin.user')->with('success', 'Berhasil memperbarui data pengguna');
    }

    public function userAccess()
    {
        User::where('role_id', 2)->update(['can_return' => 0]);

        return redirect()->route('admin.user')->with('success', 'Reset akses peminjaman barang ke semua pengguna berhasil !');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $hasActiveLoans = $user->whereHas('loan', function ($q) {
            $q->where('is_returned', 0);
        })->exists();

        if ($hasActiveLoans) {
            return redirect()->route('admin.user')->with('error', 'Gagal menghapus akun pengguna, karena pengguna masih memiliki pinjaman aktif !');
        }

        $user->delete();
        
        return redirect()->route('admin.user')->with('success', 'Berhasil menghapus akun pengguna !');
    }
}
