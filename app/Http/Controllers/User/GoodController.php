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
        $categories = Category::has('good')->get();

        $goods = Good::with([
            'category'
        ])->get();

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
            ->get();

        return view('user.goods-search', compact('goods', 'searchQuery'));
    }
}
