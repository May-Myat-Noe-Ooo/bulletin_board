@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <!-- Edit Confrim Post Begin -->
        <div class="post-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__text">
                            <h2 class="text-nowrap mb-0">Edit Confirm Post</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__links">
                            <a href="./index.html">Home</a>
                            <span>Edit Post</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Confirm Post End -->
        <div class="card">
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('postlist.update', $postlist->id) }}" method="POST"
                    style="max-width: 400px; width: 100%;">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-3 ">Title</label>
                            <div class="col-sm-8"><input type="text" name="title" class="form-control"
                                    value="{{ $title }}"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-3 ">Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="textAreaExample1" rows="4">{{ $des }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex  justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-3 text-right">Status</label>
                            <div class="col-sm-8">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="toggle_switch" value="{{ $toggleStatus }}">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckDefault" @if ($toggleStatus == 1) checked @endif>
                                </div>
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-dark confirm-btn btn-block col-sm-4">Confirm</button>
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-secondary btn-block col-sm-4" onclick="window.history.back();">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
