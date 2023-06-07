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
                    {{-- <div class="row">
                        <div class="col-md-12 mb-3">
                            <a href="!#" class="btn btn-warning">Create Procurements</a>
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
                                            <td>{{ $proc->goods_name }}</td>
                                            <td>{{ $proc->goods_amount }}</td>
                                            <td>{{ $proc->period }}</td>
                                            <td class="text-justify">{{ $proc->description }}</td>
                                            @if ($proc->status == "approved")
                                                <td class="text-success font-weight-bold">{{ "APPROVED" }}</td>
                                            @elseif ($proc->status == "pending")
                                                <td class="text-info font-weight-bold">{{ "PENDING" }}</td>
                                            @else
                                                <td class="text-danger font-weight-bold">{{ "REJECTED" }}</td>
                                            @endif
                                            <td>
                                                <a href="{{ route('admin.procurement.edit', $proc->id) }}"
                                                    class="btn btn-secondary">
                                                    <i class="fas fa-edit"></i>
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
