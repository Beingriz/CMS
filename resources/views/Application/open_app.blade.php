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
                    <!-- Table List Code  -->
                    <div class="search-table">
                        <div class="data-table-header">
                            <!-- <img src=" img/income.png" alt="Application_image" class="header-image"> -->
                            <p class="heading">Application List</p>
                        </div>
                        <span class="info-text">Total Applications Found for {{$search }} are {{ $count }}
                            &#x20B9;{{$total}}
                        </span>
                        @foreach($sdata as $data)
                        @endforeach
                        <!-- Customer Id  -->
                        <div class="view_content">
                            <table class="table_view">
                                <tr>
                                    <td class="entity">Customer Id</td>
                                    <td class="values">{{$data->Id}}</td>
                                    <td class="entity">Updated On</td>
                                    <td class="values">{{$data->Delivered_Date}}</td>
                                </tr>
                                <tr>
                                    <td class="entity">Application</td>
                                    <td class="value">{{$data->Application_Type}}</td>
                                </tr>
                                <tr>
                                    <td class="entity">Received on</td>
                                    <td class="values">{{$data->Received_Date}}</td>
                                    <td class="entity">Applied on</td>
                                    <td class="values">{{$data->Applied_Date}}</td>
                                </tr>
                                <tr>
                                    <td class="entity">Name</td>
                                    <td class="values">{{$data->Name}}</td>
                                    <td class="entity">DOB</td>
                                    <td class="values">{{$data->Dob}}</td>
                                </tr>
                                <tr>
                                    <td class="entity">Mobile No</td>
                                    <td class="values">{{$data->Mobile_No}}</td>
                                    <td class="entity">Status</td>
                                    <td class="values">{{$data->Status}}</td>
                                </tr>
                                <tr>
                                    <td class="entity">Acknowledgement</td>
                                    <td class="values">{{$data->Ack_No}}</td>
                                    <td class="entity">Document</td>
                                    <td class="values">{{$data->Document_No}}</td>
                                </tr>
                                <tr>
                                    <td class="entity">Total Amount</td>
                                    <td class="values">{{$data->Total_Amount}}</td>
                                    <td class="entity">Amount Paid</td>
                                    <td class="values">{{$data->Amount_Paid}}</td>
                                </tr>
                                <tr>
                                    <td class="entity">Balance</td>
                                    <td class="values">{{$data->Balance}}</td>
                                    <td class="entity">Payment_Mode</td>
                                    <td class="values">{{$data->Payment_Mode}}</td>
                                </tr>

                            </table>
                            <div class="row">
                                <div class="col-25">
                                    <a href='/digital/cyber/edit_open_app/{{$data->Id}}'
                                        class="btn btn-rounded btn-success">Edit</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <a href='/digital/cyber/delete_app/{{$data->Id}}'
                                        class="btn btn-rounded btn-danger">Delete</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </section>
    </div>

</body>

</html>










@endsection