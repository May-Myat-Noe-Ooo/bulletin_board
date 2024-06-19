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
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal" data-id="{{ $rs->id }}"
                                                        data-title="{{ $rs->title }}" data-description="{{ $rs->description }}"
                                                        data-status="{{$rs->status}}" >Delete</button>
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
     <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the post?</p>
                    <p><strong>ID:</strong> <span id="postId"></span></p>
                    <p><strong>Title:</strong> <span id="postTitle"></span></p>
                    <p><strong>Description:</strong> <span id="postDescription"></span></p>
                    <p><strong>Status:</strong> <span id="postStatus"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form id="deleteForm" action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const postId = button.getAttribute('data-id');
            const postTitle = button.getAttribute('data-title');
            const postDescription = button.getAttribute('data-description');
            const postStatus = button.getAttribute('data-status');

            const modalTitle = deleteModal.querySelector('.modal-title');
            const modalBodyId = deleteModal.querySelector('#postId');
            const modalBodyTitle = deleteModal.querySelector('#postTitle');
            const modalBodyDescription = deleteModal.querySelector('#postDescription');
            const modalBodyStatus = deleteModal.querySelector('#postStatus');

            modalTitle.textContent = `Delete Confirm - ${postTitle}`;
            modalBodyId.textContent = postId;
            modalBodyTitle.textContent = postTitle;
            modalBodyDescription.textContent = postDescription;
            modalBodyStatus.textContent = postStatus == 1 ? 'Active' : 'Inactive';
            deleteForm.action = `/postlists/${postId}/destroy`;
        });
    </script>

@endsection
