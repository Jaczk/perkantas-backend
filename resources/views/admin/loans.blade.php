@extends('admin.layouts.base')

@section('title', 'Loan')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Loans</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <a href="!#" class="btn btn-warning">Create Loans</a>
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
                                        <th>Username</th>
                                        <th>Loan Date</th>
                                        <th>Period</th>
                                        <th>is_returned</th>
                                        <th>Return Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loans as $loan)
                                        <tr>
                                            <td>{{ $loan->id }}</td>
                                            <td>{{ $loan->user_id }}</td>
                                            <td>{{ $loan->created_at}}</td>
                                            <td>{{ $loan->period}}</td>
                                            <td>{{ $loan->is_returned}}</td>
                                            <td>{{ $loan->return_date}}</td>
                                            <td>{{ $loan->status}}</td>
                                            <td>
                                                <a href="!#" class="btn btn-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="post" action="!#">
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
