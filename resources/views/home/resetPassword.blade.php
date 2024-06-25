@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                Reset Password
            </div>
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('reset_password.update') }}" method="POST" style="max-width: 500px; width: 100%;">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-5">Password:</label>
                            <div class="col-sm-8"><input type="password" name="password" class="form-control" >
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-5">Password Confirmation:</label>
                            <div class="col-sm-8"><input type="password" name="password_confirmation" class="form-control" >
                                @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="row d-flex justify-content-center align-content-center">
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
