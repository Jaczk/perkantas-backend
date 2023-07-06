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
                            <table id="loan" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Username</th>
                                        <th>Barang</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Periode</th>
                                        <th>Denda</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loans as $lo)
                                        <tr>
                                            <td>{{ $lo->id }}</td>
                                            <td>{{ $lo->user->name }}</td>
                                            <td>
                                                @foreach ($lo['item_loan'] as $item)
                                                    <li>{{ $item->good->goods_name }}
                                                        ({{ $item->good->condition == 'new' ? 'BARU' : ($item->good->condition == 'used' ? 'NORMAL' : 'RUSAK') }})
                                                    </li>
                                                @endforeach
                                            </td>
                                            <td class="text-bold">{{ date('D, F j, Y h:i A', strtotime($lo->created_at)) }}

                                            </td>
                                            @if ($carbon::now()->greaterThan($lo->return_date) && $lo->is_returned === 0)
                                                <td class="text-danger text-bold">
                                                    {{ date('D, F j, Y h:i A', strtotime($lo->return_date)) }}</td>
                                            @else
                                                <td class="text-bold">
                                                    {{ date('D, F j, Y h:i A', strtotime($lo->return_date)) }}</td>
                                            @endif {{-- date comparison --}}
                                            
                                            <td>{{ $lo->period }}</td>
                                            <td>{{ $lo->fine }}</td>

                                            @if ($lo->is_returned == 0)
                                                <td class="text-warning font-weight-bold">{{ 'Dipinjam' }}</td>
                                            @elseif($lo->is_returned == 1)
                                                <td class="text-success font-weight-bold">{{ 'Dikembalikan' }}</td>
                                            @endif {{-- is_returned comparison --}}
                                            <td class="flex-row d-flex">
                                                <form method="POST" action="{{ route('admin.loans.return', $lo->id) }}">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" class="mx-1 btn btn-primary return-btn">
                                                        <i class="fas fa-undo-alt"></i>
                                                    </button>
                                                </form>
                                                <a href="https://wa.me/{{ $lo->user->phone }}" class="btn btn-success"
                                                    target="_blank">
                                                    <i class="fab fa-whatsapp fa-lg"></i>
                                                </a>
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
            // Initialize DataTable
            var table = $('#loan').DataTable({
                dom: 'lBfrtipl',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            });

            // Apply event listener to return buttons
            $('#loan').on('click', '.return-btn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: 'Peminjaman akan ditandai sebagai dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3CCF4E',
                    cancelButtonColor: '#e31231',
                    confirmButtonText: 'Selesaikan Peminjaman!',
                    cancelButtonText: 'Kembali'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form after confirmation
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
