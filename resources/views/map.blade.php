@extends('layout')

@section('content')
  <!--Red div-->
  <div class=" bg-red-600 h-[46px] py-2"></div>

  <div id="map" class="lg:w-1/2 mt-3 z-20 w-full rounded-lg shadow" style="height: 400px;"></div>
@endsection

@section('scripts')
  @vite(['resources/js/home.js', 'resources/js/slide.js'])
@endsection
