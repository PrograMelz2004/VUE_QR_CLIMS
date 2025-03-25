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
            position: fixed;
            bottom: 10px;
            left: 10px;
            width: 100px;
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

        .table-container {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }
    </style>
</head>
<body>
    @include('plugin.navbar')
    <img src="{{ asset('img/sc_logo_bgr.png') }}" alt="EVSU-DC Logo" class="logo">

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="p-3 bg-dark text-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Rooms</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal">Add New</button>
                    </div>
                    <div class="table-container mt-4">
                        <table class="receipt-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="roomsTable">
                                @foreach($rooms as $index => $room)
                                    <tr id="roomRow_{{ $room->id }}">
                                        <td>{{ $index + 1 }}.</td>
                                        <td>{{ $room->name }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning editRoomBtn" data-id="{{ $room->id }}" data-name="{{ $room->name }}" data-bs-toggle="modal" data-bs-target="#editRoomModal">Edit</button>
                                            <button class="btn btn-sm btn-danger deleteRoomBtn" data-id="{{ $room->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-dark text-white">
                    <h3>System Short Name</h3>
                    <input type="text" id="sysShortName" value="{{ $system->sys_s_name }}" class="form-control mb-2" readonly>
                    <div class="text-end">
                        <button class="btn btn-sm btn-warning editSName" data-bs-toggle="modal" data-bs-target="#editSNameModal">Edit</button>
                    </div>
                </div>

                <div class="p-3 bg-dark text-white mt-3">
                    <h3>System Long Name</h3>
                    <input type="text" id="sysLongName" value="{{ $system->sys_l_name }}" class="form-control mb-2" readonly>
                    <div class="text-end">
                        <button class="btn btn-sm btn-warning editLName" data-bs-toggle="modal" data-bs-target="#editLNameModal">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.rooms_modals')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#addRoomForm').submit(function(e){
                e.preventDefault();
                $.post("{{ route('room.add') }}", $(this).serialize(), function(){
                    $('#addRoomModal').modal('hide');
                    location.reload();
                }).fail(function(response){
                    alert('Error adding room: ' + response.responseText);
                });
            });

            $('.editRoomBtn').click(function(){
                $('#edit_room_id').val($(this).data('id'));
                $('#edit_room_name').val($(this).data('name'));
            });

            $('#editRoomForm').submit(function(e){
                e.preventDefault();
                $.post("{{ route('room.update') }}", $(this).serialize(), function(){
                    $('#editRoomModal').modal('hide');
                    location.reload();
                }).fail(function(response){
                    alert('Error updating room: ' + response.responseText);
                });
            });

            $('.deleteRoomBtn').click(function(){
                let roomId = $(this).data('id');
                if(confirm("Are you sure you want to delete this room?")) {
                    $.post("{{ route('room.delete') }}", { _token: '{{ csrf_token() }}', id: roomId }, function(){
                        $('#roomRow_' + roomId).fadeOut();
                    }).fail(function(response){
                        alert('Error deleting room: ' + response.responseText);
                    });
                }
            });

            // Open Short Name Modal & Populate Input
            $(".editSName").click(function(){
                $("#editSysShortName").val($("#sysShortName").val());
            });

            // Save Updated Short Name
            $("#editShortNameForm").submit(function(e){
                e.preventDefault(); // Prevent default form submission
                let newShortName = $("#editSysShortName").val();
                let systemId = $("#sysIdShort").val(); // Get correct hidden input value

                $.post("{{ route('system.update.short_name') }}", {
                    _token: '{{ csrf_token() }}',
                    id: systemId,
                    sys_s_name: newShortName
                }, function(response){
                    $("#sysShortName").val(newShortName);
                    $("#editSNameModal").modal('hide');
                    location.reload();
                }).fail(function(error){
                    alert("Error updating system short name: " + error.responseText);
                });
            });

            // Open Long Name Modal & Populate Input
            $(".editLName").click(function(){
                $("#editSysLongName").val($("#sysLongName").val());
            });

            // Save Updated Long Name
            $("#editLongNameForm").submit(function(e){
                e.preventDefault(); // Prevent default form submission
                let newLongName = $("#editSysLongName").val();
                let systemId = $("#sysIdLong").val(); // Get correct hidden input value

                $.post("{{ route('system.update.long_name') }}", {
                    _token: '{{ csrf_token() }}',
                    id: systemId,
                    sys_l_name: newLongName
                }, function(response){
                    $("#sysLongName").val(newLongName);
                    $("#editLNameModal").modal('hide');
                    location.reload();
                }).fail(function(error){
                    alert("Error updating system long name: " + error.responseText);
                });
            });
        });
    </script>
</body>
</html>
