@extends('layouts.app')

@section('body')

    <div class="col float-middle mb-5 mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                User List
            </div>
            @if (Session::has('success'))
        <div id="success-message" class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
            <div class="card-body">
                <div class="row mb-4">
                    
                    <form class="search-form col-md-2 text-start mb-3" method="GET" action="{{ route('displayuser') }}">
                        <label for="page-size">Page Size:</label>
                        <select name="page-size" id="page-size" class="form-select d-inline-block w-auto">
                            <option value="5" {{ $pageSize == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ $pageSize == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ $pageSize == 15 ? 'selected' : '' }}>15</option>
                            <option value="20" {{ $pageSize == 20 ? 'selected' : '' }}>20</option>
                        </select>
                    </form>
                    <form class="search-form col-md-10 text-end mb-3" method="GET" action="{{ route('displayuser') }}">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col-md-2 d-flex">
                                <label for="name" class="form-label col-sm-4">Name:</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ request('name') }}">
                            </div>
                            <div class="col-md-2 d-flex">
                                <label for="email" class="form-label col-sm-4">Email:</label>
                                <input type="text" name="mailaddr" class="form-control" id="email" value="{{ request('mailaddr') }}">
                            </div>
                            <div class="col-md-3 d-flex">
                                <label for="from-date" class="form-label col-sm-3">From:</label>
                                <input type="date" name="from-date" class="form-control" id="from-date" value="{{ request('from-date') }}">
                            </div>
                            <div class="col-md-3 d-flex">
                                <label for="to-date" class="form-label col-sm-2">To:</label>
                                <input type="date" name="to-date" class="form-control" id="to-date" value="{{ request('to-date') }}">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-success w-100">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                                <div class="row">
                    @if ($userlist->count() > 0)
                        @foreach ($userlist as $rs)
                            <div class="userlist col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span>{{ $rs->name }}</span>
                                        <div class="dropdown">
                                            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </button>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#userDetailModal"
                                                    data-name="{{ $rs->name }}"
                                                    data-type="{{ $rs->type }}"
                                                    data-email="{{ $rs->email }}"
                                                    data-phone="{{ $rs->phone }}"
                                                    data-dob="{{ $rs->dob }}"
                                                    data-address="{{ $rs->address }}"
                                                    data-created="{{ $rs->created_at }}"
                                                    data-created-user="{{ $rs->createdBy->name }}"
                                                    data-updated="{{ $rs->updated_at }}"
                                                    data-updated-user="{{ $rs->updatedBy->name }}">
                                                    <i class="bi bi-info-circle me-2"></i>Details</a></li>
                                                <li><a class="dropdown-item" href="#">
                                                <i class="bi bi-pencil-square me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal"
                                                        data-id="{{ $rs->id }}"
                                                        data-name="{{ $rs->name }}">
                                                        <i class="bi bi-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <img src="{{ asset($rs->profile) }}" alt="Profile" class="rounded-circle mb-3" width="100" height="100">
                                        <h5 class="card-title">{{ $rs->name }}</h5>
                                        <p class="card-text">{{ $rs->email }}</p>
                                        <p class="card-text"><small class="text-muted">{{ $rs->createdBy->name }} - {{ $rs->created_at->diffForHumans() }}</small></p>
                                    </div>
                                    <div class="card-footer text-muted">
                                        <span>{{ $rs->type == 0 ? 'Admin' : 'User' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info">User not found</div>
                        </div>
                    @endif
                </div>

                {!! $userlist->appends(['page-size' => $pageSize])->links() !!}
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
                    <p>Are you sure you want to delete the user?</p>
                    <p><strong>ID:</strong> <span id="userId"></span></p>
                    <p><strong>Name:</strong> <span id="userName"></span></p>
                    <p><strong>Type:</strong> <span id="userType"></span></p>
                    <p><strong>Email:</strong> <span id="userEmail"></span></p>
                    <p><strong>Phone:</strong> <span id="userPhone"></span></p>
                    <p><strong>Date of Birth:</strong> <span id="userDob"></span></p>
                    <p><strong>Address:</strong> <span id="userAddress"></span></p>
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

    <!-- User Detail Modal -->
<div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailModalLabel">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="userName"></span></p>
                    <p><strong>Type:</strong> <span id="userType"></span></p>
                    <p><strong>Email:</strong> <span id="userEmail"></span></p>
                    <p><strong>Phone:</strong> <span id="userPhone"></span></p>
                    <p><strong>Date of Birth:</strong> <span id="userDob"></span></p>
                    <p><strong>Address:</strong> <span id="userAddress"></span></p>
                    <p><strong>Created Date:</strong> <span id="userCreatedDate"></span></p>
                    <p><strong>Created User:</strong> <span id="userCreatedUser"></span></p>
                    <p><strong>Updated Date:</strong> <span id="userUpdatedDate"></span></p>
                    <p><strong>Updated User:</strong> <span id="userUpdatedUser"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <script>
        // Function to make the success message disappear after a few seconds
        document.addEventListener('DOMContentLoaded', function () {
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
            const userId = button.getAttribute('data-id');
            const userName = button.getAttribute('data-name');
            const userType = button.getAttribute('data-type');
            const userEmail = button.getAttribute('data-email');
            const userPhone = button.getAttribute('data-phone');
            const userDob = button.getAttribute('data-dob');
            const userAddress = button.getAttribute('data-address');

            const modalTitle = deleteModal.querySelector('.modal-title');
            const modalBodyId = deleteModal.querySelector('#userId');
            const modalBodyName = deleteModal.querySelector('#userName');
            const modalBodyType = deleteModal.querySelector('#userType');
            const modalBodyEmail = deleteModal.querySelector('#userEmail');
            const modalBodyPhone = deleteModal.querySelector('#userPhone');
            const modalBodyDob = deleteModal.querySelector('#userDob');
            const modalBodyAddress = deleteModal.querySelector('#userAddress');
            const deleteForm = deleteModal.querySelector('#deleteForm');

            modalTitle.textContent = `Delete Confirm - ${userName}`;
            modalBodyId.textContent = userId;
            modalBodyName.textContent = userName;
            modalBodyType.textContent = userType == 0 ? 'Admin' : 'User';;
            modalBodyEmail.textContent = userEmail;
            modalBodyPhone.textContent = userPhone;
            modalBodyDob.textContent = userDob;
            modalBodyAddress.textContent = userAddress;
            deleteForm.action = `/users/${userId}/destroy`;
        });

        const userDetailModal = document.getElementById('userDetailModal');
    userDetailModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const userName = button.getAttribute('data-name');
        const userType = button.getAttribute('data-type');
        const userEmail = button.getAttribute('data-email');
        const userPhone = button.getAttribute('data-phone');
        const userDob = button.getAttribute('data-dob');
        const userAddress = button.getAttribute('data-address');
        const userCreatedDate = button.getAttribute('data-created');
        const userCreatedUser = button.getAttribute('data-created-user');
        const userUpdatedDate = button.getAttribute('data-updated');
        const userUpdatedUser = button.getAttribute('data-updated-user');

        const modalBodyName = userDetailModal.querySelector('#userName');
        const modalBodyType = userDetailModal.querySelector('#userType');
        const modalBodyEmail = userDetailModal.querySelector('#userEmail');
        const modalBodyPhone = userDetailModal.querySelector('#userPhone');
        const modalBodyDob = userDetailModal.querySelector('#userDob');
        const modalBodyAddress = userDetailModal.querySelector('#userAddress');
        const modalCreatedDate = userDetailModal.querySelector('#userCreatedDate');
        const modalCreatedUser = userDetailModal.querySelector('#userCreatedUser');
        const modalUpdatedDate = userDetailModal.querySelector('#userUpdatedDate');
        const modalUpdatedUser = userDetailModal.querySelector('#userUpdatedUser');

        modalBodyName.textContent = userName;
        modalBodyType.textContent = userType == 0 ? 'Admin' : 'User';;
        modalBodyEmail.textContent = userEmail;
        modalBodyPhone.textContent = userPhone;
        modalBodyDob.textContent = userDob;
        modalBodyAddress.textContent = userAddress;
        modalCreatedDate.textContent = userCreatedDate;
        modalCreatedUser.textContent = userCreatedUser;
        modalUpdatedDate.textContent = userUpdatedDate;
        modalUpdatedUser.textContent = userUpdatedUser;
    });

    </script>

@endsection
