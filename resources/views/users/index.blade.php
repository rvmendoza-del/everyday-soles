
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Users Management | Everyday Soles</title>

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
    max-width: 1200px;
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

.btn {
    display: inline-block;
    padding: 11px 17px;
    background: #c8102e;
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    font-weight: bold;
}

.btn:hover {
    background: #a50c25;
}

.stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.card {
    background: #171717;
    border: 1px solid #303030;
    padding: 25px;
    border-radius: 12px;
}

.card h3 {
    color: #aaa;
    font-size: 15px;
    margin-bottom: 15px;
}

.card h2 {
    font-size: 30px;
}

.panel {
    background: #171717;
    border: 1px solid #303030;
    border-radius: 12px;
    padding: 25px;
    overflow-x: auto;
}

table {
    width: 100%;
    min-width: 700px;
    border-collapse: collapse;
}

th, td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #333;
}

th {
    background: #252525;
    color: #ff4051;
}

td {
    color: #ddd;
}

tr:hover {
    background: #222;
}

select {
    padding: 8px;
    background: #242424;
    color: white;
    border: 1px solid #444;
    border-radius: 5px;
}

.update-btn {
    background: #2563eb;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
}

.delete-btn {
    background: #c8102e;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
}

.alert {
    padding: 13px;
    margin-bottom: 15px;
    border-radius: 6px;
    background: #173c28;
    color: #65e6a0;
}

.error {
    background: #471b25;
    color: #ff8795;
}

@media(max-width: 700px) {
    body {
        padding: 15px;
    }

    .stats {
        grid-template-columns: 1fr;
    }

    .header {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Users Management</h1>
            <p class="subtitle">
                Manage Everyday Soles administrator and user accounts.
            </p>
        </div>

        <a href="/" class="btn">← Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="stats">

        <div class="card">
            <h3>Total Users</h3>
            <h2>{{ $totalUsers }}</h2>
        </div>

        <div class="card">
            <h3>Administrators</h3>
            <h2>{{ $totalAdmins }}</h2>
        </div>

        <div class="card">
            <h3>Regular Users</h3>
            <h2>{{ $totalRegularUsers }}</h2>
        </div>

    </div>

    <div class="panel">

        <h2 style="margin-bottom:20px;">
            Registered Accounts
        </h2>

        <div style="overflow-x:auto;">

            <table>

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr>
                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <td>
                                {{ ucfirst($user->role ?? 'user') }}
                            </td>

                            <td>

                                @if((string)$user->_id !== (string)auth()->id())

                                    <form
                                        action="{{ url('/users/' . $user->_id . '/role') }}"
                                        method="POST"
                                        style="display:inline-block;"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <select name="role">
                                            <option value="user"
                                                {{ $user->role === 'user' ? 'selected' : '' }}>
                                                User
                                            </option>

                                            <option value="admin"
                                                {{ $user->role === 'admin' ? 'selected' : '' }}>
                                                Admin
                                            </option>
                                        </select>

                                        <button type="submit" class="update-btn">
                                            Update
                                        </button>

                                    </form>

                                    <form
                                        action="{{ url('/users/' . $user->_id) }}"
                                        method="POST"
                                        style="display:inline-block;"
                                        onsubmit="return confirm('Are you sure you want to delete this account?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="delete-btn">
                                            Delete
                                        </button>

                                    </form>

                                @else

                                    <span style="color:#65e6a0;">
                                        Current Account
                                    </span>

                                @endif

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="4">
                                No registered users found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>
