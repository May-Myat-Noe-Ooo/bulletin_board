@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-2 mb-2">
        <div class="card">
            <div class="card-header bg-light text-black">
                Sign Up
            </div>
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('signup.save') }}" method="POST"
                     style="max-width: 400px; width: 100%;">
                    @csrf
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6 ">Name</label>
                            <div class="col-sm-8"><input type="text" name="name" class="form-control" value="{{ old('name') }}">
                             @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6 ">E-Mail Address</label>
                            <div class="col-sm-8"><input type="text" name="email" class="form-control" value="{{ old('email') }}">
                            @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6">Password</label>
                            <div class="col-sm-8 position-relative">
                                <input id="password" type="password" name="spw" class="form-control" value="{{ old('spw') }}">
                                <i id="togglePassword" class="bi bi-eye position-absolute"></i>
                                @error('spw')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6">Password Confirmation</label>
                            <div class="col-sm-8 position-relative">
                                <input id="password_confirmation" type="password" name="scpw" class="form-control" value="{{ old('scpw') }}">
                                <i id="confirm_togglePassword" class="bi bi-eye position-absolute"></i>
                                @error('scpw')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex  justify-content-around align-item-center">
                            <div class="col-sm-8 offset-sm-6">
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-dark create-btn btn-block col-sm-4">Create</button>
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-secondary btn-block col-sm-3">Clear</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
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
        const confirm_password = document.getElementById('password_confirmation');

        confirm_togglePassword.addEventListener('click', function() {
            // Toggle the type attribute using getAttribute and setAttribute
            const type = confirm_password.getAttribute('type') === 'password' ? 'text' : 'password';
            confirm_password.setAttribute('type', type);
            
            // Toggle the icon
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
@endsection
