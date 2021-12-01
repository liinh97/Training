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
    <link href="{{ asset('css/users/users.css') }}" rel="stylesheet">
    <link href="{{ asset('css/users/user-create.css') }}" rel="stylesheet">
    <link href="{{ asset('css/categories/categories.css') }}" rel="stylesheet">
    <link href="{{ asset('css/categories/category-create.css') }}" rel="stylesheet">
    <link href="{{ asset('css/questions/questions.css') }}" rel="stylesheet">
    <link href="{{ asset('css/questions/question-create.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-navbar">
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

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-confirm.js') }}"></script>
    <script src="{{ asset('js/categories/main.js') }}"></script>
    <script src="{{ asset('js/questions/main.js') }}"></script>
    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
    <script>
        // Config Ajax
        function setAjaxHeader() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });
        }

        // Confirm Delete handle
        $('.handleDelete').on('click', function(e){
            var $this = $(this);
            $this.prop("disabled", true);
            $.confirm({
                title: false,
                content: "You want DELETE this",
                columnClass:
                    "default",
                buttons: {
                    confirm: {
                        text: "Yes",
                        action: function() {
                            $this.parents("form").submit();
                        }
                    },
                    cancel: {
                        text: "No",
                        action: function() {
                            $this.prop("disabled", false);
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>