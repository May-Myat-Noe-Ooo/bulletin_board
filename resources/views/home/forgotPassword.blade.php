@extends('layouts.app')

@section('body')
    <nav class="navbar navbar-dark bg-success">
        <a class="navbar-brand" href="#">
            Forgot password
        </a>
    </nav>
    <div class="container-md col-sm-4 mt-5">
        <form class="form-horizontal" action="" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col d-flex justify-content-around align-item-center">
                    <label for="" class="form-label col-sm-2">Email:</label>
                    <div class="col-sm-8"><input type="email" name="email" class="form-control"></div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="row d-flex justify-content-center align-content-center">
                    <div class="col-sm-8 offset-sm-3">
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init
                            class="btn btn-success btn-block col-sm-7">Reset Password</button>
                    </div>
                </div>
            </div>




        </form>
    </div>
@endsection
