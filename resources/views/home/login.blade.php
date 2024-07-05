@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <div class="card">
            <div class="card-header bg-light text-black">
                Log in
            </div>
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('login.store') }}" method="POST" novalidate
                    style="max-width: 400px; width: 100%;">
                    @csrf
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-4 ">Email:</label>
                            <div class="col-sm-8"><input id="email" type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', Cookie::get('remember_email')) }}" required autocomplete="email"
                                    autofocus style="max-width: 100%;">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-4 ">Password:</label>
                            <div class="col-sm-8"><input id="password" type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    value="{{ old('password', Cookie::get('remember_password')) }}" required
                                    autocomplete="current-password" style="max-width: 100%;">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col d-flex  justify-content-around align-item-center" style="max-width: 100%;">
                            <div class="col-sm-8 offset-sm-4">
                                <div class="col d-flex  justify-content-around align-item-center">
                                    <div class="form-check">
                                        <input class="form-check-input" name="remember" type="checkbox" value="1"
                                            id="remember" {{ old('remember') ? 'checked' : '' }} />
                                        <label class="form-check-label" for="remember"> Remember me </label>
                                    </div>
                                    <a href="{{ route('forgot_password') }}">Forgot password?</a>
                                </div>
                                <div>
                                    <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-dark btn-block col-sm-12 login-btn">Log In</button>
                                </div>

                                <div>
                                    <a href="{{ route('signup.form') }}">
                                        <p>Create account? <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                                            </svg></p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
