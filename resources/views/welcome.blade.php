<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
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
                text-align: center;
                padding: 0 5%;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
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

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Alex Wharff
                </div>

                <p>Hi, all. This is the skills assessment that was sent to me. You can see the code <a href="https://github.com/maxxwv/" alt="Link to skills assessment code" target="_blank" rel="noopener nofollow">here</a>. Thank you for the opportunity and the time, and I look forward to speaking with you soon!</p>
                <p>Oh, yeah. you're gonna want to create a new user in oreder to track your beverages and caffeine intake. Once you've done that, you can log in, log out, and track your caffeine intake daily. The system will only show caffiene intake from the current day, so you can start over fresh every day if you want to.</p>
                <div class="links">
                    <a href="https://maxxwv.com" target="_blank" rel="noopener nofollow">My Site</a>
                    <a href="https://bitbucket.org/maxxdesigns/" target="_blank" rel="noopener nofollow">BitBucket</a>
                    <a href="https://github.com/maxxwv" target="_blank" rel="noopener nofollow">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
