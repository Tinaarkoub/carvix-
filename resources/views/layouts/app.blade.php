<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Carvix') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                background:#f4f5f1;
                font-family: Arial, Helvetica, sans-serif;
            }
        </style>
    </head>
    <body>
        <div style="min-height:100vh;">

            @include('layouts.navigation')

            @if (isset($header))
                <div style="max-width:1200px; margin:0 auto; padding:0 20px;">
                    {{ $header }}
                </div>
            @endif

            <main>
                {{ $slot }}
            </main>

        </div>

        <x-cookie-consent />
        <x-accessibility-bar />

    </body>
</html>