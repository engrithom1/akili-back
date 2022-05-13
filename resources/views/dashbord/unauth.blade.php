<!DOCTYPE html>
<html lang="en">

<head>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style>
            .btn-cstm-light {
                color: #212841;
                background-color: #fff;
                border-color: #fff
            }

            .btn-cstm-light:hover {
                color: #212841;
                background-color: #ececec;
                border-color: #e6e6e6
            }

            .btn-cstm-light.focus,
            .btn-cstm-light:focus {
                box-shadow: 0 0 0 .2rem rgba(255, 255, 255, .5)
            }

            .btn-cstm-light.disabled,
            .btn-cstm-light:disabled {
                color: #212841;
                background-color: #fff;
                border-color: #fff
            }

            .btn-cstm-light:not(:disabled):not(.disabled).active,
            .btn-cstm-light:not(:disabled):not(.disabled):active,
            .show>.btn-cstm-light.dropdown-toggle {
                color: #212841;
                background-color: #e6e6e6;
                border-color: #dfdfdf
            }

            .btn-cstm-light:not(:disabled):not(.disabled).active:focus,
            .btn-cstm-light:not(:disabled):not(.disabled):active:focus,
            .show>.btn-cstm-light.dropdown-toggle:focus {
                box-shadow: 0 0 0 .2rem rgba(255, 255, 255, .5)
            }
        </style>
    </head>
</head>

<body style="background-color: #28304e">
    <header class="text-white" style="background-color: #28304e">
        <div class="container">
            <div class="row m-h-100">
                <div class="col-md-6 my-auto">
                    <h1 class="display-4 animated bounceIn font-worksans">Your not yet authenticated to be Admin</h1>
                    <p class="animated fadeIn">contact your admin to authenticate your as admin of this app </p>
                    <p>
                        <a class="btn animated fadeIn btn-cta btn-cstm-light" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout now
                        </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    </p>
                </div>
                <div class="text-center m-auto col-md-6 animated zoomIn">
                    <p>
                        <img class="mw-100" src="{{ asset('img/cherry-done.PNG') }}" alt="">
                    </p>
                </div>
            </div>
        </div>
    </header>
</body>

</html>