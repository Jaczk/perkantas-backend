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
            $good_id = $request->input('good_id');
            $loan_id = $request->input('loan_id');
            $user_id = $request->input('user_id');
            $is_returned = $request->input('is_returned');
            $limit = $request->input('limit', 10);

            //Query get

            $item_loanQuery = Item_Loan::query()->with(['loan','good'])->whereHas('loan', function ($q){
                $q->where('user_id', Auth::user()->id);
            });

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

            if ($user_id) {
                $item_loans->where('user_id', $user_id);
            }

            // if ($is_returned === 1) {
            //     Item_Loan::query()->with(['loan'])->whereHas('loan', function ($q, $is_returned) {
            //         $q->where('is_returned', $is_returned)->where('user_id', Auth::user()->id);
            //     });
            // }

            if ($is_returned === 1) {
                $item_loans->where('is_returned', 1);
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
                'user_id' => Auth::user()->id,
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
