@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-2 mb-2">
        <div class="card">
            <div class="card-header bg-light text-black">
                Log in
            </div>
            @if (Session::has('success'))
                <div id="success-message" class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error'))
                <div id="error-message" class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif
            <div class="card-body d-flex justify-content-center">
                <form id="login-form" class="form-horizontal" action="{{ route('login.store') }}" method="POST" novalidate
                    style="max-width: 400px; width: 100%;">
                    @csrf
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="email" class="form-label required col-sm-4 ">Email:</label>
                            <div class="col-sm-8">
                                <input id="email" type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required autocomplete="email"
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
                            <label for="password" class="form-label required col-sm-4">Password:</label>
                            <div class="col-sm-8 position-relative">
                                <input id="password" type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    value="{{ old('password') }}" required
                                    autocomplete="current-password" style="max-width: 100%;">
                                <i id="togglePassword" class="bi bi-eye position-absolute"></i>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center" style="max-width: 100%;">
                            <div class="col-sm-8 offset-sm-4">
                                <div class="col d-flex justify-content-around align-item-center">
                                    <div class="form-check">
                                        <input class="form-check-input" name="remember" type="checkbox" value="1"
                                            id="remember" />
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
                </form>
            </div>
        </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to make the success message disappear after a few seconds
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000); // 3000 milliseconds = 3 seconds
        }

        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 3000); // 3000 milliseconds = 3 seconds
        }

        // Retrieve email and password from local storage
        const storedEmail = localStorage.getItem('remember_email');
        const storedPassword = localStorage.getItem('remember_password');
        if (storedEmail && storedPassword) {
            document.getElementById('email').value = storedEmail;
            document.getElementById('password').value = storedPassword;
            document.getElementById('remember').checked = true;
        }

        // Handle form submission
        const form = document.getElementById('login-form');
        form.addEventListener('submit', function() {
            const remember = document.getElementById('remember').checked;
            if (remember) {
                // Store email and password in local storage
                localStorage.setItem('remember_email', document.getElementById('email').value);
                localStorage.setItem('remember_password', document.getElementById('password').value);
            } else {
                // Clear local storage
                localStorage.removeItem('remember_email');
                localStorage.removeItem('remember_password');
            }
        });

        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute using getAttribute and setAttribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle the icon
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    });
</script>
@endsection
