<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Your Password</title>
</head>
<body>
  <div class="container">
    <h1>Reset Your Password</h1>

    @if (session('success'))
      <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if (session('error'))
      <div style="color: red;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      
      <div>
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required />
      </div>

      <div>
        <label for="password">New Password</label>
        <input type="password" id="password" name="password" required />
      </div>

      <div>
        <label for="password_confirmation">Confirm New Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required />
      </div>

      <button type="submit">Reset Password</button>
    </form>
  </div>
</body>
</html>
