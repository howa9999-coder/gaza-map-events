<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet">

    <!--leaflet-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!--For urgent news-->
    <style>
      .marquee {
        display: inline-block;
        white-space: nowrap;
        animation: marquee 15s linear infinite;
      }

      @keyframes marquee {
        0% {
          transform: translateX(100%);
        }

        100% {
          transform: translateX(-100%);
        }
      }
    </style>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
  </head>

  <body class="font-[Poppins] antialiased">
    <header class="bg-white shadow-lg fixed top-0 left-0  w-full z-50">
      <nav class="flex justify-between items-center w-[92%] mx-auto">
        <div>
          <h1 class="text-4xl md:text-5xl my-5">
            Gaza Events
          </h1>
        </div>
        <div
          class="nav-links transition-all duration-500 md:static absolute bg-white md:min-h-fit min-h-[60vh] left-0 top-[-1000%] md:w-auto w-full flex items-center px-5">
          <ul class="flex md:flex-row flex-col mx-auto md:items-center md:gap-[4vw] gap-8">
            <li>
              <a class="hover:text-gray-500" href="#home">Dashboard</a>
            </li>
            <li>
              <a class="hover:text-gray-500" href="#articles">Articles</a>
            </li>
            <li>
              <a class="hover:text-gray-500" href="#associations">Associations</a>
            </li>
            <li>
              <a class="hover:text-gray-500" href="#contact">Contact us</a>
            </li>
          </ul>
        </div>
        <div class="flex items-center gap-6">
          <button class="text-white px-5 py-2 rounded-full  bg-green-500 hover:bg-[#87ec9f]">Map</button>
          <ion-icon name="menu" onclick="onToggleMenu(this)" class="text-3xl cursor-pointer md:hidden"></ion-icon>
        </div>
      </nav>
    </header>
    <!--Urgent-->
    <div class="fixed top-20 left-0 right-0 bg-red-600 text-white py-2 overflow-hidden z-50">
      <div class="marquee">
        <span class="px-4"> Emergency News: Major updates on the situation in Gaza... </span>
        <span class="px-4"> Emergency News: Relief efforts are ongoing... </span>
        <span class="px-4"> Emergency News: Safety tips for residents... </span>
      </div>
    </div>

    <!--first section-->
    <div class="mt-20">
      <div class="relative bg-gradient-to-r from-cyan-500 to-blue-500 h-screen  md:h-96 bg-cover bg-center"
        id="home">
        <div class="absolute inset-0 bg-black opacity-50"></div> <!-- Optional overlay for better text visibility -->
        <div class="flex flex-col items-center justify-center h-full" id="home-about">
          <h1 class="text-black text-5xl mb-6 md:text-6xl font-bold text-center">
            Gaza Events
          </h1>
          <p class="text-white text-xl font-medium text-center">
            " Remembering, Reflecting, Rising"
          </p>

        </div>
        <!-- About Us Button -->
        <div class="absolute left-8 top-14 ">
          <a href="#" onclick="aboutUs()" id="about-btn"
            class="bg-gray-200 shadow-lg z-30 text-blue-500  py-2 px-4 rounded-lg hover:bg-gray-200 transition">
            About Gaza Events
          </a>
        </div>
      </div>
    </div>

    <!--Articles section-->
    <div class="shadow-md">
      <div class="container mx-auto p-4 mt-4 " id="articles">
        <h2 class="text-2xl font-bold my-8 text-center">Latest Articles</h2>
        <div class="flex flex-wrap -mx-2">
          <div class="w-full sm:w-1/2 md:w-1/3 px-2 mb-4">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
              <img src="article.webp" alt="Article Image" class="w-full h-50 object-cover">
              <div class="p-4">
                <h3 class="text-lg font-semibold">Article Title 1</h3>
                <p class="text-gray-600 mt-1">This is a short description of the article that gives a brief overview of
                  its content.</p>
                <div class="mt-4 text-sm text-gray-500">
                  <span>By Author Name</span> | <span>Published on Oct 29, 2024</span>
                </div>
              </div>
            </div>
          </div>

          <div class="w-full sm:w-1/2 md:w-1/3 px-2 mb-4">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
              <img src="article.webp" alt="Article Image" class="w-full h-50 object-cover">
              <div class="p-4">
                <h3 class="text-lg font-semibold">Article Title 1</h3>
                <p class="text-gray-600 mt-1">This is a short description of the article that gives a brief overview of
                  its content.</p>
                <div class="mt-4 text-sm text-gray-500">
                  <span>By Author Name</span> | <span>Published on Oct 29, 2024</span>
                </div>
              </div>
            </div>
          </div>


          <div class="w-full sm:w-1/2 md:w-1/3 px-2 mb-4">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
              <img src="article.webp" alt="Article Image" class="w-full h-50 object-cover">
              <div class="p-4">
                <h3 class="text-lg font-semibold">Article Title 2</h3>
                <p class="text-gray-600 mt-1">This is a short description of the article that gives a brief overview of
                  its content.</p>
                <div class="mt-4 text-sm text-gray-500">
                  <span>By Author Name</span> | <span>Published on Oct 29, 2024</span>
                </div>
              </div>
            </div>
          </div>


        </div>
        <div class="flex justify-end my-6">
          <a href="/more-articles" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">
            More Articles
          </a>
        </div>

        <hr>
      </div>
    </div>

    <!--Map section-->
    <div class=" container flex-col mt-4 mx-auto" id="map-section">
      <h2 class="text-2xl font-bold mb-2 text-center">Gaza Damage Map</h2>

      <div class="w-full mx-auto p-6 bg-white mt-20 rounded-lg shadow-lg flex flex-col lg:flex-row items-center">

        <div class="lg:w-1/2 lg:pr-4 mb-4 lg:mb-0">
          <h3 class="mb-6">Explore the Gaza Damage Map: A Visual Representation of Impact</h3>
          <p class="text-gray-700 my-3">
            This interactive map serves as a powerful tool to visualize the extensive damages inflicted upon Gaza due to
            ongoing conflict and occupation. By incorporating multiple data layers, the map provides users with an
            intuitive and comprehensive view of the destruction across various regions.
          </p>

          <button class="bg-green-500 mt-3 text-white px-5 py-2 rounded-full hover:bg-[#87ec9f]">Map</button>

        </div>
        <div id="map" class="lg:w-1/2 mt-3 z-20 w-full rounded-lg shadow" style="height: 400px;"></div>

      </div>
    </div>

    <!--Associations section-->
    <div class="container mx-auto my-8 p-6" id="associations">
      <h2 class="text-2xl font-bold my-8 text-center">Associations</h2>
      <div class="relative">
        <div class="overflow-hidden">
          <div class="flex transition-transform duration-300 ease-in-out" id="carousel">
            <!-- Association Item 1 -->
            <div class="flex-none w-full md:w-1/3 p-2">
              <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="association.jpg" alt="Association 1" class="w-full h-40 object-cover">
                <div class="p-4">
                  <h3 class="font-semibold text-lg">Association 1</h3>
                  <p class="mt-2 text-gray-600">Description of Association 1.</p>
                  <a href="/association1" class="mt-4 inline-block text-blue-500 hover:underline">View More</a>
                </div>
              </div>
            </div>
            <!-- Association Item 2 -->
            <div class="flex-none w-full md:w-1/3 p-2">
              <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="association.jpg" alt="Association 2" class="w-full h-40 object-cover">
                <div class="p-4">
                  <h3 class="font-semibold text-lg">Association 2</h3>
                  <p class="mt-2 text-gray-600">Description of Association 2.</p>
                  <a href="/association2" class="mt-4 inline-block text-blue-500 hover:underline">View More</a>
                </div>
              </div>
            </div>
            <!-- Association Item 3 -->
            <div class="flex-none w-full md:w-1/3 p-2">
              <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="association.jpg" alt="Association 3" class="w-full h-40 object-cover">
                <div class="p-4">
                  <h3 class="font-semibold text-lg">Association 3</h3>
                  <p class="mt-2 text-gray-600">Description of Association 3.</p>
                  <a href="/association3" class="mt-4 inline-block text-blue-500 hover:underline">View More</a>
                </div>
              </div>
            </div>
            <!-- Association Item 4 -->
            <div class="flex-none w-full md:w-1/3 p-2">
              <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="association.jpg" alt="Association 4" class="w-full h-40 object-cover">
                <div class="p-4">
                  <h3 class="font-semibold text-lg">Association 4</h3>
                  <p class="mt-2 text-gray-600">Description of Association 4.</p>
                  <a href="/association3" class="mt-4 inline-block text-blue-500 hover:underline">View More</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button onclick="prevSlide()"
          class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-500 text-white p-2 rounded-full">
          &#10094;
        </button>
        <button onclick="nextSlide()"
          class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-500 text-white p-2 rounded-full">
          &#10095;
        </button>
      </div>
      <hr>

    </div>

    <!--Footer-->
    <footer class="bg-gray-800 text-white py-8" id="contact">
      <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between">
          <!-- Contact Information -->
          <div class="mb-6 md:mb-0">
            <h1 class="text-4xl mb-20 md:text-5xl font-bold text-blue-600 tracking-wide shadow-lg">
              Gaza Events
            </h1>
            <h3 class="font-bold text-lg">Contact Us</h3>
            <p class="mt-2">xxx Main Street, City, Country</p>
            <p>Email: contact@xxx.com</p>
            <p>Phone: (123) xxxxxxxxx</p>
          </div>
          <div>
            <h3 class="font-bold text-lg mb-4">Menu</h3>
            <ul class="space-y-2">
              <li><a href="#home" class="hover:underline">Dashboard</a></li>
              <li><a href="#articles" class="hover:underline">Articles</a></li>
              <li><a href="#associations" class="hover:underline">Associations</a></li>
            </ul>
          </div>
        </div>
        <div class="mt-8 border-t border-gray-700 pt-4 text-center">
          <p class="text-sm">&copy; 2024 Gaza Events. All rights reserved.</p>
        </div>
      </div>
    </footer>


    <!--scripts-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    @vite(['resources/js/dashboard.js'])

  </body>

</html>
