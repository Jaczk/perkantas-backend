<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class FineController extends Controller
{
    public function index()
    {
        $fine = Fine::all();

        return view('admin.fine',['fines'=> $fine]);
    }

    public function create()
    {
        return view('admin.fine-create');
    }

    public function edit($id)
    {

        $decryptId = Crypt::decryptString($id);

        $fine = Fine::find($decryptId);

        return view('admin.fine-edit',['fine'=> $fine]);
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        
        $request->validate([
            'fine_name' => 'required|string',
            'value' => 'required|integer'
        ]);

        Fine::create($data);
        return redirect()->route('admin.fine')->with('success', 'Denda berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');

        $request->validate([
            'fine_name' => 'required|string',
            'value' => 'required|integer'
        ]);

        $fine = Fine::find($id);

        $fine->update($data);
        return redirect()->route('admin.fine')->with('success', 'Sukses memperbarui denda');

    }

    public function destroy($id)
    {
        Fine::find($id)->delete();

        return redirect()->route('admin.fine')->with('success', 'Denda berhasil dihapus');
    }

    public function trash(){
        $trash = Fine::onlyTrashed()->get();
        return view('admin.fine-trashed',['trash' => $trash]);
    }

    public function restore($id){
        $trash = Fine::withTrashed()->find($id);
        $trash->restore();
        return redirect()->route('admin.fine.trash')->with('success', 'Data berhasil dipulihkan.');
    }

    public function forceDelete($id){
        $trash = Fine::withTrashed()->find($id);
        $trash->forceDelete();
        return redirect()->route('admin.fine.trash')->with('success', 'Data berhasil dihapus');
    }
}
