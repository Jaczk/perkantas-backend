@extends('admin.layouts.base')

@section('title', 'Daftar Barang')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header" style="background-color: #121F3E">
                    <h3 class="card-title">Daftar Barang (Dihapus)</h3>
                </div>

                <div class="card-body">
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
                                    @foreach ($trash as $t)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            {{-- <td>{{ $good->id }}</td> --}}
                                            <td>{{ $t->goods_name }}</td>
                                            <td>{{ $t->category->category_name ?? '-' }}</td>
                                            <td>
                                                {{ ($t->condition == 'new') ? "BARU" : (($t->condition == 'used') ? "NORMAL" : "RUSAK") }}
                                            </td>
                                            @if ($t->is_available == 0)
                                                <td class="text-center">
                                                    <p class="text-danger text-bold">Tidak Ada</p>
                                                </td>
                                            @else
                                                <td class="text-success font-weight-bold text-center">
                                                    <p class="text-success text-bold">Ada</p>
                                                </td>
                                            @endif
                                            {{-- <td>{{ $good->is_available == '0' ? "Not Available" : "Ready"}}</td> --}}
                                            <td class="text-justify">{{ $t->description }}</td>
                                            <td class="text-center">
                                                <img class="img-fluid" style="width: 180px"
                                                    src="{{ asset('storage/images/' . $t->image) }}" alt="">
                                            </td>
                                            <td class="flex-row d-flex">
                                                <form action="{{ route('admin.good.restore', $t->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success restore-btn">Restore</button>
                                                </form>
                                                <form method="post"
                                                    action="{{ route('admin.good.delete', $t->id) }}">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger mx-2 delete-btn">
                                                        Hapus Permanen
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
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#category').DataTable();
    
            // Apply event listener to all delete buttons
            $('#good').on('click', '.restore-btn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
    
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: 'Item akan kembali ditampilkan pada halaman utama.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5cb85c',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Pulihkan item!',
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
