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
                    <li><a href="{{ url('creditentry') }}">Credit Entry</a></li><span class="span">|</span>
                    <li><a href="{{ url('debitentry') }}">Debit Entry</a></li><span class="span">|</span>
                </ul>
            </div>
            <div class="pages">
                <div class="border">
                    <div class="data-form">
                        <div class="data-form-header">
                            <!-- <img src="img/income.png" alt="Application_image" class="header-image"> -->
                            <p class="heading">Update Credit Ledger</p>
                        </div>
                        @if (session('SuccessUpdate'))
                        <span class="success">{{session('SuccessUpdate')}}</span>

                        @endif
                        <form action="{{ url('/update_credit_entry') }}/{{ $id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-25">
                                    <label class="label" for="Particular">Particular</label>
                                    <span class="important">*</span>
                                </div>
                                <div class="col-75">
                                    <select class="form-control" id="Particular" name="Particular">

                                        @foreach($view_credit_info as $credit_info)
                                        <option selected value="{{ $credit_info->Source }}">
                                            {{ $credit_info->Source }}
                                        </option>
                                        @endforeach
                                        @foreach($credit_source as $credit_source)
                                        <option value="{{ $credit_source->Source }}">
                                            {{ $credit_source->Source }}
                                        </option>
                                        @endforeach

                                    </select>
                                    <span class="error">@error('Particular'){{$message}}@enderror</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label class="label" for="date">Date</label> <span class="important">*</span>
                                </div>
                                <div class="col-75">
                                    <div class="md-form">
                                        <input type="date" id="date" name="Date" value="{{ $credit_info->Date }}"
                                            class="form-control" />
                                        <span class="error">@error('Date'){{$message}}@enderror</span>
                                        <!-- <div class="alert alert-warning" role="alert">

                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Material input -->
                                <div class="col-25">
                                    <label for="Amount">Amount</label> <span class="important">*</span>
                                </div>
                                <div class="col-75">
                                    <div class="md-form">
                                        <input type="number" id="Amount" name="Amount"
                                            value="{{ $credit_info->Amount }}" class=" form-control"
                                            placeholder="Enter Amount">
                                        <span class="error">@error('Amount'){{$message}}@enderror</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label class="label" for="Description">Description</label> <span
                                        class="important">*</span>
                                </div>
                                <div class="col-75">
                                    <div class="md-form">
                                        <textarea id="Description" name="Description" class="form-control" rows="3"
                                            resize="none">{{ $credit_info->Description }}</textarea>
                                        <span class="error">@error('Description'){{$message}}@enderror</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label class="label" for="Payment_mode">Payment</label> <span
                                        class="important">*</span>
                                </div>
                                <div class="col-75">
                                    <select class="form-control" id="Payment_mode" name="Payment_mode">
                                        <option value="{{ $credit_info->Payment_Mode }}">
                                            {{ $credit_info->Payment_Mode }}</option>
                                        @foreach($payment_mode as $payment_mode)
                                        <option value="{{ $payment_mode->Payment_Mode }}">
                                            {{ $payment_mode->Payment_Mode }}
                                        </option>
                                        @endforeach

                                    </select>
                                    <span class="error">@error('Payment_mode'){{$message}}@enderror</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-75">
                                    <button type="submit" value="submit" name="submit"
                                        class="btn btn-success btn-rounded">Update</button>
                                    <a href="{{url('credit_entry')}}" class="btn  btn-rounded">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="data-table">
                        <div class="data-table-header">
                            <!-- <img src=" img/income.png" alt="Application_image" class="header-image"> -->
                            <p class="heading">View Credit List</p>
                        </div>
                        <span class="info-text">Total Credit as on {{ date("d-m-Y") }} is
                            &#x20B9; {{ $total }}</span>
                        <div class="progress" style="height: 15px">
                            <div class="progress-bar" role="progressbar" style="width:{{ $percentage }}%"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                {{ $percentage }}%
                            </div>
                        </div>

                        <table>
                            <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Particular</th>
                                    <th>Amount &#x20B9;</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($view_credit_info as $credit_info)
                                @while ($sl_no>0)
                                <tr>
                                    <td>
                                        {{ $n++ }}
                                        @if($sl_no==$sl_no)
                                        @break
                                        @endif
                                    </td>
                                    @endwhile
                                    <td style="width:25%">{{ $credit_info->Source }}</td>
                                    <td style="width:14%">{{ $credit_info->Amount }}</td>
                                    <td style="width:50%">{{ $credit_info->Description }}</td>
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
                                                    <li><a class="dropdown-item"
                                                            href='/digital/cyber/view_credit_entry/{{ $credit_info->Id }}'>Edit</a>
                                                    </li>
                                                    <li><a class=" dropdown-item"
                                                            href='/digital/cyber/delete_credit_entry/{{ $credit_info->Id }}'>Delete</a>
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
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>

</body>

</html>










@endsection