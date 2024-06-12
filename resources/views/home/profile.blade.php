@extends('layouts.app')
 
@section('body')
<nav class="navbar navbar-dark bg-success">
        <a class="navbar-brand" href="#">
            Profile
        </a>
    </nav>
<div class="container-md col-sm-4 mt-5">



  <form class="form-horizontal" action="{{ route('editprofile') }}" method="POST"  enctype="multipart/form-data">
        @csrf

  <div class="d-flex">

  <div class="flex-grow-1">
      <img src="/w3images/nature.jpg" alt="error" class="img-thumbnail" width="200" height="200">
  </div>

  <div class="flex-grow-1">

    <div class="row mb-3">
          <div class="row d-flex justify-content-around align-item-center">
            <label for="" class="form-label col-sm-2 ">Name</label>
            <div class="col-sm-8"><input type="text" name="name" class="form-control" value=""></div>
          </div>
      </div>

      <div class="row mb-3">
        <div class="column d-flex justify-content-around align-item-center">
          <label for="" class="form-label col-sm-2 ">Type</label>
          <div class="col-sm-8">
          <select name="type" id="" class="form-select " >
          <option value="1">Admin</option>
          <option value="2">User</option>
          </select>
          </div>
          
        </div>
      </div>


      <div class="row mb-3">
        <div class="row d-flex justify-content-around align-item-center">
            <label for="" class="form-label col-sm-2 ">Email</label>
            <div class="col-sm-8"><input type="text" name="email" class="form-control" value=""></div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="row d-flex justify-content-around align-item-center">
        <label for="" class="form-label col-sm-2 ">Phone</label>
            <div class="col-sm-8"><input type="tel" name="phone" class="form-control" value=""></div>
        </div>
      </div>

       
      <div class="row mb-3">
        <div class="column d-flex  justify-content-around align-item-center">
          <label for="" class="form-label col-sm-2 ">Date of Birth</label>
          <div class="col-sm-8">
            <input class="form-control form-control-lg" id="dd" type="date" name="date"/>
          </div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="row d-flex justify-content-around align-item-center">
        <label for="" class="form-label col-sm-2 ">Address</label>
            <div class="col-sm-8"><input type="text" name="address" class="form-control" value=""></div>
        </div>
      </div>

      
      

      <div class="row mb-3">
        <div class="row d-flex  justify-content-around align-item-center">
            <div class="col-sm-8">
              <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-8">Edit Profile</button>
            </div>
      </div>


  </div>

  </div>
  


        
      


      


  </form>



</div>



    



    

@endsection