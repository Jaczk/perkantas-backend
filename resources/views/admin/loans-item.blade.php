@extends('admin.layouts.base')

@section('title', 'Peminjaman')

@section('content')

    @inject('carbon', 'Carbon\Carbon')

    <div class="row">
        <div class="col-md-12">
            {{-- for Chart --}}
            <div>
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Ringkasan Tabel Peminjaman</h3>
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
                        <canvas id="lineChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <select name="loan_period" id="loan_period" onchange="updateLoanChart()">
                                @foreach ($loanDrop as $loan)
                                    <option value="{{ $loan->period }}" @if ($loan->period == $period) selected @endif>
                                        {{ $loan->period }}</option>
                                @endforeach
                            </select>
                            <select name="loan_type" id="loan_type" onchange="updateLoanChart()">
                                <option value="peminjaman" @if ($type == 'peminjaman') selected @endif>Peminjaman
                                </option>
                                <option value="pengembalian" @if ($type == 'pengembalian') selected @endif>Pengembalian
                                </option>
                                <option value="pinjam-kembali" @if ($type == 'pinjam-kembali') selected @endif>pinjam-kembali
                                </option>
                            </select>
                        </div>
                    </div>


                </div>
            </div>

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
        $(document).ready(function() {
            var lineChartCanvas = document.getElementById('lineChart').getContext('2d');
            var currentPeriod = "{{ $period }}";
            var currentType = "peminjaman"; // Set initial loan type to "peminjaman"
            var myChart;

            function fetchDataAndRenderChart(period, type) {
                var url = "{{ route('admin.chart.loan.ajax', ['period' => ':period', 'type' => ':type']) }}";
                url = url.replace(':period', period).replace(':type', type);

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not OK');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Received data:', data);

                        var chartData = {
                            labels: data.labels,
                            datasets: data.datasets.map(dataset => ({
                                label: dataset.label,
                                data: dataset.data,
                                backgroundColor: dataset.backgroundColor,
                                borderColor: dataset.borderColor,
                                fill: dataset.fill,
                                type: dataset.type
                            }))
                        };

                        // Destroy previous chart instance if exists
                        if (myChart) {
                            myChart.destroy();
                        }

                        // Render new chart
                        myChart = new Chart(lineChartCanvas, {
                            type: 'bar',
                            data: chartData,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Periode: ' + period
                                    },
                                    legend: {
                                        display: true,
                                        position: 'bottom'
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching chart data:', error);
                    });
            }

            // Initial chart rendering
            fetchDataAndRenderChart(currentPeriod, currentType);

            // Update chart when period or type changes
            $('#loan_period, #loan_type').on('change', function() {
                var selectedPeriod = $('#loan_period').val();
                var selectedType = $('#loan_type').val();
                fetchDataAndRenderChart(selectedPeriod, selectedType);
            });
        });
    </script>
@endsection
