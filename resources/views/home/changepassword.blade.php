@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                Change Password
            </div>
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('update_password', $user->id) }}" method="POST" style="max-width: 500px; width: 100%;">
                    @csrf
                    @method('POST')
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6">Current Password</label>
                            <div class="col-sm-8"><input type="password" name="current_password" class="form-control" value="{{ old('current_password') }}">
                                @error('current_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6">New Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="new_password" class="form-control" value="{{ old('new_password') }}">
                                @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-6">New Confirm Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="new_password_confirmation" class="form-control" value="{{ old('new_password_confirmation') }}">
                                @error('new_password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
