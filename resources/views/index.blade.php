<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('partials._head')
    </head>

    <body>
        <!--content-->
        <div id="app"></div>
    </body>

    @include('partials._javascript')
</html>