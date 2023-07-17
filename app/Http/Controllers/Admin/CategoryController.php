<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Crypt;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories',['categories'=> $categories]);
    }

    public function create()
    {
        return view('admin.category-create');
    }

    public function edit($id)
    {

        $decryptId = Crypt::decryptString($id);

        $category = Category::find($decryptId);

        return view('admin.category-edit',['category'=> $category]);
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        
        $request->validate([
            'category_name' => 'required|string'
        ]);

        Category::create($data);
        return redirect()->route('admin.category')->with('success', 'Kategori berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');

        $request->validate([
            'category_name' => 'required|string'
        ]);

        $category = Category::find($id);

        $category->update($data);
        return redirect()->route('admin.category')->with('success', 'Sukses memperbarui kategori');

    }

    public function destroy($id)
    {
        $category =  Category::find($id);

        $hasActiveGood = $category->has('good')->exists();

        if($hasActiveGood){
            return redirect()->route('admin.category')
            ->with('error', 'Gagal menghapus kategori. Pastikan tidak ada barang yang terkait dengan kategori yang akan dihapus');
        }

        $category->delete();
        return redirect()->route('admin.category')->with('success', 'Kategori berhasil dihapus');
    }

    public function trash(){
        $trash = Category::onlyTrashed()->get();
        return view('admin.categories-trashed',['trash' => $trash]);
    }

    public function restore($id){
        $trash = Category::withTrashed()->find($id);
        $trash->restore();
        return redirect()->route('admin.category.trash')->with('success', 'Data berhasil dipulihkan.');
    }

    public function forceDelete($id){
        $trash = Category::withTrashed()->find($id);
        $trash->forceDelete();
        return redirect()->route('admin.category.trash')->with('success', 'Data berhasil dihapus');
    }
}
