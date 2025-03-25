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
        .container {
            max-width: 90%;
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            color: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    
    @include('plugin.navbar')

    <img src="img/sc_logo_bgr.png" alt="EVSU-DC Logo" class="logo">
    
    <div class="container mt-4">
        <h1>EVSU DC QR Code Computer Laboratory Inventory Management System</h1>
        <p>A system designed to efficiently manage and track computer lab equipment using QR codes.</p>
        
        <h2>System Features</h2>
        <ul>
            <li>QR Code-based equipment tracking</li>
            <li>Inventory management with real-time updates</li>
            <li>User authentication and role management</li>
            <li>Automated report generation</li>
            <li>Equipment borrowing and return system</li>
        </ul>
        
        <h2>About the Developers</h2>
        <p>This system was developed as part of a project by BSIT 3A students to streamline lab inventory management.</p>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
