<?php

namespace App\Http\Controllers\Admin;

use App\Models\Good;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;


class GoodController extends Controller
{
    public function index()
    {
        $goods = Good::with(['category', 'item_loan'])
            ->whereHas('category', function ($q) {
                $q->whereNull('deleted_at');
            })->get();

        $availableGoods = Good::where('is_available', 1)->count();
        $unavailableGoods = Good::where('is_available', 0)->count();

        $goodCategories = Good::join('categories', 'goods.category_id', '=', 'categories.id')
            ->selectRaw('count(*) as total, categories.category_name')
            ->groupBy('categories.category_name')
            ->get();

        return view('admin.goods', [
            'goods' => $goods,
            'availableGoods' => $availableGoods,
            'unavailableGoods' => $unavailableGoods,
            'goodCategories' => $goodCategories
        ]);
    }


    public function create()
    {
        return view('admin.good-create', ['categories' => Category::all()]);
    }

    public function edit($id)
    {
        $decryptId = Crypt::decryptString($id);
        $goods = Good::find($decryptId);
        $categories = Category::all();

        return view('admin.good-edit', ['goods' => $goods, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $request->validate([
            'category_id' => 'required',
            'goods_name' => 'required|string',
            'condition' => 'required|string',
            'is_available' => 'nullable',
            'description' => 'required|string',
            'image' => 'image|mimes:jpg,jpeg,png'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ogImageName = Str::random(8) . $image->getClientOriginalName();

            // Compress and convert to WebP
            $compressedImage = Image::make($image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 75); // Adjust compression quality as needed

            // Save the compressed and converted image
            $compressedImage->save(storage_path('app/public/images/' . $ogImageName));

            $data['image'] = $ogImageName;
        }

        Good::create($data);
        return redirect()->route('admin.good')->with('success', 'Barang berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $request->validate([
            'category_id' => 'required',
            'goods_name' => 'required|string',
            'condition' => 'required|string',
            'is_available' => 'nullable',
            'description' => 'required|string',
            'image' => 'image|mimes:jpg,jpeg,png'
        ]);

        $good = Good::find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ogImageName = Str::random(8) . $image->getClientOriginalName();

            // Compress and convert to WebP
            $compressedImage = Image::make($image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 75); // Adjust compression quality as needed

            // Save the compressed and converted image
            $compressedImage->save(storage_path('app/public/images/' . $ogImageName));

            $data['image'] = $ogImageName;

            // Delete the old image
            Storage::delete('public/images/' . $good->image);
        }

        $good->update($data);
        return redirect()->route('admin.good')->with('success', 'Sukses memperbarui item barang');
    }

    public function destroy($id)
    {
        $good = Good::find($id);

        // Check if any associated ItemLoan records have is_returned = 0
        $hasActiveLoans = $good->item_loan()->whereHas('loan', function ($query) {
            $query->where('is_returned', 0);
        })->exists();

        if ($hasActiveLoans) {
            return redirect()->route('admin.good')
            ->with('error', 'Gagal menghapus item barang. Item barang masih dipinjam.');
        }

        // If there are no active loans, proceed with deletion
        $good->forceDelete();

        return redirect()->route('admin.good')->with('success', 'Berhasil menghapus item barang');
    }


    public function trash()
    {
        $trash = Good::onlyTrashed()->get();
        return view('admin.goods-trashed', ['trash' => $trash]);
    }

    public function restore($id)
    {
        $trash = Good::withTrashed()->find($id);
        $trash->restore();
        return redirect()->route('admin.good.trash')->with('success', 'Data berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $trash = Good::withTrashed()->find($id);
        $trash->forceDelete();
        return redirect()->route('admin.good.trash')->with('success', 'Data berhasil dihapus');
    }
}
