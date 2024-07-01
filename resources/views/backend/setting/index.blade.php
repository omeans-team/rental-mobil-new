@extends('layouts.app')
@section('contents')
    <div class="container-fluid px-4">
        @include('backend.component.breadcrumb')
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                Configurasi System
                {{-- <a href="#create" data-toggle="modal" class="btn btn-sm btn-primary float-right">
                    <i class="fa fa-plus"></i>
                </a> --}}
            </div>
            <div class="card-body">
                <form action="{{ route('setting.change') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @foreach ($data as $row)
                        <div class="row">
                            <div class="col">
                                @if ($row->type == 'file')
                                    <div class="form-group">
                                        <label>{{ $row->name }} Lama</label>
                                        <div id="loadImage" class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="card bg-dark text-white shadow-sm">
                                                        <img class="card-img"
                                                            src="{{ url('') }}/{{ $row->description }}"
                                                            alt="{{ $row->name }}">
                                                        <div class="card-img-overlay">
                                                            <a class="card-text btn btn-danger shadow-sm delete-photo"
                                                                data-href="{{ url('') }}/{{ $row->description }}"
                                                                href="#">
                                                                <i class="fa fa-times"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label>{{ $row->name }}</label>
                                        <input type="hidden" name="id[]" value="{{ $row->id }}">
                                        <input type="file" name="description[]" id="edit-file"
                                            class="form-control border-dark-50" value="{{ $row->description }}">
                                        <input type="hidden" name="edit_file" id="edit_file"
                                            class="form-control border-dark-50" value="{{ $row->description }}">
                                    </div>
                                @elseif ($row->type == 'text')
                                    <div class="form-group">
                                        <label>{{ $row->name }}</label>
                                        <input type="hidden" name="id[]" value="{{ $row->id }}">
                                        <input type="text" name="description[]" value="{{ $row->description }}"
                                            class="form-control border-dark-50" required="">

                                    </div>
                                @else
                                    <div class="form-group">
                                        <label>{{ $row->name }}</label>
                                        <input type="hidden" name="id[]" value="{{ $row->id }}">
                                        <textarea name="description[]" class="form-control" required="">{{ $row->description }}</textarea>
                                    </div>
                                @endif


                            </div>
                        </div>
                    @endforeach

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
    @include('backend.setting.create-modal')
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap',
                dropdownParent: $('#create')
            });

            $('#loadImage').on('click', 'a.delete-photo', function(e) {
                e.preventDefault();
                $.get($(this).attr('data-href'), function() {
                    $('#loadImage').empty();
                    $('#edit-file').val('');
                    $('#edit_file').val('');
                });

            });
        })
    </script>
@endpush
