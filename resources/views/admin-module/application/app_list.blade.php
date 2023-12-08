@extends('Layouts.main')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
    </head>

    <body>
        <div class="container-fluid top">
            <section class="work-area">
                <div class="sub-nav-menu">
                    <ul>
                        <li><a href="{{ url('') }}">Dashboard</a></li><span class="span">|</span>
                    </ul>
                </div>
                <div class="pages">
                    <div class="layout">
                        <!-- Left Menu Section -->
                        <div class="left-menu">
                            <div class="left-menu-section">
                                <div class="left-menu-sec-heading">
                                    <img src="\digital/cyber/photo_gallery\home-menu.jpg" alt="heading-icon">
                                    <p>Main Menu</p>
                                </div>
                                <div class="left-menu-link">
                                    <a href="{{ url('app_home') }}">Home</a>
                                    <a href="{{ url('app_form') }}">New Application</a>
                                    <a href="">Update</a>
                                    <a href="">Search</a>
                                    <a href="">Status</a>
                                </div>
                            </div>
                            <div class="left-menu-section">
                                <div class="left-menu-sec-heading">
                                    <img src="\digital/cyber/photo_gallery\sub-menu.jpg" alt="heading-icon">
                                    <p>Sub Menu</p>
                                </div>
                                <div class="left-menu-link">
                                    <a href="">Reports</a>
                                    <a href="">Filter</a>
                                </div>
                            </div>

                        </div>
                        <!-- Middle Container Section -->
                        <div class="middle-container">

                            <!-- Table List Code  -->
                            <div class="table-container">
                                <div class="data-table-header">
                                    <!-- <img src=" img/income.png" alt="Application_image" class="header-image"> -->
                                    <p class="heading">{{ $service }} Applications</p>
                                </div>
                                <div class="table-information">
                                    <span class="info-text">Total {{ $service }} Applications as on
                                        {{ date('d-m-Y') }}</span>
                                    <br><span>Total Revenue of &#x20B9; {{ $total_revenue }} Generated</span>
                                    <br><span class="info-text">Applications Found {{ $sl_no }}</span>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="">Select Service</label>
                                        </div>
                                        <div class="col-25">
                                            <select class="form-control" id="Application_Type" name="Application_Type"
                                                onchange="SelectService(value)">
                                                <option value="">---Select---</option>
                                                @foreach ($application_type as $app_type)
                                                    <option value="{{ $app_type->Service_Name }}">
                                                        {{ $app_type->Service_Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                @if (session('Error'))
                                    <span class="error">{{ session('Error') }}</span>
                                @endif
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Sl.No</th>
                                            <th>Name</th>
                                            <th>Mobile No</th>
                                            <th>Status</th>
                                            <th>Ack. No</th>
                                            <th>Total</th>
                                            <th>Paid</th>
                                            <th>Balance &#x20B9;</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($app_list as $data)
                                            <tr>
                                                <td class="show">
                                                    {{ $n++ }}
                                                </td>
                                                <td class="show">{{ $data->Name }}</td>
                                                <td class="show">{{ $data->Mobile_No }}</td>
                                                <td class="show">{{ $data->Status }}</td>
                                                <td class="show">{{ $data->Ack_No }}</td>
                                                <td class="show">{{ $data->Total_Amount }}</td>
                                                <td class="show">{{ $data->Amount_Paid }}</td>
                                                <td class="show">{{ $data->Balance }}</td>
                                                <td class="show">
                                                    <div class="btn-group" role="group"
                                                        aria-label="Button group with nested dropdown">
                                                        <div class="btn-group btn-group-sm " role="group">
                                                            <button id="btnGroupDrop1" type="button"
                                                                class="btn btn-info dropdown-toggle"
                                                                data-mdb-toggle="dropdown" aria-expanded="false">
                                                                Edit
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                <li><a class="dropdown-item "
                                                                        href='/digital/cyber/open_app/{{ $data->Id }}'>Open</a>
                                                                </li>


                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <span>
                                    {{ $app_list->links() }}
                                </span>
                            </div>
                        </div>
                        <div class="right-menu">
                            <p class="heading">Insight</p>
                            <div class="right-menu-section">
                                <img src="\digital/cyber/photo_gallery\insight.jpg" alt="">
                                <div class="sec-data">
                                    <p class="section-heading">Applications Served</p>
                                    <p class="section-value">Total {{ $applications_served }}</p>
                                    <p class="section-pre-values">Yesterday {{ $previous_day_app }}</p>
                                </div>
                            </div>
                            <div class="right-menu-section">
                                <img src="\digital/cyber/photo_gallery\insight.jpg" alt="">
                                <div class="sec-data">
                                    <p class="section-heading">Applications Deliverd</p>
                                    <p class="section-value">Delivered : {{ $applications_delivered }}</p>
                                    <p class="section-pre-values">Yesterday {{ $previous_day_app_delivered }}</p>
                                </div>
                            </div>
                            <div class="right-menu-section">
                                <img src="\digital/cyber/photo_gallery\insight.jpg" alt="">
                                <div class="sec-data">
                                    <p class="section-heading">Revenue Generated</p>
                                    <p class="section-value">Gross &#x20B9; {{ $total_revenue }}/-</p>
                                    <p class="section-pre-values">Yesterday &#x20B9; <span>{{ $previous_revenue }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="right-menu-section">
                                <img src="\digital/cyber/photo_gallery\insight.jpg" alt="">
                                <div class="sec-data">
                                    <p class="section-heading">Balance Due Amount</p>
                                    <a class="section-value" href="{{ url('balance_list') }}">Gross Bal: &#x20B9;
                                        {{ $balance_due }}/-</a>
                                    <a class="section-pre-values" href="#">Yesterday &#x20B9;
                                        <span>{{ $previous_bal }}</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
    </body>
    <script>
        function SelectService($value) {
            document.location.href = "/digital/cyber/app_list/" + $value;
        }
    </script>

    </html>
@endsection
