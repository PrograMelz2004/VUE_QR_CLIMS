<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.system_short_name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/sc_logo.png') }}">
    <style>
        body { font-family: Arial, sans-serif; }
        .header-container { display: flex; align-items: center;  text-align: center;}
        .header-center { text-align: center; flex-grow: 1; }
        .header-logo { width: 50px;}
        .title { font-size: 14px; font-weight: bold; color: #FF7805; margin-top: 5px; }
        .line { width: 60%; margin: 5px auto; border-bottom: 1px solid black; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid black; padding: 8px; text-align: left; }
        .footer { margin-top: 10px; font-size: 10px; color: gray; }
    </style>
</head>
<body>

    <div class="header-container">
        <img src="{{ public_path('img/sc_logo_bgr.png') }}" class="header-logo">
        <div class="header-center">
            <p>Republic of the Philippines</p>
            <p class="title">Eastern Visayas State University - Dulag Campus</p>
            <p>Dulag, Leyte</p>
            <div class="line"></div>
            <p class="title">EVSU DC - COMLAB USERS LIST</p>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($RegUsers as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('M j, Y h:i A') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Generated on: {{ $dateGenerated }}</p>
    </div>
</body>
</html>
