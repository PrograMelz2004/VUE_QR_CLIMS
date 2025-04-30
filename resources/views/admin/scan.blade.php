<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.system_short_name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/sc_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.3/html5-qrcode.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, rgba(0, 0, 0, 1) 0%, rgba(255, 140, 0, 1) 100%);
            min-height: 100vh;
            margin: 0;
            overflow: auto;
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
        .scanner-container {
            display: flex;
            flex-wrap: wrap;
            width: 90%;
            min-height: 80vh;
            max-height: 90vh;
            overflow-y: auto;
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.2);
            color: white;
            position: relative;
            margin: 5vh auto;
        }
        .scanner {
            width: 40%;
        }
        .details {
            width: 60%;
            padding-left: 20px;
        }
        #qr-reader button {
            background-color: #ff5722 !important;
            color: white !important;
            border-radius: 3px;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
        #qr-reader button:hover {
            background-color: #e64a19 !important;
        }
        #qr-reader a {
            color: black;
        }
        #qr-reader a:hover {
            color: white;
        }
        #qr-reader video {
            transform: scaleX(-1);
        }
    </style>
</head>
<body>

@include('plugin.navbar')

<img src="img/sc_logo_bgr.png" alt="EVSU-DC Logo" class="logo">

<div class="scanner-container mt-4">
    <div class="scanner">
        <h4>Scan QR Code</h4>
        <div id="qr-reader" style="width: 100%; background-color: rgba(255, 255, 255, 0.40);"></div>
    </div>
    <div class="details">
        <h3 class="mt-4 text-white">Scanned Item</h3>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Borrowed</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="scanned-items">
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="borrowModal" tabindex="-1" aria-labelledby="borrowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="borrowModalLabel">Borrow Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="borrow-form">
                    <div class="mb-3">
                        <label for="borrower-name" class="form-label">Name of Borrower</label>
                        <input type="text" class="form-control" id="borrower-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="borrow-quantity" class="form-label">Quantity Borrowed</label>
                        <input type="number" class="form-control" id="borrower-quantity" required max="">
                    </div>
                    <div class="mb-3">
                        <label for="borrow-room" class="form-label">Room</label>
                        <select class="form-control" id="borrow-room" required>
                            <option value="" selected disabled>----Select a Room----</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->name }}">{{ $room->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" id="borrow-item-name">
                    <input type="hidden" id="borrow-item-quantity">
                    <button type="submit" class="btn btn-primary">Confirm Borrow</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let scanCooldown = false;

    function renderScannedItem(item) {
        let newRow = `<tr>
            <td>${item.name}</td>
            <td>${item.quantity}</td>
            <td>${item.borrowed}</td>
            <td>
                <button class="btn btn-success btn-sm borrow-btn" data-name="${item.name}" data-quantity="${item.quantity}">Borrow</button>
            </td>
        </tr>`;
        $("#scanned-items").html(newRow);
    }

    function onScanSuccess(decodedText, decodedResult) {
        if (scanCooldown) return;

        scanCooldown = true;

        $.ajax({
            url: "{{ route('items.scan') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                qrcode: decodedText
            },
            success: function (response) {
                if (response.success) {
                    renderScannedItem(response.item);
                    localStorage.setItem('scannedItem', JSON.stringify(response.item));
                } else {
                    alert("QR Code not found in the database.");
                }
            },
            complete: function () {
                setTimeout(() => { scanCooldown = false; }, 1000);
            }
        });
    }

    $(document).on('click', '.borrow-btn', function() {
        let itemName = $(this).data('name');
        let itemQuantity = $(this).data('quantity');

        $('#borrow-item-name').val(itemName);
        $('#borrow-item-quantity').val(itemQuantity);
        $('#borrower-quantity').attr('max', itemQuantity);
        $('#borrowModal').modal('show');
    });

    $(document).ready(function() {
        let storedItem = localStorage.getItem('scannedItem');
        if (storedItem) {
            renderScannedItem(JSON.parse(storedItem));
        }
    });

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 250 }
    );
    html5QrcodeScanner.render(onScanSuccess);

    $('#borrow-form').submit(function(e) {
        e.preventDefault();

        let name = $('#borrow-item-name').val();
        let quantity = parseInt($('#borrower-quantity').val());
        let maxQty = parseInt($('#borrow-item-quantity').val());

        if (quantity > maxQty) {
            alert(`You can only borrow up to ${maxQty} item(s).`);
            return;
        }

        $.ajax({
            url: "{{ route('items.borrow') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                name: name,
                quantity: quantity,
                borrower_name: $('#borrower-name').val()
            },
            success: function(response) {
                if (response.success) {
                    alert('Item borrowed successfully and saved in the database!');
                    localStorage.removeItem('scannedItem');
                    location.reload();
                } else {
                    alert(response.message || 'Failed to borrow item.');
                }
            },
            error: function() {
                alert('Server error. Could not process borrow request.');
            }
        });
    });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</body>
</html>
