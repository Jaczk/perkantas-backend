<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Good;
use App\Models\Loan;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class GoodController extends Controller
{
    public function fetch (Request $request)
    {
        try {
            $id = $request->input('id');
            $goods_name = $request->input('goods_name');
            $condition = $request->input('condition');
            $is_available = $request->input('is_available');
            $category_id = $request->input('category_id');
            $is_returned = $request->input('is_returned');
            //$with_loan = $request->input('with_loan');
            $loanId = $request->input('loan_id');
            $limit = $request->input('limit', 100);

            $goodQuery = Good::query()->withWhereHas('category');

            //$loanFetch = Loan::query()->withWhereHas('items');

            //Get Single Good data
            if ($id) {
                $good = $goodQuery->find($id);

                if ($good) {
                    return ResponseFormatter::success(
                        $good,
                        'Data barang berhasil diambil'
                    );
                    return ResponseFormatter::error(
                        null,
                        'Data barang tidak berhasil diambil',
                        404
                    );
                }
            }

            //Get All Good data
            $goods = $goodQuery;

            if ($goods_name) {
                $goods->where('goods_name', 'like', '%', $goods_name, '%');
            }

            if ($condition) {
                $goods->where('condition', 'like', '%', $condition, '%');
            }

            if ($category_id) {
                $goods->where('category_id', $category_id);
            }

            if ($is_available) {
                $goods->where('is_available', $is_available);
            }

            // if ($is_returned & $loanId) {
            //     $goods->with('item_loan')->whereHas('item_loan', function ($query, $loanId){
            //         $query->where('loan_id', $loanId)->with('loan')->whereHas('loan', function ($query, $is_returned){
            //             $query->where('is_returned', $is_returned);
            //         });
            //     });
            // }

            // if ($is_returned === 1) {
            //      $goods->with(['item_loan'])->whereHas('item_loan', function ($query) {
            //         $query->whereHas('loan', function ($query) {
            //             $query->where('is_returned', 1);
            //         });
            //         });
            //     }
            // }
            if ($is_returned === 1 & $loanId) {
                $goods->with('item_loan')->where('loan_id', $loanId);
            }

            if ($is_returned === 1) {
                $goods->whereHas('item_loan.loan', function ($query) {
                    $query->where('is_returned', 1);
                });
            }
            // if ($is_returned) {
            //     $goods->with(['loan'])->whereHas('loan', function ($query, $is_returned) {
            //         $query->where('is_returned', $is_returned);
            //     });
            // }
            if ($loanId) {
                $goods->with('item_loan')->whereHas('loan_id', $loanId);
            }

            return ResponseFormatter::success(
                $goods->paginate($limit),
                'Data list barang berhasil diambil'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data barang gagal diambil', 500);
        }
    }

    public function create (Request $request)
    {
        try {
            //Upload Images
            // if ($request->hasFile('image'))
            // {
            //     $path = $request->file('image')->store('public/images');
            // }

            $good_name = $request->input('goods_name');
            $path = "https://source.unsplash.com/150x150?{$good_name}";
            //Create Good Data
            $goods = Good::create([
                'goods_name' => $good_name,
                'category_id' => $request->input('category_id'),
                'condition' => $request->input('condition'),
                'description' => $request->input('description'),
                'image' => $path,
            ]);

            //Return error if data isn't stored in database
            if (!$goods) {
                return ResponseFormatter::error(
                    null,
                    'Data barang gagal ditambahkan',
                    404
                );
            }

            //Return success if data is stored in database
            return ResponseFormatter::success($goods, 'Data barang berhasil ditambahkan');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data barang gagal ditambahkan', 500);
        }
    }

    public function update (Request $request, $id)
    {
        try {
            //Find Goods ID
            $goods = Good::find($id);

            //Upload Images Data
            if ($request->hasFile('image'))
            {
                $path = $request->file('image')->store('public/images');
            }

            //Update Goods Data
            $goods->update([
                'goods_name' => $request->input('goods_name'),
                'category_id' => $request->input('category_id'),
                'condition' => $request->input('condition'),
                'description' => $request->input('description'),
                'image' => $path,
            ]);

            if (!$goods) {
                throw new Exception('Data barang tidak ditemukan');
            }

            return ResponseFormatter::success($goods, 'Data barang berhasil diupdate');

        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data barang gagal diupdate', 500);
        }
    }

    public function userUpdate(Request $request, $id)
    {
        try {
            //Find Goods ID
            $goods = Good::find($id);
            //Update Goods Data
            $goods->update([
                'is_available' => $request->input('is_available'),
            ]);

            if (!$goods) {
                throw new Exception('Data barang tidak ditemukan');
            }

            return ResponseFormatter::success($goods, 'Data barang berhasil diupdate');

        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data barang gagal diupdate', 500);
        }
    }

    public function destroy ($id)
    {
        try {
            //Find Goods ID
            $goods = Good::find($id);

            //Check if Goods ID is not found
            if (!$goods) {
                throw new Exception('Data barang tidak ditemukan');
            }

            //Delete Goods Data
            $goods->delete();

            //Return Response
            return ResponseFormatter::success($goods, 'Data barang berhasil dihapus');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data barang gagal dihapus', 500);
        }
    }
}
