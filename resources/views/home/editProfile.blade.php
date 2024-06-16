@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                Profile Edit
            </div>
            <div class="card-body d-flex justify-content-center">
                 <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" style="max-width: 600px; width: 100%;">
            @csrf

            <div class="row mb-3">
                <div class="col d-flex justify-content-around align-item-center">
                    <label for="" class="control-label form-label required col-sm-4 ">Name</label>
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
                    <label class="form-label col-sm-4" for="customFile">Old Profile</label>
                    <div class="col-sm-8">
                        <img id="selectedImage" src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg"
                            alt="example placeholder" style="width: 300px;" />
                    </div>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col d-flex justify-content-around align-item-center">
                    <label class="form-label col-sm-4" for="customFile">New Profile</label>
                    <div class="col-sm-8">
                        <input type="file" name="profile" class="form-control" id="customFile" />
                    </div>
                </div>
            </div>


            <div class="row mb-3">
                <div class="row d-flex  justify-content-around align-item-center">
                    <div class="col-sm-8 offset-sm-4">
                        <a href="" type="button" class="btn btn-primary">Edit</a>
                        <button type="button" data-mdb-button-init data-mdb-ripple-init
                            class="btn btn-secondary btn-block col-sm-3">Clear</button>
                        <a href="{{ route('change_password') }}" class="link-primary">Change Password</a>
                    </div>
                </div>
            </div>





        </form>
            </div>
        </div>
    </div>
@endsection
