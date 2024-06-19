@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                Create Post
            </div>
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('store') }}" method="POST" style="max-width: 500px; width: 100%;">
                    @csrf
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-3">Title</label>
                            <div class="col-sm-8"><input type="text" name="title" class="form-control"
                                    value="{{ $title }}" style="max-width: 100%;"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-3">Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="textAreaExample1" rows="4" style="max-width: 100%;">{{ $des }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center align-content-center">
                        <div class="col-sm-8 offset-sm-3" style="max-width: 100%;">
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-success btn-block col-sm-4">Confirm</button>
                            <button type="button" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-secondary btn-block col-sm-4" onclick="window.history.back();">Cancel</button>
                        </div>
                    </div>



                </form>
            </div>
        </div>
    </div>
@endsection
