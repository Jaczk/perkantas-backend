@extends('admin.layouts.base')

@section('title', 'Peminjaman')

@section('content')

@inject('carbon', 'Carbon\Carbon')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header" style="background-color: #121F3E">
                    <h3 class="card-title">Daftar Peminjaman</h3>
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
                                        <th>#</th>
                                        {{-- <th>ID</th> --}}
                                        <th>Username</th>
                                        <th>Barang</th>
                                        <th>Kondisi</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Periode</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 1; ?>
                                    @foreach ($loans as $lo)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            {{-- <td>{{ $lo->id }}</td> --}}
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
                                                <td class="text-warning font-weight-bold">{{ 'Dipinjam' }}</td>
                                            @elseif($lo->loan->is_returned == 1)
                                                <td class="text-success font-weight-bold">{{ 'Dikembalikan' }}</td>
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
    {{-- <script>
        $('#good').DataTable();
    </script> --}}
    <script> 
        $(document).ready(function () {
            $('#good').DataTable({
                dom: 'lBfrtipl',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            });
        });
    </script>
@endsection
