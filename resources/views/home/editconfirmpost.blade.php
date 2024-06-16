@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                Edit Post
            </div>
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
                                    class="btn btn-success btn-block col-sm-4">Confirm</button>
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-secondary btn-block col-sm-4">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
