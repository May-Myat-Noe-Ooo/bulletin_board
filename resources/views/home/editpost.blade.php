@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-2 mb-2">
        <!-- Edit Post Begin -->
        <div class="post-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__text">
                            <h2>Edit Post</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__links">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Edit Post</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Post End -->
        <div class="card">
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('editconfirm', $postlist->id) }}" method="POST"
                    style="max-width: 400px; width: 100%;">
                    @csrf
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-3 ">Title</label>
                            <div class="col-sm-8"><input type="text" name="title" id="title" class="form-control"
                                    value="{{ old('title', $postlist->title) }}">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-3 ">Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', $postlist->description) }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="row d-flex  justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-3 text-right">Status</label>
                            <div class="col-sm-8">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="toggle_switch" value="{{ $postlist->status }}">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckDefault" @if ($postlist->status == 1) checked @endif>
                                </div>
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-dark edit-btn btn-block col-sm-4">Edit</button>
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-secondary btn-block col-sm-4" id="resetBtn">Clear</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var resetButton = document.getElementById('resetBtn');
            resetButton.addEventListener('click', function() {
                document.getElementById('title').value = "";
                document.getElementById('description').value = "";
            });

            var switchToggle = document.getElementById('flexSwitchCheckDefault');
            var hiddenInput = document.querySelector('input[name="toggle_switch"]');

            switchToggle.addEventListener('change', function() {
                hiddenInput.value = this.checked ? 1 : 0;
            });
        });
    </script>
@endsection
