@extends('layouts.app')

@section('body')
    <div class="container-md col-sm-7 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                Edit Post
            </div>
            <div class="card-body d-flex justify-content-center">
                <form class="form-horizontal" action="{{ route('editconfirm', $postlist->id) }}" method="POST"
                    style="max-width: 400px; width: 100%;">
                    @csrf
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label required col-sm-3 ">Title</label>
                            <div class="col-sm-8"><input type="text" name="title" class="form-control"
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
                                <textarea class="form-control" name="description" id="textAreaExample1" rows="4">{{ old('description', $postlist->description) }}</textarea>
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
                                    class="btn btn-success btn-block col-sm-4">Edit</button>
                                <button type="reset" data-mdb-button-init data-mdb-ripple-init
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
