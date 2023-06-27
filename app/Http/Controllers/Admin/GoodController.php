<?php

namespace App\Http\Controllers\Admin;

use App\Models\Good;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GoodController extends Controller
{
    public function index()
    {
        $goods = Good::with([
            'category',
            'item_loan'
        ])->whereHas('category', function ($q) {
            $q->whereNull('deleted_at');
        })->get();

        return view('admin.goods', ['goods' => $goods]);
    }

    public function create()
    {
        return view('admin.good-create', ['categories' => Category::all()]);
    }

    public function edit($id)
    {
        $goods = Good::find($id);
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
            'image' => 'required|image|mimes:jpg,jpeg,png'
        ]);

        $image = $request->image; //request
        $ogImageName = Str::random(8) . $image->getClientOriginalName(); //changeName
        $image->storeAs('public/images', $ogImageName); //save in storageProj
        $data['image'] = $ogImageName; //inject data only w/ file name
        // dd($data);
        Good::create($data);
        return redirect()->route('admin.good')->with('success', 'Goods created');
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
            'image' => 'required|image|mimes:jpg,jpeg,png'
        ]);

        $good = Good::find($id);

        if ($request->image) {
            $image = $request->image; //request
            $ogImageName = Str::random(8) . $image->getClientOriginalName(); //changeName
            $image->storeAs('public/images', $ogImageName); //save in storageProj
            $data['image'] = $ogImageName; //inject data only w/ file name
            //delete old image
            Storage::delete('public/images/'.$good->image);
        }
        // dd($data);
        $good->update($data);
        return redirect()->route('admin.good')->with('success', 'Updated success');
    }

    public function destroy($id)
    {
        Good::find($id)->delete();

        return redirect()->route('admin.good')->with('success', 'Deleted success');
    }
}
