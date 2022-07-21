<div>
    <div class="form-container">
        <div class="form-header">

            <!-- <img src="img/income.png" alt="Application_image" class="header-image"> -->
        <p class="heading">Application Details of <span>{{$Name}}, ID: {{$Client_Id}}</span> </p>
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
        <div class="insight-container">

            <a href="#" class="right-menu-section" wire:click.prevent="ShowApplicatins('{{$Mobile_No}}')">
                <img src="\digital/cyber/photo_gallery\customer-insight.png" alt="" >
                <div class="sec-data">
                    <p class="section-heading">Applied Services</p>
                    <p class="section-value">Total {{$count_app}} Services</p>
                    <p class="section-pre-values">Deleted {{$app_deleted}} Applications</p>
                </div>
            </a>

            <div class="right-menu-section">
                <img src="\digital/cyber/photo_gallery\customer-insight-2.png" alt="" >
                <div class="sec-data">
                    <p class="section-heading">Applications Deliverd</p>
                    <p class="section-value">Delivered : {{$app_delivered}}</p>
                    <p class="section-pre-values">Pending {{$app_pending}}</p>
                </div>
            </div>

            <div class="right-menu-section">
                <img src="../storage/app/{{$Profile_Image}}" alt="" >
                <div class="sec-data">
                    <p class="section-heading">Revenue Earned</p>
                    <p class="section-value">Payble &#x20B9; {{$total}}/-</p>
                    <p class="section-pre-values">Paid <span> &#x20B9;{{$paid}}</span> Balance <span> &#x20B9;{{$balance}}</span></p>
                    <p class="section-pre-values"></p>
                </div>
            </div>
        </div>
        <div class="form-data-container">
            <div class="form-data">

                <form action=""  wire:submit.prevent="Update('{{$Id}}')">
                    @csrf
                     <!-- Cleint Id  -->
                  <div class="row">
                    <div class="col-45">
                        <label class="label" for="Cleint_Id">Client ID</label>

                    </div>
                    <div class="col-55">
                        <label class="imp-label" for="Cleint_Id">{{$Client_Id}}</label>
                    </div>
                </div>
                    <!-- Customer Id  -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" for="Customer_ID">Application ID</label>

                        </div>
                        <div class="col-55">
                            <label class="imp-label" for="Customer_ID">{{$App_Id}}</label>
                        </div>
                    </div>

                    <!-- Application Type -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" for="Application">Application</label>
                        </div>
                        <div class="col-55">
                        <div class="md-form">
                            <select class="form-control" id="Application" name="Application" wire:model = "MainService">
                                <option value="{{$Application}}" selected>{{$Application}}</option>
                                @foreach($MainServices as $Service)
                                <option value="{{ $Service->Id }}">
                                    {{ $Service->Name}}</option>
                                @endforeach
                            </select>
                            <span class="error">@error('MainService'){{$message}}@enderror</span>
                        </div>
                        </div>
                    </div>
                    <!-- Application Type -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" for="Application">Application</label>
                        </div>
                        <div class="col-55">
                        <div class="md-form">
                            <select class="form-control" id="Application" name="Application" wire:model = "SubService">
                                <option value="{{$Application_Type}}" selected>{{$Application_Type}}</option>
                                @foreach($SubServices as $service)
                                <option value="{{ $service->Name }}">{{ $service->Name}}</option>
                                @endforeach
                            </select>
                            <span class="error">@error('SubService'){{$message}}@enderror</span>
                        </div>
                        </div>
                    </div>
                    <!-- Name -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" for="Name">Name</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input type="text" id="Name" name="Name" class="form-control"
                                wire:model.lazy = "Name"   />
                                <span class="error">@error('Name'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
                    <!-- Mobile No -->
                    <div class="row">
                        <!-- Material input -->
                        <div class="col-45">
                            <label for="Mobile_No">Mobile_No</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input type="number" id="Mobile_No" name="Mobile_No" class="form-control"
                                wire:model = "Mobile_No" >
                                <span class="error">@error('Mobile_No'){{$message}}@enderror</span>
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
                                <input type="date" id="DOB" name="DOB" class="form-control"  wire:model = "Dob" >
                                <span class="error">@error('Dob'){{$message}}@enderror</span>
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
                                <input type="text" id="Ack_No" name="Ack_No" class="form-control"
                                wire:model.lazy = "Ack_No" >
                                @if ($Ack!='Not Available')
                                    <a href="{{ url('download_ack') }}/{{$Id}}">Dowload Ack</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($Ack_No !='Not Available' )
                    <div class="row"> {{--Ack File--}}
                        <div class="col-45">
                            <label for="Thumbnail">Upload Ack File</label> <span class="important">*</span>
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
                            @if ($Doc!='Not Available')
                                    <a href="{{ url('download_doc') }}/{{$Id}}">Dowload Ack</a>
                            @endif
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
                <div class="row">
                    <div class="col-45">
                        <label for="Document_Name">Do you Have Profile Image?</label>
                    </div>
                    <div class="col-20">
                        <!-- Default radio -->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" wire:model="Pro_Yes" value="on" />
                            <label class="form-check-label" for="flexRadioDefault1"> Yes </label>
                        </div>
                     </div>
                     <div class="col-20">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2"  wire:model="Pro_Yes" value="off" checked />
                            <label class="form-check-label" for="flexRadioDefault2"> No</label>
                        </div>
                    </div>
                </div>
                @if ($Pro_Yes == 'on')

                <div class="row"> {{--Upload File--}}
                    <div class="col-45">
                        <label for="Profile_Image">Profile Image </label> <span class="important">*</span>
                    </div>

                    <div class="col-55">
                        <div class="md-form">
                            <input class="form-control " id="formFileSm" type="file"  wire:model="Profile_Image"  name="Document_Name" placeholder="Pdf"
                            accept="image/jpeg, image/png, />
                            <span class="error">@error('Profile_Image'){{$message}}@enderror</span>
                        </div>
                    </div>

                </div>
                @endif

            </div>
            <div class="form-data">
                    @if ($Pro_Yes == 'on')
                    <div wire:loading wire:target="Profile_Image">Uploading Profile Image...</div>
                        @if (!is_null($Profile_Image))
                        <div class="row">
                            <div class="col-100">
                                <img class="profile_image" src="{{ $Profile_Image->temporaryUrl() }}"" alt="Thumbnail" />
                            </div>
                        </div>
                        @endif
                    @endif
                <!-- Received Date -->
                <div class="row">
                    <!-- Material input -->
                    <div class="col-45">
                        <label for="Received_Date">Received Date</label> <span class="important">*</span>
                    </div>
                    <div class="col-55">
                        <div class="md-form">
                            <input type="date" id="Received_Date" name="Received_Date" class="form-control"  wire:model = "Received_Date" >
                            <span class="error">@error('Received_Date'){{$message}}@enderror</span>
                        </div>
                    </div>
                </div>
                <!-- Applied Date -->
                <div class="row">
                    <!-- Applied_Date -->
                    <div class="col-45">
                        <label for="Applied_Date">Applied Date</label> <span class="important">*</span>
                    </div>
                    <div class="col-55">
                        <div class="md-form">
                            <input type="date" id="Applied_Date" name="Applied_Date" class="form-control"  wire:model = "Applied_Date" >
                            <span class="error">@error('Applied_Date'){{$message}}@enderror</span>
                        </div>
                    </div>
                </div>
                <!-- Status List -->
                <div class="row">
                    <div class="col-45">
                        <label class="label" for="Payment_Mode">Status</label> <span
                            class="important">*</span>
                    </div>
                    <div class="col-55">
                        <select class="form-control" id="Status" name="Status" wire:model="Status">
                            <option  value="{{$Status}}">{{$Status}}</option>
                            @foreach ($StatusList as $Status)
                            <option value="{{ $Status->Status }}">{{ $Status->Status }}</option>
                            @endforeach
                        </select>
                        <span class="error">@error('Status'){{$message}}@enderror</span>
                    </div>
                </div>

                <div class="row"> {{--Total_Amount--}}
                    <div class="col-45">
                        <label for="Total_Amount">Total Amount</label> <span class="important">*</span>
                    </div>
                    <div class="col-20">
                        <div class="md-form">
                            <input type="number" id="amount" wire:model="Total_Amount"  name="Total_Amount" class="form-control" placeholder="Total" pattern="[0-9]" readonly>
                            <span class="error">@error('Total_Amount'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="col-20">
                        <div class="md-form">
                            <input type="number" id="paid"  wire:model="Amount_Paid"  name="Amount_Paid" class="form-control" placeholder="Paid" pattern="[0-9]" onblur="balance()">
                        </div>
                    </div>
                    <div class="col-20">
                        <div class="md-form">
                            <input type="number" id="bal" name="Balance" class="form-control"
                            wire:model = "Balance"  pattern="[0-9]" readonly>
                            <span class="error">@error('Balance'){{$message}}@enderror</span>
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
                        <select class="form-control" id="PaymentMode" name="PaymentMode" wire:model="PaymentModes">
                            <option  value="{{$PaymentMode}}">{{$PaymentMode}}</option>
                            @foreach ($Payment_Modes as $payment_mode)
                            <option value="{{ $payment_mode->Payment_Mode }}">{{ $payment_mode->Payment_Mode }}</option>
                            @endforeach
                        </select>
                        @if ($Pay!='Not Available')
                        <a href="{{ url('download_pay') }}/{{$Id}}">Dowload Ack</a>
                        @endif
                        <span class="error">@error('Payment_Mode'){{$message}}@enderror</span>
                    </div>
                </div>
                @if ($PaymentModes!='Cash')
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
                <!-- Updated Date -->
                <div class="row">
                    <!-- Material input -->
                    <div class="col-45">
                        <label for="Updated_Date">Updated Date</label> <span class="important">*</span>
                    </div>
                    <div class="col-55">
                        <div class="md-form">
                            <input type="date" id="Updated_Date" name="Updated_Date" class="form-control"  wire:model = "Updated_Date" >
                            <span class="error">@error('Updated_Date'){{$message}}@enderror</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-45">
                        <label for="Document_Name">Do you want to Upload Files?</label>
                    </div>
                    <div class="col-20">
                        <!-- Default radio -->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" wire:model="Doc_Yes" value="on" />
                            <label class="form-check-label" for="flexRadioDefault1"> Yes </label>
                        </div>
                     </div>
                     <div class="col-20">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2"  wire:model="Doc_Yes" value="off" checked />
                            <label class="form-check-label" for="flexRadioDefault2"> No</label>
                        </div>
                    </div>
                </div>
                @if ($Doc_Yes == 'on')

                <div class="row"> {{--Upload File--}}
                    <div class="col-45">
                        <label for="Document_Name">Upload File </label> <span class="important">*</span>
                    </div>

                    <div class="col-41">
                        <div class="md-form">
                            <input type="text" name="Doc_Name" id="" placeholder="Document Name" class="form-control form-control-sm" required wire:model="Doc_Name">
                            <input class="form-control form-control-sm width-40" id="formFileSm" type="file"  wire:model="Document_Name"  name="Document_Name" placeholder="Pdf"
                            accept="image/jpeg, image/png, application/pdf"/>
                            <span class="error">@error('Document_Name'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="col-0">
                        <div class="md-form">
                            <a href="#" wire:click.prevent="AddNewText({{$i}})" name="add"
                            class="btn btn-primary btn-rounded btn-sm">Add</a>
                        </div>
                    </div>

                </div>
                @foreach ($NewTextBox as $item => $value)
                    <div class="row"> {{--Thumbnail--}}
                        <div class="col-45">
                            <label for="Doc_Names">Upload File : {{$n++}} </label> <span class="important">*</span>
                        </div>
                        <div class="col-45">
                            <div class="md-form">
                                <input type="text" name="Doc_Names" id="Doc_Names" placeholder="Document Name" class="form-control form-control-sm " wire:model="Doc_Names.{{$value}}" required>
                                <input type="file"  wire:model="Document_Files.{{$value}}"  name="Document_Files"  id="Document_Files" class="form-control form-control-sm width-40"   accept="image/jpeg, image/png, application/pdf">
                                <span class="error">@error('Document_Files'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="col-0">
                            <div class="md-form">
                                <a href="#" wire:click.prevent="Remove('{{$value}}')" name="add"
                                class="btn btn-danger btn-rounded btn-sm">x</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
            </div>
        </div>
        <div class="form-data-buttons">
            <!-- Submitt Buttom -->
            <div class="row">
                <div class="col-100">
                    <button type="submit" value="submit" name="submit"
                    class="btn btn-success btn-rounded btn-sm">Update</button>
                    <a href="{{url("open_app")}}/{{$App_Id}}" class="btn btn-secondary btn-rounded btn-sm ">Back</a>

                    <a href="{{url("app_home")}}" class="btn btn-rounded btn-sm">Cancel</a>
                </div>
            </div>
        </div>
        </form>
        <!-- Right Section -->


    <!-- Table List Code  -->

    </div>
    @if (count($Doc_Files)>0)
        <div class="table-container width-50" >
                        <div class="table-information">
                <span class="info-text">Available Documents </span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th >Sl.No</th>
                        <th>Name</th>
                        <th>Download</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Doc_Files as $File)
                  <tr>
                        <td >{{ $n++ }}</td>
                        <td>{{ $File->Document_Name }}</td>
                        <td>
                            <a class="btn btn-success btn-sm "
                                onclick="confirm('Are You Sure!? You Want to Download this file?')||event.stopImmediatePropagation()" href='{{ url('download_docs') }}/{{$File->Id}}'>Download</a>
                        </td>
                        <td>
                            <a class="btn btn-info btn-sm  "
                                onclick="confirm('Are You Sure!? You Want to Delete this file?')||event.stopImmediatePropagation()"  wire:click.prevent="Delete_Doc('{{$File->Id}}')" >Delete</a>
                        </td>

                    </tr>

                    @endforeach
                </tbody>
            </table>
            <span>
            </span>
        </div>
    @endif
</div>
