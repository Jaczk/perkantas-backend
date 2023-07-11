@extends('admin.layouts.base')

@section('title', 'Dashboard')

@section('content')
    {{-- <h1>ini dashboard</h1> --}}
    <div class="d-flex row justify-content-between"> {{-- row 1 --}}
        <div class="p-0 small-box bg-primary col">
            <div class="inner">
                <h3>{{ $goods }}</h3>
                <p>Barang</p>
            </div>
            <div class="icon">
                <i class="fas fa-laptop-house"></i>
            </div>
            <a href="{{ route('admin.good') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <div class="p-0 mx-3 small-box bg-success col">
            <div class="inner">
                <h3>{{ $procurements }}</h3>
                <p>Pengadaan</p>
            </div>
            <div class="icon">
                <i class="fas fa-file"></i>
            </div>
            <a href="{{ route('admin.procurement') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <div class="p-0 small-box bg-warning col">
            <div class="inner">
                <h3>{{ $loans }}</h3>
                <p>Peminjaman</p>
            </div>
            <div class="icon">
                <i class="fas fa-people-carry"></i>
            </div>
            <a href="{{ route('admin.loans') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="d-flex row justify-content-between"> {{-- row 2 --}}
        <div class="p-0 small-box bg-dark col">
            <div class="inner">
                <h3>{{ $brokenItem }}</h3>
                <p>Barang Rusak</p>
            </div>
            <div class="icon">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <a href="{{ route('admin.good') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <div class="p-0 mx-3 small-box bg-danger col">
            <div class="inner">
                <h3>{{ $returnLate }}</h3>
                <p>Terlambat Dikembalikan</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('admin.loans') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <div class="p-0 small-box bg-info col">
            <div class="inner">
                <h3>{{ $userActive }}</h3>
                <p>Pengguna dengan Akses Pengembalian </p>
            </div>
            <div class="icon">
                <i class="fas fa-universal-access"></i>
            </div>
            <a href="{{ route('admin.user') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Tabel Barang</h3>
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

                {{-- card for chart js --}}
            </div>
            <div class="col-md-6">

                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Ringkasan Pengadaan Periode: <span>{{ $selectedPeriod }}</span></h3>
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
                        <canvas id="myChart3"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    {{-- <div class="card-footer ">
                        <div class="d-flex justify-content-between">
                            <button onclick="navigate('previous')" type="button"
                                class="btn btn-primary ">Sebelumnya</button>
                            <button onclick="navigate('next')" type="button" class="btn btn-primary ">Selanjutnya</button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        //----------------------------------------------------------------------------------------------------------------------------------
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        var pieData = {
            labels: [
                'Barang Baru',
                'Barang Normal',
                'Barang Rusak',
            ],
            datasets: [{
                data: [{{ $newItem }}, {{ $normalItem }}, {{ $brokenItem }}
                ],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            }]
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Ringkasan Tabel Kondisi Barang'
                },
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
        });

        var ctx = document.getElementById('myChart3').getContext('2d');
        var currentPeriod = "{{ $selectedPeriod }}";

        // Set initial period to current period
        var currentDate = new Date();
        var currentYearMonth = currentDate.getFullYear() + ("0" + (currentDate.getMonth() + 1)).slice(-2);
        currentPeriod = currentYearMonth;

        function fetchDataAndRenderChart(period) {
            fetch('admin/chart/' + period)
                .then(response => response.json())
                .then(data => {
                    var chartData = {
                        labels: data.labels,
                        datasets: [{
                            data: data.total,
                            backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc',
                                '#d2d6de'
                            ],
                        }]
                    };
                    renderChart(chartData);
                });
        }

        function renderChart(chartData) {
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: chartData,
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Periode: {{ $selectedPeriod }}'
                        },
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    }
                }
            });
        }


        // Initial chart rendering
        fetchDataAndRenderChart(currentPeriod);
    </script>
@endsection
