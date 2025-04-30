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
      padding: 40px;
      background: white;
      width: 90%;
      max-width: 400px;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      animation: fadeInUp 1s ease-out;
      position: relative;
    }

    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    h1, h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    .input-box {
      position: relative;
      margin-bottom: 25px;
    }

    .input-box input {
      width: 100%;
      padding: 12px 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background: transparent;
      color: #333;
      outline: none;
    }

    .input-box span {
      position: absolute;
      left: 12px;
      top: 12px;
      color: #666;
      transition: 0.3s;
      pointer-events: none;
      background: white;
      padding: 0 5px;
    }

    .input-box input:focus + span,
    .input-box input:not(:placeholder-shown) + span {
      top: -10px;
      left: 10px;
      font-size: 12px;
      color: #ff8c00;
    }

    button {
      width: 100%;
      padding: 10px;
      background: rgb(177, 97, 0);
      border: none;
      color: white;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
      font-size: 16px;
    }

    button:hover {
      background: rgb(129, 54, 0);
    }

    .reset-password {
      text-align: center;
      margin-top: 20px;
    }

    .reset-password button {
      background-color: #ff8c00;
      border-radius: 5px;
      padding: 10px;
      border: none;
      color: white;
      cursor: pointer;
    }

    .reset-password button:hover {
      background-color: #d87c00;
    }

    /* Error message styling */
    .error-msg {
      background-color: red;
      color: white;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .error-msg ul {
      list-style-type: none;
    }

    .error-msg button {
      background: transparent;
      border: none;
      color: white;
      font-size: 18px;
      cursor: pointer;
      padding: 0;
      margin-left: 10px;
    }

    .error-msg button:hover {
      color: lightgray;
    }

    /* Modal Styles */
    .modal {
      display: none; /* Hidden by default */
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background-color: white;
      padding: 20px;
      border-radius: 5px;
      text-align: center;
      width: 300px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal button {
      margin: 10px;
      padding: 10px 20px;
      background-color: rgb(177, 97, 0);
      border: none;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }

    .modal button:hover {
      background-color: rgb(129, 54, 0);
    }
  </style>
</head>
<body>
  <img src="{{ asset('img/sc_logo_bgr.png') }}" alt="EVSU-DC Logo" class="logo">

  <div class="container">
    <h1>{{ config('app.system_short_name') }}</h1>
    <div class="form-box login-box">
      <h2>Login</h2>

      @if ($errors->any())
        <div class="error-msg">
          <ul style="margin-left: 15px;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
      @endif

      @if (session('error'))
        <div class="error-msg">
          {{ session('error') }}
          <button onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
      @endif

      <form method="POST" action="{{ route('users.login') }}">
        @csrf
        <div class="input-box">
          <input type="email" name="email" required placeholder=" " id="email" />
          <span>Email</span>
        </div>

        <div class="input-box">
          <input type="password" name="password" id="password" required placeholder=" " />
          <span>Password</span>
        </div>

        <button type="submit">Login</button>
      </form>
      
      <div class="reset-password">
        <button type="button" id="resetPasswordBtn">Reset Password</button>
      </div>

      <div id="resetPasswordModal" class="modal">
        <div class="modal-content">
          <h3>Send Code to Your Email to Change Password?</h3>
          <button id="confirmReset">Yes, Send Code</button>
          <button id="cancelReset">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Get modal elements
    const resetPasswordBtn = document.getElementById('resetPasswordBtn');
    const resetPasswordModal = document.getElementById('resetPasswordModal');
    const confirmReset = document.getElementById('confirmReset');
    const cancelReset = document.getElementById('cancelReset');

    // Open modal when reset button is clicked
    resetPasswordBtn.onclick = function() {
      resetPasswordModal.style.display = 'flex';
    }

    // Close modal if cancel button is clicked
    cancelReset.onclick = function() {
      resetPasswordModal.style.display = 'none';
    }

    confirmReset.onclick = function() {
      const email = document.getElementById('email').value;

      if (email) {
        fetch("{{ route('password.email') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
          body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('A password reset link has been sent to your email.');
          } else {
            alert('Error sending reset link. Please try again.');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred. Please try again later.');
        });

        resetPasswordModal.style.display = 'none';
      } else {
        alert('Please enter your email address.');
      }
    }
  </script>
</body>
</html>
