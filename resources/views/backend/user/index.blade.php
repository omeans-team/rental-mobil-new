@extends('layouts.app')
@section('contents')
    <div class="container-fluid px-4">
        @include('backend.component.breadcrumb')
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                User DataTable
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-primary update-data">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="{{ route('user.destroy', $user->id) }}"
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
@endsection
