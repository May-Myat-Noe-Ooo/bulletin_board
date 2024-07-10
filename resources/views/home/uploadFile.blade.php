@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-2 mb-2">
        <div class="card">
            <div class="card-header bg-light text-black">
                Upload CSV File
            </div>
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" id="uploadForm" action="{{ route('upload_csv') }}" method="POST"
                    enctype="multipart/form-data" style="max-width: 500px; width: 100%;">
                    @csrf
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('error_html'))
                        <div class="alert alert-danger">
                            {!! implode('<br>', session('error_html')) !!}
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label class="form-label col-sm-4" for="customFile">CSV file:</label>
                            <div class="col-sm-8">
                                <input type="file" name="csvfile" class="form-control" id="csvfile" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex  justify-content-around align-item-center">
                            <div class="col-sm-8 offset-sm-4">
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-dark upload-btn btn-block col-sm-4">Upload</button>
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
                var form = document.getElementById('uploadForm');
                form.reset();
            });
        });
    </script>
@endsection
