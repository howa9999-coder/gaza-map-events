@extends('layout')

{{-- @section('styles')
@endsection --}}

@section('content')
  <!--Map-->
  <div class="w-full h-[500px] md:h-[calc(100vh-80px)] flex flex-col relative">
    <div
      class="bg-black flex items-center justify-center opacity-65 transition-opacity duration-700 absolute inset-0 w-full h-full z-10">
    </div>
    <div class="inset-0 object-cover opacity-90 grow overflow-hidden">
      <img src="{{ $buycut->main_image() }}" class="w-full h-full object-cover object-center" alt="buycut product image">
    </div>
    <div class="bg-red-700 h-20 w-full flex items-center justify-between px-8 relative z-20">
    </div>
  </div>

  <div class="max-w-4xl rounded-lg shadow-lg mx-auto py-12 px-12 lg:-mt-44 lg:px-24 relative z-30 bg-white">
    <h2 class="mt-4 uppercase tracking-widest text-xs text-gray-600">{{ $buycut->created_at->format('Y D i') }}</h2>
    <h1 class="font-bold text-4xl md:text-3xl  mt-4">{{ $buycut->title }}</h1>
    <div class="prose prose-sm sm:prose lg:prose-lg mt-6">
      {!! str_replace('\n', '<br/>', $buycut->reason) !!}
    </div>
  </div>


  <div class="md:max-w-7xl rounded-lg shadow-lg mx-auto py-12 px-12 lg:mt-14 lg:px-24 relative z-30 bg-white">
    {!! str_replace('\n', '<br/>', $buycut->details) !!}
  </div>

  @if ($buycut->has_video())
    <div class="md:max-w-7xl rounded-lg shadow-lg mx-auto py-12 px-12 lg:mt-14 lg:px-24 relative z-30 bg-white">
      {!! $buycut->show_video() !!}
    </div>
  @endif


  <!--onTwitter & comment-->
  <div class="flex container mx-auto mt-4 flex-col md:flex-row mb-12">

    <!--on twitter-->
    <div class="bg-gray text-white w-full md:w-1/4 p-4">
      <a class="twitter-timeline" href="https://twitter.com/YourUsername?ref_src=twsrc%5Etfw">Tweets by
        YourUsername</a>
      <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>

  </div>
@endsection
