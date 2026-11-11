
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Everyday Soles</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 20px;
            color: white;
            background-color: #071b22;
            background-image:
                linear-gradient(
                    110deg,
                    rgba(2,12,20,0.72),
                    rgba(0,40,48,0.32),
                    rgba(2,12,20,0.75)
                ),
                url('/shoe-bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .register-box {
            width: 450px;
            max-width: 100%;
            padding: 38px;
            background: rgba(8,20,30,0.82);
            border: 1px solid rgba(255,255,255,0.20);
            border-radius: 22px;
            box-shadow: 0 25px 70px rgba(0,0,0,0.55);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .brand {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-icon {
            color: #00f5e9;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 4px;
            margin-bottom: 15px;
        }

        h1 {
            font-size: 30px;
            font-weight: 900;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        .subtitle {
            color: #b5c6ce;
            font-size: 14px;
            line-height: 1.6;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin: 15px 0 8px;
            color: #e5edf2;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.22);
            border-radius: 10px;
            outline: none;
            color: white;
            font-size: 14px;
            transition: 0.3s;
        }

        input::placeholder {
            color: #a4b2be;
        }

        input:focus {
            border-color: #00e6db;
            box-shadow: 0 0 0 3px rgba(0,230,219,0.15);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 75px;
        }

        .toggle-password {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #00f5e9;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .register-btn {
            width: 100%;
            margin-top: 26px;
            padding: 16px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg,#00e6db,#00a6b2);
            color: #061923;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.3s;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(0,230,219,0.3);
        }

        .login-text {
            margin-top: 24px;
            text-align: center;
            color: #b5c6ce;
            font-size: 14px;
        }

        a {
            color: #00f5e9;
            text-decoration: none;
            font-weight: 700;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            background: rgba(220,38,38,0.15);
            border: 1px solid rgba(248,113,113,0.5);
            color: #fecaca;
            padding: 13px;
            border-radius: 9px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .error p {
            margin: 4px 0;
        }

        .footer {
            text-align: center;
            margin-top: 26px;
            font-size: 11px;
            letter-spacing: 2px;
            color: #93a8b5;
        }

        @media (max-width: 480px) {
            body {
                padding: 20px 15px;
                background-attachment: scroll;
            }

            .register-box {
                padding: 30px 24px;
            }

            h1 {
                font-size: 25px;
            }
        }
    </style>
</head>

<body>

    <div class="register-box">

        <div class="brand">
            <div class="brand-icon">
                SNEAKER COLLECTION
            </div>

            <h1>EVERYDAY SOLES</h1>

            <p class="subtitle">
                Step Into Your Style.<br>
                Create your account to get started.
            </p>
        </div>

        @if ($errors->any())
            <div class="error" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name">Full Name</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Enter your full name"
                autocomplete="name"
                required
            >

            <label for="email">Email Address</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email"
                autocomplete="email"
                required
            >

            <label for="password">Password</label>
            <div class="password-wrapper">
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Create a password"
                    autocomplete="new-password"
                    minlength="8"
                    required
                >
                <button
                    type="button"
                    class="toggle-password"
                    onclick="togglePassword('password', this)"
                    aria-label="Show password"
                    aria-pressed="false"
                >Show</button>
            </div>

            <label for="password_confirmation">
                Confirm Password
            </label>
            <div class="password-wrapper">
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm your password"
                    autocomplete="new-password"
                    minlength="8"
                    required
                >
                <button
                    type="button"
                    class="toggle-password"
                    onclick="togglePassword('password_confirmation', this)"
                    aria-label="Show password"
                    aria-pressed="false"
                >Show</button>
            </div>

            <button type="submit" class="register-btn">
                CREATE YOUR ACCOUNT
            </button>
        </form>

        <p class="login-text">
            Already have an account?
            <a href="{{ route('login') }}">Login Now</a>
        </p>

        <div class="footer">
            EVERYDAY SOLES © 2026
        </div>

    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';
            button.textContent = isHidden ? 'Hide' : 'Show';
            button.setAttribute(
                'aria-label',
                isHidden ? 'Hide password' : 'Show password'
            );
            button.setAttribute(
                'aria-pressed',
                isHidden ? 'true' : 'false'
            );
        }
    </script>

</body>
</html>
