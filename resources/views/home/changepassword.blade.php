@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                Change Password
            </div>
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="" method="POST" style="max-width: 500px; width: 100%;">
                    @csrf
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6">Current Password</label>
                            <div class="col-sm-8"><input type="password" name="password" class="form-control"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6">New Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="new_password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6">New Confirm Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="new_password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-content-center">
                            <div class="col-sm-8 offset-sm-6">
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-success btn-block col-sm-8">Update Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
