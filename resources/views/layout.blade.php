<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="PAICDR06H2ZaGeNGSDKrD4yGyR0MufSIOvYykdAV">

        <title>Анализатор страниц</title>

        <!-- Scripts -->
        <script src="https://php-l3-page-analyzer.herokuapp.com/js/app.js" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="https://php-l3-page-analyzer.herokuapp.com/css/app.css" rel="stylesheet">
    </head>
    <body class="min-vh-100 d-flex flex-column">
        <header class="flex-shrink-0">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <a class="navbar-brand" href="/">Анализатор страниц</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link 
                            @if(parse_url(Request::url(), PHP_URL_PATH) !== '/urls')
                                active
                            @endif
                            " href="/">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link
                            @if(parse_url(Request::url(), PHP_URL_PATH) === '/urls')
                                active
                            @endif
                            " href="/urls">Сайты</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        @include('messages')
        @yield('content')

        <footer class="border-top py-3 mt-5 flex-shrink-0">
            <div class="container-lg">
                <div class="text-center">
                    <a href="https://hexlet.io/pages/about" target="_blank">Hexlet</a>
                </div>
            </div>
        </footer>
    </body>
</html>
