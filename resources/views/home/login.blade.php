@extends('layouts.app')
 
@section('body')
<nav class="navbar navbar-dark bg-success">
        <a class="navbar-brand" href="#">
            Log in
        </a>
    </nav>
<!-- 
  <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">User Login</h1>
</div>
 -->   
    <div class="container-md col-sm-4">
  <!-- Email input -->
  <div class="mb-3 mt-3 row d-flex">
      <label for="email" class="control-label col-sm-3">Email:</label>
      <div class="col-sm-9"><input type="email" class="form-control" id="email" placeholder="Enter email" name="email"></div>
    </div>

  <!-- Password input -->
  <div class="mb-3 row d-flex">
      <label for="pwd" class="control-label col-sm-3">Password:</label>
      <div class="col-sm-9"><input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd"></div>
    </div>

  <!-- 2 column grid layout for inline styling -->
  <div class="row mb-4">
    <div class="col d-flex justify-content-center">
      <!-- Checkbox -->
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
        <label class="form-check-label" for="form2Example31"> Remember me </label>
      </div>
    </div>

    <div class="col">
      <!-- Simple link -->
      <a href="#!">Forgot password?</a>
    </div>
  </div>

  <!-- Submit button -->
  <div class="row">
  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block col-sm-12">Log In</button>
</div>
  <!-- Register buttons -->
  <div class="text-center">
    <p>Create account? <a href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
</svg></a></p>
    <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
      <i class="fab fa-facebook-f"></i>
    </button>

    <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
      <i class="fab fa-google"></i>
    </button>

    <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
      <i class="fab fa-twitter"></i>
    </button>

    <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
      <i class="fab fa-github"></i>
    </button>
  </div>
</form>
</div>






  @endsection