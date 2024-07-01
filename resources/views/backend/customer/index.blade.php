@extends('layouts.app')
@section('contents')
    <div class="container-fluid px-4">
        @include('backend.component.breadcrumb')
        <div class="card mb-4">
            <div class="card-header">
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $customer->nik }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->phone_number }}</td>
                                <td>
                                    <span data-toggle="modal" data-target="#CustomerDet" data-name="{{ $customer->name }}"
                                        data-nik="{{ $customer->nik }}" data-address="{{ $customer->address }}"
                                        data-sex="{{ $customer->sex }}" data-phone_number="{{ $customer->phone_number }}"
                                        data-email="{{ $customer->email }}">
                                        <a href="#" class="btn btn-info btn-sm shadow-sm" data-toggle="tooltip"
                                            data-placement="top" title="Detail">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </span>
                                    <a href="{{ route('customer.edit', $customer->id) }}"
                                        class="btn btn-sm btn-primary update-data">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="{{ route('customer.destroy', $customer->id) }}"
                                        class="btn btn-sm btn-danger delete-data">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('backend.customer.modal-show')
@endsection
