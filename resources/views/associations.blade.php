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
            <input type="text" placeholder="Search..." id="searchAssociation"
              class="border rounded p-2 w-full lg:w-64" />
            <select id="categoryAssociationSelect" class="border rounded p-2 w-full lg:w-auto">
              <option value="All">All categories</option>
            </select>
          </div>
        </div>
      </div>
      <!-- Cards -->
      <div class="my-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="associationsCards">
      </div>
    </div>
  </main>
@endsection

@section('scripts')
  @vite(['resources/js/menu.js', 'resources/js/navigation.js'])

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
@endsection
