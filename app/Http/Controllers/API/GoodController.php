<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Good;
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
            $available = $request->input('is_available');
            $limit = $request->input('limit', 10);

            $goodQuery = Good::query()->withWhereHas('category');

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

            if ($available) {
                $goods->where('is_available', $available);
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
            if ($request->hasFile('image'))
            {
                $path = $request->file('image')->store('public/images');
            }

            //Create Good Data
            $goods = Good::create([
                'goods_name' => $request->input('goods_name'),
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
