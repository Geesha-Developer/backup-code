<!-- resources/views/admin/login.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
</head>

<body>
    <div>
        <h2>Admin Login</h2>
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autofocus>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>

</html>
