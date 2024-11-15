{{-- @props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white']) --}}


{{-- <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
  <div @click="open = ! open">
    {{ $trigger }}
  </div>

  <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
    class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}" style="display: none;"
    @click="open = false">
    <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
      {{ $content }}
    </div>
  </div>
</div> --}}


<!--Associations section-->
<div class="container mx-auto my-8 p-6 carousel">
  <h2 class="text-2xl font-bold my-8 text-center">Associations</h2>
  <div class="relative">
    <div class="overflow-hidden">
      <div class="flex transition-transform duration-300 ease-in-out carousel-body">
        @foreach (config('associations') as $association)
          <!-- Association Item 1 -->
          <div class="flex-none w-full md:w-1/3 p-2">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
              <img src="images/associations/{{ $association['image'] }}" alt="{{ $association['name'] }}"
                class="w-full h-40 object-cover">
              <div class="p-4">
                <h3 class="font-semibold text-lg">{{ $association['name'] }}</h3>
                <p class="mt-2 text-gray-600">{{ $association['description'] }}</p>
                {{-- <a href="/association1" class="mt-4 inline-block text-blue-500 hover:underline">View More</a> --}}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <button id="prevSlide"
      class="prevSlide absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-500 text-white p-2 rounded-full">
      &#10094;
    </button>
    <button id="nextSlide"
      class="nextSlide absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-500 text-white p-2 rounded-full">
      &#10095;
    </button>
  </div>
  <hr>

</div>
