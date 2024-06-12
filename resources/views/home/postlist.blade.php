@extends('layouts.app')
 
@section('body')
<nav class="navbar navbar-dark bg-success">
        <a class="navbar-brand" href="#">
            Post List
        </a>
    </nav>
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
  <div class="col float-end mb-5 mt-5">
  <form class="search-form">
      <label class=""> Keyword: </label>
          <input class="search btn" type="text" name="search-keyword" placeholder="Type Something">
          <a href="#" class="btn btn-primary">Search</a>
        <a href="#" class="btn btn-primary">Create</a>
        <a href="#" class="btn btn-primary">Upload</a>
        <a href="#" class="btn btn-primary">Download</a>
        </form>
</div>

        

        <table class="table table-hover table-striped">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Post title</th>
                <th>Post Description</th>
                <th>Posted User</th>
                <th>Posted Date</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            @if($postlist->count() > 0)
                @foreach($postlist as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->title }}</td>
                        <td class="align-middle">{{ $rs->description }}</td>
                        <td class="align-middle">admin</td>
                        <td class="align-middle">{{ $rs->created_at }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('postlist.edit', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
                                <!--<a href="#" type="button" class="btn btn-warning">Edit</a>-->
                                <form action="#" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Product not found</td>
                </tr>
            @endif
        </tbody>
    </table>
    {!! $postlist->links() !!}


@endsection