@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                Upload CSV File
            </div>
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data"
                    style="max-width: 500px; width: 100%;">
                    @csrf
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label class="form-label col-sm-4" for="customFile">CSV file:</label>
                            <div class="col-sm-8">
                                <input type="file" name="profile" class="form-control" id="customFile" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="row d-flex  justify-content-around align-item-center">
                            <div class="col-sm-8 offset-sm-4">
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-success btn-block col-sm-4">Upload</button>
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-secondary btn-block col-sm-4">Clear</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
