<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">

    </nav>

    {{-- Section Content --}}
    @yield('content')
    {{-- Section Content END --}}

</div>

{{-- Section SCRIPTS --}}
@yield('scripts')
{{-- Section SCRIPTS END--}}
</body>
</html>