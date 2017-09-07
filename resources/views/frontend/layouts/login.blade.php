<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    {{--<link href="{{ asset('frontend/css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/js/izimodal/css/iziModal.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/js/virtual-keyboard/css/keyboard.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/js/virtual-keyboard/css/keyboard-dark.min.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
<div id="app">
    <img src="{{ asset('frontend/images/login-bg.jpg') }}" id="login-bg" alt="">
    {{-- Section Content --}}
        @yield('content')
    {{-- Section Content END --}}

</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
<script src="{{ asset('frontend/js/izimodal/js/iziModal.js') }}"></script>
<script src="{{ asset('frontend/js/virtual-keyboard/js/jquery.keyboard.js') }}"></script>
<script src="{{ asset('frontend/js/virtual-keyboard/js/jquery.keyboard.extension-caret.min.js') }}"></script>
<script src="{{ asset('frontend/js/virtual-keyboard/js/jquery.keyboard.extension-typing.min.js') }}"></script>

<script src="{{ asset('frontend/js/virtual-keyboard/layouts/ms-Serbian.min.js') }}"></script>

<script src="{{ asset('frontend/js/custom.js') }}"></script>
{{-- Section SCRIPTS --}}
    @yield('scripts')
{{-- Section SCRIPTS END--}}
</body>
</html>
