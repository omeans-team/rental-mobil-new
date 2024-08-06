<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @php
            $tableExists = Schema::hasTable('settings');
            $namatoko = $tableExists ? App\Models\Setting::where('slug', 'nama-toko')->get()->first()->description : 'Rental Mobil';
        @endphp
        {{-- {{ config('app.name') }} --}}
        {{ $namatoko }} @if (ucfirst(trim(parse_url(Request::url(), PHP_URL_PATH), '/')) == '')
            @else{{ '|' }} {{ ucfirst(basename(Request::url())) }}
        @endif
    </title>
    {{-- <title>{{ config('app.name') }} | {{ ucfirst(Request::path()) }}</title> --}}
    {{-- <title>{{ config('app.name') }} | {{ ucfirst(parse_url(Request::url(), PHP_URL_PATH)) }}</title> --}}
    {{-- <title>{{ config('app.name') }} @if (ucfirst(trim(parse_url(Request::url(), PHP_URL_PATH), '/')) == '')
            @else{{ '|' }}
        @endif {{ ucfirst(trim(parse_url(Request::url(), PHP_URL_PATH), '/')) }}</title> --}}

    @if (Request::is('admin*'))
        {{-- <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script> --}}
        {{-- <link href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" /> --}}
        <link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    @endif

    <script src="{{ asset('backend/js/Chart.min.js') }}"></script>

    <link href="{{ asset('backend/css/simple-datatables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/new-styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />
    <script src="{{ asset('backend/js/fontawesome-all.js') }}"></script>
    <!-- ... other meta tags and links ... -->
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}">
    @if (Request::is('admin*'))
        <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-fileinput/fileinput.min.js') }}"></script>
        <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    @endif

    @if (Request::is('admin/transaction/history') ||
            Request::is('admin/transaction') ||
            Request::is('admin/transaction/create'))
        <link href="{{ asset('vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}"
            rel="stylesheet" />
        <script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    @endif
</head>

<body class="sb-nav-fixed">

    @if (Auth::guard()->check())
        @include('backend.component.navbar')
    @endif

    @if (Auth::guard()->check())
        <div id="layoutSidenav">

            @include('backend.component.sidebar')
            <div id="layoutSidenav_content">
                <main>
                    @yield('contents')
                </main>

                @include('backend.component.footer')
            </div>
        </div>
    @else
        @yield('contents')
    @endif


    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/js/scripts.js') }}"></script>

    <script src="{{ asset('backend/js/simple-datatables.min.js') }}"></script>
    <script src="{{ asset('backend/js/datatables-simple-demo.js') }}"></script>

    @stack('scripts')


    @if (Request::is('admin*'))
        @if (Request::is('admin/role') ||
                Request::is('admin/user') ||
                (Request::is('admin/car') && (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)) ||
                (Request::is('admin/manufacture') && (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)) ||
                Request::is('admin/customer'))
            <script>
                $(document).ready(function() {

                    @php
                        $routeName = Str::before(Route::currentRouteName(), '.');
                    @endphp

                    var cardHeader = $('.card-header');

                    var plusButton = $(
                        '<a href="{{ route($routeName . '.create') }}" class="btn btn-primary btn-sm shadow-sm" data-toggle="tooltip" title="Tambah Data" style="float:right"><i class="fas fa-plus"></i></a>'
                    );

                    cardHeader.append(plusButton);
                });
            </script>
        @endif

        @if (Request::is('admin/customer'))
            <script>
                $(document).ready(function() {
                    $('[data-toggle="modal"][data-target="#CustomerDet"]').on('click', function() {
                        var name = $(this).data('name');
                        var address = $(this).data('address');
                        var email = $(this).data('email');
                        var phone_number = $(this).data('phone_number');
                        var sex = $(this).data('sex');
                        var nik = $(this).data('nik');

                        $('#CustomerDet').data('name', name);
                        $('#CustomerDet').data('address', address);
                        $('#CustomerDet').data('email', email);
                        $('#CustomerDet').data('phone_number', phone_number);
                        $('#CustomerDet').data('sex', sex);
                        $('#CustomerDet').data('nik', nik);
                        $('#CustomerDet').modal('show');
                    });

                    $('#CustomerDet').on('show.bs.modal', function() {
                        var name = $(this).data('name');
                        var address = $(this).data('address');
                        var email = $(this).data('email');
                        var phone_number = $(this).data('phone_number');
                        var sex = $(this).data('sex');
                        var nik = $(this).data('nik');

                        $('#CustomerDet.form-control').prop('readonly', true);
                        $('.form-control').prop('disabled', true);
                        $('#name').val(name);
                        $('#address').val(address);
                        $('#email').val(email);
                        $('#phone_number').val(phone_number);
                        $('#sex').val(sex);
                        $('#nik').val(nik);
                    });

                    $('#detailModal').on('hidden.bs.modal', function() {
                        $('#CustomerDet').find('input[name="name"]').val('');
                        $('#CustomerDet').find('input[name="address"]').val('');
                        $('#CustomerDet').find('input[name="email"]').val('');
                        $('#CustomerDet').find('input[name="phone_number"]').val('');
                        $('#CustomerDet').find('input[name="sex"]').val('');
                        $('#CustomerDet').find('input[name="nik"]').val('');
                        $('#CustomerDet').find('.modal-title').text('');
                    });
                });
            </script>
        @endif

        @if (Request::is('admin/transaction/history'))
            <script>
                $(document).ready(function() {

                    var cardHeader = $('.card-header');

                    var plusButton = $(
                        '<span data-toggle="modal" data-target="#export">' +
                        '<a href="#export" class="btn btn-sm btn-success" data-toggle="tooltip" title="Export ke Excel" style="float:right"><i class="fas fa-file-excel"></i></a>' +
                        '</span>'
                    );

                    cardHeader.append(plusButton);

                    $('[data-toggle="modal"][data-target="#export"]').on('click', function() {
                        var id = $(this).data('id');
                        var action = "{{ route('transaction.export', ':id') }}".replace(':id', id);
                        var invoiceno = $(this).data('invoiceno');
                        $('#export').data('action', action);
                        $('#export').data('invoiceno', invoiceno);
                        $('#export').modal('show');
                        console.log(action);
                    });

                    $('#export').on('show.bs.modal', function() {
                        var action = $(this).data('action');
                        var invoiceno = $(this).data('invoiceno');
                        $('#invoice-no').prop('readonly', true);
                        $('#form').prop('action', action);
                        $('#invoice-no').val(invoiceno);
                        console.log(action);
                    });
                });
            </script>
        @endif

        @if (Request::is('admin/transaction'))
            <script>
                $(document).ready(function() {
                    $('[data-toggle="modal"][data-target="#complete"]').on('click', function() {
                        var id = $(this).data('id');
                        var action = "{{ route('transaction.complete', ':id') }}".replace(':id', id);
                        var invoiceno = $(this).data('invoiceno');
                        $('#complete').data('action', action);
                        $('#complete').data('invoiceno', invoiceno);
                        $('#complete').modal('show');
                        console.log(action);
                    });

                    $('#complete').on('show.bs.modal', function() {
                        var action = $(this).data('action');
                        var invoiceno = $(this).data('invoiceno');
                        $('#invoice-no').prop('readonly', true);
                        $('#invoice-no').prop('disabled', 'disabled');
                        $('#form').prop('action', action);
                        $('#invoice-no').val(invoiceno);
                        console.log(action);
                    });

                });
            </script>
        @endif


        @if (Request::is('admin/car'))
            <script>
                $(document).ready(function() {
                    $('[data-toggle="modal"][data-target="#detailModal"]').on('click', function() {
                        var id = $(this).data('id');

                        // Reset the carousel and modal data
                        var carouselInner = $('#detailModal').find('.carousel-inner');
                        carouselInner.empty();
                        $('#detailModal').find('input[name="name"]').val('');
                        $('#detailModal').find('input[name="license_number"]').val('');
                        $('#detailModal').find('input[name="color"]').val('');
                        $('#detailModal').find('input[name="year"]').val('');
                        $('#detailModal').find('input[name="manufacture"]').val('');
                        $('#detailModal').find('input[name="price"]').val('');
                        $('#detailModal').find('input[name="penalty"]').val('');
                        $('#detailModal').find('.modal-title').text('');

                        // Show the modal
                        $('#detailModal').modal('show');

                        // Make an AJAX request to fetch data from the database
                        $.ajax({
                            type: 'GET',
                            url: '{{ route('car.show', ':id') }}'.replace(':id', id),
                            dataType: 'json',
                            success: function(data) {
                                // Populate the modal with the fetched data
                                $('#detailModal').find('input[name="name"]').val(data.name).prop(
                                    'disabled', true);
                                $('#detailModal').find('input[name="license_number"]').val(data
                                    .license_number).prop('disabled', true);
                                $('#detailModal').find('input[name="color"]').val(data.color).prop(
                                    'disabled', true);
                                $('#detailModal').find('input[name="year"]').val(data.year).prop(
                                    'disabled', true);
                                $('#detailModal').find('input[name="manufacture"]').val(data.manufacture
                                    .name).prop('disabled', true); // Access the manufacture name
                                $('#detailModal').find('input[name="price"]').val(data.price).prop(
                                    'disabled', true);
                                $('#detailModal').find('input[name="penalty"]').val(data.penalty).prop(
                                    'disabled', true);

                                // Update the modal title
                                $('#detailModal').find('.modal-title').text(
                                    `Detail Mobil - ${data.name}`);

                                // Make another AJAX request to fetch images for the car
                                $.ajax({
                                    type: 'GET',
                                    url: '{{ route('car.getImage', ':id') }}'.replace(':id',
                                        id),
                                    dataType: 'json',
                                    success: function(images) {
                                        $.each(images, function(index, image) {
                                            loadImage(image, index);
                                        });
                                    }
                                });
                            }
                        });
                    });

                    // Add event listener to the "next" button
                    $('#detailModal').on('click', '.carousel-control-next', function() {
                        var currentActiveItem = $('#detailModal').find('.carousel-item.active');
                        var nextItem = currentActiveItem.next();

                        if (nextItem.length === 0) {
                            nextItem = $('#detailModal').find('.carousel-item').first();
                        }

                        currentActiveItem.removeClass('active');
                        nextItem.addClass('active');
                    });

                    // Add event listener to the "prev" button
                    $('#detailModal').on('click', '.carousel-control-prev', function() {
                        var currentActiveItem = $('#detailModal').find('.carousel-item.active');
                        var prevItem = currentActiveItem.prev();

                        if (prevItem.length === 0) {
                            prevItem = $('#detailModal').find('.carousel-item').last();
                        }

                        currentActiveItem.removeClass('active');
                        prevItem.addClass('active');
                    });

                    $('#detailModal').on('hidden.bs.modal', function() {
                        // Reset the carousel and modal data
                        var carouselInner = $('#detailModal').find('.carousel-inner');
                        carouselInner.empty();
                        $('#detailModal').find('input[name="name"]').val('');
                        $('#detailModal').find('input[name="license_number"]').val('');
                        $('#detailModal').find('input[name="color"]').val('');
                        $('#detailModal').find('input[name="year"]').val('');
                        $('#detailModal').find('input[name="manufacture"]').val('');
                        $('#detailModal').find('input[name="price"]').val('');
                        $('#detailModal').find('input[name="penalty"]').val('');
                        $('#detailModal').find('.modal-title').text('');
                    });
                });

                function loadImage(image, index) {
                    var imageSrc = "{!! asset('"+image.image+"') !!}";
                    // Update the carousel images
                    var carouselInner = $('#detailModal').find('.carousel-inner');
                    var carouselItem = `
                <div class="carousel-item ${index === 0? 'active' : ''}">
                    <img src="${imageSrc}" alt="Image ${index + 1}">
                </div>
            `;
                    carouselInner.append(carouselItem);
                }
            </script>
        @endif

        @if (Request::is('admin/transaction/history') ||
                Request::is('admin/transaction') ||
                Request::is('admin/transaction/create'))
            <script>
                $(document).ready(function() {
                    $('.datepicker').datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true,
                        todayHighlight: true
                    });
                });
            </script>
        @endif

        @if (Request::is('admin/transaction/history') ||
                Request::is('admin/transaction') ||
                Request::is('admin/transaction/create') ||
                Request::is('admin/customer') ||
                Request::is('admin/car'))
            <script>
                $(document).ready(function() {
                    $('[data-dismiss="modal"]').on('click', function() {
                        $('#complete').modal('hide');
                        $('#export').modal('hide');
                        $('#detailModal').modal('hide');
                        $('#CustomerDet').modal('hide');
                    });
                });
            </script>
        @endif

        @if (Request::is('admin/role') ||
                Request::is('admin/user') ||
                Request::is('admin/car') ||
                Request::is('admin/customer') ||
                Request::is('admin/manufacture') ||
                Request::is('admin/setting') ||
                Request::is('admin/transaction'))
            <script>
                $(document).ready(function() {
                    $('.update-data').attr('data-toggle', 'tooltip').attr('title', 'Edit Data');
                    $('.delete-data').attr('data-toggle', 'tooltip').attr('title', 'Delete Data');
                    $('[data-toggle="tooltip"]').tooltip();
                });
            </script>
        @endif
        <script>
            $(document).ready(function() {
                $('body').tooltip({
                    selector: '[data-toggle="tooltip"]'
                });

                $('a.delete-data').on('click', function(e) {
                    e.preventDefault();
                    var delete_link = $(this).attr('href');
                    swal.fire({
                        title: "Hapus Data ini?",
                        text: "",
                        icon: "error",
                        showCancelButton: true,
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace(delete_link);
                        }
                    });
                });
            });
        </script>
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                });
            </script>
        @endif
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                });
            </script>
        @endif
    @endif
</body>

</html>
