<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <script src="{{ asset('js/all.min.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- fontawesome 5.14 -->
        <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
        @include('partials.globalcss')
        @yield('localcss')

    </head>
    <body>

        @include('partials.sidenav')

        <div id="app">
            @include('partials.navbar')
            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong> {{ session('status') }} </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="principal">
                @yield('content-left') 

                @yield('content')  
            </div>   
        </div>   

        @include('partials.footer')


        @include('partials.globalscript')
        @yield('localscript')

    </body>
</html>
