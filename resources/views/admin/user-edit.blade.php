@extends('admin.layouts.base')

@section('title', 'User')

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
                    <h3 class="card-title">Edit User</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" method="POST"
                    action="{{ route('admin.user.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">User Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="+62_phone number" value="{{ $user->phone }}">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Return Access</label>
                                <select class="custom-select" name="can_return">
                                    <option value = 0 @selected($user->can_return == "0")
                                        @class(['bg-warning text-white' => $user->can_return == "0"])
                                        >NOT ALLOWED</option>
                                    <option value = 1 @selected($user->can_return == "1")
                                        @class(['bg-warning text-white' => $user->can_return == "1"])
                                        >ALLOWED</option>
                                </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
