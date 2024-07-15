@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-2 mb-2">
        <div class="card">
            <div class="card-header bg-light text-black">
                Forgot Password
            </div>
            @if (Session::has('error'))
                <div id="error-message" class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('forgot_password.send') }}" method="POST" style="max-width: 500px; width: 100%;">
                    @csrf
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-2">Email:</label>
                            <div class="col-sm-8"><input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
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
                                    class="btn btn-dark reset-btn btn-block col-sm-7">Reset Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script>
        // Function to make the success message disappear after a few seconds
        document.addEventListener('DOMContentLoaded', function() {
                const errorMessage = document.getElementById('error-message');
                if (errorMessage) {
                    setTimeout(() => {
                        errorMessage.style.display = 'none';
                    }, 3000); // 3000 milliseconds = 3 seconds
                }
            });
        </script>
@endsection
