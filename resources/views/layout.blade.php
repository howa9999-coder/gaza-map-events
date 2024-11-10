<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  @include('layout.head')

  <body class="font-[Poppins] antialiased">

    @include('layout.navigation')

    @yield('content')

    <!--Footer-->
    @include('layout.footer')

    <!--scripts-->
    @include('layout.scripts')

    @yield('scripts')

  </body>

</html>
