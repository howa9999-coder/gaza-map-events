<!-- Draggable boycott list -->
<div class="navigation fixed top-2 md:top-3 left-1  bg-gray-100 z-100 rounded-lg shadow-md" id="navigation">
  <div class="toggle"></div>
  <!--Logo list-->
  <div class="flex-wrap justify-center grid grid-cols-2 gap-3 p-6 pb-0" id="logo">
    <!-- Add more logos as needed -->
    @foreach ($buycuts as $buycut)
      <button class="see-btn inline-block cursor-pointer bg-transparent border-none" title="{{ $buycut->title }}">
        <img src="{{ $buycut->logo_url() }}" alt="{{ $buycut->title }}"
          class="w-16 h-16 rounded-full cursor-pointer hover:scale-110 transition-transform duration-300 ease-in-out">
        <p class="max-w-full min-h-12">
          {{ strlen($buycut->title) > 16 ? str_replace('/\s+/', '', substr($buycut->title, 0, 16)) . '...' : str_replace('/\s+/', '', $buycut->title) }}
        </p>
      </button>
    @endforeach
  </div>
  <a href="{{ route('buycut_page') }}"
    class="mt-4 block cursor-pointer bg-transparent border-none text-blue-500 text-center pb-4">
    See More
  </a>
</div>
