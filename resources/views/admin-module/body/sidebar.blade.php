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
                    <br>
                    <span class="text-muted">Branch: <b>{{ Auth::user()->branch->address ?? 'N/A' }}</b></span>

            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                {{-- Admin Dashboard --}}
                <li>
                    <a href="{{ route('admin.home') }}" class="waves-effect">
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
                @if(Auth::user()->role == 'admin')
                {{-- Admin Controls Menu --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-bar-chart-line"></i>
                        <span>Admin Controls</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- <li><a href="{{url('client_registration')}}">Clinet Registration</a></li> --}}
                        <li> <a href="{{ route('add_services') }}">Services</a></li>
                        <li><a href="{{ route('new.status') }}">Status</a></li>
                        <li><a href="{{ route('branch_register') }}">Branches</a></li>
                        <li><a href="{{ route('emp.register') }}">Employee Reg.</a></li>
                        <li><a href="{{ url('bookmarks') }}">Bookmark</a></li>
                        <li> <a href="{{route('add.document')}}">Add Documents</a></li>
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


                <li>
                    <a href="{{ route('data.migration') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Migration</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('marketing.dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Marketing</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('doc.advisor') }}">
                        <i class=" ri-profile-line"></i>
                        <span>Doc Advisor</span>
                    </a>
                </li>
                {{-- <li class="menu-title">Report</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Clients</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#">New Clients</a></li>
                        <li><a href="#">Old Clients</a></li>
                        <li><a href="#">Repeated Clients</a></li>
                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>Applications</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#">Aadhar</a></li>

                    </ul>
                </li> --}}

                {{-- <li class="menu-title">Components</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-pencil-ruler-2-line"></i>
                        <span>Home Layout Setup</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('home_slide')}}">Home Slide</a></li>


                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-vip-crown-2-line"></i>
                        <span>Advanced UI</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="advance-rangeslider.html">Range Slider</a></li>
                        <li><a href="advance-roundslider.html">Round Slider</a></li>
                        <li><a href="advance-session-timeout.html">Session Timeout</a></li>
                        <li><a href="advance-sweet-alert.html">Sweetalert 2</a></li>
                        <li><a href="advance-rating.html">Rating</a></li>
                        <li><a href="advance-notifications.html">Notifications</a></li>
                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="ri-eraser-fill"></i>
                        <span class="badge rounded-pill bg-danger float-end">8</span>
                        <span>Forms</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="form-elements.html">Form Elements</a></li>
                        <li><a href="form-validation.html">Form Validation</a></li>
                        <li><a href="form-advanced.html">Form Advanced Plugins</a></li>
                        <li><a href="form-editors.html">Form Editors</a></li>
                        <li><a href="form-uploads.html">Form File Upload</a></li>
                        <li><a href="form-xeditable.html">Form X-editable</a></li>
                        <li><a href="form-wizard.html">Form Wizard</a></li>
                        <li><a href="form-mask.html">Form Mask</a></li>
                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-table-2"></i>
                        <span>Tables</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="tables-basic.html">Basic Tables</a></li>
                        <li><a href="tables-datatable.html">Data Tables</a></li>
                        <li><a href="tables-responsive.html">Responsive Table</a></li>
                        <li><a href="tables-editable.html">Editable Table</a></li>
                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-bar-chart-line"></i>
                        <span>Charts</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="charts-apex.html">Apex Charts</a></li>
                        <li><a href="charts-chartjs.html">Chartjs Charts</a></li>
                        <li><a href="charts-flot.html">Flot Charts</a></li>
                        <li><a href="charts-knob.html">Jquery Knob Charts</a></li>
                        <li><a href="charts-sparkline.html">Sparkline Charts</a></li>
                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-brush-line"></i>
                        <span>Icons</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="icons-remix.html">Remix Icons</a></li>
                        <li><a href="icons-materialdesign.html">Material Design</a></li>
                        <li><a href="icons-dripicons.html">Dripicons</a></li>
                        <li><a href="icons-fontawesome.html">Font awesome 5</a></li>
                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-map-pin-line"></i>
                        <span>Maps</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="maps-google.html">Google Maps</a></li>
                        <li><a href="maps-vector.html">Vector Maps</a></li>
                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-share-line"></i>
                        <span>Multi Level</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="javascript: void(0);">Level 1.1</a></li>
                        <li><a href="javascript: void(0);" class="has-arrow">Level 1.2</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);">Level 2.1</a></li>
                                <li><a href="javascript: void(0);">Level 2.2</a></li>
                            </ul>
                        </li>
                    </ul>
                </li> --}}

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
