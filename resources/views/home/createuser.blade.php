@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                Register
            </div>
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
                            <div class="col-sm-8"><input type="password" name="password" id="password" class="form-control"
                                    value="">
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                    </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6 ">Password Confirmation</label>
                            <div class="col-sm-8"><input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                                    value="">
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
                                    <option value="0">Admin</option>
                                    <option value="1">User</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Phone</label>
                            <div class="col-sm-8"><input type="tel" name="phone" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex  justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Date of Birth</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-lg" id="dd" type="date" name="date" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Address</label>
                            <div class="col-sm-8"><input type="text" name="address" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label class="form-label col-sm-6 required" for="customFile">Profile</label>
                            <div class="col-sm-8">
                                <input type="file" name="profile" class="form-control" id="profile" />
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
                                    class="btn btn-success btn-block col-sm-4">Register</button>
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
    </script>
@endsection
