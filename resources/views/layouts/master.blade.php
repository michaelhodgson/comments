<html>
    <head>
        <title>Comments</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/heroic-features.css" rel="stylesheet">
        <link href="/css/styles.css" rel="stylesheet">

        <script src="/js/jquery.js"></script>
        <script src="/js/bootstrap.min.js"></script>      
    </head>
    <body>
        @section('header')
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">            
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">Comments</a>
                </div>              
            </div>

        </nav>
        @show

        <div class="container">
            @yield('content')
        </div>

        @yield('scripts')
    </body>
</html>