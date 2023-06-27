@extends('admin.layouts.base')

@section('title', 'Pengguna')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header" style="background-color: #121F3E">
                    <h3 class="card-title">Daftar Pengguna</h3>
                </div>

                <div class="card-body">

                    <div class="row">
                        <form enctype="multipart/form-data" method="POST" action="{{ route('admin.user.access') }}">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-warning text-bold"
                                    onclick="confirmResetForm(event)">Reset Akses Pengguna</button>
                            </div>
                        </form>
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
                            <table id="user" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Nomor Telepon</th>
                                        <th>Akses Pengembalian</th>
                                        <th>Tipe Pengguna</th>
                                        <th>Total Denda</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            @if ($user->can_return == 0)
                                                <td class="text-center">
                                                    <i class="fas fa-times fa-lg" style="color: #e00043;"></i>
                                                </td>
                                            @else
                                                <td class="text-center text-success font-weight-bold">
                                                    <i class="fas fa-check fa-lg" style="color: #19942e;"></i>
                                                </td>
                                            @endif
                                            <td>{{ $user->roles == 1 ? 'Admin' : ($user->roles == 0 ? 'User' : 'Deactivated User') }}
                                            </td>
                                            <td>
                                                {{ $user->total_fine }}
                                            </td>
                                            <td class="flex-row d-flex">
                                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                                    class="btn btn-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <!-- Button trigger modal -->
                                                <form method="post" {{-- Delete Button --}}
                                                    action="{{ route('admin.user.destroy', $user->id) }}">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="mx-2 btn btn-danger delete-btn">
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
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#user').DataTable();

            // Apply event listener to all delete buttons
            $('#user').on('click', '.delete-btn', function(e) {
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
        function confirmResetForm(event) {
            event.preventDefault(); // Prevent default form submission

            Swal.fire({
                title: 'Reset akses pengembalian ?',
                text: 'Aksi ini akan melakukan reset akses pengembalian pada semua pengguna.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Kembali',
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, submit the form
                    event.target.form.submit();
                }
            });
        }
    </script>
@endsection
