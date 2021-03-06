<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />

    </head>
    <body class="antialiased">
        <div id="root">
            <App></App>
        </div>
        <script src="{{ mix('/js/app.js') }}" defer></script>
    </body>
</html>
