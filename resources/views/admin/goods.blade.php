@extends('admin.layouts.base')

@section('title', 'Daftar Barang')

@section('content')

    <div class="row">
        <div class="col-md-12">
            {{-- for Chart --}}
            <div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">Tabel Ketersediaan Barang</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="pieChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Tabel Barang Berdasarkan Kategori</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="pieChart2"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header" style="background-color: #121F3E">
                        <h3 class="card-title">Daftar Barang</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <a href="{{ route('admin.good.create') }}" class="btn btn-primary text-bold">+ Barang</a>
                                |
                                <a href="{{ route('admin.good.trash') }}">Data Dihapus</a>
                            </div>
                        </div>

                        {{-- Alert w/ session --}}
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
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Kondisi</th>
                                            <th>Ketersediaan</th>
                                            <th>Deskripsi</th>
                                            <th>Gambar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter = 1; ?>
                                        @foreach ($goods as $good)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                {{-- <td>{{ $good->id }}</td> --}}
                                                <td>{{ $good->goods_name }}</td>
                                                <td>{{ $good->category->category_name ?? '-' }}</td>
                                                <td>
                                                    {{ $good->condition == 'new' ? 'BARU' : ($good->condition == 'used' ? 'NORMAL' : 'RUSAK') }}
                                                </td>
                                                @if ($good->is_available == 0)
                                                    <td class="text-center">
                                                        <p class="text-danger text-bold">Tidak Ada</p>
                                                    </td>
                                                @else
                                                    <td class="text-center text-success font-weight-bold">
                                                        <p class="text-success text-bold">Ada</p>
                                                    </td>
                                                @endif
                                                {{-- <td>{{ $good->is_available == '0' ? "Not Available" : "Ready"}}</td> --}}
                                                <td class="text-justify">{{ $good->description }}</td>
                                                <td class="text-center">
                                                    <img src="{{ filter_var($good->image, FILTER_VALIDATE_URL) ? $good->image : asset('storage/images/' . $good->image) }}"
                                                        class="img-fluid" style="width: 180px" alt="Image">
                                                </td>
                                                <td class="flex-row d-flex">
                                                    <a href="{{ route('admin.good.edit', Crypt::encryptString($good->id)) }}"
                                                        class="btn btn-secondary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="post"
                                                        action="{{ route('admin.good.destroy', $good->id) }}">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="mx-1 btn btn-danger delete-btn">
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
            $(document).ready(function() {
                // Initialize DataTable
                var table = $('#good').DataTable({
                    dom: 'lBfrtipl',
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                });

                // Apply event listener to all delete buttons
                $('#good').on('click', '.delete-btn', function(e) {
                    e.preventDefault();
                    var form = $(this).closest('form');

                    // Show SweetAlert confirmation dialog
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: 'Item yang telah dihapus akan dipindahkan ke dalam menu Data Dihapus!!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e31231',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus item!',
                        cancelButtonText: 'Kembali'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit the form after confirmation
                            form.submit();
                        }
                    });
                });
            });
            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            // You can switch between pie and douhnut using the method below.
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: {
                    labels: [
                        'Tersedia',
                        'Tidak Tersedia',
                    ],
                    datasets: [{
                        data: [
                            {{ $availableGoods }},
                            {{ $unavailableGoods }},
                        ],
                        backgroundColor: ['#00a65a', '#f56954'],
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                }
            })
            //-------------
            //- PIE CHART 2 -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas2 = $('#pieChart2').get(0).getContext('2d');
            // You can switch between pie and douhnut using the method below.
            new Chart(pieChartCanvas2, {
                type: 'pie',
                data: {
                    labels: [
                        @foreach ($goodCategories as $goodCategory)
                            '{{ $goodCategory->category_name }}',
                        @endforeach
                    ],
                    datasets: [{
                        data: [
                            @foreach ($goodCategories as $goodCategory)
                                {{ $goodCategory->total }},
                            @endforeach
                        ],
                        backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                }
            });
        </script>
    @endsection
