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
    
</head>
<body>
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
                            <a class="nav-link rounded-pill" aria-current="page" href="{{ route('register') }}">Sign up</a>
                        </li>
                        <li class="nav-item li_border_right">
                            <a class="nav-link rounded-pill" href="{{ route('login') }}">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- nav ent  -->
        
        <!-- main content start  -->
        @yield('content')
        <!-- main content end  -->

    </div>

    <script src="{{ asset('web/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web/js/custom.js') }}"></script>
</body>
</html>
