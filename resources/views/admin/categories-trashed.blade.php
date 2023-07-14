@extends('admin.layouts.base')

@section('title', 'Kategori')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header" style="background-color: #121F3E">
                    <h3 class="card-title">Kategori Barang (Dihapus)</h3>
                </div>

                <div class="card-body">
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
                            <table id="category" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        {{-- <th>Id</th> --}}
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 1; ?>
                                    @foreach ($trash as $t)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            {{-- <td>{{ $category->id }} </td> --}}
                                            <td>{{ $t->category_name }} </td>
                                            <td class="flex-row d-flex">
                                                <form action="{{ route('admin.category.restore', $t->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success restore-btn">Kembalikan</button>
                                                </form>
                                                <form method="post"
                                                    action="{{ route('admin.category.delete', $t->id) }}">
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
            var table = $('#category').DataTable();

            // Apply event listener to all delete buttons
            $('#category').on('click', '.delete-btn', function(e) {
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
        $('#category').on('click', '.restore-btn', function(e) {
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
