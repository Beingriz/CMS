<header id="page-topbar">
    <div class="navbar-header" margin-bottom = "-40px">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('admin.home') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('logo/dclogo.png') }}" alt="logo-sm" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('logo/dclogo.png') }}" alt="logo-dark" height="20">
                    </span>
                </a>

                <a href="{{ route('admin.home') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('logo/dclogo.png') }}" alt="logo-sm-light" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('logo/dclogo.png') }}" alt="logo-light" height="70" width="90">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

            <!-- App Search-->

            @livewire('admin-module.application.global-search-bar')
            @livewire('admin-module.operations.header-bookmarks')



        </div>

        <div class="d-flex">

            {{-- Full Screen Button Start --}}
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>
            {{-- Full Screen Button End --}}

            @livewire('admin-module.operations.header-notification')


            {{-- Profile Button Start --}}
            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (Auth::check())
                        <img class="rounded-circle header-profile-user"
                            src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->name }}</span>
                    @endif


                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('admin.profile_view') }}"><i
                            class="ri-user-line align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item" href="{{ route('change_password') }}"><i
                            class="ri-wallet-2-line align-middle me-1"></i> Change Password</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}" id="logout"><i
                            class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                </div>
            </div>
            {{-- Profile Button End --}}
        </div>
    </div>
</header>
