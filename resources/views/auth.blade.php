<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.system_short_name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/sc_logo.png') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: linear-gradient(135deg, rgba(0, 0, 0, 1) 0%, rgba(255, 140, 0, 1) 100%); color: white;}
        .container { position: relative; height: 95%; width: 30%; overflow: hidden;}
        h1 { text-align: center; margin: 30px; color: #ffffff;;}
        h2 { text-align: center; margin-bottom: 20px; color: #ffffff;;}
        .input-box { margin-bottom: 15px; }   
        .input-box label { display: block; font-weight: bold; color: white;}
        .input-box input { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        button { width: 100%; padding: 10px; background:rgb(177, 97, 0); border: none; color: white; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        button:hover { background:rgb(129, 54, 0); }
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
        <h1>{{ config('app.system_short_name') }}</h1>
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
            </form>
        </div>
</body>
</html>
