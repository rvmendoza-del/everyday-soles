
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Everyday Soles</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: #f4f6fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .login-box {
            background: white;
            padding: 35px;
            border-radius: 12px;
            width: 380px;
            max-width: 92%;
            box-shadow: 0 4px 20px #17203320;
        }
        h1 { color: #172033; text-align: center; }
        p { text-align: center; color: #68758a; }
        label { display: block; margin-top: 15px; }
        input {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border: 1px solid #d7deea;
            border-radius: 8px;
        }
        button {
            width: 100%;
            padding: 13px;
            background: #172033;
            color: white;
            border: none;
            border-radius: 8px;
            margin-top: 22px;
            cursor: pointer;
        }
        .error { color: #dc2626; }
        a { color: #2563eb; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>EVERYDAY SOLES</h1>
        <p>Login to your account</p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label>Email Address</label>
            <input type="email" name="email"
                   value="{{ old('email') }}" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <p>Don't have an account?
            <a href="{{ route('register') }}">Register</a>
        </p>
    </div>
</body>
</html>
