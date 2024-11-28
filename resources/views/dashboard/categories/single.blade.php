@extends('dashboard.layout')

@section('meta')
  @php $page_title = config("app.name") . " | " . __('Edit Category') @endphp
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('styles')
  @vite('resources/css/dashboard/style.css')
@endsection

@section('content')
  <div class="container mt-4">
    <form method="POST"
      action="{{ isset($category->id) ? route('category_edit', $category->id) : route('category_create') }}">
      @csrf
      <div class="row">
        <div class="col-12 col-xl-7">
          <div class="card card-body border-0 shadow mb-4">
            <h2 class="h5 mb-4">{{ __('Category information') }}</h2>
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="ar-content" role="tabpanel" aria-labelledby="ar-content-tab">
                <div class="mb-3">
                  <label for="title">{{ __('Title') }}</label>
                  <input class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    type="text" value="{{ old('title') ?? (isset($category) ? $category->title : "") }}"
                    placeholder="{{ __('title of the category') }}">
                  @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="desc">{{ __('Description') }}</label>
                  <textarea class="form-control @error('description') is-invalid @enderror" id="desc" style="min-height: 80px;"
                    name="description" placeholder="{{ __('a brief description about the category') }}">{{ old('description') ?? (isset($category) ? $category->description : "") }}</textarea>
                  @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <!-- End of tab -->

            <button class="btn btn-gray-800 mt-2 animate-up-2" type="submit">{{ __('Save all') }}</button>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@section('jslibs')
  @if (Session::has('category-saved') && Session::get('category-saved'))
    <script src="{{ url('libs/dashboard/sweetalert2.all.min.js') }}"></script>
  @endif
@endsection

@section('scripts')
  <script>
    categoryImage.addEventListener("change", function(e) {
      const [file] = this.files
      if (file) {
        categoryImagePreview.src = URL.createObjectURL(file)
      }
    })
    @if (Session::has('category-saved') && Session::get('category-saved'))
      Swal.fire({
        title: "Category Saved Successfully",
        customClass: {
          confirmButton: 'btn btn-success me-4',
        },
        buttonsStyling: false,
        inputAttributes: {
          autocapitalize: "off"
        },
        showCancelButton: false,
        confirmButtonText: "ok",
        showLoaderOnConfirm: false,
      })
    @endif
  </script>
@endsection
