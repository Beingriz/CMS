<div> {{-- Main Route --}}

        <div class="form-container">
            <div class="form-header">
                <p class="heading"> Application Form</p>
            </div>
            @if ($Open ==1)


            <div class="border-b">
                <div class="profile-main-container">
                    <div class="profile-header">
                        <div class="profile-icon">
                            <img src="{{$Old_Profile_Image}}" alt="">
                        </div>
                        <div class="profile-heading">
                            <p class="heading2"  >{{$C_Name}}</p>
                        </div>
                        <div class="profile-options">
                            {{-- Links to be added --}}
                        </div>
                    </div>

                    <div class="profile-container">
                        {{-- Details 1 --}}
                        <div class="form-data">
                            <div class="row"> <!-- Client Id  -->
                                <div class="col-35">
                                    <label class="existing_label" for="Client_ID">Client ID :</label>
                                </div>
                                <div class="col-55">
                                    <div class="label-value" > {{$C_Id}} </div>
                                </div>
                            </div>
                            <div class="row"> <!-- Name-->
                                <div class="col-35">
                                    <label class="existing_label" for="Client_Name">Name :</label>
                                </div>
                                <div class="col-55">
                                    <div class="label-value" > {{$C_Name}}  </div>
                                </div>
                            </div>
                            <div class="row"> <!-- Mobile No-->
                                <div class="col-35">
                                    <label class="existing_label" for="Mobile_No">Mobile No :</label>
                                </div>
                                <div class="col-55">
                                    <div class="label-value" > {{$C_Mob}} </div>
                                </div>
                            </div>
                        </div>
                        {{-- Details 2 --}}
                        <div class="form-data">
                            <div class="row"> <!-- DOB-->
                                <div class="col-35">
                                    <label class="existing_label" for="DOB">DOB :</label>
                                </div>
                                <div class="col-55">
                                    <div class="label-value" > {{$C_Dob}} </div>
                                </div>
                            </div>
                            <div class="row"> <!-- Address-->
                                <div class="col-35">
                                    <label class="existing_label" for="Address">Address :</label>
                                </div>
                                <div class="col-55">
                                    <div class="label-value" > {{$C_Address}} </div>
                                </div>
                            </div>
                            <div class="row"> <!-- Client Type-->
                                <div class="col-35">
                                    <label class="existing_label" for="Client_Type">Client Type :</label>
                                </div>
                                <div class="col-55">
                                    <div class="label-value" > {{$C_Ctype}} </div>
                                </div>
                            </div>
                        </div>
                        {{-- Details 3 --}}
                        <div class="form-data">
                            <div class="row"> <!-- Profile Image -->
                            @if(!is_null($Old_Profile_Image))
                                <div class="col-45">
                                    <label class="existing_label" for="Customer_ID">Pofile Image</label>
                                    <img class="profile_image2" src="{{$Old_Profile_Image}}" alt="Profile Image" />
                                </div>
                                <div class="col-55">
                                    <a href="./client_registration" class="btn btn-primary  btn-sm">Edit</a>
                                    <a href="#" class="btn btn-primary  btn-sm">Dashboard</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <form wire:submit.prevent="submit">
                @csrf
                <div class="form-data-container">
                    {{--Form Data 1--}}
                    <div class="form-data">
                        <div> {{--Error Msg --}}
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
                        </div>

                        <div class="row"> <!-- Customer Id  -->
                            <div class="col-45">
                                <label class="label" for="Customer_ID">App_ID</label>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    {{$App_Id}}
                                </div>
                            </div>
                        </div>
                            <div class="row"><!-- Applicaiton -->
                                <div class="col-45">
                                    <label class="label" for="Service">Application </label> <span
                                        class="important">*</span>
                                </div>
                                <div class="col-55">
                                    <select class="form-control" id="Service" name="Service"  wire:model="MainSelected">
                                        <option value="">--Select Service--</option>
                                        @foreach ($main_service as $service)
                                        <option value="{{ $service->Id }} ">
                                            {{ $service->Name }}</option>
                                        @endforeach
                                    </select>
                                    @error('MainSelected') <span class="error">{{ $message }}</span> @enderror

                                </div>
                            </div>
                            @if (!empty($this->sub_service))

                                <div class="row"><!--Applicaiton Type -->
                                    <div class="col-45">
                                        <label class="label" for="Application_Type">Application Type </label> <span
                                            class="important">*</span>
                                    </div>
                                    <div class="col-55">
                                        <select class="form-control" id="Application_Type" name="Application_Type"  wire:model="SubSelected">
                                            <option value="">--Sub Category--</option>
                                            @foreach ($sub_service as $service)
                                            <option value="{{ $service->Name }} ">
                                                {{ $service->Name }}</option>
                                            @endforeach
                                        </select>
                                        @error('SubSelected') <span class="error">{{ $message }}</span> @enderror

                                    </div>
                                </div>
                            @endif

                        <div class="row"> <!-- Name -->
                            <div class="col-45">
                                <label class="label" for="Name">Name</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="text" id="Name" name="Name" class="form-control"
                                        placeholder="Applicant Name"  wire:model.lazy="Name"/>
                                        @error('Name') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row"><!-- Mobile No -->
                            <!-- Material input -->
                            <div class="col-45">
                                <label for="Mobile_No">Mobile_No</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="number" id="Mobile_No" name="Mobile_No" class="form-control"
                                        placeholder="Mobile No" wire:model.debounce.500ms="Mobile_No" onkeydown="mobile(this)">
                                    <span class="error">@error('Mobile_No'){{$message}}@enderror</span>
                                    @if(!is_null($user_type))
                                    <span class="success">{{$user_type}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row"><!-- DOB -->
                            <!-- Material input -->
                            <div class="col-45">
                                <label for="DOB">DOB</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="date" id="DOB" name="DOB" class="form-control" wire:model.lazy="Dob">
                                    @error('Dob') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Ack No -->
                    <div class="row">
                        <!-- Material input -->
                        <div class="col-45">
                            <label for="Ack_No">Acknowledgment</label> </span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input type="text" id="Ack_No" name="Ack_No" class="form-control"
                                wire:model.lazy = "Ack_No" placeholder="Acknowledgment" >

                            </div>
                        </div>
                    </div>
                    @if ($Ack_No !='Not Available' )
                    <div class="row"> {{--Ack File--}}
                        <div class="col-45">
                            <label for="Ack_File">Upload Ack File</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input type="file" id="Ack_File" wire:model="Ack_File" name="Ack_File" class="form-control" accept="application/pdf">
                                <span class="error">@error('Ack_File'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Document No -->
                    <div class="row">
                        <!-- Material input -->
                        <div class="col-45">
                            <label for="Document_No">Document_No</label>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input type="text" id="Document_No" name="Document_No" class="form-control"
                                wire:model.lazy = "Document_No" >

                            </div>
                        </div>
                    </div>
                    @if ($Document_No!='Not Available')
                    <div class="row"> {{--Document File--}}
                        <div class="col-45">
                            <label for="Doc_File">Upload Doc File</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input type="file" id="Doc_File" wire:model="Doc_File" name="Doc_File" class="form-control" accept="application/pdf">
                                <span class="error">@error('Doc_File'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row"> {{--Upload Client Image--}}
                        <div class="col-45">
                            <label for="Client_Image">Client Image </label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input class="form-control " id="formFileSm" type="file"  wire:model="Client_Image"  name="Client_Image" accept="image/jpeg, image/png" />
                                <span class="error">@error('Client_Image'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
                    <div wire:loading wire:target="Client_Image">Uploading Profile Image...</div>
                        @if (!is_null($Client_Image))
                        <div class="row">
                            <div class="col-100">
                                <img class="profile_image" src="{{ $Client_Image->temporaryUrl() }}" alt="Client_Image" />
                            </div>
                        </div>
                        @endif

                </div>
                    {{--Form Data 2--}}
                <div class="form-data">


                        <div class="row"> <!-- Received Date -->
                            <div class="col-45">
                                <label for="Received_Date">Received_Date</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="date" id="Received_Date" name="Received_Date" class="form-control" value="{{$today}}" wire:model="Received_Date">
                                    @error('Received_Date') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row"> <!-- Total Amount -->
                            <!-- Material input -->
                            <div class="col-45">
                                <label for="amount">Total</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="number" id="amount" name="Total_Amount" class="form-control"
                                        placeholder="Total Amount" wire:model.lazy="Total_Amount">
                                        @error('Total_Amount') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row"><!-- Amount Paid -->
                            <!-- Material input -->
                            <div class="col-45">
                                <label for="Amount_Paid">Paid</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="number" id="paid" name="Amount_Paid" class="form-control"
                                        placeholder="Amount Paid" onblur="balance()" wire:model.lazy="Amount_Paid">
                                        @error('Amount_Paid') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row"> <!-- Balance Amount -->
                            <!-- Material input -->
                            <div class="col-45">
                                <label for="Balance">Balance</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="number" id="bal" name="Balance" class="form-control"
                                        placeholder="Balance" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row"> <!-- Payment Mode -->
                            <div class="col-45">
                                <label class="label" for="Payment_Mode">Payment</label> <span
                                    class="important">*</span>
                            </div>
                            <div class="col-55">
                                <select class="form-control" id="Payment_Mode" name="Payment_Mode" wire:model="PaymentMode">
                                    <option value="">---Select---</option>
                                    @foreach ($payment_mode as $payment_mode)
                                    <option value="{{ $payment_mode ->Payment_Mode }} ">
                                        {{ $payment_mode ->Payment_Mode }}</option>
                                    @endforeach
                                </select>
                                @error('PaymentMode') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @if ($PaymentMode != 'Cash' && $PaymentMode =='' )
                        <div class="row"> {{--Payment_Receipt File--}}
                            <div class="col-45">
                                <label for="Payment_Receipt">Upload Payment Recipt</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="file" id="Payment_Receipt" wire:model="Payment_Receipt" name="Payment_Receipt" class="form-control" accept="image/jpeg, image/png>
                                    <span class="error">@error('Payment_Receipt'){{$message}}@enderror</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                    <div class="form-data-buttons"><!-- Submitt Buttom -->
                        <div class="row">
                            <div class="col-100">
                                <button type="submit" value="submit" name="submit"
                                    class="btn btn-primary btn-rounded btn-sm">Save Application</button>
                                <a href="{{url("app_home")}}" class="btn btn-rounded btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
            </form>
    @if (count($daily_applications)>0)
        <div class="table-container">
            <div class="form-header">
                <p class="heading"> Application List</p>
            </div>
            <div class="table-information">
                <span class="info-text">Total Credit as on
                    @if (empty($Select_Date)) {{ $today }} is &#x20B9 {{$Daily_Income}} @endif
                    @if (!empty($Select_Date)) {{ $Select_Date }} is &#x20B9 {{$Daily_Income}} @endif
                </span>
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
                                <label for="date" class="text-nowrap mr-2 mb-0">Search By Date</label>

                                <input type="date" id="date" name="Select_Date" wire:model="Select_Date" class="form-control form-control-sm"/>

                            </div>
                        </div>
                    </div>
                </div>
                @if (!is_null($collection))
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
                                                <td style="width:10%">{{$item['Id']}}</td>
                                                <td style="width:35%">{{$item['Description']}}</td>
                                                <td style="width:5%">&#x20B9; {{$item['Total_Amount']}}</td>
                                                <td style="width:5%">&#x20B9; {{$item['Amount_Paid']}}</td>
                                                <td style="width:5%">&#x20B9; {{$item['Balance']}}</td>
                                                <td style="width:5%">
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
            <table>
                <thead>
                    <tr>
                        <th >Sl.No</th>
                        <th >Select</th>
                        <th>Name</th>
                        <th>Application</th>
                        <th>Mobile No</th>
                        <th>Amount &#x20B9;</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daily_applications as $data)
                  <tr>
                        <td class="show">{{ $n++ }}</td>
                        <td class="show"><input type="checkbox" id="checkbox" name="checkbox" value="{{$data->Id}}" wire:model="Checked"></td>
                        <td class="show">{{ $data->Name }}</td>
                        <td class="show">{{ $data->Application }} , {{ $data->Application_Type }}</td>
                        <td class="show">{{ $data->Mobile_No }}</td>
                        <td class="show">{{ $data->Amount_Paid }}</td>
                        <td class="show">
                            <div class="btn-group" role="group"
                                aria-label="Button group with nested dropdown">
                                <div class="btn-group btn-group-sm " role="group">
                                    <button id="btnGroupDrop2" type="button"
                                        class="btn btn-info dropdown-toggle" data-mdb-toggle="dropdown"
                                        aria-expanded="false">
                                        Edit
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                        <li><a class="dropdown-item " href='./edit_app/{{ $data->Id }}' onclick="confirm('Are You Sure!? You Want to Edit {{$data->Name}}  Record?')||event.stopImmediatePropagation" >Edit</a>
                                        </li>
                                        <li><a class="dropdown-item "
                                                href='./open_app/{{ $data->Id }}'>Open</a>
                                        </li>
                                        <li><a class=" dropdown-item"
                                                onclick="confirm('Are You Sure!? You Want to Delete This Record?')||event.stopImmediatePropagation" wire:click="Delete('{{$data->Id}}')">Delete</a>
                                        </li>
                                        <li><a class=" dropdown-item"
                                                href='./print_ack/{{ $data->Id }}'>Print</a>
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
                {{$daily_applications->links()}}
            </span>
        </div>
    @endif
    </div>

</div>
