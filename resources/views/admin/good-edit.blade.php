@extends('admin.layouts.base')

@section('title', 'Barang')

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
                <h3 class="card-title">Edit Barang</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form enctype="multipart/form-data" method="POST" action="{{ route('admin.good.update', $goods->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Nama</label>
                        <input type="text" class="form-control" id="goods_name" name="goods_name"
                            placeholder="Guitar / Bible / Projector {english}" value="{{ $goods->goods_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="custom-select" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $goods->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Kondisi Barang</label>
                            <select class="custom-select" name="condition">
                                <option value = "BARU" @selected($goods->condition == 'BARU')
                                    @class(['bg-warning text-white' => $goods->condition == 'BARU'])
                                    >BARU</option>
                                <option value = "NORMAL" @selected($goods->condition == 'NORMAL')
                                    @class(['bg-warning text-white' => $goods->condition == 'NORMAL'])
                                    >NORMAL</option>
                                <option value = "RUSAK" @selected($goods->condition == 'RUSAK')
                                    @class(['bg-warning text-white' => $goods->condition == 'RUSAK'])
                                    >RUSAK</option>
                            </select>
                    </div>
                    {{-- <div class="form-group">
                        <label for="trailer">Condition</label>
                        <input type="text" class="form-control" id="condition" name="condition"
                            placeholder="broken/new/used" value="{{ $goods->condition }}">
                    </div> --}}
                    <div class="form-group">
                        <label for="short-about">Deskripsi</label>
                        <input type="text" class="form-control" id="description" name="description"
                            placeholder="Proyektor dengan resolusi 1080p" value="{{ $goods->description}}">
                    </div>
                    <div class="form-group">
                        <label for="short-about">Gambar</label>
                        <input type="text" class="form-control" id="image" name="image"
                            placeholder="diisi sama dengan field name"  value = "{{ $goods->goods_name }}">
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
