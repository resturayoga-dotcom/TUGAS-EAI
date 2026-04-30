<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - City Transit</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #d2d2d2;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            width: 400px;
        }

        .header-box {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: white;
            padding: 20px;
            border-radius: 12px 12px 0 0;
            text-align: center;
        }

        .header-box h1 {
            font-size: 1.5rem;
        }

        .header-box p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .login-box {
            background: white;
            padding: 25px;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            font-size: 0.9rem;
            display: block;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #1e40af;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn:hover {
            background: #1e3a8a;
        }

        .links {
            margin-top: 10px;
            text-align: center;
            font-size: 0.85rem;
        }

        .links a {
            color: #2563eb;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<div class="login-container">
    
    <div class="header-box">
        <h1>🚍 City Transit Live</h1>
        <p>Login to manage bus tracking</p>
    </div>

    <div class="login-box">

        {{-- Error Message --}}
        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <label>Email</label>
                <input 
                    type="email" 
                    name="email" 
                    required 
                    autofocus 
                    autocomplete="username"
                >
            </div>

            <div class="input-group">
                <label>Password</label>
                <input 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                >
            </div>

            <button type="submit" class="btn">LOGIN</button>
        </form>

        <div class="links">
            <a href="{{ route('register') }}">Register</a>
        </div>

    </div>

</div>

</body>
</html>