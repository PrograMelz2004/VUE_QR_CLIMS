<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.system_short_name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/sc_logo.png') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: linear-gradient(135deg, rgba(0, 0, 0, 1) 0%, rgba(255, 140, 0, 1) 100%); }
        .container { position: relative; height: 95%; width: 80%; overflow: hidden;}
        .form-box { position: absolute; width: 100%; height: 100%; background: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: 0.5s ease-in-out; padding: 30px; }
        .register-box { transform: translateX(100%); }
        .active .register-box { transform: translateX(0); }
        .active .login-box { transform: translateX(-100%); }
        h2 { text-align: center; margin-bottom: 20px; color: #ffffff;;}
        .input-group { display: flex; justify-content: space-between; margin-bottom: 15px; }
        .input-group .input-box2 { width: 48%; }
        .input-group .input-box3 { width: 32%; }
        .input-box2, .input-box3, .input-box { margin-bottom: 15px; }   
        .input-box2, .input-box3 label, .input-box label { display: block; font-weight: bold; color: white;}
        .input-box2 input, .input-box input, .input-box2 select, .input-box3 input, .input-box3 select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        button { width: 100%; padding: 10px; background:rgb(177, 97, 0); border: none; color: white; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        button:hover { background:rgb(129, 54, 0); }
        .toggle { text-align: center; margin-top: 10px; color:rgb(255, 255, 255); cursor: pointer; }
        .toggle:hover { text-decoration: underline; }
        .logo {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
            opacity: 0.1;
            z-index: -1;
        }
    </style>
</head>
<body>

<img src="img/sc_logo_bgr.png" alt="EVSU-DC Logo" class="logo">
    <div class="container">
        <div class="form-box login-box">
            <h2>Login</h2>
            <form method="POST" action="{{ route('users.login') }}">
                @csrf
                <div class="input-box">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input-box">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Login</button>
                <p class="toggle" onclick="toggleForm()">Create an account</p>
            </form>
        </div>

        <div class="form-box register-box">
            <h2>Register</h2>
            <form method="POST" action="{{ route('users.register') }}">
                @csrf
                <div class="input-group">
                    <div class="input-box2">
                        <label>First Name</label>
                        <input type="text" name="first_name" required>
                    </div>
                    <div class="input-box2">
                        <label>Last Name</label>
                        <input type="text" name="last_name" required>
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-box3">
                        <label>Age</label>
                        <input type="number" name="age" required>
                    </div>

                    <div class="input-box3">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="input-box3">
                        <label>Birthday</label>
                        <input type="date" name="birthday" required>
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-box3">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" required>
                    </div>

                    <div class="input-box3">
                        <label>Address</label>
                        <input type="text" name="address" required>
                    </div>

                    <div class="input-box3">
                        <label>Email</label>
                        <input type="email" name="email" required>
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-box2">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="input-box2">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" required>
                    </div>
                </div>

                <button type="submit">Register</button>
                <p class="toggle" onclick="toggleForm()">Already have an account?</p>
            </form>
        </div>
    </div>

    <script>
        function toggleForm() {
            document.querySelector('.container').classList.toggle('active');
        }
    </script>
</body>
</html>
