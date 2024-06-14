@extends('layouts.app')

@section('body')
    <nav class="navbar navbar-dark bg-success">
        <a class="navbar-brand" href="#">
            Create Post
        </a>
    </nav>
    <div class="container-md col-sm-4 mt-5">
        <form class="form-horizontal" action="{{ route('confirm') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col d-flex justify-content-around align-item-center">
                    <label for="" class="form-label required col-sm-3">Title</label>
                    <div class="col-sm-8"><input type="text" name="title" class="form-control"></div>
                </div>
            </div>



            <div class="row mb-3">
                <div class="col d-flex justify-content-around align-item-center">
                    <label for="" class="form-label required col-sm-3">Description</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="description" id="textAreaExample1" rows="4"></textarea>
                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-center align-content-center">
                <div class="col-sm-8 offset-sm-3">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init
                        class="btn btn-success btn-block col-sm-4">Create</button>
                    <button type="button" data-mdb-button-init data-mdb-ripple-init
                        class="btn btn-secondary btn-block col-sm-4">Clear</button>
                </div>
            </div>



        </form>
    </div>
@endsection
