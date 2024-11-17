@extends('dashboard.empty-layout')

@section('header')
  <!-- Bootstrap 5.2.3 -->
  @if (app()->getLocale() == 'ar')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"
      integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
  @else
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  @endif

  <!-- fontawesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- libraries -->
  @vite(['resources/css/dashboard/sweetalert2.min.css', 'resources/css/dashboard/notyf.min.css', 'resources/css/dashboard/volt.css'])

  @yield('styles')
@endsection


@section('page')
  @include('dashboard.layout.header')

  <main class="content">

    @include('dashboard.layout.navbar')

    @yield('content')

    @include('dashboard.layout.footer')

  </main>

  <!-- Jquery 3.7.0 -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

  <!-- Bootstrap 5.2.3 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

  <script src="{{ url('libs/dashboard/sweetalert2.all.min.js') }}"></script>

  @yield('jslibraries')

  @vite('resources/js/volt.js')

  @yield('scripts')
@endsection
