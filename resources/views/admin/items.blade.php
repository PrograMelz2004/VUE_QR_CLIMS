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

<?php $codee = substr(bin2hex(random_bytes(10)), 0, 10); ?>

@include('plugin.navbar')

<img src="img/sc_logo_bgr.png" alt="EVSU-DC Logo" class="logo">

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">Add New Item</button>
            <a class="btn btn-success btn-sm" href="{{ route('download.inventory') }}">
                <img src="img/print.png" width="24" class="me-2"> PDF
            </a>
        </div>
        <input type="text" id="searchInput" class="form-control form-control-sm w-25" placeholder="Search...">
    </div>

    <table class="receipt-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Borrowed</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="itemTable">
            @foreach($items_lists as $index => $list)
            <tr class="searchable">
                <td>{{ $index + 1 }}.</td>
                <td>{{ $list->name }}</td>
                <td>{{ $list->items->count() }}</td>
                <td>{{ $list->items->where('quantity', 0)->count() }}</td>
                <td>
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#itemListModal{{ $list->id }}">
                        View Items
                    </button>
                </td>
            </tr>
            @endforeach
            <tr id="noResultsRow" style="display: none;">
                <td colspan="3" class="text-center text-white">No results found</td>
            </tr>
        </tbody>
    </table>
</div>

@foreach($items_lists as $list)
<div class="modal fade" id="itemListModal{{ $list->id }}" tabindex="-1" aria-labelledby="itemListModalLabel{{ $list->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title">Items under "{{ $list->name }}"</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($list->items->isEmpty())
                    <p>No items found under this category.</p>
                @else
                    <table class="table table-bordered text-white">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list->items as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->qrcode }}</td>
                                <td>
                                    @if ($item->quantity == 0)
                                        Borrowed
                                    @elseif ($item->quantity == 1)
                                        At Shelf
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-success btn-sm qrModal" data-qrcode="{{ $item->qrcode }}">QR Code</button>
                                    <button class="btn btn-warning btn-sm editItemBtn" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-quantity="{{ $item->quantity }}">Edit</button>
                                    <button class="btn btn-danger btn-sm deleteItemBtn" data-id="{{ $item->id }}">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@include('modals.items_modals')

<script>
    $(document).ready(function () {
        $('#searchInput').on('keyup', function () {
            let value = $(this).val().toLowerCase();
            let found = false;

            $('#itemTable .searchable').each(function () {
                if ($(this).text().toLowerCase().includes(value)) {
                    $(this).show();
                    found = true;
                } else {
                    $(this).hide();
                }
            });

            $('#noResultsRow').toggle(!found);
        });

        $('#addItemForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('items.store') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    items_list_id: $('#selectItemName').val(),
                    name: $('#addItemSpecificName').val(),
                    qrcode: $('#qrcode').val(),
                    quantity: $('#addItemQuantity').val()
                },
                success: function (data) {
                    location.reload();
                }
            });
        });

        $('.editItemBtn').click(function () {
            $('#editItemId').val($(this).data('id'));
            $('#editItemName').val($(this).data('name'));
            $('#editItemQuantity').val($(this).data('quantity'));
            $('#editItemModal').modal('show');
        });

        $('#editItemForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: "/items/" + $('#editItemId').val(),
                method: "PATCH",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: $('#editItemName').val(),
                    quantity: $('#editItemQuantity').val()
                },
                success: function (data) {
                    location.reload();
                }
            });
        });

        $('.deleteItemBtn').click(function () {
            let id = $(this).data('id');
            if (confirm("Are you sure you want to delete this item?")) {
                $.ajax({
                    url: "/items/" + id,
                    method: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (data) {
                        location.reload();
                    }
                });
            }
        });

        $('.qrModal').click(function () {
            let qrCodeData = $(this).data('qrcode');
            let qrCodeUrl = "https://quickchart.io/qr?text=" + qrCodeData + "&dark=520000&size=400&centerImageUrl=https://i.ibb.co/QMRxkML/Untitled-design-2-removebg-preview.png";
            $('#qrCodeImage').attr('src', qrCodeUrl);
            $('#qrModal').modal('show');
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</body>
</html>
