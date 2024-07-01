@extends('layouts.app')
@section('contents')
    <div class="container-fluid px-4">
        @include('backend.component.breadcrumb')
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>Mobil
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Merk</th>
                            <th>Tahun</th>
                            <th>Harga Sewa</th>
                            <th>Status</th>
                            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($cars as $car)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $car->name }}</td>
                                <td>{{ $car->manufacture->name }}</td>
                                <td>{{ $car->year }}</td>
                                <td>Rp. {{ number_format($car->price, 2, ',', '.') }}</td>
                                <td>
                                    @if ($car->status == 'tersedia')
                                        <button class="btn btn-sm btn-success"
                                            style="cursor: text;">{{ Str::ucfirst($car->status) }}</button>
                                    @else
                                        <button class="btn btn-sm btn-danger"
                                            style="cursor: text;">{{ Str::ucfirst($car->status) }}</button>
                                    @endif
                                </td>
                                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#detailModal" data-id="{{ $car->id }}">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <a href="{{ route('car.edit', $car->id) }}"
                                            class="btn btn-sm btn-primary update-data">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="{{ route('car.destroy', $car->id) }}"
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
    @include('backend.car.modal-show')
@endsection
@push('scripts')
@endpush
