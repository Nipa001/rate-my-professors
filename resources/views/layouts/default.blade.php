<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Evaluation System') }}</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- font awsome  -->
    <link rel="stylesheet" href="{{ asset('web/font/all.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.min.css') }}">
    <!-- custom css  -->
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">

    @stack('styles')
</head>
<body class="navbar-top-md-xs sidebar-xs has-detached-left" >
    <div id="app">
        <!-- nav strat  -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
            <div class="container">
                <a class="navbar-brand" href="{{url('/')}}">Navbar</a>
                <div class="left_part text-white">
                    <i class="fas fa-phone-square-alt m-1"> +880 172 2707 693</i>

                    <i class="fas fa-envelope-open"> najmul35-2581@diu.edu.bd</i>

                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarText">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{url('/')}}"><i class="fas fa-home "></i> 
                                {{ @Auth::user()->name }}</a>
                        </li>
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item li_border_right">
                                    <a class="nav-link rounded-pill" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="fa fa-user-o" aria-hidden="true"></i>Logout </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>

                            @else
                                <li class="nav-item li_border_right"><a class="nav-link rounded-pill" href="{{ route('loginStep') }}"><i class="fa fa-user-o" aria-hidden="true"></i> Login </a></li>
                                @if (Route::has('register'))
                                    <li class="nav-item"><a class="nav-link rounded-pill" href="{{ route('register') }}"><i class="fa fa-file-text-o" aria-hidden="true"></i> Sign Up </a></li>
                                @endif
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <!-- nav ent  -->
        
        <!-- main content start  -->
        @yield('content')
        <!-- main content end  -->
    </div>

    <!-- footer start -->
    <footer class="bg-light text-center text-lg-start">
        <!-- Grid container -->
        <div class="container p-4">
            <!--Grid row-->
            <div class="row">
                <!--Grid column-->
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0 text-white">
                    <h5 class="text-uppercase">Footer text</h5>

                    <p>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iste atque ea quis
                        molestias. Fugiat pariatur maxime quis culpa corporis vitae repudiandae
                        aliquam voluptatem veniam, est atque cumque eum delectus sint!
                    </p>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0 text-white">
                    <h5 class="text-uppercase">Footer text</h5>

                    <p>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iste atque ea quis
                        molestias. Fugiat pariatur maxime quis culpa corporis vitae repudiandae
                        aliquam voluptatem veniam, est atque cumque eum delectus sint!
                    </p>
                </div>
                <!--Grid column-->
            </div>
            <!--Grid row-->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3 text-white" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2020 Copyright by me:
            <a class="text-decoration-none" href="#">click</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- footer end  -->

    <script type="text/javascript" src="{{ asset('backend/assets/js/core/libraries/jquery.min.js') }}"></script>
    <script src="{{ asset('web/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web/js/custom.js') }}"></script>


    <!-- Per Page JS files -->
    @stack('javascript')
    <!-- /Per Page JS files -->

</body>
</html>
