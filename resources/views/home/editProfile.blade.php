@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-2 mb-2">
        <!-- EditProfile Begin -->
        <div class="post-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__text">
                            <h2>Edit Profile</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__links">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Edit Profile</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Profile End -->
        <div class="card">
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('updateprofile', $user->id) }}" method="POST" enctype="multipart/form-data" style="max-width: 600px; width: 100%;">
                    @csrf
                    @method('PATCH') <!-- Using PATCH method for update -->
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="control-label form-label required col-sm-4 ">Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-4 ">E-Mail Address</label>
                            <div class="col-sm-8">
                                <input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-4 ">Type</label>
                            <div class="col-sm-8">
                                <select name="type" id="" class="form-select">
                                    <option value="0" {{ old('type', $user->type) == 0 ? 'selected' : '' }}>Admin</option>
                                    <option value="1" {{ old('type', $user->type) == 1 ? 'selected' : '' }}>User</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-4 ">Phone</label>
                            <div class="col-sm-8">
                                <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-4 ">Date of Birth</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-lg" id="date" type="date" name="date" value="{{ old('date', $user->dob) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-4 ">Address</label>
                            <div class="col-sm-8">
                                <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label class="form-label col-sm-4" for="customFile">Old Profile</label>
                            <div class="col-sm-8">
                                <img src="{{ asset($user->profile) }}" alt="error" class="rounded-circle" width="200" height="200">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label class="form-label col-sm-4" for="customFile">New Profile</label>
                            <div class="col-sm-8">
                                <input type="file" name="profile" class="form-control" id="profile">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="row d-flex justify-content-around align-item-center">
                            <div class="col-sm-8 offset-sm-4">
                                <button type="submit" class="btn btn-dark save-btn col-sm-3">Save</button>
                                <button type="reset" class="btn btn-secondary btn-block col-sm-3">Clear</button>
                                <a href="{{ route('change_password', ['id' => $user->id]) }}" class="change-pw-link">Change Password</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
