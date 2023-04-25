<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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

    public function create(Request $request)
    {
        try {
            //Create Loan
            $loan = Loan::create([
                'user_id' => Auth::user()->id,
                'return_date' => $request->input('return_date'),
                'due_date' => Carbon::now()->addDays(14),
                'period' => Carbon::now()->format('Ym'),
            ]);

            //Jika ada yang salah, maka akan throw error
            if (!$loan) {
                throw new Exception('Data Peminjaman tidak berhasil ditambahkan');
            }

            //Return Response
            return ResponseFormatter::success(
                $loan,
                'Data Peminjaman berhasil ditambahkan'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Create Loan Failed', 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            //Get Loan by ID
            $loan = Loan::findOrFail($id);

            //Update Loan
            $loan->update([
                'return_date' => $request->input('return_date'),
                'due_date' => Carbon::now()->addDays(5),
                'period' => Carbon::now()->format('Ym'),
            ]);

            //Return Response
            return ResponseFormatter::success(
                $loan,
                'Data Peminjaman berhasil diupdate'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Update Loan Failed', 500);
        }
    }

    public function destroy($id)
    {
        try {
            //Get Loan by ID
            $loan = Loan::find($id);

            if (!$loan) {
                return ResponseFormatter::error(
                    null,
                    'Data peminjaman tidak ada',
                    404
                );
            }

            //Delete Loan
            $loan->delete();

            //Return Response
            return ResponseFormatter::success(
                $loan,
                'Data Peminjaman berhasil dihapus'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Delete Loan Failed', 500);
        }
    }
}
