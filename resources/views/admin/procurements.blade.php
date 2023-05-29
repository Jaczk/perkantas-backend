@extends('admin.layouts.base')

@section('title', 'Procurements')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Procurements</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <a href="!#" class="btn btn-warning">Create Procurements</a>
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
                                        <th>Goods req</th>
                                        <th>Amount</th>
                                        <th>Period</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($procurements as $proc)
                                        <tr>
                                            <td>{{ $proc->id }}</td>
                                            <td>{{ $proc->user->name }}</td>
                                            <td>{{ $proc->goods_name}}</td>
                                            <td>{{ $proc->goods_amount}}</td>
                                            <td>{{ $proc->period}}</td>
                                            <td>{{ $proc->description }}</td>
                                            <td> 
                                                <p class="font-weight-bold text-uppercase">{{ $proc->status }}</p>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.procurement.edit', $proc->id) }}" class="btn btn-secondary">
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
