@extends('admin.layouts.base')

@section('title', 'Categories')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Categories</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <a href="{{ route('admin.category.create') }}" class="btn btn-warning text-bold">+ Categories</a>
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
                            <table id="category" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }} </td>
                                            <td>{{ $category->category_name }} </td>
                                            <td class="flex-row d-flex">
                                                <a href="{{ route('admin.category.edit', $category->id) }}"
                                                    class="btn btn-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="post" action="{{ route('admin.category.destroy', $category->id) }}">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger mx-2">
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
        $('#category').DataTable();
    </script>
@endsection
