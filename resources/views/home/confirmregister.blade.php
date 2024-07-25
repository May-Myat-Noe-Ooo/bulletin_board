@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-2 mb-2">
        <!-- Register Confirm Begin -->
        <div class="post-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__text">
                            <h2 class="text-nowrap mb-0">Register Confirm</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__links">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Register Confirim</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Register Confirm End -->
        <div class="card">
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('storeRegisterUser') }}" method="POST" style="max-width: 500px; width: 100%;">
                    @csrf
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Name</label>
                            <div class="col-sm-8"><input type="text" name="name" class="form-control"
                                    value="{{ $name }}"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">E-Mail Address</label>
                            <div class="col-sm-8"><input type="text" name="email" class="form-control"
                                    value="{{ $email }}"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Password</label>
                            <div class="col-sm-8 position-relative">
                            <input id="password" type="password" name="password" class="form-control"
                                    value="{{ $password }}">
                                     <i id="togglePassword" class="bi bi-eye position-absolute"></i></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Password Confirmation</label>
                            <div class="col-sm-8 position-relative"><input id="password_confirmation" type="password" name="password_confirmation" class="form-control"
                                    value="{{ $cpassword }}">
                                    <i id="confirm_togglePassword" class="bi bi-eye position-absolute"></i></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Type</label>
                            <div class="col-sm-8">
                            <input type="text" name="type" class="form-control"
                                    value="{{ $type == 0 ? 'Admin' : 'User' }}">
                            </div>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Phone</label>
                            <div class="col-sm-8"><input type="tel" name="phone" class="form-control"
                                    value="{{ $phone }}"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="column d-flex  justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Date of Birth</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-lg" id="date" type="date" name="date" value="{{ $dob }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Address</label>
                            <div class="col-sm-8"><input type="text" name="address" class="form-control"
                                    value="{{ $address }}"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label class="form-label col-sm-6" for="customFile">Profile</label>
                            <div class="col-sm-8">
                                <img src="{{ asset($imagePath) }}" alt="error" class="rounded-circle" width="200"
                                    height="200">
                                <input type="hidden" name="profile_path" value="{{ $imagePath }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex  justify-content-around align-item-center">
                            <div class="col-sm-8 offset-sm-6">
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-dark confirm-btn btn-block col-sm-4">Confirm</button>
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-secondary btn-block col-sm-4" onclick="window.history.back();">Cancel</button>
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
