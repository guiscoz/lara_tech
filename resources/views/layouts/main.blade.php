<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <title>@yield('title')</title>
        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    </head>

    <style>
            html, body {
                height: 100%;
            }
            body {
                display: flex;
                flex-direction: column;
            }
            main {
                flex: 1;
            }
        </style>

    <body class="antialiased">
        @component('components.header')
        @endcomponent

        <main class="py-4 vh-80">
            <div class="container">
                @if(session('msg'))
                    <div class="alert alert-success" role="alert">
                        {{ session('msg') }}
                    </div>
                @endif

                @if(session('alert'))
                    <div class="alert alert-warning" role="alert">
                        {{ session('alert') }}
                    </div>
                @endif

                @yield('content')

                @stack('scripts')
            </div>
        </main>

        @component('components.footer')
        @endcomponent

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
