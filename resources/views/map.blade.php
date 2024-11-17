@extends('layout')

@section('content')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <!--Red div-->
  <div class="pt-20">
    <div class="bg-[#181818] pb-4 px-4 lg:px-16 min-h-screen flex" id="map-section">
      <div class="flex flex-col lg:flex-row gap-6 lg:gap-12 items-center w-full">
        <!-- Sidebar for Map Layers -->
        <div class="w-full lg:w-1/3 bg-[#212121] p-6 rounded-lg shadow-xl h-[600px] md:h-[500px] text-gray-300">
          <div class="space-y-5">
            <label for="layer-select" class="block text-xl text-white mb-2 font-extrabold">Interactive Map Article</label>

            <select id="layer-select"
              class="w-full bg-[#333333] text-gray-300 border border-[#444444] rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500">
              <!-- Add more options as needed -->
              <option value="">select an event</option>
              @foreach ($events as $event)
                <option value="{{ $event->id }}">{{ $event->title }}</option>
              @endforeach
            </select>
          </div>
          <div class="space-y-5">
            <!--title & description & read more-->
            <div id="content"> </div>
            <!--Full screen-->
            <button class="screen-button text-[40px] text-white cursor-pointer p-0 bg-transparent border-none"><ion-icon
                name="scan-outline"></ion-icon></button>
          </div>

        </div>

        <!-- Map Display -->
        <div id="map"
          class="w-full lg:w-2/3 z-10 bg-[#2A2A2A] h-[400px] md:h-[500px] rounded-lg shadow-lg mt-4 lg:mt-0"
          style="height: 500px;"></div>

      </div>
    </div>
    <div class="w-full h-[4px] pt-10 bg-red-500"></div>
  </div>
@endsection

@section('scripts')
  <script>
    const events = JSON.parse(`{!! $events->map(
        fn($event) => [
            'title' => $event->title,
            'article' => $event->article,
            'id' => $event->id,
            'shapes' => $event->shapes_json(),
        ],
    ) !!}`);
  </script>
  @vite(['pages/js/map.js'])
@endsection
