@extends('dashboard.layout')

@section('meta')
  @php $page_title = config("app.name") . " | " . __('Edit Category') @endphp
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('styles')
  @vite('resources/css/dashboard.css')
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
                <div class="mb-4">
                  <label for="desc">{{ __('Description') }}</label>
                  <textarea class="form-control @error('description') is-invalid @enderror" id="desc" style="min-height: 80px;"
                    name="description" placeholder="{{ __('a brief description about the category') }}">{{ old('description') ?? (isset($category) ? $category->description : "") }}</textarea>
                  @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-4">
                  <div class="form-group">
                    <fieldset>
                      <legend class="h6 mb-3">{{ __('Category Type') }}</legend>
                      <div class="d-flex gap-4">
                        <input class="d-none" type="radio" name="status" id="private"
                          @if (isset($category) && $category->is_buycut_category == 0) checked @endif value="0">
                        <button type="button" data-target="private"
                          class="btn btn-primary @if (isset($category) && $category->is_buycut_category == 0) active @endif status-buttons">
                          <div calss="text-white" style="width: 22px">
                            <svg class="w-22px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                              <path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z"/>
                            </svg>
                          </div>
                        </button>
                        <input class="d-none" type="radio" name="status" id="unlisted"
                          @if (isset($category) && $category->is_buycut_category == 1) checked @endif value="1">
                        <button type="button" data-target="unlisted"
                          class="btn btn-warning @if (isset($category) && $category->is_buycut_category == 1) active @endif status-buttons">
                          <div calss="text-white" style="width: 22px">
                            <svg strok="currentColor" data-slot="icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                              <path d="M96 96c0-35.3 28.7-64 64-64l288 0c35.3 0 64 28.7 64 64l0 320c0 35.3-28.7 64-64 64L80 480c-44.2 0-80-35.8-80-80L0 128c0-17.7 14.3-32 32-32s32 14.3 32 32l0 272c0 8.8 7.2 16 16 16s16-7.2 16-16L96 96zm64 24l0 80c0 13.3 10.7 24 24 24l112 0c13.3 0 24-10.7 24-24l0-80c0-13.3-10.7-24-24-24L184 96c-13.3 0-24 10.7-24 24zm208-8c0 8.8 7.2 16 16 16l48 0c8.8 0 16-7.2 16-16s-7.2-16-16-16l-48 0c-8.8 0-16 7.2-16 16zm0 96c0 8.8 7.2 16 16 16l48 0c8.8 0 16-7.2 16-16s-7.2-16-16-16l-48 0c-8.8 0-16 7.2-16 16zM160 304c0 8.8 7.2 16 16 16l256 0c8.8 0 16-7.2 16-16s-7.2-16-16-16l-256 0c-8.8 0-16 7.2-16 16zm0 96c0 8.8 7.2 16 16 16l256 0c8.8 0 16-7.2 16-16s-7.2-16-16-16l-256 0c-8.8 0-16 7.2-16 16z"/>
                            </svg>
                          </div>
                        </button>
                      </div>
                    </fieldset>
                    @error('status')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
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
    <script src="{{ url('libs/sweetalert2.all.min.js') }}"></script>
  @endif
@endsection

@section('scripts')
  <script>
    let btns = document.querySelectorAll('.status-buttons');
    btns.forEach(el => {
      el.addEventListener("click", function () {
        btns.forEach(btn => btn.classList.remove("active"));
        this.classList.add("active");
        document.getElementById(el.dataset.target).setAttribute("checked", true);
      });
    });
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
