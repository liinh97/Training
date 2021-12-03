<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title')
    </title>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/search.css') }}" rel="stylesheet">
    <link href="{{ asset('css/paginate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-confirm.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/users/users.css') }}" rel="stylesheet">
    <link href="{{ asset('css/users/user-create.css') }}" rel="stylesheet">
    <link href="{{ asset('css/categories/categories.css') }}" rel="stylesheet">
    <link href="{{ asset('css/categories/category-create.css') }}" rel="stylesheet">
    <link href="{{ asset('css/questions/questions.css') }}" rel="stylesheet">
    <link href="{{ asset('css/questions/question-create.css') }}" rel="stylesheet">
</head>
<body>
    <div class="navbar-container">
        <ul class="navbar">
            <li><a href="/admin/users">Users</a></li>
            <li><a href="/admin/categories">Category</a></li>
            <li><a href="/admin/questions">Question</a></li>
        </ul>
        <form method="GET" action="{{ route('users.getLogout') }}">
            @csrf
            <button>Logout</button>
        </form>
    </div>
    
    @yield('content')

    <script src="{{ asset('js/jquery.slim.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-confirm.js') }}"></script>
    <script src="{{ asset('js/categories/main.js') }}"></script>
    <script src="{{ asset('js/questions/main.js') }}"></script>
    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>