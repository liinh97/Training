<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Login</title>
</head>
<body>
    <div id="login-container">
        <div class="login-title">FORM LOGIN</div>
        <form id="form-login" action="{{ route('users.postLogin') }}" method="POST">
            @csrf
            <div class="login-name">
                <label for="login-name">Name</label>
                <input type="text" name="name" id="login-name">
            </div>
            <div class="login-password">
                <label for="login-password">Password</label>
                <input type="text" name="password" id="login-password">
            </div>
            <button id="btn-login">LOGIN</button>
        </form>
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="login-err"> {{ $error }} </div>
            @endforeach
        @endif
    </div>
</body>
</html>