<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Item_Loan;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Item_LoanController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            //Get Input User
            $id = $request->input('id');
            //$userID = Auth::user()->id;
            $good_id = $request->input('good_id');
            $loan_id = $request->input('loan_id');
            $limit = $request->input('limit', 10);

            //Query get

            $item_loanQuery = Item_Loan::query()->withWhereHas('loan')->withWhereHas('good');

            // $item_loanQuery = Item_Loan::query()->withWhereHas('good')->with(['loan'])->whereHas('loan', function ($q){
            //     $q->where('user_id', Auth::user()->id);
            // });

            // $item_loanQuery = Item_Loan::with('loan')->whereHas('loan', function ($q){
            //     $q->where('user_id', Auth::user()->id);
            // });
            // with(['loan'])->whereHas('loan', function ($query) {$query->where('user_id', Auth::user()->id)})

            // $item_loanQuery = Item_Loan::query()->with('loan')->whereHas('loan', function ($query) {
            //     $query->where('user_id', Auth::user()->id);
            // })->withWhereHas('good');
            
            // $item_loanQuery = Item_Loan::query()->with('loan')->whereHas('loan', function ($q) {
            //     $q->where('user_id', Auth::user()->id);
            // });

            // $companyQuery = Company::with(['users'])->whereHas('users', function ($query) {
            //     $query->where('user_id', Auth::user()->id);
            // });

            //Get Single Item Loan data
            if ($id) {
                $item_loan = $item_loanQuery->find($id);

                if ($item_loan) {
                    return ResponseFormatter::success(
                        $item_loan,
                        'Data item peminjaman berhasil diambil'
                    );
                } else {
                    return ResponseFormatter::error(
                        null,
                        'Data item peminjaman tidak berhasil diambil',
                        404
                    );
                }
            }

            //Get All Item Loan data
            $item_loans = $item_loanQuery;

            if ($good_id) {
                $item_loans->where('good_id', $good_id);
            }

            //where('good_id', $good_id)
            if ($loan_id) {
                $item_loans->where('loan_id', $loan_id);
            }

            //return Response
            return ResponseFormatter::success(
                $item_loans->paginate($limit),
                'Data list item peminjaman berhasil diambil'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Fetch Item Failed', 500);
        }
    }

    public function create(Request $request)
    {
        try {
            //Get Input User
            $item_loan = Item_Loan::create([
                'good_id' => $request->good_id,
                'loan_id' => $request->loan_id,
            ]);

            //Check if item_loan is success
            if (!$item_loan) {
                return ResponseFormatter::error(
                    null,
                    'Data item peminjaman tidak berhasil ditambahkan',
                    404
                );
            }

            //return Response
            return ResponseFormatter::success(
                $item_loan,
                'Data item peminjaman berhasil ditambahkan'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Create Item Failed', 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            //Get Input User
            $item_loan = Item_Loan::find($id);

            $item_loan->update([
                'good_id' => $request->input('good_id'),
                'loan_id' => $request->input('loan_id'),
            ]);

            //Check if item_loan is success
            if (!$item_loan) {
                return ResponseFormatter::error(
                    null,
                    'Data item peminjaman tidak berhasil diupdate',
                    404
                );
            }

            //return Response
            return ResponseFormatter::success(
                $item_loan,
                'Data item peminjaman berhasil diupdate'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Update Item Failed', 500);
        }
    }

    public function destroy($id)
    {
        try {
            //Get Input User
            $item_loan = Item_Loan::find($id);
            $item_loan->delete();

            //Check if item_loan is success 
            if (!$item_loan) {
                return ResponseFormatter::error(
                    null,
                    'Data item peminjaman tidak berhasil dihapus',
                    404
                );
            }

            //return Response
            return ResponseFormatter::success(
                $item_loan,
                'Data item peminjaman berhasil dihapus'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Delete Item Failed', 500);
        }
    }
}
