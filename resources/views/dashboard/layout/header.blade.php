<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
  <a class="navbar-brand" href="#">
    <img class="navbar-brand-dark" src="{{ url('images/brand/logo.png') }}" alt="{{ __('logo') }}" />
    <img class="navbar-brand-light" src="{{ url('images/brand/logo.png') }}" alt="{{ __('logo') }}" />
  </a>
  <div class="d-flex align-items-center">
    <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
  <div class="sidebar-inner px-4 pt-3">
    <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
      <div class="d-flex align-items-center">
        <div class="avatar-lg me-4">
          <img src="{{ auth()->user()?->image_url() }}" class="card-img-top rounded-circle border-white"
            alt="{{ __('Bonnie Green') }}">
        </div>
        <div class="d-block">
          <h2 class="h5 mb-3">Hi, {{ auth()->user()?->name }}</h2>
          <a href="{{ route('logout') }}" tabindex="-1"
            class="btn btn-secondary btn-sm d-inline-flex align-items-center">
            <svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
              </path>
            </svg>
            {{ __('Logout') }}
          </a>
        </div>
      </div>
      <div class="collapse-close d-md-none">
        <a href="{{ __('sidebarMenu') }}" data-bs-toggle="collapse" data-bs-target="{{ __('sidebarMenu') }}"
          aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
          <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </a>
      </div>
    </div>
    <ul class="nav flex-column pt-3 pt-md-0">
      <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center">
          <span class="sidebar-icon">
            <img src="{{ url('images/brand/logo.png') }}" alt="{{ __('logo') }}">
          </span>
          <span class="mt-1 ms-1 sidebar-text">{{ __('Dashboard') }}</span>
        </a>
      </li>

      <li class="nav-item {{ \Request::route()->getName() == 'dashboard' ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="nav-link">
          <span class="sidebar-icon">
            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
              <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
            </svg>
          </span>
          <span class="sidebar-text">{{ __('Dashboard') }}</span>
        </a>
      </li>

      <li class="nav-item {{ \Request::route()->getName() == 'users_manage' ? 'active' : '' }}">
        <a href="{{ route('users_manage') }}" class="nav-link">
          <span class="sidebar-icon">
            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="20.000000pt" height="20.000000pt"
              viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet"
              style="padding-right: 6px;padding-left: 2px;box-sizing: border-box;">
              <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="currentColor"
                stroke="none">
                <path
                  d="M1110 4694 c-84 -17 -229 -90 -305 -151 -162 -131 -260 -325 -272 -538 -8 -139 13 -239 79 -375 44 -91 62 -115 142 -195 76 -76 106 -99 186 -138 121 -59 207 -80 335 -80 136 0 262 31 361 88 39 23 42 28 64 112 44 170 156 357 277 460 l56 48 -6 90 c-14 205 -113 399 -272 528 -77 63 -220 133 -310 152 -87 18 -249 18 -335 -1z" />
                <path
                  d="M3670 4695 c-85 -19 -229 -91 -305 -152 -150 -122 -251 -310 -271 -508 l-6 -61 43 -29 c191 -125 352 -384 384 -612 6 -48 9 -52 48 -67 93 -35 173 -49 277 -49 133 0 217 20 340 80 80 39 110 62 186 138 80 80 98 104 142 195 66 136 87 236 79 375 -18 318 -228 583 -538 680 -75 24 -292 30 -379 10z" />
                <path
                  d="M2473 3930 c-184 -33 -357 -138 -468 -285 -63 -84 -95 -145 -127 -245 -19 -64 -23 -96 -23 -215 0 -154 14 -213 77 -338 214 -424 782 -541 1144 -235 277 234 350 610 181 933 -31 60 -65 103 -132 170 -101 101 -196 158 -325 195 -86 24 -247 34 -327 20z" />
                <path
                  d="M769 3140 c-379 -80 -671 -375 -749 -757 -19 -95 -20 -131 -18 -539 l3 -437 150 -43 c168 -49 419 -105 570 -129 100 -16 351 -45 391 -45 21 0 22 4 27 208 4 181 8 220 31 307 50 191 172 400 313 537 110 107 298 222 421 259 23 7 42 15 42 19 0 3 -14 19 -31 36 -119 113 -225 346 -245 540 l-7 64 -406 -1 c-352 0 -417 -3 -492 -19z" />
                <path
                  d="M3526 3138 c-3 -13 -8 -48 -11 -78 -17 -151 -95 -330 -201 -461 -36 -45 -64 -82 -62 -84 2 -1 29 -12 60 -23 268 -99 492 -301 623 -562 87 -174 113 -293 122 -557 6 -189 6 -193 27 -188 12 2 66 7 121 10 294 19 631 96 838 192 l77 36 0 430 c0 393 -2 437 -21 530 -77 385 -370 679 -753 758 -79 16 -138 19 -453 19 l-363 0 -4 -22z" />
                <path
                  d="M2177 2379 c-242 -25 -480 -153 -636 -341 -73 -87 -163 -261 -193 -373 -21 -76 -22 -103 -26 -556 l-3 -476 123 -36 c262 -77 483 -124 728 -157 199 -27 637 -38 814 -21 331 33 616 100 814 192 l84 39 -5 452 c-5 504 -8 529 -74 688 -140 333 -440 553 -802 590 -119 12 -709 11 -824 -1z" />
              </g>
            </svg>
          </span>
          <span class="sidebar-text">{{ __('Users') }}</span>
        </a>
      </li>

      <li class="nav-item {{ \Request::route()->getName() == 'articles_manage' ? 'active' : '' }}">
        <a href="{{ route('articles_manage') }}" class="nav-link">
          <span class="sidebar-icon">
            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="20.000000pt" height="20.000000pt"
              viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet"
              style="padding-right: 6px;padding-left: 2px;box-sizing: border-box;">
              <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="currentColor"
                stroke="none">
                <path
                  d="M1110 4694 c-84 -17 -229 -90 -305 -151 -162 -131 -260 -325 -272 -538 -8 -139 13 -239 79 -375 44 -91 62 -115 142 -195 76 -76 106 -99 186 -138 121 -59 207 -80 335 -80 136 0 262 31 361 88 39 23 42 28 64 112 44 170 156 357 277 460 l56 48 -6 90 c-14 205 -113 399 -272 528 -77 63 -220 133 -310 152 -87 18 -249 18 -335 -1z" />
                <path
                  d="M3670 4695 c-85 -19 -229 -91 -305 -152 -150 -122 -251 -310 -271 -508 l-6 -61 43 -29 c191 -125 352 -384 384 -612 6 -48 9 -52 48 -67 93 -35 173 -49 277 -49 133 0 217 20 340 80 80 39 110 62 186 138 80 80 98 104 142 195 66 136 87 236 79 375 -18 318 -228 583 -538 680 -75 24 -292 30 -379 10z" />
                <path
                  d="M2473 3930 c-184 -33 -357 -138 -468 -285 -63 -84 -95 -145 -127 -245 -19 -64 -23 -96 -23 -215 0 -154 14 -213 77 -338 214 -424 782 -541 1144 -235 277 234 350 610 181 933 -31 60 -65 103 -132 170 -101 101 -196 158 -325 195 -86 24 -247 34 -327 20z" />
                <path
                  d="M769 3140 c-379 -80 -671 -375 -749 -757 -19 -95 -20 -131 -18 -539 l3 -437 150 -43 c168 -49 419 -105 570 -129 100 -16 351 -45 391 -45 21 0 22 4 27 208 4 181 8 220 31 307 50 191 172 400 313 537 110 107 298 222 421 259 23 7 42 15 42 19 0 3 -14 19 -31 36 -119 113 -225 346 -245 540 l-7 64 -406 -1 c-352 0 -417 -3 -492 -19z" />
                <path
                  d="M3526 3138 c-3 -13 -8 -48 -11 -78 -17 -151 -95 -330 -201 -461 -36 -45 -64 -82 -62 -84 2 -1 29 -12 60 -23 268 -99 492 -301 623 -562 87 -174 113 -293 122 -557 6 -189 6 -193 27 -188 12 2 66 7 121 10 294 19 631 96 838 192 l77 36 0 430 c0 393 -2 437 -21 530 -77 385 -370 679 -753 758 -79 16 -138 19 -453 19 l-363 0 -4 -22z" />
                <path
                  d="M2177 2379 c-242 -25 -480 -153 -636 -341 -73 -87 -163 -261 -193 -373 -21 -76 -22 -103 -26 -556 l-3 -476 123 -36 c262 -77 483 -124 728 -157 199 -27 637 -38 814 -21 331 33 616 100 814 192 l84 39 -5 452 c-5 504 -8 529 -74 688 -140 333 -440 553 -802 590 -119 12 -709 11 -824 -1z" />
              </g>
            </svg>
          </span>
          <span class="sidebar-text">{{ __('Articles') }}</span>
        </a>
      </li>

      <li class="nav-item {{ request()->segment(3) == 'settings' ? 'active' : '' }}">
        <a href="" class="nav-link">
          <span class="sidebar-icon">
            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                clip-rule="evenodd"></path>
            </svg>
          </span>
          <span class="sidebar-text">{{ __('Settings') }}</span>
        </a>
      </li>

      <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
      <li class="nav-item">
        <a href="https://t.me/salahbakhash" target="_blank" class="nav-link d-flex align-items-center">
          <span class="sidebar-icon">
            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                clip-rule="evenodd"></path>
            </svg>
          </span>
          <span class="sidebar-text">{{ __('Want Help') }} <span
              class="badge badge-sm bg-secondary ms-1 text-gray-800">{{ __('call me') }}</span></span>
        </a>
      </li>
    </ul>
  </div>
</nav>
