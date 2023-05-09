<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();

        return view('admin.categories',['categories'=> $categories]);
    }

    public function create(){
        return view('admin.category-create');
    }

    public function store(Request $request){
        $data = $request->except('_token');
        
        $request->validate([
            'category_name' => 'required|string'
        ]);

        Category::create($data); 
        return redirect()->route('admin.category')->with('success', 'Category created');
    }

}
