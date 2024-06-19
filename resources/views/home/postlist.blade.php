@extends('layouts.app')

@section('body')
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="container-md col-sm-12 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                Post List
            </div>
            <div class="card-body">
                <form class="search-form float-end mb-5" method="GET" action="{{ route('postlist.index') }}">
                    <label class=""> Keyword: </label>
                    <input class="search btn border border-secondary" type="text" name="search-keyword"
                        placeholder="Type Something" value="{{ request('search-keyword') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('createpost') }}" class="btn btn-primary">Create</a>
                    <a href="#" class="btn btn-primary">Upload</a>
                    <a href="#" class="btn btn-primary">Download</a>
                </form>
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
                        @if ($postlist->count() > 0)
                            @foreach ($postlist as $rs)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $rs->title }}</td>
                                    <td class="align-middle">{{ $rs->description }}</td>
                                    <td class="align-middle">
                                     @if ($rs->user)
                                            @if ($rs->user->type == 0)
                                                admin
                                            @elseif ($rs->user->type == 1)
                                                user
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ $rs->created_at }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <a href="{{ route('postlist.edit', $rs->id) }}"
                                                class="btn btn-primary me-2">Edit</a>
                                            <form action="#" method="POST" onsubmit="return confirm('Delete?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="6">Post not found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {!! $postlist->links() !!}
            </div>
        </div>
    </div>
@endsection
