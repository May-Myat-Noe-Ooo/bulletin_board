@extends('layouts.app')

@section('body')


    <div class="container-md col-sm-12 mt-2 mb-2">
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
                            <a href="{{ route('home') }}">Home</a>
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
                        {{-- Page size selection form --}}
                        <form class="search-form" method="GET" action="{{ route('postlist.index') }}" id="pageSizeForm">
                            <label for="page-size">Page Size:</label>
                            <select name="page-size" id="page-size" class="form-select d-inline-block w-auto">
                                <option value="6" {{ $pageSize == 6 ? 'selected' : '' }}>6</option>
                                <option value="12" {{ $pageSize == 12 ? 'selected' : '' }}>12</option>
                                <option value="18" {{ $pageSize == 18 ? 'selected' : '' }}>18</option>
                                <option value="24" {{ $pageSize == 24 ? 'selected' : '' }}>24</option>
                            </select>
                            <input type="hidden" name="page-size-changed" id="page-size-changed" value="0">
                            <input type="hidden" name="search-keyword" value="{{ request('search-keyword') }}">
                        </form>
                    </div>
                    <div class="col-md-8 text-end">
                        <form class="search-form" method="GET"
                            action="{{ request()->route()->getName() == 'home' ? route('home') : route('postlist.index') }}">
                            <label class="mr-2">Keyword:</label>
                            <input class="search btn border border-secondary" type="text" name="search-keyword"
                                placeholder="Type Something" value="{{ request('search-keyword') }}">
                            <input type="hidden" name="current-route" value="{{ request()->route()->getName() }}">
                            <button type="submit" class="btn btn-dark">Search</button>
                            <a href="{{ route('createpost') }}" class="btn btn-dark">Create</a>
                            <a href="{{ route('upload_file') }}" class="btn btn-dark">Upload</a>
                            <a href="{{ route('postlists.export', ['search-keyword' => request('search-keyword'), 'current-route' => request()->route()->getName()]) }}"
                                class="btn btn-dark">Download</a>
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
                                                <div>{{ $rs->user->name }}</div>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-clock me-1"></i>
                                                    <span>{{ $rs->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @auth
                                            @if (($route == 'postlist.index' && Auth::user()->type == 0) || ($route == 'postlist.index' && Auth::user()->type == 1))
                                                <div class="dropdown">
                                                    <button class="btn btn-link p-0 " type="button" id="dropdownMenuButton"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots custom-dot"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#postDetailModal"
                                                                data-title="{{ $rs->title }}"
                                                                data-description="{{ $rs->description }}"
                                                                data-status="{{ $rs->status }}"
                                                                data-user="{{ $rs->user ? ($rs->user->type == 0 ? 'admin' : 'user') : 'N/A' }}"
                                                                data-created="{{ $rs->created_at }}"
                                                                data-updated="{{ $rs->updated_at }}"
                                                                data-updated-user="{{ $rs->updatedUser ? ($rs->updatedUser->type == 0 ? 'admin' : 'user') : 'N/A' }}">
                                                                <i class="bi bi-info-circle me-2"></i>Details</a></li>
                                                        <li>
                                                            <a href="{{ route('postlist.edit', $rs->id) }}"
                                                                class="dropdown-item">
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
                                            @endif
                                        @endauth
                                    </div>
                                    <div class="card-body position-relative">
                                        <h5 class="card-title">
                                            <a href="#" class="post-title-link" data-bs-toggle="modal"
                                                data-bs-target="#postDetailModal" data-title="{{ $rs->title }}"
                                                data-description="{{ $rs->description }}"
                                                data-status="{{ $rs->status }}"
                                                data-user="{{ $rs->user ? ($rs->user->type == 0 ? 'admin' : 'user') : 'N/A' }}"
                                                data-created="{{ $rs->created_at }}"
                                                data-updated="{{ $rs->updated_at }}"
                                                data-updated-user="{{ $rs->updatedUser ? ($rs->updatedUser->type == 0 ? 'admin' : 'user') : 'N/A' }}"
                                                style="opacity: {{ $rs->status == 0 ? '0.5' : '1' }}">
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
                                                    data-updated-user="{{ $rs->updatedUser ? ($rs->updatedUser->type == 0 ? 'admin' : 'user') : 'N/A' }}"
                                                    style="opacity: {{ $rs->status == 0 ? '0.5' : '1' }}">
                                                    See more
                                                </a>
                                            @else
                                                {{ $rs->description }}
                                            @endif
                                        </p>
                                    </div>
                                    @auth
                                        <div class="card-footer d-flex justify-content-between align-items-center">
                                            <span class="likes-count" data-post-id="{{ $rs->id }}"
                                                data-bs-toggle="modal" data-bs-target="#likesModal" style="cursor:pointer;">
                                                {{ $rs->likes->count() }} {{ $rs->likes->count() <= 1? 'Like' : 'Likes' }}
                                            </span>
                                            <button
                                                class="btn btn-like {{ $rs->likes->contains('user_id', Auth::id()) ? 'liked' : '' }}"
                                                type="button" data-post-id="{{ $rs->id }}">
                                                <i class="bi bi-hand-thumbs-up"></i> Like
                                            </button>
                                        </div>
                                    @endauth
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

                <div class="row mt-3 float-start">
                    <div class="reset-nav">
                        {!! $postlist->appends(['page-size' => $pageSize, 'search-keyword' => request('search-keyword')])->links() !!}
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
                    <div class="row mb-2">
                        <div class="col-5 d-flex align-items-center">
                            <i class="bi bi-hash me-2"></i><strong>ID:</strong>
                        </div>
                        <div class="col-7">
                            <p class="mb-0 mt-2"><span id="postId"></span></p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 d-flex align-items-center">
                            <i class="bi bi-file-earmark-text me-2"></i><strong>Title:</strong>
                        </div>
                        <div class="col-7">
                            <p class="mb-0 mt-2"><span id="postTitle"></span></p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 d-flex align-items-center">
                            <i class="bi bi-card-text me-2"></i><strong>Description:</strong>
                        </div>
                        <div class="col-7">
                            <p class="mb-0 mt-2"><span id="postDescription"></span></p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 d-flex align-items-center">
                            <i class="bi bi-check-circle me-2"></i><strong>Status:</strong>
                        </div>
                        <div class="col-7">
                            <p class="mb-0 mt-2"><span id="postStatus"></span></p>
                        </div>
                    </div>
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
                    <div class="row mb-2">
                        <div class="col-5 d-flex align-items-center">
                            <i class="bi bi-file-earmark-text me-2"></i><strong>Title:</strong>
                        </div>
                        <div class="col-7">
                            <p class="mb-0 mt-2"><span id="modalPostTitle"></span></p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 d-flex align-items-center">
                            <i class="bi bi-card-text me-2"></i><strong>Description:</strong>
                        </div>
                        <div class="col-7">
                            <p class="mb-0 mt-2"><span id="modalPostDescription"></span></p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 d-flex align-items-center">
                            <i class="bi bi-check-circle me-2"></i><strong>Status:</strong>
                        </div>
                        <div class="col-7">
                            <p class="mb-0 mt-2"><span id="modalPostStatus"></span></p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 d-flex align-items-center">
                            <i class="bi bi-person-check me-2"></i><strong>Posted User:</strong>
                        </div>
                        <div class="col-7">
                            <p class="mb-0 mt-2"><span id="modalPostedUser"></span></p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 d-flex align-items-center">
                            <i class="bi bi-calendar-event me-2"></i><strong>Posted Date:</strong>
                        </div>
                        <div class="col-7">
                            <p class="mb-0 mt-2"><span id="modalPostedDate"></span></p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 d-flex align-items-center">
                            <i class="bi bi-calendar-check me-2"></i><strong>Updated Date:</strong>
                        </div>
                        <div class="col-7">
                            <p class="mb-0 mt-2"><span id="modalUpdatedDate"></span></p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 d-flex align-items-center">
                            <i class="bi bi-person-lines-fill me-2"></i><strong>Updated User:</strong>
                        </div>
                        <div class="col-7">
                            <p class="mb-0 mt-2"><span id="modalUpdatedUser"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Likes Modal -->
    <div class="modal fade" id="likesModal" tabindex="-1" aria-labelledby="likesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="likesModalLabel">Like Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="likesList"></div>
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
            document.getElementById('page-size').addEventListener('change', function() {
                document.getElementById('page-size-changed').value = '1';
                document.getElementById('pageSizeForm').submit();
            });

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

        // resources/js/likes.js
        document.addEventListener('DOMContentLoaded', function() {
            const likeButtons = document.querySelectorAll('.btn-like');
            const likesCounts = document.querySelectorAll('.likes-count');

            likeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');
                    const likeButton = this;

                    fetch(`/posts/${postId}/like`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            const likesCount = document.querySelector(
                                `.likes-count[data-post-id="${postId}"]`);
                            likesCount.textContent = `${data.likes_count} ${data.likes_count <= 1 ? 'Like' : 'Likes'}`;

                            if (data.liked_by_user) {
                                likeButton.classList.add('liked');
                            } else {
                                likeButton.classList.remove('liked');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            likesCounts.forEach(span => {
                span.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');

                    fetch(`/posts/${postId}/likes`, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            const likesList = document.getElementById('likesList');
                            likesList.innerHTML = '';
                            data.likers.forEach(liker => {
                                likesList.innerHTML += `<div class="d-flex align-items-center mb-2">
                        <img src="${liker.profile}" alt="Profile" class="rounded-circle me-2" width="30" height="30">
                        <span>${liker.name}</span>
                    </div>`;
                            });
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endsection
