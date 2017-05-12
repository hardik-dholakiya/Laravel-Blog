<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="icon" href="{{asset('image/blog-logo.png') }}"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        #searchText {
            width: 250px;
            transition: 0.5s;
        }

        #searchText:focus {
            width: 500px;
            transition: 0.5s;
        }
        body{
            background-image: url('{{asset('image/hilltop.jpg')}}');
            background-attachment: fixed;
        }
        footer {
            height: 40px;
            background: #303030;
        }
        .btn{
            background-color: white;
            color: #3c4245;
            border: 1px solid #303030;
        }
    </style>
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @yield('head-include')

</head>
<body>
<div id="app" style="margin-top: 60px;">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                    @if (!Auth::guest())
                        @if(Auth::user()->role== '1')
                            :: Admin
                        @endif
                    @endif
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (!Auth::guest())
                        <li>
                            <a href="{{ route('home') }}">
                                <span class="glyphicon glyphicon-home"></span>
                                Home
                            </a>
                        </li>
                        <li><a href="{{ route('createPost') }}">
                                <span class="glyphicon glyphicon-plus"></span>
                                Create Post
                            </a>
                        </li>
                        <li style="margin: 7px">     {{-- search post form --}}
                            <form class="form-inline" id="searchform" method="post" action="{{route('searchPost')}}">
                                <div class="input-group">
                                    {{ csrf_field() }}
                                    <input type="text" class="form-control" id="searchText"
                                           placeholder="Search by title"
                                           name="search_text" required>
                                    <div class="input-group-btn">
                                        <button class="btn btn-default form-control" type="submit">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </li>
                    @endif

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Wel-Come
                                <img src="{{asset(Auth::user()->image)}}" height="35px"
                                     onerror="this.src='{{asset('image/user-icon.png')}}'">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('edit-profile') }}">
                                        Edit Profile
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('changePassword') }}">
                                        Change Password
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
</div>

@yield('body-include')
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
<footer class="footer" >
    @include('layouts.footer')
</footer>
</html>
