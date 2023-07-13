@extends('admin.layouts.base')

@section('title', 'Denda')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header" style="background-color: #121F3E">
                    <h3 class="card-title">Denda</h3>
                </div>

                <div class="card-body">
                    <div class="col">
                        {{-- <div class="mb-3 col-md-12">
                            <a href="{{ route('admin.fine.trash') }}">Data Dihapus</a>
                        </div> --}}
                        <div class="mb-3 col-md-12">
                            <p class="font-italic text-bold">
                                Nilai Denda dalam satuan ribuan rupiah. (cont: 5 melambangkan Rp 5.000)
                            </p>
                        </div>
                    </div>
                    

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
                            <table id="fine" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        {{-- <th>Id</th> --}}
                                        <th>Nama Denda</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 1; ?>
                                    @foreach ($fines as $fine)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            {{-- <td>{{ $fine->id }} </td> --}}
                                            <td>{{ $fine->fine_name }} </td>
                                            <td>{{ $fine->value }}</td>
                                            <td class="flex-row d-flex">
                                                <a href="{{ route('admin.fine.edit', Crypt::encryptString($fine->id)) }}"
                                                    class="btn btn-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                {{-- <form method="post"
                                                    action="{{ route('admin.fine.destroy', $fine->id) }}">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="mx-2 btn btn-danger delete-btn">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form> --}}
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
            var table = $('#fine').DataTable();

            // Apply event listener to all delete buttons
            $('#category').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: 'Item yang telah dihapus akan dipindahkan ke dalam menu Data Dihapus!',
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
