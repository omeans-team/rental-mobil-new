@extends('layouts.app')
@section('contents')
    <div class="container-fluid px-4">
        @include('backend.component.breadcrumb')
        <div class="card mb-4">
            <div class="card-header">
                Ubah Data
            </div>
            <div class="card-body">
                <form action="{{ route('customer.update', $customer->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" name="nik" value="{{ $customer->nik }}"
                                    class="form-control border-dark-50" required="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" value="{{ $customer->name }}"
                                    class="form-control border-dark-50" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="address" value="{{ $customer->address }}"
                                    class="form-control border-dark-50" required="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select name="sex" class="form-control">
                                    <option value="laki-laki" {{ $customer->sex == 'laki-laki' ? 'selected' : '' }}>
                                        Laki-Laki
                                    </option>
                                    <option value="perempuan" {{ $customer->sex == 'perempuan' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>No Telp</label>
                                <input type="text" name="phone_number" value="{{ $customer->phone_number }}"
                                    class="form-control border-dark-50" required="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ $customer->email }}"
                                    class="form-control border-dark-50" required="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-gorup">
                                <button type="submit" class="btn btn-primary shadow-sm">Simpan</button>
                                <a class="btn btn-light shadow-sm" href="{{ route('customer.index') }}">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
