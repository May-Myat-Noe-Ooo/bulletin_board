@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                Forgot Password
            </div>
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('forgot_password.send') }}" method="POST" style="max-width: 500px; width: 100%;">
                    @csrf
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-2">Email:</label>
                            <div class="col-sm-8"><input type="email" name="email" class="form-control" required>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
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
        </div>
    </div>
    </div>
@endsection
