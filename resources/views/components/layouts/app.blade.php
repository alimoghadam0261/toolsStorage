<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">





        <title>{{ $title ?? 'Page Title' }}</title>


        @livewireStyles
        @vite([
        'resources/css/app.css',

        'resources/js/app.js',
        'resources/js/chart.js',
        'resources/js/vis-network.js'
        ])
    </head>
    <body>
{{--    <i id="toggleBtn" class="fa-solid fa-arrow-right-arrow-left"></i>--}}
    @livewire ('component.mobile.topmenu')
        {{ $slot }}
    @livewire ('component.mobile.bottommenu')


    @livewireScripts


    </body>
</html>
