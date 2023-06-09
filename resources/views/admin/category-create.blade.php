@extends('admin.layouts.base')

@section('title', 'Kategori')

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
                <h3 class="card-title">Buat Kategori</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form enctype="multipart/form-data" method="POST" action="{{ route('admin.category.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Nama Kategori</label>
                        <input type="text" class="form-control w-50" id="category_name" name="category_name"
                            placeholder="Alat Musik" value="{{ old('category_name') }}">
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
