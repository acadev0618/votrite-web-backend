<!DOCTYPE html>
<html lang="en">
<head>
    @include('auth.common.meta')
    @include('auth.common.css')
</head>
    <body>
        @yield('content')
        @include('auth.common.js')
    </body>
</html>
