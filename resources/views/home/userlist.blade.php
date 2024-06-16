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
    <div class="col float-middle mb-5 mt-5">
        <div class="row ">
            <div class="col-md-12">
                <form class="search-form justify">

                    <div class="col d-flex justify-content-around align-item-center">
                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-2 ">Name:</label>
                            <div class="col-sm-8"><input type="text" name="name" class="form-control" value="">
                            </div>
                        </div>


                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-2 ">Email:</label>
                            <div class="col-sm-8"><input type="text" name="mailaddr" class="form-control" value="">
                            </div>
                        </div>

                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-2 ">From:</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-lg" id="dd" type="date" name="date" />
                            </div>
                        </div>

                        <div class="col d-flex justify-content-around align-item-center">
                            <label for="" class="form-label col-sm-2 ">To:</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-lg" id="dd" type="date" name="date" />
                            </div>
                        </div>

                        <div>
                            <div class="col-sm-8">
                                <a href="#" class="btn btn-success">Search</a>
                            </div>
                        </div>
                    </div>

                </form>

            </div>

        </div>

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
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $rs->id }}" data-name="{{ $rs->name }}" data-type="{{ $rs->type }}" data-email="{{ $rs->email }}" data-phone="{{ $rs->phone }}" data-dob="{{ $rs->dob }}" data-address="{{ $rs->address }}">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="9">User not found</td>
                </tr>
            @endif
        </tbody>
    </table>
    {!! $userlist->links() !!}

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

    <script>
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
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
            modalBodyType.textContent = userType;
            modalBodyEmail.textContent = userEmail;
            modalBodyPhone.textContent = userPhone;
            modalBodyDob.textContent = userDob;
            modalBodyAddress.textContent = userAddress;
            deleteForm.action = `/users/${userId}`;
        });
    </script>

@endsection
