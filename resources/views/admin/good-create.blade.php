@extends('admin.layouts.base')

@section('title', 'Goods')

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
                <h3 class="card-title">Create Goods</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form enctype="multipart/form-data" method="POST" action="{{ route('admin.good.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" class="form-control" id="goods_name" name="goods_name"
                            placeholder="Guitar / Bible / Projector {english}" value="{{ old('goods_name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="custom-select" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trailer">Condition</label>
                        <input type="text" class="form-control" id="condition" name="condition"
                            placeholder="broken/new/used" value="{{ old('condition') }}">
                    </div>
                    <div class="form-group">
                        <label>Availability</label>
                        <select class="custom-select" name="is_available)">
                            <option value="1" {{ old('is_available') === '1' ? "selected" : "" }}>Available</option>
                            <option value="0" {{ old('is_available') === '0' ? "selected" : "" }}>Not Available</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="short-about">Description</label>
                        <input type="text" class="form-control" id="description" name="description"
                            placeholder="Proyektor dengan resolusi 1080p" value="{{ old('description') }}">
                    </div>
                    <div class="form-group">
                        <label for="short-about">Image</label>
                        <input type="text" class="form-control" id="image" name="image"
                            placeholder="diisi sama dengan field name" value="{{ old('image') }}">
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
