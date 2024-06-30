@extends('layouts.app')

@section('body')


    <div class="container-md col-sm-12 mt-5">
        <!-- Postlist Begin -->
        <div class="post-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__text">
                            <h2>Postlist</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="post__links">
                            <a href="./index.html">Home</a>
                            <span>Post</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Postlist End -->
        <div class="card">
            @if (Session::has('success'))
                <div id="success-message" class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <form class="search-form" method="GET" action="{{ route('postlist.index') }}">
                            <label for="page-size">Page Size:</label>
                            <select name="page-size" id="page-size" class="form-select d-inline-block w-auto">
                                <option value="5" {{ $pageSize == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ $pageSize == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ $pageSize == 15 ? 'selected' : '' }}>15</option>
                                <option value="20" {{ $pageSize == 20 ? 'selected' : '' }}>20</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-8 text-end">
                        <form class="search-form" method="GET" action="{{ route('postlist.index') }}">
                            <label class="mr-2">Keyword:</label>
                            <input class="search btn border border-secondary" type="text" name="search-keyword"
                                placeholder="Type Something" value="{{ request('search-keyword') }}">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('createpost') }}" class="btn btn-primary">Create</a>
                            <a href="{{ route('upload_file') }}" class="btn btn-primary">Upload</a>
                            <a href="{{ route('postlists.export', ['search-keyword' => request('search-keyword')]) }}"
                                class="btn btn-primary">Download</a>
                        </form>
                    </div>
                </div>

                <div class="row mt-3">
                    @if ($postlist->count() > 0)
                        @foreach ($postlist as $rs)
                            <div class="postlist col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($rs->user->profile) }}" alt="error"
                                                class="rounded-circle me-2" width="30" height="30">
                                            <div>
                                                <div>{{ $rs->user ? ($rs->user->type == 0 ? 'admin' : 'user') : 'N/A' }}
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-clock me-1"></i>
                                                    <span>{{ $rs->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a href="{{ route('postlist.edit', $rs->id) }}" class="dropdown-item">
                                                        <i class="bi bi-pencil-square text-primary"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal" data-id="{{ $rs->id }}"
                                                        data-title="{{ $rs->title }}"
                                                        data-description="{{ $rs->description }}"
                                                        data-status="{{ $rs->status }}">
                                                        <i class="bi bi-trash-fill text-danger"></i> Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body position-relative">
                                        <h5 class="card-title">
                                            <a href="#" class="post-title-link" data-bs-toggle="modal"
                                                data-bs-target="#postDetailModal" data-title="{{ $rs->title }}"
                                                data-description="{{ $rs->description }}"
                                                data-status="{{ $rs->status }}"
                                                data-user="{{ $rs->user ? ($rs->user->type == 0 ? 'admin' : 'user') : 'N/A' }}"
                                                data-created="{{ $rs->created_at }}" data-updated="{{ $rs->updated_at }}"
                                                data-updated-user="{{ $rs->updatedUser ? ($rs->updatedUser->type == 0 ? 'admin' : 'user') : 'N/A' }}">
                                                {{ $rs->title }}
                                            </a>
                                        </h5>
                                        <p class="card-text">
                                            @if (strlen($rs->description) > 100)
                                                {{ substr($rs->description, 0, 100) }}...
                                                <a href="#" class="see-more-link" data-bs-toggle="modal"
                                                    data-bs-target="#postDetailModal" data-title="{{ $rs->title }}"
                                                    data-description="{{ $rs->description }}"
                                                    data-status="{{ $rs->status }}"
                                                    data-user="{{ $rs->user ? ($rs->user->type == 0 ? 'admin' : 'user') : 'N/A' }}"
                                                    data-created="{{ $rs->created_at }}"
                                                    data-updated="{{ $rs->updated_at }}"
                                                    data-updated-user="{{ $rs->updatedUser ? ($rs->updatedUser->type == 0 ? 'admin' : 'user') : 'N/A' }}">
                                                    See more
                                                </a>
                                            @else
                                                {{ $rs->description }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-outline-primary"><i class="bi bi-hand-thumbs-up"></i>
                                            Like</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-warning text-center" role="alert">
                                Post not found
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row mt-3">
                    <div class="col-md-1">
                        {!! $postlist->appends(['page-size' => $pageSize])->links() !!}
                    </div>
                </div>
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

    <!-- Post Detail Modal -->
    <div class="modal fade" id="postDetailModal" tabindex="-1" aria-labelledby="postDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postDetailModalLabel">Post Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Title:</strong> <span id="modalPostTitle"></span></p>
                    <p><strong>Description:</strong> <span id="modalPostDescription"></span></p>
                    <p><strong>Status:</strong> <span id="modalPostStatus"></span></p>
                    <p><strong>Posted User:</strong> <span id="modalPostedUser"></span></p>
                    <p><strong>Posted Date:</strong> <span id="modalPostedDate"></span></p>
                    <p><strong>Updated Date:</strong> <span id="modalUpdatedDate"></span></p>
                    <p><strong>Updated User:</strong> <span id="modalUpdatedUser"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to make the success message disappear after a few seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3000); // 3000 milliseconds = 3 seconds
            }
        });

        const pageSizeSelect = document.querySelectorAll('#page-size');

        pageSizeSelect.forEach(select => {
            select.addEventListener('change', function() {
                const selectedPageSize = this.value;
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('page-size', selectedPageSize);
                window.location.href = currentUrl.href;
            });
        });

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

        const postDetailModal = document.getElementById('postDetailModal');
        postDetailModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const postTitle = button.getAttribute('data-title');
            const postDescription = button.getAttribute('data-description');
            const postStatus = button.getAttribute('data-status');
            const postedUser = button.getAttribute('data-user');
            const postedDate = button.getAttribute('data-created');
            const updatedDate = button.getAttribute('data-updated');
            const updatedUser = button.getAttribute('data-updated-user');

            const modalPostTitle = postDetailModal.querySelector('#modalPostTitle');
            const modalPostDescription = postDetailModal.querySelector('#modalPostDescription');
            const modalPostStatus = postDetailModal.querySelector('#modalPostStatus');
            const modalPostedUser = postDetailModal.querySelector('#modalPostedUser');
            const modalPostedDate = postDetailModal.querySelector('#modalPostedDate');
            const modalUpdatedDate = postDetailModal.querySelector('#modalUpdatedDate');
            const modalUpdatedUser = postDetailModal.querySelector('#modalUpdatedUser');

            modalPostTitle.textContent = postTitle;
            modalPostDescription.textContent = postDescription;
            modalPostStatus.textContent = postStatus == 1 ? 'Active' : 'Inactive';
            modalPostedUser.textContent = postedUser;
            modalPostedDate.textContent = postedDate;
            modalUpdatedDate.textContent = updatedDate;
            modalUpdatedUser.textContent = updatedUser;
        });
    </script>
@endsection
