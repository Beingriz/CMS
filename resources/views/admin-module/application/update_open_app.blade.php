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
                            <div class="form-container">
                                <div class="form-header">
                                    <!-- <img src="img/income.png" alt="Application_image" class="header-image"> -->
                                    <p class="heading">Edit Service Application Form</p>
                                </div>
                                <div class="form-data-container">
                                    <div class="form-data">
                                        @if (session('SuccessUpdate'))
                                            <span class="success">{{ session('SuccessUpdate') }}</span>
                                        @endif
                                        @if (session('SuccessMsg'))
                                            <span class="success">{{ session('SuccessMsg') }}</span>
                                        @endif
                                        @if (session('RecycleMsg'))
                                            <span class="success">{{ session('RecycleMsg') }}</span>
                                            <span><a class="btn-sm- btn-rounded btn-primary"
                                                    href="{{ url('view_recycle_bin') }}">Goto
                                                    Receycle
                                                    Bil</a></span>
                                        @endif
                                        @foreach ($applicant_data as $view_data)
                                        @endforeach
                                        <form action="{{ url('/update_app') }}/{{ $id }}" method="POST">
                                            @csrf
                                            <!-- Customer Id  -->
                                            <div class="row">
                                                <div class="col-45">
                                                    <label class="label" for="Customer_ID">App_ID</label>

                                                </div>
                                                <div class="col-55">
                                                    <label class="label" for="Customer_ID">{{ $view_data->Id }}</label>
                                                </div>
                                            </div>

                                            <!-- Application Type -->
                                            <div class="row">
                                                <div class="col-45">
                                                    <label class="label" for="Application_Type">Application</label>
                                                </div>
                                                <div class="col-55">
                                                    <div class="md-form">
                                                        <select class="form-control" id="Application_Type"
                                                            name="Application_Type">
                                                            <option value="{{ $view_data->Application_Type }}">
                                                                {{ $view_data->Application_Type }}</option>
                                                            @foreach ($application_type as $app_type)
                                                                <option value="{{ $app_type->Service_Name }}">
                                                                    {{ $app_type->Service_Name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="error">
                                                            @error('Application_Type')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Name -->
                                            <div class="row">
                                                <div class="col-45">
                                                    <label class="label" for="Name">Name</label> <span
                                                        class="important">*</span>
                                                </div>
                                                <div class="col-55">
                                                    <div class="md-form">
                                                        <input type="text" id="Name" name="Name"
                                                            class="form-control" value="{{ $view_data->Name }}" />
                                                        <span class="error">
                                                            @error('Name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Mobile No -->
                                            <div class="row">
                                                <!-- Material input -->
                                                <div class="col-45">
                                                    <label for="Mobile_No">Mobile_No</label> <span
                                                        class="important">*</span>
                                                </div>
                                                <div class="col-55">
                                                    <div class="md-form">
                                                        <input type="number" id="Mobile_No" name="Mobile_No"
                                                            class="form-control" value="{{ $view_data->Mobile_No }}"
                                                            onkeydown="mobile(this)">
                                                        <span class="error">
                                                            @error('Mobile_No')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- DOB -->
                                            <div class="row">
                                                <!-- Material input -->
                                                <div class="col-45">
                                                    <label for="DOB">DOB</label> <span class="important">*</span>
                                                </div>
                                                <div class="col-55">
                                                    <div class="md-form">
                                                        <input type="date" id="DOB" name="DOB"
                                                            class="form-control" value="{{ $view_data->Dob }}">
                                                        <span class="error">
                                                            @error('DOB')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Ack No -->
                                            <div class="row">
                                                <!-- Material input -->
                                                <div class="col-45">
                                                    <label for="Ack_No">Ack_No</label> </span>
                                                </div>
                                                <div class="col-55">
                                                    <div class="md-form">
                                                        <input type="text" id="Ack_No" name="Ack_No"
                                                            class="form-control" value="{{ $view_data->Ack_No }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Ack File Upload -->
                                            <div class="row">
                                                <!-- Material input -->
                                                <div class="col-45">
                                                    <label for="Ack_File">Upload Ack</label> </span>
                                                </div>
                                                <div class="col-55">
                                                    <div class="md-form">
                                                        <input type="file" id="Ack_File" name="Ack_File"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Document No -->
                                            <div class="row">
                                                <!-- Material input -->
                                                <div class="col-45">
                                                    <label for="Document_No">Document_No</label>
                                                </div>
                                                <div class="col-55">
                                                    <div class="md-form">
                                                        <input type="text" id="Document_No" name="Document_No"
                                                            class="form-control" value="{{ $view_data->Document_No }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Dcoument File Upload -->
                                            <div class="row">
                                                <!-- Material input -->
                                                <div class="col-45">
                                                    <label for="Doc_File">Upload Document</label> </span>
                                                </div>
                                                <div class="col-55">
                                                    <div class="md-form">
                                                        <input type="file" id="Doc_File" name="Doc_File"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                                    <div class="form-data">
                                        <!-- Received Date -->
                                        <div class="row">
                                            <!-- Material input -->
                                            <div class="col-45">
                                                <label for="Received_Date">Received Date</label> <span
                                                    class="important">*</span>
                                            </div>
                                            <div class="col-55">
                                                <div class="md-form">
                                                    <input type="date" id="Received_Date" name="Received_Date"
                                                        class="form-control" value="{{ $view_data->Received_Date }}">
                                                    <span class="error">
                                                        @error('Received_Date')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Applied Date -->
                                        <div class="row">
                                            <!-- Material input -->
                                            <div class="col-45">
                                                <label for="Applied_Date">Applied Date</label> <span
                                                    class="important">*</span>
                                            </div>
                                            <div class="col-55">
                                                <div class="md-form">
                                                    <input type="date" id="Applied_Date" name="Applied_Date"
                                                        class="form-control" value="{{ $view_data->Applied_Date }}">
                                                    <span class="error">
                                                        @error('Applied_Date')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Status-->
                                        <div class="row">
                                            <div class="col-45">
                                                <label class="label" for="Status">Status</label> <span
                                                    class="important">*</span>
                                            </div>
                                            <div class="col-55">
                                                <select class="form-control" id="Status" name="Status">
                                                    <option value="{{ $view_data->Status }}">{{ $view_data->Status }}
                                                    </option>
                                                    @foreach ($status_list as $status)
                                                        <option value="{{ $status->status }} ">
                                                            {{ $status->status }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error">
                                                    @error('status')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Total Amount -->
                                        <div class="row">
                                            <!-- Material input -->
                                            <div class="col-45">
                                                <label for="amount">Total</label> <span class="important">*</span>
                                            </div>
                                            <div class="col-55">
                                                <div class="md-form">
                                                    <input type="number" id="amount" name="Total_Amount"
                                                        class="form-control" value="{{ $view_data->Total_Amount }}">
                                                    <span class="error">
                                                        @error('Total_Amount')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Amount Paid -->
                                        <div class="row">
                                            <!-- Material input -->
                                            <div class="col-45">
                                                <label for="Amount_Paid">Paid</label> <span class="important">*</span>
                                            </div>
                                            <div class="col-55">
                                                <div class="md-form">
                                                    <input type="number" id="paid" name="Amount_Paid"
                                                        class="form-control" value="{{ $view_data->Amount_Paid }}"
                                                        onblur="balance()">
                                                    <span class="error">
                                                        @error('Amount_Paid')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Balance Amount -->
                                        <div class="row">
                                            <!-- Material input -->
                                            <div class="col-45">
                                                <label for="Balance">Balance</label> <span class="important">*</span>
                                            </div>
                                            <div class="col-55">
                                                <div class="md-form">
                                                    <input type="number" id="bal" name="Balance"
                                                        class="form-control" value="{{ $view_data->Balance }}" readonly>
                                                    <span class="error">
                                                        @error('Balance')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Payment Mode -->
                                        <div class="row">
                                            <div class="col-45">
                                                <label class="label" for="Payment_Mode">Payment</label> <span
                                                    class="important">*</span>
                                            </div>
                                            <div class="col-55">
                                                <select class="form-control" id="Payment_Mode" name="Payment_Mode">
                                                    <option value="{{ $view_data->Payment_Mode }}">
                                                        {{ $view_data->Payment_Mode }}</option>
                                                    @foreach ($payment_mode as $payment_mode)
                                                        <option value="{{ $payment_mode->Payment_Mode }} ">
                                                            {{ $payment_mode->Payment_Mode }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error">
                                                    @error('Payment_Mode')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <!-- Delivered Date -->
                                        <div class="row">
                                            <!-- Material input -->
                                            <div class="col-45">
                                                <label for="Delivered_Date">Delivered Date</label> <span
                                                    class="important">*</span>
                                            </div>
                                            <div class="col-55">
                                                <div class="md-form">
                                                    <input type="date" id="Delivered_Date" name="Delivered_Date"
                                                        class="form-control" value="{{ $view_data->Delivered_Date }}">
                                                    <span class="error">
                                                        @error('Delivered_Date')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-data-buttons">
                                    <!-- Submitt Buttom -->
                                    <div class="row">
                                        <div class="col-100">
                                            <button type="submit" value="submit" name="submit"
                                                class="btn btn-success btn-sm btn-rounded">Update </button>
                                            <a href="{{ url('app_form') }}" class="btn btn-sm btn-rounded">Cancel</a>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Right Section -->


                            <!-- Table List Code  -->
                            <p class="heading">Insight</p>
                            <div class="insight-container">

                                <div class="right-menu-section">
                                    <img src="\digital/cyber/photo_gallery\customer-insight.png" alt="">
                                    <div class="sec-data">
                                        <p class="section-heading">Applied Services</p>
                                        <p class="section-value">Total {{ $indi_count }} Services</p>
                                        <p class="section-pre-values">Deleted {{ $indi_deleted }} Applications</p>
                                    </div>
                                </div>

                                <div class="right-menu-section">
                                    <img src="\digital/cyber/photo_gallery\customer-insight-2.png" alt="">
                                    <div class="sec-data">
                                        <p class="section-heading">Applications Deliverd</p>
                                        <p class="section-value">Delivered : {{ $indi_delivered }}</p>
                                        <p class="section-pre-values">Pending {{ $indi_pending }}</p>
                                    </div>
                                </div>

                                <div class="right-menu-section">
                                    <img src="\digital/cyber/photo_gallery\customer-insight-3.png" alt="">
                                    <div class="sec-data">
                                        <p class="section-heading">Revenue Earned</p>
                                        <p class="section-value">Payble &#x20B9; {{ $indi_total }}/-</p>
                                        <p class="section-pre-values">Paid <span> &#x20B9;{{ $indi_amount }}</span>
                                            Balance <span> &#x20B9;{{ $indi_bal }}</span></p>
                                        <p class="section-pre-values"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right Menu for Insight Data -->
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
