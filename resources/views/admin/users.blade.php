@extends('admin.layouts.base')

@section('title', 'Users')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Users</h3>
                </div>

                <div class="card-body">

                    <div class="row">
                        <form enctype="multipart/form-data" method="POST" action="{{ route('admin.user.access') }}">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-warning">Reset Users Access</button>
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
                            <table id="good" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Return access</th>
                                        <th>Role</th>
                                        <th>Action</th>
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
                                                <td class="text-success font-weight-bold text-center">
                                                    <i class="fas fa-check fa-lg" style="color: #19942e;"></i>
                                                </td>
                                            @endif
                                            <td>{{ $user->roles == 1 ? 'Admin' : ($user->roles == 0 ? 'User' : 'Deactivated User') }}
                                            </td>
                                            <td class="flex-row d-flex">
                                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                                    class="btn btn-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger mx-2" data-toggle="modal"
                                                    data-target="#staticBackdrop">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="staticBackdrop" data-backdrop="static"
                                                    data-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-bold" id="staticBackdropLabel">
                                                                    Delete Item
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure want to permanently delete this item ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">No</button>
                                                                <form method="post" {{-- Delete Button --}}
                                                                    action="{{ route('admin.user.destroy', $user->id) }}">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger mx-2">
                                                                        Yes
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
        $('#good').DataTable();
    </script>
@endsection
