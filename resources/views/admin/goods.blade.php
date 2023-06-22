@extends('admin.layouts.base')

@section('title', 'Daftar Barang')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header" style="background-color: #121F3E">
                    <h3 class="card-title">Daftar Barang</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <a href="{{ route('admin.good.create') }}" class="btn btn-primary text-bold">+ Barang</a>
                        </div>
                    </div>
                    
                    {{-- Alert w/ session --}}
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <table id="good" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        {{-- <th>ID</th> --}}
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Kondisi</th>
                                        <th>Ketersediaan</th>
                                        <th>Deskripsi</th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 1; ?>
                                    @foreach ($goods as $good)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            {{-- <td>{{ $good->id }}</td> --}}
                                            <td>{{ $good->goods_name }}</td>
                                            <td>{{ $good->category->category_name ?? '-'}}</td>
                                            <td>{{ $good->condition }}</td>
                                            @if ($good->is_available == 0)
                                                <td class="text-center">
                                                    <i class="fas fa-times fa-lg" style="color: #e00043;"></i>
                                                </td>
                                            @else
                                                <td class="text-success font-weight-bold text-center">
                                                    <i class="fas fa-check fa-lg" style="color: #19942e;"></i>
                                                </td>
                                            @endif
                                            {{-- <td>{{ $good->is_available == '0' ? "Not Available" : "Ready"}}</td> --}}
                                            <td class="text-justify">{{ $good->description }}</td>
                                            <td class="text-center">
                                                <img class="img-fluid" style="width: 50%" src="{{ asset('storage/images/'.$good->image) }}" alt="">
                                            </td>
                                            <td class="flex-row d-flex">
                                                <a href="{{ route('admin.good.edit', $good->id) }}" class="btn btn-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="post" action="{{ route('admin.good.destroy', $good->id) }}">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger mx-1 delete-btn">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- <script>
        $('#good').DataTable();
    </script> --}}
    {{-- <script> 
        $(document).ready(function () {
            $('#good').DataTable({
                dom: 'lBfrtipl',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            });
        });
    </script> --}}
    
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#good').DataTable({
                dom: 'lBfrtipl',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            });

            // Apply event listener to all delete buttons
            $('#good').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: 'Item yang telah dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e31231',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus item!',
                    cancelButtonText: 'Kembali'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form after confirmation
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
