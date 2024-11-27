@extends('layout')

@section('styles')
  <!--Leaflet-->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <!--Marker cluster-->
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
  <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
@endsection

@section('content')
  <!--Map-->
  <div class="w-full h-[500px] md:h-[calc(100vh-80px)] flex flex-col relative">
    <div id="overlay"
      class="bg-black opacity-30 flex items-center justify-center hover:opacity-65 transition-opacity duration-700 absolute inset-0 w-full h-full z-10">
      <h3 class="text-white font-bold">Click To Interact with map</h3>
    </div>
    <div class="inset-0 object-cover opacity-90 grow" id="map"></div>
    <div class="bg-red-700 h-10 w-full flex items-center justify-between px-8 relative z-20">
      <button class="screen-button text-white text-extrabold text-2xl hover:text-black">
        <i class="fas fa-expand"></i>
      </button>
      <a class="hover:text-black text-white" href="{{ route('articles_page') }}">
        More Articles
        <i class="px-2 fas fa-arrow-right"></i>
      </a>
    </div>
  </div>

  <!--Article-->
  <div class="max-w-4xl rounded-lg shadow-lg mx-auto py-12 px-12 lg:-mt-44 lg:px-24 relative z-30 bg-white">
    <h2 class="mt-4 uppercase tracking-widest text-xs text-gray-600">{{ $article->created_at->format('Y D i') }}</h2>
    <h1 class="font-bold text-4xl md:text-3xl  mt-4">{{ $article->title }}</h1>
    <div class="prose prose-sm sm:prose lg:prose-lg mt-6">
      {!! str_replace('\n', '<br/>', $article->content) !!}
    </div>
  </div>


  <!--Suggestion-->
  <div class="lg:container mt-8 mx-auto">
    <h2 class="text-4xl text-center mx-auto border-l-4 py-2 font-semibold border-b-4 w-[450px] border-red-500 mb-8">
      Recommended for You</h2>

    <div class="flex  flex-row flex-wrap mt-4">

      @foreach ($similler_articles as $art)
        <div
          class="flex-shrink max-w-full w-full sm:w-1/3 px-3 pb-3 pt-3 sm:pt-0 border-b-2 sm:border-b-0 border-dotted border-gray-100">
          <div class="flex flex-row sm:block hover-img">
            <a href="{{ route('article_show', $art->slug) }}">
              <img
                class="max-w-full w-full mx-auto aspect-[1.5] object-cover object-center hover:scale-105 hover:shadow-md border border-black border-opacity-0 hover:border-opacity-15 shadow transition-all duration-500"
                src="{{ $art->image_url() }}" alt="{{ $art->title }}">
            </a>
            <div class="py-0 sm:py-3 pl-3 sm:pl-0">
              <h3 class="text-lg font-bold leading-tight mb-2">
                <a href="{{ route('article_show', $art->slug) }}">{{ $art->title }}</a>
              </h3>
              <p class="hidden md:block text-gray-600 leading-tight mb-1">
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

  <!--onTwitter & comment-->
  <div class="flex container mx-auto mt-4 flex-col md:flex-row mb-12">

    <!-- Comment Section -->
    <div class="bg-white w-full md:w-3/4 p-4 shadow rounded-md">
      <div class="mt-6">
        <h2 class="text-xl font-semibold">Comments</h2>
        <div class="mt-4">
          @foreach ($comments as $comment)
            <div class="border-b pb-4 mb-4 flex items-start">
              <img src="{{ $comment->user->image_url() }}" alt="{{ $comment->user->name }}"
                class="rounded-full mr-4 w-14 object-cover h-full aspect-square">
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

                @if ($comment->replys?->count() > 0)
                  <!-- Replies -->
                  <div class="ml-6 mt-2 border-l pl-4">
                    @foreach ($comment->replys as $reply)
                      <div class="flex items-start">
                        <img src="{{ $reply->user->image_url() }}" alt="{{ $reply->user->name }}"
                          class="rounded-full mr-4 w-14 object-cover h-full aspect-square">
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
          {{-- <div class="border-b pb-4 mb-4 flex items-start">
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
          </div> --}}
        </div>

        <!-- Add New Comment -->
        <div class="mt-6">
          <h3 class="text-lg font-semibold">Add a Comment</h3>
          <form action="{{ route('article_comments', $article->id) }}" method="POST">
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li class="text-red-500">{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            @csrf
            <textarea name="comment" class="w-full border p-2 mt-2" rows="3" placeholder="Write your comment..."></textarea>
            @if (!auth()->check())
              <h3 class="text-gray-500 text-center mt-3">you are not signed in, please make an account to comment</h3>
              <div class="flex gap-4 md:flex-row flex-col mb-3">
                <input value="{{ old('email') }}" type="email" name="email" class="w-full border p-2 mt-2"
                  placeholder="email" />
                <input value="{{ old('name') }}" name="name" class="w-full border p-2 mt-2" placeholder="name" />
                <input value="{{ old('password') }}" name="password" type="password" class="w-full border p-2 mt-2"
                  placeholder="password" />
              </div>
            @endif
            <button class="bg-blue-500 text-white px-4 py-2 mt-2">Submit</button>
            @error('comment')
              <p class="text-reg-800">{{ $message }}</p>
            @enderror
          </form>
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
@endsection

@section('scripts')
  <script>
    const event = JSON.parse(`{!! json_encode([
        'title' => $article->event->title,
        'id' => $article->event->id,
        'shapes' => $article->event->shapes_json(),
    ]) !!}`);
  </script>
  @vite(['resources/js/single-article.js'])
@endsection
