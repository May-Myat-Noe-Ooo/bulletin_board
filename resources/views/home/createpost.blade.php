@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <!-- Create Post Begin -->
        <div class="post-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__text">
                            <h2>Create Post</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__links">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Create Post</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Create Post End -->
        <div class="card">
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('confirm') }}" method="POST"
                    style="max-width: 400px; width: 100%;" id="createPostForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-3">Title</label>
                            <div class="col-sm-8"><input type="text" name="title" id="title" class="form-control"
                                    style="max-width: 100%;" value="{{ old('title') }}">
                                    @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                    </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-3">Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="description" rows="4" style="max-width: 100%;">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center align-content-center">
                        <div class="col-sm-8 offset-sm-3" style="max-width: 100%;">
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-dark create-btn btn-block col-sm-4">Create</button>
                            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-4" id="resetBtn">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
          var resetButton = document.getElementById('resetBtn');
          resetButton.addEventListener('click', function () {
            document.getElementById('title').value = "  ";
            document.getElementById('description').value = " ";
          });
        });
      </script>
@endsection