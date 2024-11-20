@extends('layout')

@section('content')
  <main class="pt-24 flex flex-col mt-10 items-center">

    <div class="container mx-auto px-4 relative">

      <!-- Map Section -->
      <div id="map" class="w-ful h-[450px] md:h-[400px] mb-6 shadow-lg rounded-lg overflow-hidden z-10 "></div>
      <!--draggbale list-->
      <div class="navigation absolute top-0 right-0 bg-gray-100 rounded-lg shadow-md">
        <div class="toggle"></div>
        <div id="radio-Layers" class="pl-3 pt-2"></div>
      </div>
      <!--Article content-->
      <div class="bg-white shadow-md  p-6 mb-8">
        <h1 id="title" class="text-3xl font-bold text-gray-800 mb-4">{{ $article->title }}</h1>
        <div id="article" class="text-gray-700 leading-relaxed space-y-4">
          <p>{!! $article->content !!}</p>
        </div>
        <h6 id="author"></h6>
        <h6 id="date"></h6>
        <div class="mt-6 flex space-x-2">
          <a href="/path/to/shapefile.zip" download
            class="flex items-center bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-300">
            <ion-icon name="download-outline" class="mr-2"></ion-icon>
            Download Shapefile
          </a>
          <a id="facebookShare" class="flex items-center  text-black font-semibold py-2 px-4 rounded hover:bg-gray-50"
            target="_blank">
            <ion-icon name="logo-facebook" class="mr-2"></ion-icon></a>
          <a id="twitterShare" class="flex items-center  text-black font-semibold py-2 px-4 rounded hover:bg-gray-50"
            target="_blank">
            <ion-icon name="logo-twitter" class="mr-2"></ion-icon></a>
          <a id="linkedinShare" class="flex items-center  text-black font-semibold py-2 px-4 rounded hover:bg-gray-50"
            target="_blank">
            <ion-icon name="logo-linkedin" class="mr-2"></ion-icon></a>
        </div>
      </div>

      <!--Suggested articles-->
      <div class="container mx-auto my-4 p-6">
        <h2 class="text-2xl font-bold my-2 text-center">Suggested articles</h2>

        <div class="my-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"></div>
      </div>

      <!--Associations-->
      <div class="container mx-auto my-4 p-6">
        <h2 class="text-2xl font-bold my-2 text-center">Associations</h2>
        <div class="relative">
          <div class="overflow-hidden">
            <div class="flex transition-transform duration-300 ease-in-out" id="carousel"> <!--Cards--></div>
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

      <!--onTwitter & comment-->
      <div class="flex flex-col md:flex-row">

        <!-- Comment Section -->
        <div class="bg-white w-full md:w-3/4 p-4">
          <div class="mt-6">
            <h2 class="text-xl font-semibold">Comments</h2>
            <div class="mt-4">
              @foreach ($comments as $comment)
                <div class="border-b pb-4 mb-4 flex items-start">
                  <img src="{{ $comment->user->image }}" alt="User1" class="rounded-full mr-4">
                  <div class="flex-1">
                    <div class="flex justify-between">
                      <div>
                        <p class="font-bold">{{ $comment->user->name }}</p>
                        <p>{{ $comment->text }}</p>
                      </div>
                      <div class="flex items-center">
                        <button class="mr-2 text-blue-500">👍</button>
                        <span class="mr-2">{{ $comment->likes_count }}</span>
                        <button class="mr-2 text-red-500">👎</button>
                        <span class="mr-2">{{ $comment->dislikes_count }}</span>
                        <button class="text-gray-500">Reply</button>
                      </div>
                    </div>

                    @if ($comment->replys->count() > 0)
                      <!-- Replies -->
                      <div class="ml-6 mt-2 border-l pl-4">
                        @foreach ($comment->replys as $reply)
                          <div class="flex items-start">
                            <img src="{{ $reply->user->image }}" alt="{{ $reply->user->name }}" class="rounded-full mr-4">
                            <div class="flex-1">
                              <div class="flex justify-between">
                                <div>
                                  <p class="font-bold">{{ $reply->user->name }}</p>
                                  <p>{{ $reply->text }}</p>
                                </div>
                                <div class="flex items-center">
                                  <button class="mr-2 text-blue-500">👍</button>
                                  <span class="mr-2">{{ $reply->likes_count }}</span>
                                  <button class="mr-2 text-red-500">👎</button>
                                  <span class="mr-2">{{ $reply->dislikes_count }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    @endif
                  </div>
                </div>
              @endforeach
              <div class="border-b pb-4 mb-4 flex items-start">
                <img src="https://via.placeholder.com/40" alt="User2" class="rounded-full mr-4">
                <div class="flex-1">
                  <div class="flex justify-between">
                    <div>
                      <p class="font-bold">User2</p>
                      <p>This is another comment.</p>
                    </div>
                    <div class="flex items-center">
                      <button class="mr-2 text-blue-500">👍</button>
                      <span class="mr-2">4</span>
                      <button class="mr-2 text-red-500">👎</button>
                      <span class="mr-2">0</span>
                      <button class="text-gray-500">Reply</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Add New Comment -->
            <div class="mt-6">
              <h3 class="text-lg font-semibold">Add a Comment</h3>
              <textarea class="w-full border p-2 mt-2" rows="3" placeholder="Write your comment..."></textarea>
              <button class="bg-blue-500 text-white px-4 py-2 mt-2">Submit</button>
            </div>
          </div>
        </div>
        <!--on twitter-->
        <div class="bg-gray text-white w-full md:w-1/4 p-4">
          <a class="twitter-timeline" href="https://twitter.com/YourUsername?ref_src=twsrc%5Etfw">Tweets by
            YourUsername</a>
          <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>

      </div>
    </div>

  </main>
@endsection

@section('scripts')
  <script>
    const event = JSON.parse(`{!! json_encode([
        'title' => $article->event->title,
        'id' => $article->event->id,
        'shapes' => $article->event->shapes_json(),
    ]) !!}`);
  </script>
  @vite(['resources/js/single-article.js', 'resources/js/menu.js', 'resources/js/navigation.js'])
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
@endsection
