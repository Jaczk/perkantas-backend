<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $id = $request->input('id');
            $category_name = $request->input('category_name');
            $limit = $request->input('limit', 10);

            $categoryQuery = Category::query();

            //Get Single Category data
            if ($id) {
                $category = $categoryQuery->find($id);

                if ($category) {
                    return ResponseFormatter::success(
                        $category,
                        'Data kategori berhasil diambil'
                    );
                    return ResponseFormatter::error(
                        null,
                        'Data kategori tidak berhasil diambil',
                        404
                    );
                }
            }

            //Get All Category data
            $categories = $categoryQuery;

            if ($category_name) {
                $categories->where('category_name', 'like', '%', $category_name, '%');
            }

            return ResponseFormatter::success(
                $categories->paginate($limit),
                'Data list kategori berhasil diambil'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data kategori gagal diambil', 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $category = Category::create([
                'category_name' => $request->input('category_name'),
            ]);

            return ResponseFormatter::success(
                $category,
                'Data kategori berhasil ditambahkan'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data kategori gagal ditambahkan', 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update([
                'category_name' => $request->input('category_name'),
            ]);

            return ResponseFormatter::success(
                $category,
                'Data kategori berhasil diperbarui'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data kategori gagal diperbarui', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            $category->delete();

            return ResponseFormatter::success(
                null,
                'Data kategori berhasil dihapus'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data kategori gagal dihapus', 500);
        }
    }
}
