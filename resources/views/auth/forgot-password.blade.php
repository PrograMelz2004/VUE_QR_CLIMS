<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password</title>
</head>
<body>
  <div class="container">
    <h1>Reset Password</h1>

    @if (session('success'))
      <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if (session('error'))
      <div style="color: red;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div>
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required />
      </div>
      <button type="submit">Send Reset Link</button>
    </form>
  </div>
</body>
</html>
