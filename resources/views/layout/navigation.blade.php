<header id="navbar" class="fixed w-full bg-transparent transition-colors duration-300 z-50 top-0">
  <div class="flex items-center bg-black justify-between px-6 py-4">

    <!-- Logo Name -->
    <a href="/">
      <div class="text-3xl md:text-5xl ml-10 text-white">Gaza Events</div>
    </a>
    <div class="flex">
      <!-- Contact Us Icon -->
      <div class="pr-6">
        <a href="/contact" class="text-white md:text-2xl text-xl hover:text-gray-600">
          <i class="fas fa-envelope"></i>
        </a>
      </div>
      <!-- Menu Icon -->
      <div class="flex items-center">
        <button id="menu-toggle" class="text-white md:text-2xl text-xl hover:text-gray-600 focus:outline-none"
          aria-expanded="false"><i class="fas fa-bars"></i>
        </button>
      </div>
    </div>

  </div>
  <!-- Dropdown Menu -->
  <nav id="menu-content"
    class="flex flex-col justify-center items-center top-0 bg-gray-100 left-0 w-full h-screen text-gray-800 shadow-lg py-4 px-6 hidden">
    <a href="/" class="text-2xl py-2 hover:text-blue-500">Home</a>
    <a href="{{ route('articles_page') }}" class="text-2xl py-2 hover:text-blue-500">Blog</a>
    <a href="{{ route('buycut_page') }}" class="text-2xl py-2 hover:text-blue-500">Boycott</a>
    <a href="{{ route('contact') }}" class="text-2xl py-2 hover:text-blue-500">Contact</a>
  </nav>
</header>
