<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use Illuminate\Http\Request;
use App\Enums\ServerStatus;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Crypt;

class ProcurementController extends Controller
{
    public function index()
    {
        $procurements = Procurement::withWhereHas('user')
            ->orderBy('created_at', 'desc')->get();

        return view('admin.procurements', ['procurements' => $procurements]);
    }

    public function edit($id)
    {
        $decryptId = Crypt::decryptString($id);
        $procurements = Procurement::find($decryptId);
        return view('admin.procurement-edit', ['procurements' => $procurements]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $request->validate([
            'status' => 'required',
        ]);

        $procurement = Procurement::find($id);
        $procurement->update($data);
        return redirect()->route('admin.procurement')->with('success', 'Berhasil memperbarui data pengajuan barang');
    }

    public function delete($id)
    {
        Procurement::find($id)->delete();

        return redirect()->route('admin.procurement')->with('success', 'One item has been deleted !');
    }
}
