@extends('Layouts.main')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
    </head>

    <body>
        <div class="container">
            <section class="work-area">
                <div class="sub-nav-menu">
                    <ul>
                        <li><a href="{{ url('debit_entry') }}">New Debit Entry</a></li><span class="span">|</span>
                    </ul>
                </div>
                <div class="pages">
                    <div class="border">
                        <div class="data-form">
                            <div class="data-form-header">
                                <!-- <img src="img/income.png" alt="Application_image" class="header-image"> -->
                                <p class="heading">Service Application Form</p>
                            </div>
                            @if (session('SuccessUpdate'))
                                <span class="success">{{ session('SuccessUpdate') }}</span>
                            @endif
                            @if (session('SuccessMsg'))
                                <span class="success">{{ session('SuccessMsg') }}</span>
                            @endif

                            <form action="{{ url('/update_app') }}/{{ $id }}" method="POST">
                                @csrf
                                <!-- Customer Id  -->
                                @foreach ($view_details as $details)
                                @endforeach
                                <div class="row">
                                    <div class="col-25">
                                        <label class="label" for="Customer_ID">App_ID</label>

                                    </div>
                                    <div class="col-75">
                                        <label class="label" for="Customer_ID">{{ $details->Id }}</label>
                                    </div>
                                </div>
                                <!-- Application Type -->
                                <div class="row">
                                    <div class="col-25">
                                        <label class="label" for="Application_Type">Application</label>
                                    </div>
                                    <div class="col-75">
                                        <select class="form-control" id="Application_Type" name="Application_Type">
                                            <option value="{{ $details->Id }}}">{{ $details->Application_Type }}</option>
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
                                <!-- Name -->
                                <div class="row">
                                    <div class="col-25">
                                        <label class="label" for="Name">Name</label> <span class="important">*</span>
                                    </div>
                                    <div class="col-75">
                                        <div class="md-form">
                                            <input type="text" id="Name" name="Name" class="form-control"
                                                value="{{ $details->Name }}" />
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
                                    <div class="col-25">
                                        <label for="Mobile_No">Mobile_No</label> <span class="important">*</span>
                                    </div>
                                    <div class="col-75">
                                        <div class="md-form">
                                            <input type="number" id="Mobile_No" name="Mobile_No" class="form-control"
                                                placeholder="+91 Ph:" onkeydown="mobile(this)"
                                                value="{{ $details->Mobile_No }}">
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
                                    <div class="col-25">
                                        <label for="DOB">DOB</label> <span class="important">*</span>
                                    </div>
                                    <div class="col-75">
                                        <div class="md-form">
                                            <input type="date" id="DOB" name="DOB" class="form-control"
                                                value="{{ $details->Dob }}">
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
                                    <div class="col-25">
                                        <label for="Ack_No">Ack_No</label> </span>
                                    </div>
                                    <div class="col-75">
                                        <div class="md-form">
                                            <input type="text" id="Ack_No" name="Ack_No" class="form-control"
                                                placeholder="Acknowledgment" value="{{ $details->Ack_No }}">
                                        </div>
                                    </div>
                                </div>
                                <!-- Document No -->
                                <div class="row">
                                    <!-- Material input -->
                                    <div class="col-25">
                                        <label for="Document_No">Document_No</label>
                                    </div>
                                    <div class="col-75">
                                        <div class="md-form">
                                            <input type="text" id="Document_No" name="Document_No" class="form-control"
                                                placeholder="Document No" value="{{ $details->Document_No }}">
                                        </div>
                                    </div>
                                </div>
                                <!-- Total Amount -->
                                <div class="row">
                                    <!-- Material input -->
                                    <div class="col-25">
                                        <label for="amount">Total</label> <span class="important">*</span>
                                    </div>
                                    <div class="col-75">
                                        <div class="md-form">
                                            <input type="number" id="amount" name="Total_Amount"
                                                class="form-control" placeholder="Total Amount"
                                                value="{{ $details->Total_Amount }}">
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
                                    <div class="col-25">
                                        <label for="Amount_Paid">Paid</label> <span class="important">*</span>
                                    </div>
                                    <div class="col-75">
                                        <div class="md-form">
                                            <input type="number" id="paid" name="Amount_Paid" class="form-control"
                                                placeholder="Amount Paid" onblur="balance()"
                                                value="{{ $details->Amount_Paid }}">
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
                                    <div class="col-25">
                                        <label for="Balance">Balance</label> <span class="important">*</span>
                                    </div>
                                    <div class="col-75">
                                        <div class="md-form">
                                            <input type="number" id="bal" name="Balance" class="form-control"
                                                placeholder="Balance " readonly value="{{ $details->Balance }}">
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
                                    <div class="col-25">
                                        <label class="label" for="Payment_Mode">Payment</label> <span
                                            class="important">*</span>
                                    </div>
                                    <div class="col-75">
                                        <select class="form-control" id="Payment_Mode" name="Payment_Mode">
                                            <option value="{{ $details->Payment_Mode }}">{{ $details->Payment_Mode }}
                                            </option>
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
                                <!-- Submitt Buttom -->
                                <div class="row">
                                    <div class="col-75">
                                        <button type="submit" value="submit" name="submit"
                                            class="btn btn-success btn-rounded">Update</button>
                                        <a href="{{ url('app_home') }}" class="btn btn-rounded">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Table List Code  -->
                        <div class="data-table">
                            <div class="data-table-header">
                                <!-- <img src=" img/income.png" alt="Application_image" class="header-image"> -->
                                <p class="heading">Application List</p>
                            </div>
                            <span class="info-text">Applications as on {{ date('d-m-Y') }} is
                                &#x20B9; {{ $total }}</span>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Name</th>
                                        <th>Application</th>
                                        <th>Amount &#x20B9;</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($daily_applications as $data)
                                        @while ($sl_no > 0)
                                            <tr>
                                                <td>
                                                    {{ $n++ }}
                                                    @if ($sl_no == $sl_no)
                                                    @break
                                                @endif
                                            </td>
                                    @endwhile
                                    <td style="width:30%">{{ $data->Name }}</td>
                                    <td style="width:55%">{{ $data->Application_Type }}</td>
                                    <td style="width:20%">{{ $data->Amount_Paid }}</td>
                                    <td style="width:15%">
                                        <div class="btn-group" role="group"
                                            aria-label="Button group with nested dropdown">
                                            <div class="btn-group btn-group-sm " role="group">
                                                <button id="btnGroupDrop1" type="button"
                                                    class="btn btn-info dropdown-toggle" data-mdb-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Edit
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <li><a class="dropdown-item "
                                                            href='/digital/cyber/view_app/{{ $data->Id }}'>Edit</a>
                                                    </li>
                                                    <li><a class=" dropdown-item"
                                                            href='/digital/cyber/delete_app/{{ $data->Id }}'>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>

                                    </tr>
                                @endforeach
                            </tbody>

                            <!-- <tfoot>
                                <tr>
                                    <th>Name
                                    </th>
                                    <th>Position
                                    </th>
                                    <th>Office
                                    </th>
                                    <th>Age
                                    </th>
                                    <th>Start date
                                    </th>
                                    <th>Salary
                                    </th>
                                </tr>
                            </tfoot> -->
                        </table>
                        <span>
                            {{ $daily_applications->links() }}
                        </span>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>

</body>

</html>
@endsection
