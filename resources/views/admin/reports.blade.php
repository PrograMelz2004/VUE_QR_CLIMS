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
        .no-results {
            text-align: center;
            color: white;
            display: none;
        }
    </style>
</head>
<body>

    @include('plugin.navbar')

    <img src="{{ asset('img/sc_logo_bgr.png') }}" alt="EVSU-DC Logo" class="logo">
    
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-2 text-white">
            <div>
                <h1 class="mb-2">Borrowed Items Report</h1>
            </div>
            <input type="text" id="searchInput" class="form-control form-control-sm w-25" placeholder="Search...">
        </div>

        @if($borrowed->isEmpty())
            <p>No borrowed items found.</p>
        @else
            <div class="table-container">
                <table class="receipt-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Item Code</th>
                            <th>Borrower</th>
                            <th>Room</th>
                            <th>Borrowed Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowed as $index => $item)
                            <tr class="searchable">
                                <td>{{ $index + 1 }}.</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->item_code }}</td>
                                <td>{{ $item->borrower }}</td>
                                <td>{{ $item->room_name }}</td>
                                <td>{{ $item->borrowed_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tr id="noResultsRow" style="display: none;">
                        <td colspan="6" class="text-center text-white">No results found</td>
                    </tr>
                </table>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#searchInput').on('keyup', function () {
                let value = $(this).val().toLowerCase();
                let found = false;

                // Loop through each row and search for the entered value in any cell
                $('.receipt-table tbody tr').each(function () {
                    let rowText = $(this).text().toLowerCase();
                    if (rowText.includes(value)) {
                        $(this).show();
                        found = true;
                    } else {
                        $(this).hide();
                    }
                });

                // If no row matches, display "No results found"
                $('#noResultsRow').toggle(!found);
            });
        });
    </script>
</body>
</html>
