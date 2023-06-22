@extends('admin.layouts.base')

@section('title', 'Barang')

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
                                    <option value="{{ $category->id }}"
                                        {{ $goods->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Kondisi Barang</label>
                            <select class="custom-select" name="condition">
                                <option value="new" @selected($goods->condition == 'new') @class(['bg-warning text-white' => $goods->condition == 'new'])>BARU
                                </option>
                                <option value="used" @selected($goods->condition == 'used') @class(['bg-warning text-white' => $goods->condition == 'used'])>NORMAL
                                </option>
                                <option value="broken" @selected($goods->condition == 'broken') @class(['bg-warning text-white' => $goods->condition == 'broken'])>RUSAK
                                </option>
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
                                placeholder="Proyektor dengan resolusi 1080p" value="{{ $goods->description }}">
                        </div>
                        <label for="image">Gambar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image">
                            <label class="custom-file-label" for="image">Choose file...</label>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" onclick="confirmEditForm(event)">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function confirmEditForm(event) {
            event.preventDefault(); // Prevent default form submission

            Swal.fire({
                title: 'Simpan perubahan?',
                text: 'Kategori akan diperbarui.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Kembali',
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, submit the form
                    event.target.form.submit();
                }
            });
        }
    </script>

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
