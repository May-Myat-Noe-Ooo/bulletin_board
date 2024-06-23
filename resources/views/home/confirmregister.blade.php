@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                Register Confirm
            </div>
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
                            <div class="col-sm-8"><input type="password" name="password" class="form-control"
                                    value="{{ $password }}"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-6 ">Password Confirmation</label>
                            <div class="col-sm-8"><input type="password" name="password_confirmation" class="form-control"
                                    value="{{ $cpassword }}"></div>
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
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-4">Confirm</button>
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-secondary btn-block col-sm-4" onclick="window.history.back();">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
