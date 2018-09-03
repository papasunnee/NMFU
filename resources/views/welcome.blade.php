<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>NMFU::GBC</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800,900" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Montserrat', sans-serif;
                font-weight: 400;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
                color: #fff ;
                background: -moz-linear-gradient(309deg, #667eea 0%, #7159B6 71%, #764ba2 100%); /* ff3.6+ */
                background: -webkit-gradient(linear, left top, right bottom, color-stop(0%, #667eea), color-stop(71%, #7159B6), color-stop(100%, #764ba2)); /* safari4+,chrome */
                background: -webkit-linear-gradient(309deg, #667eea 0%, #7159B6 71%, #764ba2 100%); /* safari5.1+,chrome10+ */
                background: -o-linear-gradient(309deg, #667eea 0%, #7159B6 71%, #764ba2 100%); /* opera 11.10+ */
                background: -ms-linear-gradient(309deg, #667eea 0%, #7159B6 71%, #764ba2 100%); /* ie10+ */
                background: linear-gradient(141deg, #667eea 0%, #7159B6 71%, #764ba2 100%); /* w3c */
            }

            .flex-center {
                align-items: center;
                display: flex;
                *justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                margin-left: 50px ;
            }

            .title {
                font-size: 60px;
                font-weight: 800;
            }

            .links > a {
                color: #fff;
                padding-right:25px;
                font-size: 12px;
                font-weight: 400;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                transition: all linear 200ms ;
            }
            .links > a:hover {
                color: #636b6f;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        {{-- <a href="{{ route('register') }}">Register</a> --}}
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    New Members' Fellowship Unit
                    <hr/>
                </div>
                <div class="m-b-md">
                    Gloryland Baptist Church, FHA Lugbe, Abuja.
                </div>

                <div class="links">
                    <a href="#">About NMFU</a>
                    <a href="#">Information</a>
                    <a href="#">Contact</a>
                </div>
            </div>
        </div>
    </body>
</html>
