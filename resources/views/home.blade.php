<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>You are logged</h1>
    <h1>Welcome, {{ $user->username }}</h1>
    @if (session('status'))
        <p style="color: green;">{{ session('status') }}</p>
    @endif
    <form action="{{ route('home.update') }}" method="POST">
        @csrf
        <!-- Username Field -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="{{ $user->username }}" required><br>

        <!-- Email Field -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ $user->email }}" required><br>

        <!-- Password Field (optional) -->
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Leave blank to keep unchanged"><br>

        <!-- Password Confirmation Field -->
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Leave blank to keep unchanged"><br>

        <!-- Submit Button -->
        <button type="submit">Update Profile</button>
    </form>

    <form action="{{ route('login.logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
