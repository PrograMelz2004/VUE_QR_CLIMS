<!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addRoomForm">
                        @csrf
                        <div class="mb-3">
                            <label for="room_name" class="form-label">Room Name</label>
                            <input type="text" name="room_name" class="form-control" id="room_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Edit Room Modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editRoomForm">
                        @csrf
                        <input type="hidden" name="room_id" id="edit_room_id">
                        <div class="mb-3">
                            <label for="edit_room_name" class="form-label">Room Name</label>
                            <input type="text" name="room_name" class="form-control" id="edit_room_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Modal for Editing Short Name -->
<div class="modal fade" id="editSNameModal" tabindex="-1" aria-labelledby="editSNameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editShortNameForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSNameModalLabel">Edit System Short Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="sysIdShort" name="sysId" value="{{ $system->id }}">
                    <input type="text" id="editSysShortName" name="sys_s_name" class="form-control" value="{{ $system->sys_s_name }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Editing Long Name -->
<div class="modal fade" id="editLNameModal" tabindex="-1" aria-labelledby="editLNameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editLongNameForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLNameModalLabel">Edit System Long Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="sysIdLong" name="sysId" value="{{ $system->id }}">
                    <input type="text" id="editSysLongName" name="sys_l_name" class="form-control" value="{{ $system->sys_l_name }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
