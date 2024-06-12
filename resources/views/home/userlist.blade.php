@extends('layouts.app')

@section('body')
    <nav class="navbar navbar-dark bg-success">
        <a class="navbar-brand" href="#">
            User List
        </a>
    </nav>
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="col float-end mb-5 mt-5">
        <form class="search-form">
            <div class="row mb-3">
                <div class="column d-flex justify-content-space-between align-item-center">
                    <div>
                        <label for="" class="form-label col-sm-2 ">Name:</label>
                    </div>

                    <div>
                        <div class="col-sm-8"><input type="text" name="name" class="form-control" value="">
                        </div>
                    </div>
                    <div>
                        <label for="" class="form-label col-sm-2 ">Email:</label>
                    </div>
                    <div>
                        <div class="col-sm-8"><input type="text" name="mailaddr" class="form-control" value="">
                        </div>
                    </div>
                    <div>
                        <label for="" class="form-label col-sm-2 ">From:</label>
                    </div>
                    <div>
                        <div class="col-sm-12">
                            <input class="form-control form-control-lg" id="dd" type="date" name="date" />
                        </div>
                    </div>
                    <div>
                        <label for="" class="form-label col-sm-2 ">To:</label>
                    </div>
                    <div>
                        <div class="col-sm-12">
                            <input class="form-control form-control-lg" id="dd" type="date" name="date" />
                        </div>
                    </div>
                    <div>
                        <div class="col-sm-8">
                            <a href="#" class="btn btn-primary">Search</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>



    <table class="table table-hover table-striped">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created User</th>
                <th>Type</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            @if ($userlist->count() > 0)
                @foreach ($userlist as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->name }}</td>
                        <td class="align-middle">{{ $rs->email }}</td>
                        <td class="align-middle">{{ $rs->name }}</td>
                        <td class="align-middle">admin</td>
                        <td class="align-middle">{{ $rs->phone }}</td>
                        <td class="align-middle">{{ $rs->dob }}</td>
                        <td class="align-middle">{{ $rs->address }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <!--<a href="{{ route('postlist.edit', $rs->id) }}" type="button" class="btn btn-warning">Edit</a>-->
                                <!--<a href="#" type="button" class="btn btn-warning">Edit</a>-->
                                <form action="#" method="POST" type="button" class="btn btn-danger p-0"
                                    onsubmit="return confirm('Delete?')">
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
                    <td class="text-center" colspan="5">User not found</td>
                </tr>
            @endif
        </tbody>
    </table>
    {!! $userlist->links() !!}


@endsection
