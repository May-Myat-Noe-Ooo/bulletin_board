@extends('layouts.app')

@section('body')
    <nav class="navbar navbar-dark bg-success">
        <a class="navbar-brand" href="#">
            Register
        </a>
    </nav>
    <div class="container-md col-sm-4 mt-5">

        <form class="form-horizontal" action="{{ route('storeuser') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="row d-flex justify-content-around align-item-center">
                    <label for="" class="form-label col-sm-2 ">Name</label>
                    <div class="col-sm-8"><input type="text" name="name" class="form-control"
                            value="{{ $name }}"></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="row d-flex justify-content-around align-item-center">
                    <label for="" class="form-label col-sm-2 ">E-Mail Address</label>
                    <div class="col-sm-8"><input type="text" name="email" class="form-control"
                            value="{{ $email }}"></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="row d-flex justify-content-around align-item-center">
                    <label for="" class="form-label col-sm-2 ">Password</label>
                    <div class="col-sm-8"><input type="password" name="password" class="form-control"
                            value="{{ $password }}"></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="row d-flex justify-content-around align-item-center">
                    <label for="" class="form-label col-sm-2 ">Password Confirmation</label>
                    <div class="col-sm-8"><input type="password" name="confirmpassword" class="form-control"
                            value="{{ $cpassword }}"></div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="column d-flex justify-content-around align-item-center">
                    <label for="" class="form-label col-sm-2 ">Type</label>
                    <div class="col-sm-8">
                        <select name="type" id="" class="form-select ">

                            <option value='1'>Admin</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="row mb-3">
                <div class="row d-flex justify-content-around align-item-center">
                    <label for="" class="form-label col-sm-2 ">Phone</label>
                    <div class="col-sm-8"><input type="tel" name="phone" class="form-control"
                            value="{{ $phone }}"></div>
                </div>
            </div>


            <div class="row mb-3">
                <div class="column d-flex  justify-content-around align-item-center">
                    <label for="" class="form-label col-sm-2 ">Date of Birth</label>
                    <div class="col-sm-8">
                        <input class="form-control form-control-lg" id="dd" type="date" name="date" />
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="row d-flex justify-content-around align-item-center">
                    <label for="" class="form-label col-sm-2 ">Address</label>
                    <div class="col-sm-8"><input type="text" name="address" class="form-control"
                            value="{{ $address }}"></div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="column d-flex justify-content-around align-item-center">
                    <label class="form-label" for="customFile">Profile</label>
                    <div class="col-sm-8">
                        <img src="{{ asset($imagePath) }}" alt="error" class="rounded-circle" width="200"
                            height="200">
                    </div>
                </div>
            </div>


            <div class="row mb-3">
                <div class="row d-flex  justify-content-around align-item-center">
                    <div class="col-sm-8">
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init
                            class="btn btn-success btn-block col-sm-4">Confirm</button>
                        <button type="button" data-mdb-button-init data-mdb-ripple-init
                            class="btn btn-secondary btn-block col-sm-4">Cancel</button>
                    </div>
                </div>





        </form>



    </div>
@endsection
