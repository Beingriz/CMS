<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="">
                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt=""
                    class="avatar-md rounded-circle">
            </div>
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">{{ Auth::user()->name }}</h4>
                <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i>
                    Online | <b class="text-danger" >{{ ucwords(Auth::user()->role) }}</b></span>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                {{-- Admin Dashboard --}}
                <li>
                    <a href="{{ route('branch_dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Home</span>
                    </a>
                </li>
                {{-- Application Dashboard --}}
                <li>
                    <a href="{{ route('Dashboard') }}">
                        <i class=" ri-profile-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{-- Application Menu --}}
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i><span
                            class="badge rounded-pill bg-primary float-end font-size-11">2</span>
                        <span>New App</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('new.application') }}">New Application</a></li>
                        <li> <a href="{{ route('update_application') }}">Update</a></li>


                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-layout-3-line"></i>
                        <span>Ledger</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">Credit Book</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ route('Credit') }}">New Entry</a></li>
                                <li><a href="{{ route('CreditSource') }}">Add Category</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">Debit Book</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ route('Debit') }}">New Entry</a></li>
                                <li><a href="{{ route('DebitSource') }}">Add Category</a></li>
                                <li><a href="#">Report</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                {{-- User Control Menu --}}
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="ri-home-3-line"></i>
                        <span>User Controls</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('user_top_bar') }}">Header & Footer</a></li>
                        <li> <a href="{{ route('new.carousel') }}">Carousel</a></li>
                        <li> <a href="{{ route('new.about_us') }}">About Us</a></li>
                    </ul>
                </li>


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
