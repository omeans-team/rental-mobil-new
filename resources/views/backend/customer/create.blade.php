@extends('layouts.app')
@section('contents')
    <div class="container-fluid px-4">
        @include('backend.component.breadcrumb')
        <div class="card mb-4">
            <div class="card-header">
                Tambah Data
            </div>
            <div class="card-body">
                <form action="{{ route('customer.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" name="nik" id="" class="form-control border-dark-50"
                                    required="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" id="" class="form-control border-dark-50"
                                    required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="address" id="" class="form-control border-dark-50"
                                    required="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select name="sex" class="form-control">
                                    <option value="laki-laki">Laki-Laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>No Telp</label>
                                <input type="text" name="phone_number" id="" class="form-control border-dark-50"
                                    required="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" id="" class="form-control border-dark-50"
                                    required="">
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
