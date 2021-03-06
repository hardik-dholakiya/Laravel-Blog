<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>@yield('title')</title>
    <link rel="icon" href="{{asset('image/blog-logo.png') }}"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        #searchText {
            width: 230px;
            transition: 0.5s;
        }

        #searchText:focus {
            width: 330px;
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
            border-radius: 0px;
            border: 1px solid #303030;
        }
        .comment-link{
            margin-left: -20px;
        }
        .comment-link img{
            height: 20px;
        }
        /**comment reply*/
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .comment-section{
            list-style: none;
            max-width: 1000px;
            width: 100%;
            margin: 50px auto;
            padding: 10px;
            font: normal 13px sans-serif;
        }
        .comment{
            display: flex;
            border-radius: 3px;
            flex-wrap: wrap;
        }
        .comment.user-comment{
            color:  #808080;
        }
        /* User and time info */
        .comment.user-comment .info{
            text-align: right;
        }
        .comment .info a{   /* User name */
            display: block;
            text-decoration: none;
            color: #656c71;
            font-weight: bold;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            padding: 10px 0 3px 0;
        }
        .comment .info span{    /* Time */
            font-size: 11px;
            color:  #9ca7af;
        }
        /* The user avatar */
        .comment.user-comment .avatar{
            padding: 10px 10px 0 3px;
        }
        .comment .avatar img{
            border-radius: 50px;
        }
        /* The comment text */
        .comment p{
            line-height: 1.5;
            padding: 18px 22px;
            width: 80%;
            border-radius:20px;
            position: relative;
            word-wrap: break-word;
        }
        .comment.user-comment p{
            background-color:  #f3f3f3;
        }
        .user-comment p:after{
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: #ffffff;
            border: 2px solid #f3f3f3;
            left: -8px;
            top: 18px;
        }
        .container{
            alignment: center;
            padding: 10px 10px 5px 10px;
            margin: -10px 0px 20px 108px; width: 80%
        }
        .panel-info{
            border-radius: 10px;
        }
        .reply-link{
            margin-left: 86%;
        }
        /* Comment form */
        .write-new{
            margin: 20px auto;
            width: 70%;
        }
        .write-new textarea{
            color:  #444;
            font: inherit;
            outline: 0;
            border-radius: 3px;
            border: 1px solid #cecece;
            background-color:  #fefefe;
            box-shadow: 1px 2px 1px 0 rgba(0, 0, 0, 0.06);
            overflow: auto;
            width:100%;
            min-height: 80px;
            padding: 15px 20px;
        }
        .write-new img{
            border-radius: 50%;
            margin-top: 15px;
        }
        .write-new button{
            float:right;
            background-color:  #87bae1;
            box-shadow: 1px 2px 1px 0 rgba(0, 0, 0, 0.12);
            border-radius: 2px;
            border: 0;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            padding: 10px 25px;
            margin-top: 18px;
        }
        .description{
            margin: 10px 0px 0px 14px;
        }

        /* end comment reply*/

        input[type=text]{
            border-radius: 0px;
        }
        .form-control {
            border-radius: 0px;
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
    <nav class="navbar navbar-inverse navbar-fixed-top" style="height: 52px">
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
                                        <button class="btn btn-default form-control" type="submit" style="border: 0px solid #303030;">
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
                        <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                        <li class="dropdown" style="margin-top: -6px;">
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
