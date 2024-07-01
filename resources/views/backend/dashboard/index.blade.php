@extends('layouts.app')
@section('contents')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <h4>Mobil Tersedia</h4>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="col text-center">
                                <h1>{{ $car->where('status', 'tersedia')->get()->count() }} / {{ $car->get()->count() }}
                                </h1>
                            </div>
                            <i class="fas fa-fw fa-user"
                                style="opacity: .5; position:absolute; right:24px;font-size: 50px;"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('car.index') }}">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <h4>Customer</h4>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="col text-center">
                                <h1>{{ $customer->get()->count() }}</h1>
                            </div>
                            <i class="fas fa-fw fa-user"
                                style="opacity: .5; position:absolute; right:24px;font-size: 50px;"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('customer.index') }}">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <h4>Transaksi</h4>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="col text-center">
                                <h1>{{ $transaction->where('status', 'selesai')->get()->count() }}</h1>
                            </div>
                            <i class="fas fa-fw fa-book"
                                style="opacity:.5; position:absolute; right:24px;font-size: 50px;"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('transaction.history') }}">View
                            Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <h4>Transaksi Aktif</h4>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="col text-center">
                                <h1>{{ $transaction->where('status', 'proses')->get()->count() }}</h1>
                            </div>
                            <i class="fas fa-fw fa-book"
                                style="opacity:.5; position:absolute; right:24px;font-size: 50px;"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('transaction.index') }}">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Customer
                    </div>
                    <div class="card-body"><canvas id="CustomerLine" width="100%" height="40"></canvas>
                    </div>
                    <script>
                        var ctx = document.getElementById('CustomerLine');
                        var myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: @json($data['labels']),
                                datasets: [{
                                    data: @json($data_line['data']),
                                    label: "Sessions",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(2,117,216,0.2)",
                                    borderColor: "rgba(2,117,216,1)",
                                    pointRadius: 5,
                                    pointBackgroundColor: "rgba(2,117,216,1)",
                                    pointBorderColor: "rgba(255,255,255,0.8)",
                                    pointHoverRadius: 5,
                                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                                    pointHitRadius: 50,
                                    pointBorderWidth: 2,
                                }]
                            },
                            options: {
                                scales: {
                                    xAxes: [{
                                        time: {
                                            unit: 'date'
                                        },
                                        gridLines: {
                                            display: false
                                        },
                                        ticks: {
                                            maxTicksLimit: 7
                                        }
                                    }],
                                    yAxes: [{
                                        ticks: {
                                            // min: 0,
                                            // max: 40000,
                                            maxTicksLimit: 5
                                        },
                                        gridLines: {
                                            color: "rgba(0, 0, 0, .125)",
                                        }
                                    }],
                                },
                                legend: {
                                    display: false
                                }
                            }
                        });
                    </script>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Transactions
                    </div>
                    <div class="card-body"><canvas id=" TransactionsBarChart" width="100%" height="40"></canvas>
                    </div>
                    <script>
                        var ctx = document.getElementById(' TransactionsBarChart');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: @json($data['labels']),
                                datasets: [{
                                    label: 'Transactions',
                                    data: @json($data['data']),
                                    backgroundColor: "rgba(2,117,216,1)",
                                    borderColor: "rgba(2,117,216,1)",
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    xAxes: [{
                                        time: {
                                            unit: 'month'
                                        },
                                        gridLines: {
                                            display: false
                                        },
                                        ticks: {
                                            maxTicksLimit: 6
                                        }
                                    }],
                                    yAxes: [{
                                        ticks: {
                                            // min: 0,
                                            // max: 50,
                                            maxTicksLimit: 6
                                        },
                                        gridLines: {
                                            display: true
                                        }
                                    }],
                                },
                                legend: {
                                    display: false
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Customer
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>No Telp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $customer->nik }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->phone_number }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
