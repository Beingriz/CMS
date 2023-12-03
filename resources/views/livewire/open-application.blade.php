<div>
    <div class="form-container">
        <div class="form-header">

            <!-- <img src="img/income.png" alt="Application_image" class="header-image"> -->
        <p class="heading">Application Details of <span>{{$Name}}</span> </p>
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
                <form action="" method="POST">
                    @csrf
                      <!-- Client Id  -->
                      <div class="row">
                        <div class="col-45">
                            <label class="label" >Client ID</label>

                        </div>
                        <div class="col-55">
                            <label class="imp-label" >{{$Client_Id}}</label>
                        </div>
                    </div>
                    <!-- Application Id  -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" >Application ID</label>

                        </div>
                        <div class="col-55">
                            <label class="label-value" >{{$Id}}</label>
                        </div>
                    </div>


                    <!-- Application Type -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" >Service</label>

                        </div>
                        <div class="col-55">
                            <label class="label-value" >{{$Application}}</label>
                        </div>
                    </div>

                    <!-- Applied Date -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" >Applied Date</label>

                        </div>
                        <div class="col-55">
                            <label class="label-value" >{{$Applied_Date}}</label>
                        </div>
                    </div>

                    <!-- Mobile No -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" >Phone Number</label>

                        </div>
                        <div class="col-55">
                            <label class="label-value" >{{$Mobile_No}}</label>
                        </div>
                    </div>
                    <!-- DOB -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label">Date of Birth</label>

                        </div>
                        <div class="col-55">
                            <label class="label-value" >{{$Dob}}</label>
                        </div>
                    </div>
                    <!-- Ack No -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" >Acknowledgment</label>

                        </div>
                        <div class="col-55">
                            <a href="/digital/cyber/download_ack/{{$Id}}" class="label">{{$Ack_No}}</a>
                        </div>
                    </div>
                      <!-- Document No -->
                      <div class="row">
                        <div class="col-45">
                            <label class="label" >Document No</label>

                        </div>
                        <div class="col-55">
                            <a href="/digital/cyber/download_doc/{{$Id}}" class="label">{{$Document_No}}</a>
                        </div>
                    </div>
                    <!-- Name -->
                <div class="row">
                        <div class="col-45">
                            <label class="label" >Status</label>

                        </div>
                        <div class="col-55">
                            <label class="imp-label" >{{$Status}}</label>
                        </div>
                    </div>
                </div>
                <div class="form-data">
                <!-- Name -->
                <div class="row">
                        <div class="col-45">
                            <label class="label" >Name</label>

                        </div>
                        <div class="col-55">
                            <label class="imp-label" >{{$Name}}</label>
                        </div>
                    </div>
                    <!-- Service Type-->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" >Service Type</label>

                        </div>
                        <div class="col-55">
                            <label class="label-value" >{{$Application_Type}}</label>
                        </div>
                    </div>
                    <!-- Received Date -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" >Received Date</label>

                        </div>
                        <div class="col-55">
                            <label class="label-value" >{{$Received_Date}}</label>
                        </div>
                    </div>


                    <!-- Total Amount -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" >Total Amount</label>

                        </div>
                        <div class="col-55">
                            <label class="label-value" >{{$Total_Amount}}</label>
                        </div>
                    </div>

                    <!-- Amount Paid -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" >Amount Paid</label>

                        </div>
                        <div class="col-55">
                            <label class="label-value" >{{$Amount_Paid}}</label>
                        </div>
                    </div>
                    <!-- Balance Amount -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" >Balance</label>

                        </div>
                        <div class="col-55">
                            <label class="imp-label" >{{$Balance}}</label>
                        </div>
                    </div>
                    <!-- Payment Mode -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" >Payment Mode</label>

                        </div>
                        <div class="col-55">
                            <a href="/digital/cyber/download_pay/{{$Id}}" class="label">{{$PaymentMode}}</a>
                        </div>
                    </div>
                    <!-- Updated on -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" >Updated Date</label>

                        </div>
                        <div class="col-55">
                            <label class="label-value" >{{$Delivered_Date}}</label>
                        </div>
                    </div>
                    </div>
        </div>
        <div class="form-data-buttons">
                    <!-- Submitt Buttom -->
                    <div class="row">
                        <div class="col-100">
                            <a href="{{url("edit_app")}}/{{$Id}}" class="btn btn-success btn-sm btn-rounded">Edit</a>
                            <a href="{{ url('download_doc') }}/{{$Id}}"  class="btn btn-warning btn-sm btn-rounded">Download</a>
                            @if (count($Doc_Files)>0)
                                <a class="btn btn-info btn-sm btn-rounded" data-mdb-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" > {{count($Doc_Files)}}+ Documents
                                </a>
                            @endif

                            <a href="{{ url('app_form') }}" class="btn btn-sm btn-rounded">New</a>
                        </div>
                    </div>
                </form>
        </div>

    </div>
    <!-- Collapsed content -->
<div class="collapse mt-3" id="collapseExample">
    @if (count($Doc_Files)>0)
    <div class="table-container width-50" >
                    <div class="table-information">
            <span class="info-text"> {{count($Doc_Files)}} Available Documents </span>
        </div>
        <table>
            <thead>
                <tr>
                    <th >Sl.No</th>
                    <th>File Name</th>
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
    @if ($show == 1)
    <div class="table-container">
        <div class="form-header">
            <p class="heading"> Application List</p>
        </div>
        <div class="table-information">

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
                @foreach($show_app as $data)
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
                                    <li><a class="dropdown-item "
                                            href='/digital/cyber/edit_app/{{ $data->Id }}'>Edit</a>
                                    </li>
                                    <li><a class="dropdown-item "
                                            href='/digital/cyber/open_app/{{ $data->Id }}'>Open</a>
                                    </li>
                                    <li><a class=" dropdown-item"
                                            onclick="confirm('Are You Sure!? You Want to Delete This Record?')||event.stopImmediatePropagation" wire:click="Delete('{{$data->Id}}')">Delete</a>
                                    </li>
                                    <li><a class=" dropdown-item"
                                            href='/digital/cyber/print_ack/{{ $data->Id }}'>Print</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>

                </tr>

                @endforeach
            </tbody>
        </table>

    </div>
@endif



</div>
