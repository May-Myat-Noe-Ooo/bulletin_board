@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-2 mb-2">
        <!-- Create User/Register Begin -->
        <div class="post-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__text">
                            <h2>Register</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__links">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Create User</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Create User/ Register End -->
        <div class="card register">           
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" id="createuser" action="{{ route('registerconfirm') }}" method="POST"
                    enctype="multipart/form-data" style="max-width: 400px; width: 100%;">
                    @csrf
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6 ">Name</label>
                            <div class="col-sm-8"><input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                             @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6 ">E-Mail Address</label>
                            <div class="col-sm-8"><input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
                            @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6 ">Password</label>
                            <div class="col-sm-8 position-relative">
                            <input id="password" type="password" name="password" id="password" class="form-control"
                                    value="{{ old('password') }}">
                                    <i id="togglePassword" class="bi bi-eye position-absolute"></i>
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                    </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6 ">Password Confirmation</label>
                            <div class="col-sm-8 position-relative"><input id="password_confirmation" type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                                    value="{{ old('password_confirmation') }}">
                                    <i id="confirm_togglePassword" class="bi bi-eye position-absolute"></i>
                                    @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Type</label>
                            <div class="col-sm-8">
                                <select name="type" id="type" class="form-select ">
                                    <option value="0" {{ old('type') == 0 ? 'selected' : '' }}>Admin</option>
                                    <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>User</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Phone</label>
                            <div class="col-sm-8"><input type="tel" name="phone" class="form-control" value="{{ old('phone') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex  justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Date of Birth</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-lg" id="dd" type="date" name="date" value="{{ old('date') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Address</label>
                            <div class="col-sm-8"><input type="text" name="address" class="form-control" value="{{ old('address') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label class="form-label col-sm-6 required" for="customFile">Profile</label>
                            <div class="col-sm-8">
                                <input type="file" name="profile" class="form-control" id="profile" value="{{ old('profile') }}">
                                @error('profile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex  justify-content-around align-item-center">
                            <div class="col-sm-8 offset-sm-6">
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-dark btn-block col-sm-4 register-btn">Register</button>
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-secondary btn-block col-sm-3" id="resetBtn">Clear</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var resetButton = document.getElementById('resetBtn');
            resetButton.addEventListener('click', function() {
                var form = document.getElementById('createuser');
                form.reset();
            });
        });

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
    </script>
@endsection
