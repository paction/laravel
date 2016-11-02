<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Laravel Assessment - @yield('title')</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
  </head>

  <body>
    @include('layouts.partials._nav')
    
    @include('layouts.partials._header')
    
    @yield('content')
    
    @include('layouts.partials._footer')
  </body>
</html>
