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
                        <div class="left-menu">
                            <div class="left-menu-section">
                                <div class="left-menu-sec-heading">
                                    <img src="../cyber\product_images\Pan card .png" alt="heading-icon">
                                    <p>Main Menu</p>
                                </div>
                                <div class="left-menu-link">
                                    <a href="">Aadhar Card</a>
                                    <a href="">Aadhar Card</a>
                                    <a href="">Aadhar Card</a>
                                    <a href="">Aadhar Card</a>
                                </div>
                            </div>
                            <div class="left-menu-section">
                                <div class="left-menu-sec-heading">
                                    <img src="../cyber\product_images\Pan card .png" alt="heading-icon">
                                    <p>Sub Menu</p>
                                </div>
                                <div class="left-menu-link">
                                    <a href="">Pan Card</a>
                                    <a href="">Pan Card</a>
                                    <a href="">Pan Card</a>
                                    <a href="">Pan Card</a>
                                </div>
                            </div>
                            <div class="left-menu-section">
                                <div class="left-menu-sec-heading">
                                    <img src="../cyber\product_images\Pan card .png" alt="heading-icon">
                                    <p>Search Menu</p>
                                </div>
                                <div class="left-menu-link">
                                    <a href="">Voter Card</a>
                                    <a href="">Voter Card</a>
                                    <a href="">Voter Card</a>
                                    <a href="">Voter Card</a>
                                </div>
                            </div>
                        </div>
                        <div class="middle-container">
                            <div class="form-container">
                                <div class="form-header">
                                    <!-- <img src="img/income.png" alt="Application_image" class="header-image"> -->
                                    <p class="heading">Service Application Form</p>
                                </div>
                                <div class="form-data-container">
                                    <div class="form-data">
                                        <div class="row">
                                            <div class="col-45">
                                                <label for="">Customer Id</label>
                                            </div>
                                            <div class="col-55">
                                                <input type="text" id="date" name="Select_Date" class="form-control"
                                                    onchange="Selected_date_List(value)
                                                " />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-45">
                                                <label class="label" for="">Customer Id</label>
                                            </div>
                                            <div class="col-55">
                                                <input type="text" id="date" name="Select_Date" class="form-control"
                                                    onchange="Selected_date_List(value)
                                                " />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-45">
                                                <label class="label" for="">Customer Id</label>
                                            </div>
                                            <div class="col-55">
                                                <input type="text" id="date" name="Select_Date" class="form-control"
                                                    onchange="Selected_date_List(value)
                                                " />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-45">
                                                <label class="label" for="">Customer Id</label>
                                            </div>
                                            <div class="col-55">
                                                <input type="date" id="date" name="Select_Date" class="form-control"
                                                    onchange="Selected_date_List(value)
                                                " />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-data">
                                        <div class="row">
                                            <div class="col-45">
                                                <label class="label" for="">Customer Id</label>
                                            </div>
                                            <div class="col-55">
                                                <input type="text" id="date" name="Select_Date" class="form-control"
                                                    onchange="Selected_date_List(value)
                                                " />
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Form Place -->
                            </div>
                            <!-- Table List Code  -->
                            <div class="table-container">
                                <div class="data-table-header">
                                    <!-- <img src=" img/income.png" alt="Application_image" class="header-image"> -->
                                    <p class="heading">Application List</p>
                                </div>
                                <div class="table-information">
                                    <span class="info-text">Applications as on {{ date('d-m-Y') }} is
                                        &#x20B9; </span>
                                    <div class="row">
                                        <div class="col-45">
                                            <a href="{{ url('previous') }}" class="btn-sm btn-info ">Previous Day</a>
                                        </div>
                                        <div class="col-25">
                                            <input type="date" id="date" name="Select_Date" class="form-control"
                                                onchange="Selected_date_List(value)
                                                " />
                                        </div>
                                    </div>
                                </div>

                                <br>
                                @if (session('Error'))
                                    <span class="error">{{ session('Error') }}</span>
                                @endif
                                <!-- Table Place -->
                                <span>

                                </span>
                            </div>
                        </div>
                        <div class="right-menu">
                            <div class="right-menu-section">
                                <div class="right-menu-sec-heading">
                                    <p>Budget</p>
                                </div>
                                <div class="right-menu-sec-data">
                                    <p>Values</p>
                                </div>


                            </div>
                        </div>`
                    </div>
                </div>
            </section>
        </div>

    </body>
    <script>
        function Selected_date_List($date) {
            document.location.href = "/digital/cyber/selected_date_app/" + $date;
        }
    </script>

    </html>
@endsection
