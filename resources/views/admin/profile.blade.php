<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.system_short_name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/sc_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>
<body>
    @include('plugin.navbar')
    <img src="img/sc_logo_bgr.png" alt="EVSU-DC Logo" class="logo">

    <div class="container mt-5 text-white">
        <h3 class="text-center mb-4">Edit Profile</h3>
        <form id="editProfileForm">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">First Name</label>
                    <input type="text" id="editFname" class="form-control" value="{{ $user->first_name }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" id="editLname" class="form-control" value="{{ $user->last_name }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Age</label>
                    <input type="number" id="editAge" class="form-control" value="{{ $user->age }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Gender</label>
                    <select id="editGender" class="form-control">
                        <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Address</label>
                    <input type="text" id="editAddress" class="form-control" value="{{ $user->address }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" id="editEmail" class="form-control" value="{{ $user->email }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Birthday</label>
                    <input type="date" id="editBirthday" class="form-control" value="{{ $user->birthday }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact Number</label>
                    <input type="text" id="editContact" class="form-control" value="{{ $user->contact_number }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password (leave blank to keep current)</label>
                    <input type="password" id="editPassword" class="form-control">
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#editProfileForm').submit(function (e) {
                e.preventDefault();
                
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

                let password = $('#editPassword').val();
                if (password.trim() !== '') {
                    data.password = password;
                }
                
                $.ajax({
                    url: "/users/" + "{{ $user->id }}",
                    method: "PATCH",
                    data: data,
                    success: function (response) {
                        alert('Profile updated successfully.');
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
