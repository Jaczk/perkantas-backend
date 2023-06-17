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
        ])->whereHas('category', function($q){
            $q->whereNull('deleted_at');
        })->get();

        return view('user.goods', ['goods' => $goods, 'categories' => $categories]);
    }

    public function search(Request $request, $search)
    {
        $goods = Good::where();
    }
}