 <div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="addUserForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <label for="addFname" class="col-4 col-form-label">First Name:</label>
                        <div class="col-8">
                            <input type="text" id="addFname" name="first_name" class="form-control" placeholder="First Name" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="addLname" class="col-4 col-form-label">Last Name:</label>
                        <div class="col-8">
                            <input type="text" id="addLname" name="last_name" class="form-control mt-2" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="addBirthday" class="col-4 col-form-label">Birthday:</label>
                        <div class="col-8">
                            <input type="date" id="addBirthday" name="birthday" class="form-control mt-2" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="addAge" class="col-4 col-form-label">Age:</label>
                        <div class="col-8">
                            <input type="number" id="addAge" name="age" class="form-control mt-2" placeholder="Age" required readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="addGender" class="col-4 col-form-label">Gender:</label>
                        <div class="col-8">
                            <select id="addGender" class="form-control" required>
                                <option value="" disabled selected>----select----</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="addAddress" class="col-4 col-form-label">Address:</label>
                        <div class="col-8">
                            <input type="text" id="addAddress" name="address" class="form-control mt-2" placeholder="Address" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="addEmail" class="col-4 col-form-label">Email:</label>
                        <div class="col-8">
                            <input type="email" id="addEmail" name="email" class="form-control mt-2" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="addContact" class="col-4 col-form-label">Contact Number:</label>
                        <div class="col-8">
                            <input type="text" id="addContact" name="contact_number" class="form-control mt-2" placeholder="Contact Number" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="addPassword" class="col-4 col-form-label">Password:</label>
                        <div class="col-8">
                            <input type="password" id="addPassword" name="password" class="form-control mt-2" placeholder="Password" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="viewUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <label for="viewFname" class="col-4 col-form-label">First Name:</label>
                    <div class="col-8">
                        <input type="text" id="viewFname" class="form-control" disabled>
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="viewLname" class="col-4 col-form-label">Last Name:</label>
                    <div class="col-8">
                        <input type="text" id="viewLname" class="form-control" disabled>
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="viewEmail" class="col-4 col-form-label">Email:</label>
                    <div class="col-8">
                        <input type="email" id="viewEmail" class="form-control" disabled>
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="viewContact" class="col-4 col-form-label">Contact Number:</label>
                    <div class="col-8">
                        <input type="text" id="viewContact" class="form-control" disabled>
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="viewAge" class="col-4 col-form-label">Age:</label>
                    <div class="col-8">
                        <input type="number" id="viewAge" class="form-control" disabled>
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="viewGender" class="col-4 col-form-label">Gender:</label>
                    <div class="col-8">
                        <input type="text" id="viewGender" class="form-control" disabled>
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="viewAddress" class="col-4 col-form-label">Address:</label>
                    <div class="col-8">
                        <input type="text" id="viewAddress" class="form-control" disabled>
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="viewBirthday" class="col-4 col-form-label">Birthday:</label>
                    <div class="col-8">
                        <input type="date" id="viewBirthday" class="form-control" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editUserForm">
            @csrf
            <input type="hidden" id="editUserId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <label for="editFname" class="col-4 col-form-label">First Name:</label>
                        <div class="col-8">
                            <input type="text" id="editFname" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="editLname" class="col-4 col-form-label">Last Name:</label>
                        <div class="col-8">
                            <input type="text" id="editLname" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="editEmail" class="col-4 col-form-label">Email:</label>
                        <div class="col-8">
                            <input type="email" id="editEmail" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="editContact" class="col-4 col-form-label">Contact Number:</label>
                        <div class="col-8">
                            <input type="text" id="editContact" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="editBirthday" class="col-4 col-form-label">Birthday:</label>
                        <div class="col-8">
                            <input type="date" id="editBirthday" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="editAge" class="col-4 col-form-label">Age:</label>
                        <div class="col-8">
                            <input type="number" id="editAge" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="editGender" class="col-4 col-form-label">Gender:</label>
                        <div class="col-8">
                            <select id="editGender" name="editGender" class="form-control" required>
                                <option value="Male" {{ old('editGender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('editGender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="editAddress" class="col-4 col-form-label">Address:</label>
                        <div class="col-8">
                            <input type="text" id="editAddress" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="editPassword" class="col-4 col-form-label">Password:</label>
                        <div class="col-8">
                            <input type="password" id="editPassword" class="form-control" placeholder="Leave blank if not editing...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
