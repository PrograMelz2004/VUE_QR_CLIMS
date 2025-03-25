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
            display: flex;
            flex-direction: column;
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

        .container-fluid {
            flex: 1;
        }

        .content {
            padding: 20px;
        }
    </style>
</head>
<body>

    @include('plugin.navbar')
    <img src="{{ asset('img/sc_logo_bgr.png') }}" alt="EVSU-DC Logo" class="logo">
    
    <!-- Main Content -->
    <div class="content">
        <section id="systemName">
            <h3>System Name</h3>
            <form action="#" method="POST">
                @csrf
                <input type="text" name="system_name" class="form-control" value="">
                <button type="submit" class="btn btn-primary mt-2">Save</button>
            </form>
        </section>

        <section id="rooms" class="mt-4">
            <h3>Rooms</h3>
            <form action="#" method="POST">
                @csrf
                <input type="text" name="room_name" class="form-control" placeholder="Add a room">
                <button type="submit" class="btn btn-primary mt-2">Add Room</button>
            </form>
        </section>

        <section id="borrowHistory" class="mt-4">
            <h3>Borrow History</h3>
            <p>View recent borrowed items here.</p>
        </section>

        <section id="returnHistory" class="mt-4">
            <h3>Return History</h3>
            <p>View return records here.</p>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
