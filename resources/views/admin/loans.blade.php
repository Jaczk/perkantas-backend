@extends('admin.layouts.base')

@section('title', 'Loan')

@section('content')

@inject('carbon', 'Carbon\Carbon')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Loans</h3>
                </div>

                <div class="card-body">
                    {{-- <div class="row">
                        <div class="col-md-12 mb-3">
                            <a href="!#" class="btn btn-warning">Create Loans</a>
                        </div>
                    </div> --}}

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
                                        <th>Username</th>
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
                                            <td>{{ $lo->good->goods_name }}</td>
                                            <td>{{ $lo->good->condition }}</td>
                                            <td class="text-bold">{{ date('D, F j, Y h:i A', strtotime($lo->loan->created_at)) }}</td>

                                            @if ($carbon::now()->greaterThan($lo->loan->return_date))
                                            <td class="text-danger text-bold">{{ date('D, F j, Y h:i A', strtotime($lo->loan->return_date)) }}</td>
                                            @else
                                            <td class="text-bold">{{ date('D, F j, Y h:i A', strtotime($lo->loan->return_date)) }}</td>
                                            @endif {{-- date comparison --}}

                                            <td>{{ $lo->loan->period }}</td>

                                            @if ($lo->loan->is_returned == 0)
                                                <td class="text-warning font-weight-bold">{{ 'On Loan' }}</td>
                                            @else
                                                <td class="text-success font-weight-bold">{{ 'Returned' }}</td>
                                            @endif {{-- is_returned comparison --}}
                                            <td>
                                                <a href="https://wa.me/{{ $lo->user->phone }}" class="btn btn-success"
                                                    target="_blank">
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
