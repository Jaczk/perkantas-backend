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
                                        <th>User-ID</th>
                                        <th>Goods</th>
                                        <th>Condition</th>
                                        <th>Loan Date</th>
                                        <th>Return Date</th>
                                        <th>Period</th>
                                        <th>Returned</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loans as $lo)
                                        <tr>
                                            <td>{{ $lo->id }}</td>
                                            <td>{{ $lo->user->name }}</td>
                                            <td>{{ $lo->good->goods_name}}</td>
                                            <td>{{ $lo->good->condition}}</td>
                                            <td>{{ date('D, F j, Y h:i A',strtotime($lo->loan->created_at))}}</td>
                                            <td>{{ date('D, F j, Y h:i A',strtotime($lo->loan->return_date))}}</td>
                                            <td>{{ $lo->loan->period}}</td>
                                            <td>{{ $lo->loan->is_returned == '0' ? "On Loan" : "Returned"}}</td>
                                            <td>
                                                <a href="!#" class="btn btn-success">
                                                    <i class="fab fa-whatsapp fa-lg"></i>
                                                </a>
                                                {{-- <form method="post" action="!#">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
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
        $('#good').DataTable();
    </script>
@endsection
