@extends('admin.layouts.base')

@section('title', 'Pengadaan')

@section('content')
<div class="row">
    <div class="col-md-12">

        {{-- Alert Here --}}
        @if ($errors->any())    
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error )
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Pengadaan barang</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form enctype="multipart/form-data" method="POST" action="{{ route('admin.procurement.update', $procurements->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Pilih Status :</label>
                            <select {{-- conditional status --}}
                            class="custom-select font-weight-bold" 
                            {{-- @if ($procurements->status === "pending")
                                class="custom-select font-weight-bold text-info" 
                            @elseif($procurements->status === "approved")
                                class="custom-select font-weight-bold text-success" 
                            @else
                                class="custom-select font-weight-bold text-danger" 
                            @endif --}}
                            name="status">
                                <option class="text-info font-weight-bold" value="pending" @selected($procurements->status == "pending")>MENUNGGU</option>
                                <option class="text-success font-weight-bold" value="approved" @selected($procurements->status == "approved")>DITERIMA</option>
                                <option class="text-danger font-weight-bold" value="rejected" @selected($procurements->status == "rejected")>DITOLAK</option>
                            </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
