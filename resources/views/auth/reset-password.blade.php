<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ config('app.system_short_name') }}</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('img/sc_logo.png') }}">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: linear-gradient(135deg, rgba(0, 0, 0, 1) 0%, rgba(255, 140, 0, 1) 100%);
      color: white;
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
      background: rgba(0, 0, 0, 0.6);
      padding: 20px;
      border-radius: 8px;
      max-width: 400px;
      width: 100%;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background-color: #333;
      color: white;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #ff8c00;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      color: white;
      cursor: pointer;
      margin-top: 20px;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #e07b00;
    }

    .alert {
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 4px;
      font-size: 14px;
    }

    .alert.success {
      background-color: #28a745;
      color: white;
    }

    .alert.error {
      background-color: #dc3545;
      color: white;
    }
  </style>
</head>
<body>

  <img src="{{ asset('img/sc_logo_bgr.png') }}" alt="EVSU-DC Logo" class="logo">

  <div class="container">
    <h1>Reset Your Password</h1>

    @if (session('success'))
      <div class="alert success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
      <div class="alert error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required />
      </div>

      <div class="form-group">
        <label for="password">New Password</label>
        <input type="password" id="password" name="password" required />
      </div>

      <div class="form-group">
        <label for="password_confirmation">Confirm New Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required />
      </div>

      <button type="submit">Reset Password</button>
    </form>
  </div>
</body>
</html>
