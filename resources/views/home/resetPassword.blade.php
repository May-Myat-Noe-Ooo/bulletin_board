@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-2 mb-2">
        <!-- Reset Password Begin -->
        <div class="post-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__text">
                            <h2>Reset Password</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__links">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Reset Password</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Reset Password End -->
        <div class="card">
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('reset_password.update') }}" method="POST" style="max-width: 500px; width: 100%;">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-5">Password:</label>
                            <div class="col-sm-8 position-relative"><input id="password" type="password" name="rpw" class="form-control" value="{{ old('rpw') }}">
                                <i id="togglePassword" class="bi bi-eye position-absolute"></i>
                                @error('rpw')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-5">Password Confirmation:</label>
                            <div class="col-sm-8 position-relative"><input id="password_confirmation" type="password" name="crpw" class="form-control" value="{{ old('crpw') }}">
                                <i id="confirm_togglePassword" class="bi bi-eye position-absolute"></i>
                                @error('crpw')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="row d-flex justify-content-center align-content-center">
                            <div class="col-sm-8 offset-sm-6">
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-dark btn-block update-btn col-sm-8">Update Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            const confirmTogglePassword = document.getElementById('confirm_togglePassword');
            const confirmPassword = document.getElementById('password_confirmation');
            
            confirmTogglePassword.addEventListener('click', function() {
                // Toggle the type attribute using getAttribute and setAttribute
                const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPassword.setAttribute('type', type);
                
                // Toggle the icon
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        });
    </script>
@endsection
