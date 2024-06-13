@extends('layouts.app')

@section('body')
    <nav class="navbar navbar-dark bg-success">
        <a class="navbar-brand" href="#">
            Register
        </a>
    </nav>
    <div class="container-md col-sm-4 mt-5">



        <form class="form-horizontal" action="{{ route('registerconfirm') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
                <div class="col d-flex justify-content-around align-item-center">
                    <label for="" class="form-label required col-sm-4 ">Name</label>
                    <div class="col-sm-8"><input type="text" name="name" class="form-control" value=""></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col d-flex justify-content-around align-item-center">
                    <label for="" class="form-label required col-sm-4 ">E-Mail Address</label>
                    <div class="col-sm-8"><input type="text" name="email" class="form-control" value=""></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col d-flex justify-content-around align-item-center">
                    <label for="" class="form-label required col-sm-4 ">Password</label>
                    <div class="col-sm-8"><input type="password" name="password" class="form-control" value=""></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col d-flex justify-content-around align-item-center">
                    <label for="" class="form-label required col-sm-4 ">Password Confirmation</label>
                    <div class="col-sm-8"><input type="password" name="confirmpassword" class="form-control" value="">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col d-flex justify-content-around align-item-center">
                    <label for="" class="form-label col-sm-4 ">Type</label>
                    <div class="col-sm-8">
                        <select name="type" id="" class="form-select ">
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="row mb-3">
                <div class="col d-flex justify-content-around align-item-center">
                    <label for="" class="form-label col-sm-4 ">Phone</label>
                    <div class="col-sm-8"><input type="tel" name="phone" class="form-control" value=""></div>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col d-flex  justify-content-around align-item-center">
                    <label for="" class="form-label col-sm-4 ">Date of Birth</label>
                    <div class="col-sm-8">
                        <input class="form-control form-control-lg" id="dd" type="date" name="date" />
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col d-flex justify-content-around align-item-center">
                    <label for="" class="form-label col-sm-4 ">Address</label>
                    <div class="col-sm-8"><input type="text" name="address" class="form-control" value=""></div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col d-flex justify-content-around align-item-center">
                    <label class="form-label col-sm-4" for="customFile">Profile</label>
                    <div class="col-sm-8">
                        <input type="file" name="profile" class="form-control" id="customFile" />
                    </div>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col d-flex  justify-content-around align-item-center">
                    <div class="col-sm-8 offset-sm-4">
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init
                            class="btn btn-success btn-block col-sm-4">Register</button>
                        <button type="button" data-mdb-button-init data-mdb-ripple-init
                            class="btn btn-secondary btn-block col-sm-3">Clear</button>
                    </div>
                </div>





        </form>



    </div>
@endsection
