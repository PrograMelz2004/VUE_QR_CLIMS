<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.system_short_name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/sc_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, rgba(0, 0, 0, 1) 0%, rgba(255, 140, 0, 1) 100%);
            height: 100vh;
        }
        .logo {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
            opacity: 0.1;
            z-index: -1;
        }
        .receipt-table {
            font-family: "Courier New", Courier, monospace;
            width: 100%;
            background: rgba(0, 0, 0, 0.50);
            border-collapse: collapse;
            color: white;
        }
        .receipt-table th, .receipt-table td {
            text-align: left;
            padding: 5px;
        }
        .receipt-table th {
            border-bottom: 2px dashed white;
        }
        .receipt-table td {
            border-bottom: 1px dashed gray;
        }
    </style>
</head>
<body>
    @include('plugin.navbar')

    <img src="img/sc_logo_bgr.png" alt="EVSU-DC Logo" class="logo">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>
                <a class="btn btn-success btn-sm" href="{{ route('download.user') }}">
                    <img src="img/print.png" width="24" class="me-2"> PDF
                </a>
            </div>
            <input type="text" id="search" class="form-control form-control-sm w-25" placeholder="Search...">
        </div>
        <table class="receipt-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTable">
                @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}.</td>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('M. d, Y h:i A') }}</td>
                    <td>
                        <button class="btn btn-success btn-sm userModal" data-user='@json($user)'>View Details</button>
                        <button class="btn btn-warning btn-sm editUserBtn" data-user='@json($user)'>Edit</button>
                        <button class="btn btn-danger btn-sm deleteUserBtn" data-id="{{ $user->id }}">Delete</button>
                    </td>
                </tr>
                @endforeach
                <tr id="noResultsRow" style="display: none;">
                    <td colspan="5" class="text-center text-white">No results found</td>
                </tr>
            </tbody>
        </table>
    </div>

   @include('modals.users_modals')

<script>
    $(document).ready(function () {
        $('#search').on('keyup', function () {
            let value = $(this).val().toLowerCase();
            let found = false;
            $('#userTable tr').each(function () {
                if ($(this).text().toLowerCase().includes(value)) {
                    $(this).show();
                    found = true;
                } else {
                    $(this).hide();
                }
            });
            $('#noResultsRow').toggle(!found);
        });

        $('.userModal').click(function () {
            let user = $(this).data('user');
            $('#viewFname').val(user.first_name);
            $('#viewLname').val(user.last_name);
            $('#viewEmail').val(user.email);
            $('#viewContact').val(user.contact_number);
            $('#viewAge').val(user.age);
            $('#viewGender').val(user.gender);
            $('#viewAddress').val(user.address);
            $('#viewBirthday').val(user.birthday);
            $('#viewUserModal').modal('show');
        });

        $('.editUserBtn').click(function () {
            let user = $(this).data('user');
            $('#editUserId').val(user.id);
            $('#editFname').val(user.first_name);
            $('#editLname').val(user.last_name);
            $('#editEmail').val(user.email);
            $('#editContact').val(user.contact_number);
            $('#editAge').val(user.age);
            $('#editGender').val(user.gender);
            $('#editAddress').val(user.address);
            $('#editBirthday').val(user.birthday);
            $('#editUserModal').modal('show');
        });

        $('.deleteUserBtn').click(function () {
            let id = $(this).data('id');
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: "/users/" + id,
                    method: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function () {
                        alert("User deleted successfully!");
                        location.reload();
                    },
                    error: function () {
                        alert("Something went wrong! Please try again.");
                    }
                });
            }
        });

        $('#addUserForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('users.store') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    first_name: $('#addFname').val(),
                    last_name: $('#addLname').val(),
                    age: $('#addAge').val(),
                    gender: $('#addGender').val(),
                    address: $('#addAddress').val(),
                    email: $('#addEmail').val(),
                    password: $('#addPassword').val(),
                    birthday: $('#addBirthday').val(),
                    contact_number: $('#addContact').val()
                },
                success: function (response) {
                    alert('User added successfully.');
                    location.reload();
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "Error adding new User.\n";
                    $.each(errors, function (key, value) {
                        errorMessage += "- " + value + "\n";
                    });
                    alert(errorMessage);
                }
            });
        });

        $('#editUserForm').submit(function (e) {
            e.preventDefault();
            let id = $('#editUserId').val();
            let password = $('#editPassword').val();

            let data = {
                _token: "{{ csrf_token() }}",
                first_name: $('#editFname').val(),
                last_name: $('#editLname').val(),
                age: $('#editAge').val(),
                gender: $('#editGender').val(),
                address: $('#editAddress').val(),
                email: $('#editEmail').val(),
                birthday: $('#editBirthday').val(),
                contact_number: $('#editContact').val()
            };

            if (password.trim() !== '') {
                data.password = password;
            }

            $.ajax({
                url: "/users/" + id,
                method: "PATCH",
                data: data,
                success: function (response) {
                    alert('Edited successfully.');
                    location.reload();
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "Please correct the following errors:\n";
                    $.each(errors, function (key, value) {
                        errorMessage += "- " + value + "\n";
                    });
                    alert(errorMessage);
                }
            });
        });
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</body>
</html>
