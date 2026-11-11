
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Settings | Everyday Soles</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    background: #090909;
    color: white;
    padding: 35px;
}

.container {
    max-width: 1100px;
    margin: auto;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    gap: 15px;
}

h1 {
    font-size: 30px;
}

.subtitle {
    color: #aaa;
    margin-top: 8px;
}

.back {
    display: inline-block;
    margin-bottom: 25px;
    color: #ff4051;
    text-decoration: none;
    font-weight: bold;
}

.back:hover {
    color: white;
}

.panel {
    background: #171717;
    border: 1px solid #303030;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 25px;
}

.panel h2 {
    font-size: 20px;
    margin-bottom: 10px;
}

.description {
    color: #999;
    font-size: 13px;
    margin-bottom: 25px;
    line-height: 1.6;
}

.account-info {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.info-item {
    background: #222;
    padding: 18px;
    border-radius: 8px;
    border: 1px solid #333;
}

.info-item small {
    display: block;
    color: #999;
    margin-bottom: 9px;
}

.info-item strong {
    overflow-wrap: anywhere;
}

.status {
    color: #65e6a0;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 9px;
    font-size: 14px;
    color: #ddd;
}

input {
    width: 100%;
    padding: 13px;
    background: #242424;
    border: 1px solid #444;
    border-radius: 7px;
    color: white;
    outline: none;
    font-size: 14px;
}

input:focus {
    border-color: #c8102e;
}

input::placeholder {
    color: #777;
}

.password-wrapper {
    position: relative;
}

.password-wrapper input {
    padding-right: 75px;
}

.toggle-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    color: #ff4051;
    cursor: pointer;
    font-size: 12px;
    font-weight: bold;
}

.btn {
    display: inline-block;
    padding: 12px 18px;
    background: #c8102e;
    color: white;
    border: none;
    border-radius: 7px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}

.btn:hover {
    background: #a50c25;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 7px;
    background: #153c28;
    color: #65e6a0;
    border: 1px solid #23633e;
    line-height: 1.6;
}

.error {
    background: #471b25;
    color: #ff8795;
    border: 1px solid #782b3c;
}

.field-error {
    color: #ff6575;
    font-size: 12px;
    margin-top: 7px;
}

.footer {
    text-align: center;
    color: #666;
    font-size: 12px;
    padding: 20px;
    margin-top: 15px;
}

@media(max-width: 600px) {
    body {
        padding: 15px;
    }

    .account-info {
        grid-template-columns: 1fr;
    }

    .header {
        flex-direction: column;
        align-items: flex-start;
    }

    .btn {
        width: 100%;
    }

    .panel {
        padding: 18px;
    }
}
</style>
</head>

<body>

<div class="container">

    <!-- HEADER -->

    <a href="{{ route('home') }}" class="back">
        ← Back to Dashboard
    </a>

    <div class="header">
        <div>
            <h1>System Settings</h1>
            <p class="subtitle">
                Manage your Everyday Soles account and security.
            </p>
        </div>
    </div>


    <!-- SUCCESS MESSAGE -->

    @if(session('success'))
        <div class="alert">
            ✓ {{ session('success') }}
        </div>
    @endif


    <!-- ERROR MESSAGE -->

    @if($errors->any())
        <div class="alert error">
            <strong>Please check the following:</strong>

            @foreach($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif


    <!-- ACCOUNT INFORMATION -->

    <div class="panel">

        <h2>Account Information</h2>

        <p class="description">
            View your current Everyday Soles account details.
        </p>

        <div class="account-info">

            <div class="info-item">
                <small>Account Name</small>
                <strong>{{ $user->name }}</strong>
            </div>

            <div class="info-item">
                <small>Email Address</small>
                <strong>{{ $user->email }}</strong>
            </div>

            <div class="info-item">
                <small>Account Role</small>
                <strong>
                    {{ ucfirst($user->role ?? 'user') }}
                </strong>
            </div>

            <div class="info-item">
                <small>Account Status</small>
                <strong class="status">● Active</strong>
            </div>

        </div>

    </div>


    <!-- PROFILE SETTINGS -->

    <div class="panel">

        <h2>Profile Settings</h2>

        <p class="description">
            Update your administrator name and email address.
        </p>

        <form action="{{ route('settings.profile.update') }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label for="name">Full Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    placeholder="Enter your full name"
                    maxlength="255"
                    required
                >

                @error('name')
                    <p class="field-error">{{ $message }}</p>
                @enderror

            </div>

            <div class="form-group">

                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    placeholder="Enter your email address"
                    maxlength="255"
                    required
                >

                @error('email')
                    <p class="field-error">{{ $message }}</p>
                @enderror

            </div>

            <button type="submit" class="btn">
                Save Profile Changes
            </button>

        </form>

    </div>


    <!-- SECURITY SETTINGS -->

    <div class="panel">

        <h2>Security Settings</h2>

        <p class="description">
            Change your account password to keep your system secure.
            Your new password must contain at least 8 characters,
            including letters and numbers.
        </p>

        <form action="{{ route('settings.password.update') }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label for="current_password">
                    Current Password
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        placeholder="Enter current password"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword('current_password', this)">
                        SHOW
                    </button>

                </div>

                @error('current_password')
                    <p class="field-error">{{ $message }}</p>
                @enderror

            </div>


            <div class="form-group">

                <label for="password">
                    New Password
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter new password"
                        minlength="8"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword('password', this)">
                        SHOW
                    </button>

                </div>

                @error('password')
                    <p class="field-error">{{ $message }}</p>
                @enderror

            </div>


            <div class="form-group">

                <label for="password_confirmation">
                    Confirm New Password
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirm new password"
                        minlength="8"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword('password_confirmation', this)">
                        SHOW
                    </button>

                </div>

            </div>


            <button type="submit" class="btn">
                Change Password
            </button>

        </form>

    </div>


    <!-- FOOTER -->

    <div class="footer">
        EVERYDAY SOLES INVENTORY MANAGEMENT SYSTEM © 2026
    </div>

</div>


<script>

// SHOW / HIDE PASSWORD

function togglePassword(id, button) {

    const input = document.getElementById(id);

    if (input.type === 'password') {

        input.type = 'text';
        button.textContent = 'HIDE';

    } else {

        input.type = 'password';
        button.textContent = 'SHOW';

    }

}

</script>

</body>
</html>
