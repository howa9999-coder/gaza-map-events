@extends('dashboard.layout')

@section('meta')
  @php $page_title = config("app.name") . " | " . __('Edit Buycut') @endphp
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('styles')
  <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
  @vite('resources/css/dashboard.css')
  @vite('resources/css/editor.css')
@endsection

@section('content')
  <div class="container mt-4">
    <form id="form" method="POST"
      action="{{ isset($buycut->id) ? route('buycut_edit', $buycut->id) : route('buycut_create') }}">
      @csrf
      <div class="row">
        <div class="col-12 col-xl-7">
          <div class="card card-body border-0 shadow mb-4">
            <h2 class="h5 mb-4">{{ __('Buycut information') }}</h2>
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <div class="mb-3">
              <label for="title">{{ __('Title') }}</label>
              <input class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                type="text" value="{{ old('title') ?? (isset($buycut) ? $buycut->title : "") }}"
                placeholder="{{ __('title of the buycut') }}">
              @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="desc">{{ __('Reason') }}</label>
              <textarea class="form-control @error('reason') is-invalid @enderror" id="desc" style="min-height: 80px;"
                name="reason" placeholder="{{ __('the reason of buycut') }}">{{ old('reason') ?? isset($buycut) ? $buycut->reason : "" }}</textarea>
              @error('reason')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-4">
              <label for="cat">{{ __('Category') }}</label>
              <select class="form-select @error('category') is-invalid @enderror" id="cat" name="category">
                <option value="">{{ __('-- select a category --') }}</option>
                @foreach ($categories as $category)
                  <option @if (isset($buycut) && $category->id == $buycut->category_id) selected @endif value="{{ $category->id }}">
                    {{ $category->title }}</option>
                @endforeach
              </select>
              @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <hr>
            <button class="btn btn-gray-800 mt-2 animate-up-2" type="submit">{{ __('Save all') }}</button>
          </div>
        </div>
        <div class="col-12 col-xl-5">
          <div class="row">
            <div class="col-12 mb-4">
              <div class="card shadow border-0 text-center p-0">
                <div class="card-body pb-5">
                  <p class="lead mb-0 mt-2" style="font-size: 1rem;">{{ __('max file size 2MB') }}</p>
                  <img src="{{ isset($buycut) ? $buycut->logo_url() : "/images/image-placeholder.png" }}" id="buycutImagePreview"
                    class="rounded mx-auto m-0 buycut-thumbnail" alt="{{ __('Buycut Image') }}">
                  <p class="lead mb-0 mt-2" style="font-size: 1rem;">{{ __('recommended size is') }} <bdi>1200 x
                      628</bdi></p>
                  <hr>
                  <input type="file" class="d-none" name="image" id="buycutImage">
                  <button type="button" onclick="document.getElementById('buycutImage').click()"
                    class="btn btn-sm btn-warning d-inline-flex mx-3 align-items-center">
                    <svg style="width: 22px" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                      viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z">
                      </path>
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="row">
            <div class="col-12">
              <div class="card card-body border-0 shadow">
                <div class="d-flex justify-content-between align-items-center">
                  <h2 class="h4 m-0">{{ __('Buycut Content') }}</h2>
                </div>
                <hr class="my-3">
                <input id="buycutContent" type="hidden" name="details"
                  value="{{ old('details') ?? (isset($buycut) ? $buycut->details : '') }}">
                <trix-editor class="article-content" input="buycutContent"></trix-editor>
                <button class="w-content btn btn-gray-800 mt-4 ms-auto w-fit px-5 animate-up-1"
                  type="submit">{{ __('Save all') }}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@section('scripts')
  @if (Session::has('buycut-saved') && Session::get('buycut-saved'))
    <script src="{{ url('libs/sweetalert2.all.min.js') }}"></script>
  @endif
  <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
  <script>
    buycutImage.addEventListener("change", function(e) {
      const [file] = this.files
      if (file) {
        buycutImagePreview.src = URL.createObjectURL(file)
      }
    })

    var HOST = "{{ route('buycut_attachment') }}"

    addEventListener("trix-attachment-add", function(event) {
      if (event.attachment.file) {
        uploadFileAttachment(event.attachment)
      }
    })

    function uploadFileAttachment(attachment) {
      uploadFile(attachment.file, setProgress, setAttributes)

      function setProgress(progress) {
        attachment.setUploadProgress(progress)
      }

      function setAttributes(attributes) {
        attachment.setAttributes(attributes)
      }
    }

    function uploadFile(file, progressCallback, successCallback) {
      var key = createStorageKey(file)
      var formData = createFormData(key, file)
      var xhr = new XMLHttpRequest()

      xhr.open("POST", HOST, true)
      xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'))

      xhr.upload.addEventListener("progress", function(event) {
        var progress = event.loaded / event.total * 100
        progressCallback(progress)
      })

      xhr.addEventListener("load", function(event) {
        if (xhr.status == 200) {
          var attributes = {
            url: xhr.response,
            href: xhr.response + "?content-disposition=attachment"
          }
          successCallback(attributes)
        }
      })

      xhr.send(formData)
    }

    function createStorageKey(file) {
      var date = new Date()
      var day = date.toISOString().slice(0, 10)
      var name = date.getTime() + "-" + file.name
      return ["tmp", day, name].join("/")
    }

    function createFormData(key, file) {
      var data = new FormData()
      data.append("key", key)
      data.append("Content-Type", file.type)
      data.append("file", file)
      return data
    }

    @if (Session::has('buycut-saved') && Session::get('buycut-saved'))
      Swal.fire({
        title: "Buycut Saved Successfully",
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
