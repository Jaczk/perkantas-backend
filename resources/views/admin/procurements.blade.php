@extends('admin.layouts.base')

@section('title', 'Pengadaan')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header" style="background-color: #121F3E">
                    <h3 class="card-title">Pengadaan Barang</h3>
                </div>

                <div class="card-body">
                    {{-- <div class="row">
                        <div class="mb-3 col-md-12">
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
                                        <th>#</th>
                                        {{-- <th>ID</th> --}}
                                        <th>Username</th>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>Deskripsi</th>
                                        <th>Periode</th>
                                        <th>Tanggal Pengajuan</th>
                                        {{-- <th>Pesan</th> --}}
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($procurements as $proc)
                                        <tr>
                                            <td></td>
                                            {{-- <td>{{ $proc->id }}</td> --}}
                                            <td>{{ $proc->user->name }}</td>
                                            <td>{{ $proc->goods_name }}</td>
                                            <td>{{ $proc->goods_amount }}</td>
                                            <td class="text-justify">{{ $proc->description }}</td>
                                            <td>{{ $proc->period }}</td>
                                            <td class="text-bold">
                                                {{ date('D, F j, Y h:i A', strtotime($proc->created_at)) }}</td>
                                            {{-- <td class="text-justify">{{ $proc->message }}</td> --}}
                                            @if ($proc->status == 'added')
                                                <td class="text-success font-weight-bold">{{ 'TERSEDIA' }}</td>
                                            @elseif ($proc->status == 'not_added')
                                                <td class="text-warning font-weight-bold">{{ 'DIAJUKAN' }}</td>
                                            @endif
                                            <td>
                                                <a href="{{ route('admin.procurement.edit', Crypt::encryptString($proc->id)) }}"
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
    {{-- <script>
        $('#good').DataTable();
    </script> --}}

    <script>
        $(document).ready(function() {
            var table = $('#good').DataTable({
                dom: 'lBfrtipl',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6,
                                7] // Include columns 1 to 5 in the copy report
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'Daftar Pengadaan Barang Baru Perkantas',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6,
                                7] // Include columns 1 to 5, 6, 7 in the Excel report
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Daftar Pengadaan Barang Baru Perkantas',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6,
                                7] // Include columns 1 to 5, 6, 7 in the PDF report
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Daftar Pengadaan Barang Baru Perkantas',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6,
                            7] // Include columns 1 to 5 in the printed report
                        }
                    }
                ],
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0
                }],
                order: [
                    [1, 'asc']
                ]
            });

            table
                .on('order.dt search.dt', function() {
                    var i = 1;

                    table
                        .cells(null, 0, {
                            search: 'applied',
                            order: 'applied'
                        })
                        .every(function(cell) {
                            this.data(i++);
                        });
                })
                .draw();
        });
    </script>
@endsection
