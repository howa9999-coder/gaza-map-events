@extends('layout')

@section('styles')
  <!--Leaflet-->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <!--Marker cluster-->
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
  <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
@endsection

@section('content')
  <!--Map-->
  <div class="w-full h-[500px] md:h-[calc(100vh-80px)] flex flex-col relative">
    <div id="overlay"
      class="bg-black opacity-30 flex items-center justify-center hover:opacity-65 transition-opacity duration-700 absolute inset-0 w-full h-full z-10">
      <h3 class="text-white font-bold">Click To Interact with map</h3>
    </div>
    <div class="inset-0 object-cover opacity-90 grow" id="map"></div>
    <div class="bg-red-700 h-10 w-full flex items-center justify-between px-8 relative z-20">
      <button class="screen-button text-white text-extrabold text-2xl hover:text-black">
        <i class="fas fa-expand"></i>
      </button>
      <a class="hover:text-black text-white" href="{{ route('articles_page') }}">
        More Articles
        <i class="px-2 fas fa-arrow-right"></i>
      </a>
    </div>
  </div>

  <!--Article-->
  <div class="max-w-4xl rounded-lg shadow-lg mx-auto py-12 px-12 lg:-mt-44 lg:px-24 relative z-30 bg-white">
    <h2 class="mt-4 uppercase tracking-widest text-xs text-gray-600">{{ $buycut->created_at->format('Y D i') }}</h2>
    <h1 class="font-bold text-4xl md:text-3xl  mt-4">{{ $buycut->title }}</h1>
    <div class="prose prose-sm sm:prose lg:prose-lg mt-6">
      {!! str_replace('\n', '<br/>', $buycut->reason) !!}
    </div>
  </div>

  <!-- Search Bar -->
  <div class="w-full py-3">
    <div class="p-4 bg-gray-100">
      <form>
        <div class="flex flex-col gap-4 md:flex-row md:items-center">
          <div class="flex-grow">
            <input type="text" id="search" placeholder="Search..." name="search"
              class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div class="flex-grow md:w-1/4">
            <select name="category"
              class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
              <option value="">Select a category</option>
              @foreach ($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->title }}</option>
              @endforeach
            </select>
          </div>

          <button type="submit"
            class="bg-red-600 hover:bg-red-700 transition-colors rounded-md px-4 py-2 text-white">Search</button>
        </div>
      </form>
    </div>
  </div>

  <!--onTwitter & comment-->
  <div class="flex container mx-auto mt-4 flex-col md:flex-row mb-12">

    <!--on twitter-->
    <div class="bg-gray text-white w-full md:w-1/4 p-4">
      <a class="twitter-timeline" href="https://twitter.com/YourUsername?ref_src=twsrc%5Etfw">Tweets by
        YourUsername</a>
      <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>

  </div>
@endsection

@section('scripts')
  {{-- @vite(['resources/js/single-article.js']) --}}
@endsection
