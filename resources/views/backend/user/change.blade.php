@extends('layouts.app')
@section('contents')
    <div class="container-fluid px-4">
        @include('backend.component.breadcrumb')
        <div class="card mb-4">
            <div class="card-header">
                Ganti Password
            </div>
            <div class="card-body">
                <form action="{{ route('user.updatePassword') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Password Lama</label>
                                <input type="password" name="old_password" id=""
                                    class="form-control border-dark-50" required="">
                            </div>
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="new_password" id=""
                                    class="form-control border-dark-50" required="">
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" name="confirm_password" id=""
                                    class="form-control border-dark-50" required="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-gorup">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a class="btn btn-light" href="{{ route('dashboard') }}">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
