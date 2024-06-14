@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-5 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                Log in
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-4 ">Email:</label>
                            <div class="col-sm-8"><input type="email" name="email" class="form-control" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-4 ">Password:</label>
                            <div class="col-sm-8"><input type="password" name="password" class="form-control"
                                    value=""></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col d-flex  justify-content-around align-item-center">
                            <div class="col-sm-8 offset-sm-4">
                                <div class="col d-flex  justify-content-around align-item-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="form2Example31"
                                            checked />
                                        <label class="form-check-label" for="form2Example31"> Remember me </label>
                                    </div>
                                    <a href="#!">Forgot password?</a>
                                </div>
                                <div>
                                    <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-success btn-block col-sm-12">Log In</button>
                                </div>

                                <div class="text-center">
                                    <p>Create account? <a href="#!"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" fill="currentColor" class="bi bi-person"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                                            </svg></a></p>
                                    <button type="button" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-link btn-floating mx-1">
                                        <i class="fab fa-facebook-f"></i>
                                    </button>

                                    <button type="button" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-link btn-floating mx-1">
                                        <i class="fab fa-google"></i>
                                    </button>

                                    <button type="button" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-link btn-floating mx-1">
                                        <i class="fab fa-twitter"></i>
                                    </button>

                                    <button type="button" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-link btn-floating mx-1">
                                        <i class="fab fa-github"></i>
                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
