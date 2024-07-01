@extends('layouts.app')
@section('contents')
    <div class="container-fluid px-4">
        @include('backend.component.breadcrumb')
        <div class="card mb-4">
            <div class="card-header">
                Transaksi
            </div>
            <div class="card-body">
                <table class="table table-sm table-bordered" id="transaction-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Invoice</th>
                            <th>Date Sewa</th>
                            <th>Date Kembali</th>
                            <th>Customer</th>
                            <th>Mobil</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->invoice_no }}</td>
                                <td>{{ date('d M Y', strtotime($transaction->rent_date)) }}</td>
                                <td>{{ date('d M Y', strtotime($transaction->back_date)) }}</td>
                                <td>{{ $transaction->customer->name }}</td>
                                <td>{{ $transaction->car->name }}</td>
                                <td>
                                    @if ($transaction->status == 'proses')
                                        <button class="btn btn-sm btn-warning"
                                            style="cursor: text;">{{ Str::ucfirst($transaction->status) }}</button>
                                    @else
                                        <button class="btn btn-sm btn-success"
                                            style="cursor: text;">{{ Str::ucfirst($transaction->status) }}</button>
                                    @endif
                                </td>
                                <td>
                                    @if ($transaction->status == 'proses')
                                        <span data-toggle="modal" data-target="#complete"
                                            data-form="{{ route('transaction.complete', $transaction->id) }}"
                                            data-invoiceno="{{ $transaction->invoice_no }}"
                                            data-id="{{ $transaction->id }}">
                                            <a href="#" class="btn btn-sm btn-primary shadow-sm" data-toggle="tooltip"
                                                data-placement="top" title="Selesai Transaksi">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        </span>

                                        <a href="{{ route('transaction.destroy', [$transaction->id]) }}"
                                            class="btn btn-sm btn-danger shadow-sm delete-data" data-toggle="tooltip"
                                            data-placement="top" title="Delete">
                                            <i class="fa fa-times"></i>
                                        </a>
                                        <a href="{{ route('transaction.destroy', $transaction->id) }}"
                                            class="btn btn-sm btn-danger delete-data">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @elseif ($transaction->status == 'selesai')
                                        <a href="{{ route('transaction.print', [$transaction->id]) }}" target="_blank"
                                            class="btn btn-sm btn-primary shadow-sm" data-toggle="tooltip"
                                            data-placement="top" title="Cetak">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('backend.transaction.modal-export')
    @include('backend.transaction.modal-complete')
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {


            $('#transaction-table_wrapper > div.toolbar').html('<div class="row">' +
                '<div class="col-lg-10">' +
                '<div class="input-group mb-3"> ' +
                '<input type="text" class="form-control form-control-sm border-0 bg-light" id="search-box" placeholder="Masukkan Kata Kunci"> ' +
                '<div class="input-group-append">' +
                '<span class="btn btn-sm btn-primary"><i class="fas fa-search"></i></span>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-2">' +
                // '<span data-toggle="modal" data-target="#export">'+
                // '<a href="#export" class="btn btn-sm btn-success float-right" data-toggle="tooltip" title="Export ke Excel"><i class="fas fa-file-excel"></i></a>'+
                // '</span>'+
                '</div>' +
                '</div>');

            $(document).on('keyup', '#search-box', function(e) {
                e.preventDefault();
                $table.search($(this).val()).draw();
            });




        });
    </script>
@endpush
