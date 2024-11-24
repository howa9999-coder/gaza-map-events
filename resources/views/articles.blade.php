@extends('layout')

@section('content')
  <div class="bg-white py-6">
    <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2">
      <div class="flex flex-row flex-wrap">
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
      </div>
      <div class="flex flex-row flex-wrap -mx-3 mt-4">
        @foreach ($articles as $art)
          <div
            class="flex-shrink max-w-full w-full sm:w-1/3 lg:w-1/4 px-3 pb-3 pt-3 sm:pt-0 border-b-2 sm:border-b-0 border-dotted border-gray-100">
            <div class="flex flex-row sm:block hover-img">
              <a href="{{ route('article_show', $art->slug) }}">
                <img
                  class="max-w-full w-full mx-auto aspect-[1.5] object-cover object-center hover:scale-105 hover:shadow-md border border-black border-opacity-0 hover:border-opacity-15 shadow transition-all duration-500"
                  src="{{ $art->image_url() }}" alt="alt title">
              </a>
              <div class="py-0 sm:py-3 pl-3 sm:pl-0">
                <h3 class="text-lg font-bold leading-tight mb-2">
                  <a href="{{ route('article_show', $art->slug) }}">{{ $art->title }}</a>
                </h3>
                <p class="hidden md:block text-gray-600 leading-tight mb-1 min-h-16">
                  {{ strlen($art->description) > 80 ? substr($art->description, 0, 80) . '...' : $art->description }}</p>
                @if ($art->category)
                  <a class="text-gray-500" href="{{ route('article_show', $art->slug) }}"><span
                      class="inline-block h-3 border-l-2 border-red-600 mr-2"></span>{{ $art->category?->title }}</a>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  </div>
@endsection
