<div>
    <div class="form-container">
        <div class="form-header">
            <p class="heading">Debit Ledger {{date('Y')}}</p>
        </div>
        @if (session('SuccessUpdate'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{session('SuccessUpdate')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if (session('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{session('Error')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if (session('SuccessMsg'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{session('SuccessMsg')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <form wire:submit.prevent="DebitEntry">
            @csrf
            <div class="form-data-container">
{{--Debit Entry Form--}}
                @if ($DebitFormDisplay==1)
                <div class="form-data form">
                    <div class="row"> {{--Transaction ID--}}
                        <div class="col-45">
                            <label class="label" for="Transaction_Id">Transaction Id</label>

                        </div>
                        <div class="col-55">
                            <label class="label" for="Transaction_Id">{{$transaction_id}}</label>
                        </div>
                    </div>
                    <div class="row"> {{--Date--}}
                        <div class="col-45">
                            <label class="label" for="date">Date</label>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input type="date" id="date" name="Date" wire:model="Date" value="{{ date('Y-m-d') }}"
                                    class="form-control" />
                                <span class="error">@error('Date'){{$message}}@enderror</span>
                                <!-- <div class="alert alert-warning" role="alert">

                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="row"> {{--Category--}}
                        <div class="col-45">
                            <label class="label" for="Category_Type">Category </label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <select class="form-control" id="Category_Type" wire:model="Category_Type" name="Category">
                                <option value="">---Select---</option>
                                <option value="Expenses">Expenses</option>
                                <option value="Savings">Savings</option>
                                <option value="Loans">Loans</option>
                            </select>
                            <span class="error">@error('Category_Type'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="row"> {{--Particular--}}
                        <div class="col-45">
                            <label class="label" for="Particular">Source</label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <select class="form-control" id="Particular" wire:model="ParticularSelected" name="Particular">
                                <option value="">---Select---</option>
                                @foreach($source as $key)
                                <option value="{{ $key->Id }}">
                                    {{ $key->Name }}</option>
                                @endforeach
                            </select>
                            <a href="#" onclick="confirm('Do you want to Add New Debit Source? !!') || event.stopImmediatePropagation()" wire:click="OpenSourceForm('Source')">Add Source</a>
                            <span class="error">@error('ParticularSelected'){{$message}}@enderror</span>
                        </div>
                    </div>
                   @if(!empty($ParticularSelected))
                   <div class="row"> {{--Sources--}}
                    <div class="col-45">
                        <label class="label" for="Particular">Name</label>
                        <span class="important">*</span>
                    </div>
                    <div class="col-55">
                        <select class="form-control" id="Particular" wire:model="SelectedSources" name="Particular">
                            <option value="">---Select---</option>
                            @foreach($debit_sources as $key)
                            <option value="{{ $key->Name }}">
                                {{ $key->Name }}</option>
                            @endforeach
                        </select>
                        <a href="#" onclick="confirm('Do you want to Add More Item? !!') || event.stopImmediatePropagation()" wire:click="OpenSourceForm('Particular')">Add Particular</a>
                        <span class="error">@error('SelectedSources'){{$message}}@enderror</span>
                    </div>
                    </div>
                   @endif


                    <div class="row"> {{--Total_Amount--}}
                        <div class="col-45">
                            <label for="Amount_Paid">Total Amount</label> <span class="important">*</span>
                        </div>
                        <div class="col-20">
                            <div class="md-form">
                                <input type="number"  wire:model="Unit_Price"  name="Total_Amount" class="form-control"
                                    placeholder="Amount" pattern="[0-9]" readonly>
                                <span class="error">@error('Unit_Price'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-20">
                            <div class="md-form">
                                <input type="number" id=""  wire:model="Quantity"  name="Total_Amount" class="form-control"
                                    placeholder="Quantity" pattern="[0-9]">
                                <span class="error">@error('Quantity'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-20">
                            <div class="md-form">
                                <input type="number" id="amount"  value="{{$Total_Amount}}"  name="Total_Amount" class="form-control"
                                placeholder="Total" pattern="[0-9]" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row"> {{--Amount_Paid--}}
                        <div class="col-45">
                            <label for="Amount_Paid">Paid / Bal </label> <span class="important">*</span>
                        </div>
                        <div class="col-27">
                            <div class="md-form">
                                <input type="number" id="paid" wire:model="Amount_Paid" name="Amount_Paid" class="form-control"
                                    placeholder="Paid" onblur="balance()">
                                <span class="error">@error('Amount_Paid'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-27">
                            <div class="md-form">
                                <input type="number" id="bal" name="Balance" class="form-control"
                                    placeholder="Bal" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row"> {{--Description--}}
                        <div class="col-45">
                            <label class="label" for="Description">Description</label> <span
                                class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <textarea id="Description" wire:model="Description" name="Description" class="form-control"
                                    placeholder="Debit Description" rows="3" resize="none"></textarea>
                                <span class="error">@error('Description'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row"> {{--Payment_Mode--}}
                        <div class="col-45">
                            <label class="label" for="Payment_mode">Payment</label> <span
                                class="important">*</span>
                        </div>
                        <div class="col-55">
                            <select class="form-control" id="Payment_mode" wire:model="Payment_Mode" name="Payment_mode" wire:change="Change($event.target.value)"">
                                <option value="">---Select---</option>
                                @foreach ($payment_mode as $payment_mode)
                                <option value="{{$payment_mode->Payment_Mode}}">
                                    {{$payment_mode->Payment_Mode}}</option>
                                @endforeach
                            </select>
                            <span class="error">@error('Payment_mode'){{$message}}@enderror</span>
                        </div>
                    </div>
                    @if ($Payment_Mode!="Cash")
                        <div class="row"> {{--Attachment--}}
                            <div class="col-45">
                                <label for="Attachment">Attachment</label>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="file" id="Attachment{$itteration}" wire:model="Attachment" name="Attachment" class="form-control" accept="image/*">
                                    <span class="error">@error('Attachment'){{$message}}@enderror</span>
                                </div>
                            </div>
                        </div>


                        <div wire:loading wire:target="Attachment">Uploading...</div>
                        @if (!is_Null($Attachment))
                            <div class="row">
                                <div class="col-45">
                                    <img class="col-75" src="{{ $Attachment->temporaryUrl() }}"" alt="File" />
                                </div>
                            </div>

                        @elseif(!is_Null($Old_Attachment))
                            <div class="row">
                                <div class="col-45">
                                    <img class="col-75" src="{{ $Old_Attachment}}"" alt="Existing File" />
                                </div>
                            </div>
                        @endif
                    @endif


                {{--Debit Entry Buttons--}}
                <div class="form-data-buttons">
                    <div class="row">
                        <div class="col-100">
                            @if ($UpdateButton == 0 )
                            <button type="submit" value="submit" name="submit"
                                class="btn btn-primary btn-rounded btn-sm">Add Debit</button>
                                <a href='#' wire:click.prevent="ResetFields()"class="btn  btn-info btn-rounded btn-sm">Reset</a>
                                @elseif ($UpdateButton == 1 )
                                <a href='#' class="btn btn-success btn-rounded btn-sm" wire:click="Update('{{$transaction_id}}')">Update</a>
                                <a href='#' wire:click.prevent="ResetFields()"class="btn  btn-info btn-rounded btn-sm">Reset</a>
                            @else

                            @endif
                            <a href="{{ URL::to('debit_entry') }}" class="btn btn-rounded btn-sm">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        @endif

{{-- Source Form   --}}
                @if ($SourceFormDisplay==1)
                <form >
                @csrf
                <div class="form-data box-border">
                    <p class="heading2">Add Source form
                    <a href="#" class="btn-sm btn-danger"  onclick="confirm('Do you Want ot Close Source Form? !!') || event.stopImmediatePropagation()"  wire:click="CloseSourceForm('No')">Close</a></p>

                    <div class="row"> {{--Category Type--}}
                        <div class="col-45">
                            <label class="label" for="Type">Source Type </label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <select class="form-control" id="Type" wire:model="Type" name="Type" wire:change="ChangeSource($event.target.value)">
                                <option value="">---Select---</option>
                                <option value="Debit Source">Debit Source</option>
                                <option value="Particular">Particular</option>
                            </select>
                            <span class="error">@error('Category'){{$message}}@enderror</span>
                        </div>
                    </div>

                    @if($Type == "Debit Source")
                        <div class="row"> {{--Source Name--}}
                            <div class="col-45">
                                <label class="label" for="Name">Name</label>
                                <span class="important">*</span>
                            </div>
                            <div class="col-55">
                            <input type="text"  class="form-control" name="Name" wire:model="Name" id="Name" placeholder="Enter Name">
                                <span class="error">@error('Name'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="row"> {{--Category--}}
                            <div class="col-45">
                                <label class="label" for="Category_Type">Category_Type </label>
                                <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <select class="form-control" id="Category_Type" wire:model="Category_Type" name="Category_Type">
                                    <option value="---Select---">---Select---</option>
                                    <option value="Expenses">Expenses</option>
                                    <option value="Savings">Savings</option>
                                    <option value="Loans">Loans</option>
                                </select>
                                <span class="error">@error('Category_Type'){{$message}}@enderror</span>
                            </div>
                        </div>
                    @elseif ($Type == "Particular")
                    <div class="row"> {{--Category--}}
                        <div class="col-45">
                            <label class="label" for="Category_Type">Category_Type </label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <select class="form-control" id="Category_Type" wire:model="Category_Type" name="Category_Type">
                                <option value="">---Select---</option>
                                <option value="Expenses">Expenses</option>
                                <option value="Savings">Savings</option>
                                <option value="Loans">Loans</option>
                            </select>
                            <span class="error">@error('Category_Type'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="row"> {{--Particular--}}
                        <div class="col-45">
                            <label class="label" for="Particular">Source</label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <select class="form-control" id="Particular" wire:model="ParticularSelected" name="Particular">
                                <option value="">---Select---</option>
                                @foreach($source as $key)
                                <option value="{{ $key->Id }}">
                                    {{ $key->Name }}</option>
                                @endforeach
                            </select>
                            <span class="error">@error('ParticularSelected'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="row"> {{--Source Name--}}
                        <div class="col-45">
                            <label class="label" for="Name">Name</label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                        <input type="text"  class="form-control" name="Name" wire:model="Name" id="Name" placeholder="Enter Name" >
                            <span class="error">@error('Name'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="row"> {{--Budget--}}
                        <div class="col-45">
                            <label class="label" for="Budget">Budget</label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                        <input type="number"  class="form-control" name="Budget" wire:model="Budget" id="Budget" placeholder="Enter Amount" >
                            <span class="error">@error('Budget'){{$message}}@enderror</span>
                        </div>
                    </div>
                    @endif


                <div class="form-data-buttons">
                    <div class="row">
                        <div class="col-100">
                            @if ($UpdateButton == 0 )
                            <button type="submit"wire:click.prevent="SaveSource()"name="submit"
                                class="btn btn-primary btn-rounded btn-sm">Add Source</button>
                                @elseif ($UpdateButton == 1 )
                                <a href='#' id="UpdateButton" class="btn btn-success btn-rounded btn-sm" wire:click.prevent="UpdateSource('{{$UpdateId}}')">Update</a>
                            @else


                            @endif
                            <a href="#" wire:click.prevent="CancelUpdate()"class="btn btn-rounded btn-sm">Cancel</a>
                        </div>
                    </div>
                </div>
                </div>
            </form>
{{-- Available Source List  --}}
                <div class="form-data">
                    <p class="heading2">Debit Source List </p>
                        <table>
                            <thead>
                                <tr>
                                    <th>SL.No</th>
                                    <th>Name</th>
                                    @if($Type == 'Debit Source')
                                    <th>Category</th>
                                    @elseif($Type == 'Particular')
                                    <th>Budget</th>
                                    @endif
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($DSList as $key)
                                <tr>
                                    <td>{{ $n++ }}</td>
                                    <td style="width:30%">{{ $key->Name }}</td>
                                    @if($Type == 'Debit Source')
                                    <td style="width:30%">{{ $key->Category }}</td>
                                    @elseif($Type == 'Particular')
                                    <td style="width:30%">{{ $key->Total }}</td>
                                    @endif
                                    <td style="width:15%">
                                        <div class="btn-group" role="group"
                                            aria-label="Button group with nested dropdown">
                                            <div class="btn-group btn-group-sm " role="group">
                                                <button id="btnGroupDrop2" type="button"
                                                    class="btn btn-info dropdown-toggle" data-mdb-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Edit
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                                    <li>
                                                        <a class="dropdown-item " href='#' onclick="confirm('Are you sure you want to Edit {{$key->Name}}?') || event.stopImmediatePropagation()" wire:click="Edit('{{$key->Id}}')">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class=" dropdown-item" onclick="confirm('Are you sure you want to Delete {{$key->Name}} Permanently!!') || event.stopImmediatePropagation()"
                                                        wire:click="Delete('{{$key->Id}}')">Delete</a>
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
                            {{$DSList->links()}}
                        </span>


                </div>

                @endif













{{--Form Insight--}}
                @if ($DebitFormDisplay==1)
                <div class="form-data">
                    <div class="right-menu">
                        <p class="heading2">Revenue Insight</p>
                        <div class="form-insight-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="form-sec-data">
                                <p class="section-heading">Revenue Generated</p>
                                <p class="section-value">Gross &#x20B9; {{$total_revenue}}/-</p>
                                <p class="section-pre-values">Yesterday &#x20B9; <span>{{$previous_revenue}}</span></p>
                            </div>
                        </div>
                        <div class="form-insight-section" >
                            <img src="\digital/cyber/photo_gallery\insight-2.png" alt="" >
                            <div class="form-sec-data">
                                <p class="section-heading">Reveniue From </p>
                                <p class="section-value">{{$SelectedSources}}</p>
                                <p class="section-value"> &#x20B9; <span style="color:green">{{$source_total}} </span>/-</p>
                            </div>
                        </div>
                        <div class="form-insight-section" >
                            <img src="\digital/cyber/photo_gallery\insight-3.png" alt="" >
                            <div class="form-sec-data">
                                <p class="section-heading">Percentage Contribution</p>
                                <p class="section-value"><span style="color:red">{{$contribution}}</span> %  Percentage </p>
                                <p class="section-pre-values">Yesterday Earned &#x20B9; <span>{{$prev_earning}}/-</span> By {{$SelectedSources}}</p>

                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>













@if (count($creditdata)>0)


        <div class="table-container"> {{--Table Container--}}
            <div class="form-header">
                <p class="heading">Daily Expenses </p>
            </div>
            <div class="table-information">
                <span class="info-text">Total Expense as on
                @if (empty($Select_Date))
                    {{ $today }} is
                    &#x20B9; {{ $total }}
                @endif
                @if (!empty($Select_Date))
                    {{ $Select_Date }} is
                    &#x20B9; {{ $total }}
                @endif</span>
                <!-- Quick List Button -->
                <div class="d-flex justify-content-between align-content-center mb-2">
                    <div class="d-flex">
                        <div>
                            <div class="d-flex align-items-center ml-4">
                                @if ($Checked)
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group btn-group-sm btn-rounded" role="group">
                                        <button id="btnGroupDrop1" type="button"
                                            class="btn btn-danger btn-sm dropdown-toggle" data-mdb-toggle="dropdown"
                                            aria-expanded="false">
                                            Cheched ({{count($Checked)}})
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                            <li><a class=" dropdown-item" onclick="confirm('Are you sure you want to Delete these records Permanently!!') || event.stopImmediatePropagation()" wire:click="MultipleDelete()">Delete</a>
                                            </li>
                                            </ul>
                                    </div>
                                </div>
                                <div class="row"></div>


                                @endif

                                <label for="paginate" class="text-nowrap mr-2 mb-0">Per Page</label>
                                <select wire:model="paginate" name="paginate" id="paginate" class="form-control form-control-sm">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>
                                <div class="row"></div>
                                <label for="paginate" class="text-nowrap mr-2 mb-0">Sort By</label>
                                <input  type="text"  wire:model="filterby" class="form-control form-control-sm" placeholder="Filter">
                                <div class="row"></div>
                                <label for="paginate" class="text-nowrap mr-2 mb-0">Search By Date</label>

                                <input type="date" id="date" name="Select_Date" wire:model="Select_Date" class="form-control form-control-sm"/>

                            </div>
                        </div>
                    </div>
                </div>
                @if (sizeof($collection)>0)
                                    <br>
                                    <span class="info-text">Balance Due Found for {{count($collection)}} Records!.</span>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Description</th>
                                                <th>Total Amount</th>
                                                <th>Amount Paid</th>
                                                <th>Balance</th>
                                                <th>Update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($collection as $item)
                                            <tr>
                                                <td style="width:25%">{{$item['Id']}}</td>
                                                <td style="width:25%">{{$item['Description']}}</td>
                                                <td style="width:25%">&#x20B9; {{$item['Total_Amount']}}</td>
                                                <td style="width:25%">&#x20B9; {{$item['Amount_Paid']}}</td>
                                                <td style="width:25%">&#x20B9; {{$item['Balance']}}</td>
                                                <td style="width:25%">
                                                    <a class="btn-sm btn-primary"  wire:click="UpdateBalance('{{$item['Id']}}')" style = "color: white">Update</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <span class="info-text">Total Balance Due : &#x20B9;{{
                                             $collection->sum('Balance') }}</span>
                                        </tbody>
                                    </table>
                                    <div class="row"></div>
                                    @endif

            </div>

            <div class="progress" style="height: 15px">
                <div class="progress-bar" role="progressbar" style="width:{{$percentage}}%"
                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    {{$percentage}}%
                </div>
            </div>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>SL.No</th>
                        <th>Check</th>
                        <th>Particular</th>
                        <th>Amount &#x20B9;</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($creditdata as $data)
                    <tr>
                        <td>{{ $n++ }}</td>
                        <td><input type="checkbox" name="checked" id="checked" value="{{$data->Id}}" wire:model="Checked"></td>
                        <td style="width:30%">{{ $data->Source }}, {{ $data->Name }}</td>
                        <td style="width:14%">{{ $data->Amount_Paid }}</td>
                        <td style="width:50%">{{ $data->Description }}</td>
                        <td style="width:15%">
                            <div class="btn-group" role="group"
                                aria-label="Button group with nested dropdown">
                                <div class="btn-group btn-group-sm " role="group">
                                    <button id="btnGroupDrop2" type="button"
                                        class="btn btn-info dropdown-toggle" data-mdb-toggle="dropdown"
                                        aria-expanded="false">
                                        Edit
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                        <li>
                                            <a class="dropdown-item " href='#' onclick="confirm('Are you sure you want to Edit this Recored ?') || event.stopImmediatePropagation()" wire:click="Edit('{{$data->Id}}')">Edit</a>
                                        </li>
                                        <li>
                                            <a class=" dropdown-item" onclick="confirm('Are you sure you want to Delete this Recored Permanently!!') || event.stopImmediatePropagation()"
                                            wire:click="Delete('{{$data->Id}}')">Delete</a>
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
                {{$creditdata->links()}}
            </span>
        </div>
        @endif
    </div>
</div>
