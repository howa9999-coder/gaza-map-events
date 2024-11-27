@extends('layout')

@section('content')
  <div class="bg-white py-6">
    <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2">
      <div class="flex flex-row flex-wrap">
        <div class="flex-shrink max-w-full w-full overflow-hidden">
          <div class="w-full py-3">
            <div class="p-4 bg-gray-100">
              <div class="flex flex-col gap-4 md:flex-row md:items-center">

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
            </div>
          </div>

        </div>
        <!--Cards-->
        <div class="flex flex-row flex-wrap -mx-3">
          @foreach ($buycuts as $buycut)
            <div
              class="flex-shrink  max-w-full w-full sm:w-1/3 lg:w-1/4 px-3 pb-3 pt-3 sm:pt-0 border-b-2 sm:border-b-0 border-dotted border-gray-100 ">
              <div class="flex flex-row sm:block hover-img">
                <a href="{{ route('buycut_show', $buycut->id) }}">
                  <img class="max-w-full w-full object-cover h-48 mx-auto" src="{{ $buycut->logo_url() }}"
                    alt="{{ $buycut->title }} image">
                </a>
                <div class="py-0 sm:py-3 pl-3 sm:pl-0">
                  <h3 class="text-lg font-bold leading-tight mb-2">
                    <a href="{{ route('buycut_show', $buycut->id) }}">{{ $buycut->title }}</a>
                  </h3>
                  <p class="hidden md:block text-gray-600 leading-tight mb-1">
                    {{ strlen($buycut->reason) > 80 ? substr($buycut->reason, 0, 80) . '...' : $buycut->reason }}</p>
                </div>
              </div>
            </div>
          @endforeach

        </div>
      </div>
    </div>
  </div>
@endsection
