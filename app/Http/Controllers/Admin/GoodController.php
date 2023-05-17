<?php

namespace App\Http\Controllers\Admin;

use App\Models\Good;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        return view('admin.good-create',['categories' => Category::all()]);
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
            'image' => 'required|string'
        ]);

        $image = $request->image;
        $url = "https://source.unsplash.com/150x150?";
        $imageUrl = $url.$image;

        $data['image'] = $imageUrl;
        // dd($data);
        Good::create($data);
        return redirect()->route('admin.good')->with('success', 'Goods created');
    }

}
