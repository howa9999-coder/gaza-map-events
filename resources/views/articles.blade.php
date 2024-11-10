@extends('layout')

@section('content')
  <main class="pt-24 flex flex-col mt-10 items-center">
    <div class="container mx-auto p-4 relative">
      <!-- Draggable boycott list -->
      <div class="navigation absolute top-0 right-0 bg-gray-100 rounded-lg shadow-md z-20">
        <div class="toggle"></div>
        <div id="radio-Layers" class="pl-3 pt-2"></div>
      </div>

      <!-- Search & filter -->
      <div class="bg-white shadow filter-container z-10">
        <div class="flex flex-col lg:flex-row mx-auto justify-center items-center p-4 space-y-4 lg:space-y-0">
          <div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4 w-full max-w-3xl">
            <input type="text" placeholder="Search..." id="search" class="border rounded p-2 w-full lg:w-64" />
            <select class="border rounded p-2 w-full lg:w-auto" id="articleSort">
              <option value="">Timeline</option>
              <option value="latest">Latest</option>
              <option value="oldest">Oldest</option>
            </select>
            <select id="categorySelect" class="border rounded p-2 w-full lg:w-auto">
              <option value="All">All categories</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Articles Cards -->
      <h2 class="text-2xl  font-bold mt-4  text-center">Articles</h2>
      <div class="my-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="card"></div>
      <div id="pagination" class="mt-4 flex justify-center"></div>
      <hr>
      <!--Associations-->
      <div class="container mx-auto my-6 p-6 carousel">
        <h2 class="text-2xl font-bold my-2 text-center">Associations</h2>
        <div class="relative">
          <div class="overflow-hidden">
            <div class="flex transition-transform duration-300 ease-in-out carousel-body" id="association-carousel">
              <!--Cards-->
            </div>
          </div>
          <button
            class="prevSlide absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-500 text-white p-2 rounded-full">
            &#10094;
          </button>
          <button
            class="nextSlide absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-500 text-white p-2 rounded-full">
            &#10095;
          </button>
        </div>
        <hr>
      </div>
    </div>
  </main>
@endsection

@section('scripts')
  @vite(['resources/js/article.js', 'resources/js/slide.js', 'resources/js/menu.js', 'resources/js/navigation.js'])

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
  <script>
    fetch("json/association.json")
      .then((response) => response.json())
      .then((data) => {
        data.forEach((item) => {
          // Function to render articles
          function renderAssociations(associations) {
            document.querySelector("#association-carousel").innerHTML = ""; // Clear existing cards
            associations.forEach((association) => {
              document.querySelector(
                "#association-carousel"
              ).innerHTML += `<div class="flex-none w-full md:w-1/3 p-2">
                                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                                        <img src="${association.logo}" alt="${association.name}" class="w-full h-40 object-cover">
                                        <div class="p-4">
                                            <h3 class="font-semibold text-lg">${association.name}</h3>
                                            <p class="mt-2 text-gray-600">${association.description}</p>
                                            <a href="${association.website}" class="mt-4 inline-block text-blue-500 hover:underline">${association.website}</a>
                                        </div>
                                    </div>
                                </div>`;
            });
          }
          // Initial render
          renderAssociations(data);
        });
      });
  </script>
@endsection
