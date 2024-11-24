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

  <!-- block news -->
  <div class="bg-gray-50 py-6 mt-4">
    <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2">
      <div class="flex flex-row flex-wrap">
        <!-- right -->
        <div class="flex-shrink max-w-full w-full lg:w-1/3 lg:pl-8 lg:pt-14 lg:pb-8 order-first lg:order-last">
          <div class="w-full bg-white">
            <div class="mb-6">
              <div class="p-4 bg-gray-100">
                <h2 class="text-lg font-bold">Most Popular</h2>
              </div>
              <ul class="post-number">
                <li class="border-b border-gray-100 hover:bg-gray-50">
                  <a class="text-lg font-bold px-6 py-3 flex flex-row items-center" href="#">Why the world
                    would end
                    without political polls</a>
                </li>
                <li class="border-b border-gray-100 hover:bg-gray-50">
                  <a class="text-lg font-bold px-6 py-3 flex flex-row items-center" href="#">Meet The Man
                    Who Designed
                    The Ducati Monster</a>
                </li>
                <li class="border-b border-gray-100 hover:bg-gray-50">
                  <a class="text-lg font-bold px-6 py-3 flex flex-row items-center" href="#">2020 Audi R8
                    Spyder spy
                    shots release</a>
                </li>
                <li class="border-b border-gray-100 hover:bg-gray-50">
                  <a class="text-lg font-bold px-6 py-3 flex flex-row items-center" href="#">Lamborghini
                    makes Huracán
                    GT3 racer faster for 2019</a>
                </li>
                <li class="border-b border-gray-100 hover:bg-gray-50">
                  <a class="text-lg font-bold px-6 py-3 flex flex-row items-center" href="#">ZF plans $14
                    billion
                    autonomous vehicle push, concept van</a>
                </li>
              </ul>
            </div>
          </div>
          <!--on twitter-->
          <div class="text-sm py-6 sticky">
            <div class="w-full text-center">
              <a class="twitter-timeline" href="https://twitter.com/YourUsername?ref_src=twsrc%5Etfw">Tweets by
                YourUsername</a>
              <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
            </div>
          </div>
        </div>
        <!-- Left -->
        <div class="flex-shrink max-w-full w-full lg:w-2/3  overflow-hidden">
          <div class="w-full py-3">
            <h2 class="text-4xl text-center border-l-4 py-2 font-semibold border-b-4 w-[300px] border-red-500">Newest
              Articles</h2>
          </div>
          <div class="flex flex-row mt-2 flex-wrap -mx-3">
            {{-- big article --}}
            <div class="flex-shrink max-w-full w-full px-3 pb-5">
              <div class="relative hover-img max-h-98 overflow-hidden">
                <!--thumbnail-->
                <a href="#">
                  <img class="max-w-full w-full mx-auto h-auto aspect-[1.5] object-cover object-center"
                    src="src/img/dummy/img15.jpg" alt="Image description">
                </a>
                <div class="absolute px-5 pt-8 pb-5 bottom-0 w-full bg-gradient-cover">
                  <!--title-->
                  <a href="#">
                    <h2 class="text-3xl font-bold capitalize text-white mb-3">Amazon Shoppers Are Ditching Designer
                      Belts for This Best-Selling</h2>
                  </a>
                  <p class="text-gray-100 hidden sm:inline-block">This is a wider card with supporting text below
                    as a
                    natural lead-in to additional content. This very helpfull for generate default content..</p>
                  <!-- author and date -->
                  <div class="pt-2">
                    <div class="text-gray-100">
                      <div class="inline-block h-3 border-l-2 border-red-600 mr-2"></div>Europe
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- articles --}}
            @foreach ($latest_articles as $article)
              <div
                class="flex-shrink max-w-full w-full sm:w-1/3 px-3 pb-3 pt-3 sm:pt-0 border-b-2 sm:border-b-0 border-dotted border-gray-100">
                <div class="flex flex-row sm:block hover-img">
                  <a href="{{ route('article_show', $article->slug) }}">
                    <img class="max-w-full w-full mx-auto aspect-[1.5] object-cover object-center"
                      src="{{ $article->image_url() }}" alt="{{ $article->title }}">
                  </a>
                  <div class="py-0 sm:py-3 pl-3 sm:pl-0">
                    <h3 class="text-lg font-bold leading-tight mb-2">
                      <a href="{{ route('article_show', $article->slug) }}">{{ $article->title }}</a>
                    </h3>
                    <p class="hidden md:block text-gray-600 leading-tight mb-1 md:min-h-16">
                      {{ strlen($article->description) > 80 ? substr($article->description, 0, 80) . '...' : $article->description }}
                    </p>
                    <a class="text-gray-500" href="#"><span
                        class="inline-block h-3 border-l-2 border-red-600 mr-2"></span>Europe</a>
                  </div>
                </div>
              </div>
            @endforeach

          </div>
        </div>

      </div>
    </div>
  </div>

  <!--sources-->
  <div class=" bg-gray-200 shadow-lg py-2 text-xl text-blue-900 overflow-hidden">
    <div class="marquee flex   items-center">
      <a href="" class="pr-10">UNOSAT - The United Nations Satellite Centre </a>
      <a href="" class="pr-10">BDS - Boycott, Divestment and Sanctions</a>
      <a href="" class="pr-10">UNOSAT - The United Nations Satellite Centre </a>
      <a href="" class="pr-10">BDS - Boycott, Divestment and Sanctions</a>
    </div>
  </div>

  <!-- Subscribe Section -->
  <div class="bg-white  py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto text-center">
      <h2 class="text-3xl font-extrabold text-black sm:text-4xl">
        Subscribe to Our Newsletter
      </h2>
      <p class="mt-4 text-lg text-gray-700">
        Get the latest updates and news delivered directly to your inbox.
      </p>
      <div class="mt-8 max-w-md mx-auto flex">
        <input type="email" placeholder="Enter your email address"
          class="w-full px-4 border border-gray-700 border-r-blue-500 rounded-l-md py-2rounded-l-md text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
        <button
          class="w-auto px-6 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
          Subscribe
        </button>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    const GeoJsonEvents = JSON.parse(`
      {
        "type": "FeatureCollection",
        "features": [
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.4506, 31.5] },
            "properties": {
              "title": "Marker 1",
              "description": "Description for Marker 1",
              "link": "article.html",
              "category": "Category A",
              "date": "2024-01-01",
              "author": "Author 1"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.46, 31.51] },
            "properties": {
              "title": "Marker 2",
              "description": "Description for Marker 2",
              "link": "article.html",
              "category": "Category B",
              "date": "2024-01-02",
              "author": "Author 2"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.47, 31.52] },
            "properties": {
              "title": "Marker 3",
              "description": "Description for Marker 3",
              "link": "article.html",
              "category": "Category C",
              "date": "2024-01-03",
              "author": "Author 3"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.48, 31.53] },
            "properties": {
              "title": "Marker 4",
              "description": "Description for Marker 4",
              "link": "https://example.com/marker4",
              "category": "Category A",
              "date": "2024-01-04",
              "author": "Author 4"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.49, 31.54] },
            "properties": {
              "title": "Marker 5",
              "description": "Description for Marker 5",
              "link": "article.html",
              "category": "Category B",
              "date": "2024-01-05",
              "author": "Author 5"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.45, 31.55] },
            "properties": {
              "title": "Marker 6",
              "description": "Description for Marker 6",
              "link": "article.html",
              "category": "Category C",
              "date": "2024-01-06",
              "author": "Author 6"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.46, 31.56] },
            "properties": {
              "title": "Marker 7",
              "description": "Description for Marker 7",
              "link": "https://example.com/marker7",
              "category": "Category A",
              "date": "2024-01-07",
              "author": "Author 7"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.47, 31.57] },
            "properties": {
              "title": "Marker 8",
              "description": "Description for Marker 8",
              "link": "article.html",
              "category": "Category B",
              "date": "2024-01-08",
              "author": "Author 8"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.48, 31.58] },
            "properties": {
              "title": "Marker 9",
              "description": "Description for Marker 9",
              "link": "article.html",
              "category": "Category C",
              "date": "2024-01-09",
              "author": "Author 9"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.49, 31.59] },
            "properties": {
              "title": "Marker 10",
              "description": "Description for Marker 10",
              "link": "article.html",
              "category": "Category C",
              "date": "2024-01-10",
              "author": "Author 10"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.4506, 31.505] },
            "properties": {
              "title": "Marker 11",
              "description": "Description for Marker 11",
              "link": "article.html",
              "category": "Category B",
              "date": "2024-01-11",
              "author": "Author 11"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.4556, 31.515] },
            "properties": {
              "title": "Marker 12",
              "description": "Description for Marker 12",
              "link": "article.html",
              "category": "Category C",
              "date": "2024-01-12",
              "author": "Author 12"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.4606, 31.525] },
            "properties": {
              "title": "Marker 13",
              "description": "Description for Marker 13",
              "link": "article.html",
              "category": "Category A",
              "date": "2024-01-13",
              "author": "Author 13"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.4656, 31.535] },
            "properties": {
              "title": "Marker 14",
              "description": "Description for Marker 14",
              "link": "article.html",
              "category": "Category B",
              "date": "2024-01-14",
              "author": "Author 14"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.4706, 31.545] },
            "properties": {
              "title": "Marker 15",
              "description": "Description for Marker 15",
              "link": "article.html",
              "category": "Category C",
              "date": "2024-01-15",
              "author": "Author 15"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.4756, 31.555] },
            "properties": {
              "title": "Marker 16",
              "description": "Description for Marker 16",
              "link": "article.html",
              "category": "Category A",
              "date": "2024-01-16",
              "author": "Author 16"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.4806, 31.565] },
            "properties": {
              "title": "Marker 17",
              "description": "Description for Marker 17",
              "link": "article.html",
              "category": "Category B",
              "date": "2024-01-17",
              "author": "Author 17"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.4856, 31.575] },
            "properties": {
              "title": "Marker 18",
              "description": "Description for Marker 18",
              "link": "article.html",
              "category": "Category C",
              "date": "2024-01-18",
              "author": "Author 18"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.4906, 31.585] },
            "properties": {
              "title": "Marker 19",
              "description": "Description for Marker 19",
              "link": "article.html",
              "category": "Category A",
              "date": "2024-01-19",
              "author": "Author 19"
            }
          },
          {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [34.4956, 31.595] },
            "properties": {
              "title": "Marker 20",
              "description": "Description for Marker 20",
              "link": "article.html",
              "category": "Category B",
              "date": "2024-01-20",
              "author": "Author 20"
            }
          }
        ]
      }
    `);
  </script>
  @vite(['resources/js/map.js'])
@endsection
