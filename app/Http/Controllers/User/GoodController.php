<?php

namespace App\Http\Controllers\User;

use App\Models\Good;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $goods = Good::with([
            'category',
            'item_loan'
        ])->whereHas('category', function ($q) {
            $q->whereNull('deleted_at');
        })->get();

        return view('user.goods', ['goods' => $goods, 'categories' => $categories]);
    }

    public function sortedByCategory($id)
    {
        $goods = Good::whereHas('category', function ($q) use ($id) {
            $q->where('id', $id);
        })->get();

        return view('user.goods-category', ['goods' => $goods]);
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('query');

        // Perform the search query to fetch matching goods
        $goods = Good::where('goods_name', 'like', '%' . $searchQuery . '%')
            ->orWhere('description', 'like', '%' . $searchQuery . '%')
            ->get();

        return view('user.goods-search', compact('goods', 'searchQuery'));
    }
}
