@extends('admin.layouts.base')

@section('title', 'Procurements')

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
                <h3 class="card-title">Edit Procurements</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form enctype="multipart/form-data" method="POST" action="{{ route('admin.procurement.update', $procurements->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Select Status :</label>
                            <select class="custom-select font-weight-bold" name="status">
                                <option class="text-info font-weight-bold" value="pending" @selected($procurements->status == "pending")>PENDING</option>
                                <option class="text-success font-weight-bold" value="approved" @selected($procurements->status == "approved")>APPROVED</option>
                                <option class="text-danger font-weight-bold" value="rejected" @selected($procurements->status == "rejected")>REJECTED</option>
                            </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
