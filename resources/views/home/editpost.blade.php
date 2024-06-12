@extends('layouts.app')
 
@section('body')
<nav class="navbar navbar-dark bg-success">
        <a class="navbar-brand" href="#">
            Edit Post
        </a>
    </nav>
<div class="container-md col-sm-4 mt-5">
  <form class="form-horizontal" action="{{ route('editconfirm',$postlist->id) }}" method="POST">
        @csrf
        
      <div class="row mb-3">
          <div class="row d-flex justify-content-around align-item-center">
            <label for="" class="form-label col-sm-2 ">Title</label>
            <div class="col-sm-8"><input type="text" name="title" class="form-control" value="{{$postlist->title}}"></div>
          </div>
      </div>
      <div class="row mb-3">
        <div class="row d-flex justify-content-around align-item-center">
          <label for="" class="form-label col-sm-2 ">Description</label>
          <div class="col-sm-8"><textarea class="form-control" name="description" id="textAreaExample1" rows="4">{{$postlist->description}}</textarea></div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="row d-flex  justify-content-around align-item-center">
            <label for="" class="form-label col-sm-2 text-right">Status</label>
            <div class="col-sm-8">
              <div class="form-check form-switch">
                  <input type="hidden" name="toggle_switch" value="{{$postlist->status}}">
                  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" @if($postlist->status == 1) checked @endif>
              </div>
              <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-4">Edit</button>
              <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-4">Clear</button>
            </div>
      </div>
  </form>

  <script>
document.addEventListener('DOMContentLoaded', function () {
    var switchToggle = document.getElementById('flexSwitchCheckDefault');
    var hiddenInput = document.querySelector('input[name="toggle_switch"]');
    
    switchToggle.addEventListener('change', function () {
        hiddenInput.value = this.checked ? 1 : 0;
    });
});
</script>

</div>



    



    

@endsection