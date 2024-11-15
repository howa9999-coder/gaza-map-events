@extends('layout')

@section('content')
  <main class="pt-24 flex flex-col mt-10 items-center bg-gray-200">
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
      <div class="my-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($articles as $article)
          <div
            class="bg-white shadow-lg rounded-lg p-4 hover:shadow-2xl hover:scale-105 transition-all duration-300 ease-in-out relative">
            <a href="{{ route('article_show', $article->slug) }}">
              <img src="images/articles/{{ $article->image }}" alt="{{ $article->title }}"
                class="w-full object-cover rounded-lg max-h-48 mb-4">
            </a>
            <a href="{{ route('article_show', $article->slug) }}">
              <h2 class="text-xl font-semibold">{{ $article->title }}</h2>
            </a>
            <p class="text-gray-700 mt-2">{{ $article->description }}</p>
            <div class="mt-4 text-sm text-gray-500">
              <p>Author: {{ $article->author }}</p>
              <p>Date: {{ $article->date() }}</p>
            </div>
            <a href="{{ route('article_show', $article->slug) }}"
              class="read-button absolute bottom-4 right-4 text-blue-500 cursor-pointer p-0 bg-transparent border-none">
              Read
            </a>
          </div>
        @endforeach
      </div>
      <div id="pagination" class="mt-6 flex justify-center"></div>

      <hr class="my-6">

      <!--Associations section-->
      <x-associations-section />

    </div>
  </main>
@endsection

@section('scripts')
  @vite(['resources/js/article.js', 'resources/js/slide.js', 'resources/js/menu.js', 'resources/js/navigation.js'])

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
@endsection
