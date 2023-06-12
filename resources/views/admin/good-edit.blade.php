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
            <form enctype="multipart/form-data" method="POST" action="{{ route('admin.good.update', $goods->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" class="form-control" id="goods_name" name="goods_name"
                            placeholder="Guitar / Bible / Projector {english}" value="{{ $goods->goods_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="custom-select" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $goods->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Return Access</label>
                            <select class="custom-select" name="condition">
                                <option value = "NEW" @selected($goods->condition == 'NEW')
                                    @class(['bg-warning text-white' => $goods->condition == 'NEW'])
                                    >NEW</option>
                                <option value = "USED" @selected($goods->condition == 'USED')
                                    @class(['bg-warning text-white' => $goods->condition == 'USED'])
                                    >USED</option>
                                <option value = "BROKEN" @selected($goods->condition == 'BROKEN')
                                    @class(['bg-warning text-white' => $goods->condition == 'BROKEN'])
                                    >BROKEN</option>
                            </select>
                    </div>
                    {{-- <div class="form-group">
                        <label for="trailer">Condition</label>
                        <input type="text" class="form-control" id="condition" name="condition"
                            placeholder="broken/new/used" value="{{ $goods->condition }}">
                    </div> --}}
                    <div class="form-group">
                        <label for="short-about">Description</label>
                        <input type="text" class="form-control" id="description" name="description"
                            placeholder="Proyektor dengan resolusi 1080p" value="{{ $goods->description}}">
                    </div>
                    <div class="form-group">
                        <label for="short-about">Image</label>
                        <input type="text" class="form-control" id="image" name="image"
                            placeholder="diisi sama dengan field name"  value = "{{ $goods->goods_name }}">
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
