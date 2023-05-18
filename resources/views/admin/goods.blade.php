@extends('admin.layouts.base')

@section('title', 'Goods')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Goods</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <a href="{{ route('admin.good.create') }}" class="btn btn-warning">Create Goods</a>
                        </div>
                    </div>

                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <table id="good" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Condition</th>
                                        <th>Availability</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($goods as $good)
                                        <tr>
                                            <td>{{ $good->id }}</td>
                                            <td>{{ $good->goods_name }}</td>
                                            <td>{{ "($good->category_id) ".$good->category->category_name }}</td>
                                            <td>{{ $good->condition }}</td>
                                            <td>{{ $good->is_available == '0' ? "Not Avail" : "Avail"}}</td>
                                            <td>{{ $good->description }}</td>
                                            <td>{{ $good->image }}</td>
                                            <td>
                                                <a href="{{ route('admin.good.edit', $good->id) }}" class="btn btn-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="post" action="">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
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
        $('#good').DataTable();
    </script>
@endsection
