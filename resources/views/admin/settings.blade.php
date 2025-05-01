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
            max-height: calc(100vh - 300px);
            overflow-y: auto;
        }
    </style>
</head>
<body>
    @include('plugin.navbar')
    <img src="{{ asset('img/sc_logo_bgr.png') }}" alt="EVSU-DC Logo" class="logo">

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white">System Information</h2>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editSystemNamesModal">Edit System Names</button>
        </div>

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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Items</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">Add New</button>
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
                            <tbody id="itemsTable">
                                @foreach($items as $index => $item)
                                    <tr id="itemRow_{{ $item->id }}">
                                        <td>{{ $index + 1 }}.</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning editItemBtn" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-bs-toggle="modal" data-bs-target="#editItemModal">Edit</button>
                                            <button class="btn btn-sm btn-danger deleteItemBtn" data-id="{{ $item->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.system_modals')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){

            // Add Room
            $('#addRoomForm').submit(function(e){
                e.preventDefault();
                $.post("{{ route('room.add') }}", $(this).serialize(), function(){
                    $('#addRoomModal').modal('hide');
                    location.reload();
                });
            });

            // Edit Room - fill modal
            $('.editRoomBtn').click(function(){
                $('#edit_room_id').val($(this).data('id'));
                $('#edit_room_name').val($(this).data('name'));
            });

            // Edit Room - submit
            $('#editRoomForm').submit(function(e){
                e.preventDefault();
                $.post("{{ route('room.update') }}", $(this).serialize(), function(){
                    $('#editRoomModal').modal('hide');
                    location.reload();
                });
            });

            // Delete Room
            $('.deleteRoomBtn').click(function(){
                let roomId = $(this).data('id');
                if(confirm("Are you sure you want to delete this room?")) {
                    $.post("{{ route('room.delete') }}", {
                        _token: '{{ csrf_token() }}',
                        id: roomId
                    }, function(){
                        $('#roomRow_' + roomId).fadeOut();
                    });
                }
            });

            // Add Item
            $('#addItemForm').submit(function(e){
                e.preventDefault();
                $.post("{{ route('items_list.add') }}", $(this).serialize(), function() {
                    $('#addItemModal').modal('hide');
                    location.reload();
                });
            });

            // Edit Item - fill modal
            $('.editItemBtn').click(function() {
                $('#edit_item_id').val($(this).data('id'));
                $('#edit_item_name').val($(this).data('name'));
            });

            // Edit Item - submit
            $('#editItemForm').submit(function(e) {
                e.preventDefault();
                $.post("{{ route('items_list.update') }}", $(this).serialize(), function() {
                    $('#editItemModal').modal('hide');
                    location.reload();
                });
            });

            // Delete Item
            $('.deleteItemBtn').click(function() {
                let id = $(this).data('id');
                if (confirm("Are you sure you want to delete this item?")) {
                    $.post("{{ route('items_list.delete') }}", {
                        _token: '{{ csrf_token() }}',
                        id: id
                    }, function() {
                        $('#itemRow_' + id).fadeOut();
                    });
                }
            });

            // Update System Names
            $('#editSystemNamesForms').submit(function(e) {
                e.preventDefault();

                let shortName = $('#editSysShortNamef').val();
                let longName = $('#editSysLongNamef').val();

                $.post("{{ route('system.update.names') }}", {
                    _token: '{{ csrf_token() }}',
                    sys_s_name: shortName,
                    sys_l_name: longName
                })
                .done(function(response) {
                    $('#editSystemNamesModal').modal('hide');
                    location.reload();
                })
                .fail(function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.error || 'Something went wrong.'));
                });
            });

        });
    </script>
</body>
</html>