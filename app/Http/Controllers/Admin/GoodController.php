<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Good;
use Illuminate\Http\Request;

class GoodController extends Controller
{
    public function index()
    {
        $goods = Good::with([
            'category',
            'item_loan'
        ])->get();

        return view('admin.goods',['goods' => $goods]);
    }

    public function create()
    {
        return view('admin.good-create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $request->validate([
            'category_id' => 'required',
            'goods_name' => 'required|string',
            'condition' => 'required|string',
            'is_available' => 'required',
            'description' => 'required|string',
            'image' => 'required|string'
        ]);
    }

}
