@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <!-- Profile Begin -->
        <div class="post-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__text">
                            <h2>Profile</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__links">
                            <a href="./index.html">Home</a>
                            <span>Profile</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Profile End -->
        <div class="card">
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('editprofile',$user->id) }}" method="POST" enctype="multipart/form-data"
                    style="max-width: 600px; width: 100%;">
                    @csrf
                    <div class="d-flex">
                        <div class="flex-grow-1 border-right">
                            <img src="{{ asset($user->profile) }}" alt="error" class="img-thumbnail" width="200" height="200">
                            <input type="hidden" name="profile_path" value="{{ $user->profile }}">
                        </div>
                        <div class="flex-grow-1">
                            <div class="row mb-3">
                                <div class="col d-flex justify-content-around align-item-center">
                                    <label for="" class="form-label col-sm-4 ">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="column d-flex justify-content-around align-item-center">
                                    <label for="" class="form-label col-sm-4 ">Type</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="type" class="form-control" value="{{ $user->type == 0 ? 'Admin' : 'User' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col d-flex justify-content-around align-item-center">
                                    <label for="" class="form-label col-sm-4 ">Email</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col d-flex justify-content-around align-item-center">
                                    <label for="" class="form-label col-sm-4 ">Phone</label>
                                    <div class="col-sm-8">
                                        <input type="tel" name="phone" class="form-control" value="{{ $user->phone }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="column d-flex justify-content-around align-item-center">
                                    <label for="" class="form-label col-sm-4 ">Date of Birth</label>
                                    <div class="col-sm-8">
                                        <input class="form-control form-control-lg" id="date" type="date" name="date" value="{{ $user->dob }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col d-flex justify-content-around align-item-center">
                                    <label for="" class="form-label col-sm-4 ">Address</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="row d-flex justify-content-around align-item-center">
                                    <div class="col-sm-8 offset-sm-4">
                                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-block col-sm-8">Edit Profile</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
