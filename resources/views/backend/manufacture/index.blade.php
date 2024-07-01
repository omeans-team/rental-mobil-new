@extends('layouts.app')
@section('contents')
    <div class="container-fluid px-4">
        @include('backend.component.breadcrumb')
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Merk DataTable
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($manufactures as $manufacture)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $manufacture->name }}</td>
                                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                    <td>
                                        <a href="{{ route('manufacture.edit', $manufacture->id) }}"
                                            class="btn btn-sm btn-primary update-data">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="{{ route('manufacture.destroy', $manufacture->id) }}"
                                            class="btn btn-sm btn-danger delete-data">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
