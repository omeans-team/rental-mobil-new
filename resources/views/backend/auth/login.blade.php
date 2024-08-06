@extends('layouts.app')
@section('contents')
    @php
        $tableExists = Schema::hasTable('settings');
        $logo = $tableExists ? \App\Models\Setting::where('slug', 'logo-depan')->first() : null;
    @endphp
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center"
                        style="height: 100vh; display: flex; justify-content: center; align-items: center;">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header text-center">
                                    <div
                                        style="height: 100px; width: 100px; border-radius: 50%; overflow: hidden; margin: 0 auto;">

                                        <img src="{{ $logo && $logo->description !== '' ? asset($logo->description) : asset('backend/img/logo.jpg') }} "
                                            style="width: 100%; height: 100%; object-fit: cover; margin: 0 auto;">
                                    </div>
                                    <h3 class="text-center font-weight-light my-4">Rental Mobil</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('proceed-login') }}">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input class="form-control" type="text" id="username" name="username"
                                                placeholder="Input Username" required="" autofocus="" />
                                            <label for="username">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password"
                                                placeholder="Password" name="password" required="" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
