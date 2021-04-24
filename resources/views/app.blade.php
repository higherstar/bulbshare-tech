<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('Shared.head')
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                @yield('content')
            </div>
        </div>
        @include('Shared.footer')
    </body>
</html>
