@extends('layouts.app')
@section('contents')
    <div class="container-fluid px-4">
        @include('backend.component.breadcrumb')
        <div class="card mb-4">
            <div class="card-header">
                Tambah Data
            </div>
            <div class="card-body">
                <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" id="" class="form-control border-dark-50"
                                    required="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Role</label>
                                <select name="role_id" class="form-control select2" required="">
                                    @foreach ($role->get() as $row)
                                        {{-- <option value="{{$row->id}}">{{title_case($row->name)}}</option> --}}
                                        <option value="{{ $row->id }}">{{ ucwords(strtolower($row->name)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" id="" class="form-control border-dark-50"
                                    required="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" name="password" id="" class="form-control border-dark-50"
                                    required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
                                <a class="btn btn-light shadow-sm" href="{{ route('user.index') }}">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // $(document).ready(function(){
        //     $('.select2').select2({
        //         dropdownParent: $('body'),
        //         theme: 'bootstrap'
        //     })
        // });
    </script>
@endpush
