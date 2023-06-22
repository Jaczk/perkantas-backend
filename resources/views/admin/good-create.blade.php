@extends('admin.layouts.base')

@section('title', 'Daftar Barang')

@section('content')
    <div class="row">
        <div class="col-md-12">

            {{-- Alert Here --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Barang</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" method="POST" action="{{ route('admin.good.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Nama</label>
                            <input type="text" class="form-control" id="goods_name" name="goods_name"
                                placeholder="Isi dengan nama barang yang akan ditambahkan" value="{{ old('goods_name') }}">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="custom-select" name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="condition" class="form-label">Kondisi Barang</label>
                            <select class="custom-select" name="condition">
                                <option value="new" @selected(old('condition') == 'new') @class(['bg-warning text-white' => old('condition') == 'new'])>BARU
                                </option>
                                <option value="used" @selected(old('condition') == 'used') @class(['bg-warning text-white' => old('condition') == 'used'])>NORMAL
                                </option>
                                {{-- <option value="RUSAK" @selected(old('condition') == 'RUSAK') @class(['bg-warning text-white' => old('condition') == 'RUSAK'])>RUSAK
                                </option> --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ketersediaan</label>
                            <select class="custom-select" name="is_available)">
                                <option value="1" {{ old('is_available') === '1' ? 'selected' : '' }}>Available
                                </option>
                                <option value="0" {{ old('is_available') === '0' ? 'selected' : '' }}>Not Available
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="short-about">Deskripsi</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Proyektor dengan resolusi 1080p" value="{{ old('description') }}">
                        </div>
                        <label for="image">Gambar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image">
                            <label class="custom-file-label" for="image">Choose file...</label>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Get the custom file input element
        const customFileInput = document.getElementById('image');
        // Add event listener to update the label text with the selected file name
        customFileInput.addEventListener('change', function() {
            // Get the file name from the input value
            const fileName = this.value.split('\\').pop();
            // Update the label text with the file name
            const labelElement = this.nextElementSibling;
            labelElement.innerText = fileName;
        });
    </script>
@endsection
