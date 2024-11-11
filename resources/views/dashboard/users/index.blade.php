@extends('dashboard.layout')

@section('content')
  <div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
      <div class="d-block mb-4 mb-md-0">
        <x-breadcrumb page="users" :is-route="true" url="users_manage" />
        <h2 class="h4">{{ __('All Users') }}</h2>
        <p class="mb-0">{{ __('manage subscribed users from one place.') }}</p>
      </div>
      <div class="btn-toolbar mb-2 mb-md-0">
        {{-- <div class="btn-group me-2 me-lg-3">
          <button type="button" class="btn btn-sm btn-outline-gray-600">{{ __('Export') }}</button>
        </div> --}}
        <a href="{{ route('user_create') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
          <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          {{ __('New User') }}
        </a>
      </div>
    </div>
    <div class="table-settings mb-4">
      <div class="row align-items-center justify-content-between">
        <div class="col col-md-6 col-lg-3 col-xl-4">
          <div class="input-group me-2 me-lg-3 fmxw-400">
            <span class="input-group-text">
              <svg class="icon icon-xs" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                  clip-rule="evenodd"></path>
              </svg>
            </span>
            <input type="text" class="form-control" placeholder="{{ __('search :item', ['item' => __('users')]) }}">
          </div>
        </div>
        <div class="col-4 col-md-2 col-xl-1 ps-md-0 text-end">
          <div class="dropdown">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-1" data-bs-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                  clip-rule="evenodd"></path>
              </svg>
              <span class="visually-hidden">{{ __('Toggle Dropdown') }}</span>
            </button>
            <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end pb-0">
              <div class="small ps-3 pb-2 fw-bold text-dark">{{ __('show') }}</div>
              <a class="dropdown-item fw-bold">10</a>
              {{-- <a class="dropdown-item rounded-bottom" href="{{ route('dashboard_settings') }}">{{ __('change') }}</a> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive overflow-visible">
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="border-gray-200">{{ __('Image') }}</th>
            <th class="border-gray-200">{{ __('Name') }}</th>
            <th class="border-gray-200">{{ __('Email') }}</th>
            <th class="border-gray-200">{{ __('register date') }}</th>
            <th class="border-gray-200">{{ __('Action') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
            <!-- Item -->
            <tr class="fw-normal">
              <td class="p-1">
                <a href="{{ route('user_edit', $user->id) }}">
                  <img class="ms-3 rounded-1 profile-pick" width="60" src="{{ $user->image_url() }}"
                    alt="{{ __('user image') }}">
                </a>
              </td>
              <td>
                <a href="{{ route('user_edit', $user->id) }}">{{ $user->name }}</a>
              </td>
              <td>
                <a href="{{ route('user_edit', $user->id) }}">{{ $user->email }}</a>
              </td>
              <td>{{ $user->created_at }}</td>
              <td>
                <div class="btn-group">
                  <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 py-0 p-2"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="icon icon-sm">
                      <span class="fa fa-ellipsis-h icon-dark"></span>
                    </span>
                    <span class="visually-hidden">{{ __('Toggle Dropdown') }}</span>
                  </button>
                  <div class="dropdown-menu py-0">
                    <a class="dropdown-item" href="{{ route('user_edit', $user->id) }}">
                      <span class="fa me-1">
                        <svg class="me-2" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                          viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                          </path>
                        </svg>
                      </span>
                      {{ __('Edit') }}
                    </a>
                    <hr class="my-0">
                    <a class="dropdown-item text-danger rounded-bottom" href="#">
                      <span class="fa me-2">
                        <svg class="me-2" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                          viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                          </path>
                        </svg>
                      </span>
                      {{ __('Remove') }}
                    </a>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
        {!! $users->links() !!}

      </div>
    </div>
  </div>
@endsection
