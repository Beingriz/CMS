<div >
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{$ServName}}  Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Digital Cyber</a></li>
                        <li class="breadcrumb-item active">Services Board</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{url('home_dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('admin_home')}}">Admin</a></li>
            <li class="breadcrumb-item"><a href="{{url('app_form')}}">New Application</a></li>
        </ol>
    </div>
    <div class="data-table-header">
        <p class="heading"> {{$ServName}}  Dashboard</p>
    </div>
    @if (session('SuccessMsg'))
                <span class="dynamic-success">{{session('SuccessMsg')}}</span>
            @endif
    <div class="row">
         @foreach ($SubServices as $item)
            <a href="#" class="col-xl-3 col-md-10" wire:click.prevent="ChangeService('{{$item->Name}}')">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate text-primary font-size-20 mb-2">{{$item->Name}}
                                <p class="text-muted mb-0"><span class="text-dark fw-bold font-size-15 me-2"><i class="dripicons-folder"></i>App : {{$item->Total_Count}}</span></p>
                        </div>

                        <div>
                            <img src="{{$item->Thumbnail}}"  class="rounded-circle avatar-md">
                        </div>

                        </div>
                    </div>
                </div>
            </a>
            @endforeach
    </div>



            <div class="dynamic-table-header">
                <p class="dynamic-heading"> Status of {{$Serv_Name}} , {{$Sub_Serv_Name}} | Status Board</p>
            </div>

            <div class="row">
            @if ($temp_count>0)
            @foreach ($status as $item)
            <a href="#" class="col-xl-3 col-md-10" wire:click.prevent="ShowDetails('{{$item->Status}}')">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate text-primary font-size-20 mb-2">{{$item->Status}}
                                <p class="text-muted mb-0"><span class="text-dark fw-bold font-size-15 me-2"><i class="dripicons-folder"></i>{{$item->Temp_Count}}</span></p>
                        </div>

                        <div>
                            <img src="../{{$item->Thumbnail}}"  class="rounded-circle avatar-md">
                        </div>

                        </div>
                    </div>
                </div>
            </a>
            @endforeach
            @endif
        </div>

{{-- ------------------------------------------------------------------------------------ --}}
@if ($count>0)
<div class="row">
    @if (!empty($StatusDetails))
    <div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Applicaiton with Deatails of {{$Sub_Serv_Name}} ,{{$status_name}}  </h4>
            {{-- <p class="card-title-desc">Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p> --}}

            <div class="table-responsive">
                <table class="table table-bordered mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th >Date</th>
                            <th>Name</th>
                            <th>Mobile No</th>
                            <th>Application</th>
                            <th>Service Type</th>
                            <th>Ack. No</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Balance &#x20B9;</th>
                            <th>Change Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($StatusDetails as $data)
                        <tr>
                            <td>
                                {{ $n++ }}
                            </td>
                            <td  >{{ $data->Received_Date }}</td>
                            <td   >{{ $data->Name }}</td>
                            <td   >{{ $data->Mobile_No }}</td>
                            <td   >{{ $data->Application }}</td>
                            <td   >
                                <select name="ChangeStatus" id="ChangeStatus" class="form-control-sm form-control" wire:change="UpdateServiceType('{{$data->Id}}','{{$data->Application_Type}}',$event.target.value)">
                                    <option value="{{ $data->Application_Type }}">{{ $data->Application_Type }}</option>
                                    @foreach ($SubServices as $item)
                                        <option value="{{$item->Name}}">{{$item->Name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td   >{{ $data->Ack_No }}</td>
                            <td   >{{ $data->Total_Amount }}</td>
                            <td   >{{ $data->Amount_Paid }}</td>

                            <td   >{{ $data->Balance }}</td>
                            <td   >
                                <select name="ChangeStatus" id="ChangeStatus" class="form-control-sm form-control" wire:change="UpdateStatus('{{$data->Id}}','{{$data->Status}}',$event.target.value)">
                                    <option value="{{ $data->Status }}">{{ $data->Status }}</option>
                                    @foreach ($status as $status_list)
                                        <option value="{{$status_list->Status}}">{{$status_list->Status}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td   >

                                <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupVerticalDrop1" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                            <a class="dropdown-item" href='/digital/cyber/open_app/{{ $data->Id }}'>Open</a>
                                            <a class="dropdown-item" href='/digital/cyber/edit_app/{{ $data->Id }}'>Edit</a>
                                        </div>
                                    </div>

                                </div>
                            </td>

                        </tr>

                        @endforeach
                    </tbody>
                    @endif
                </div>
                @endif
                </table>
            </div>

        </div>
    </div>
</div>





















{{-- ------------------------------ --}}
            {{-- @if ($count>0)
            <div class="row">
                @if (!empty($StatusDetails))
                    <div class="row"></div>
                    <div class="table-header">
                        <p class="heading2">Applicaiton with Deatails of {{$Sub_Serv_Name}} ,{{$status_name}}  </p>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th >Sl.No</th>
                                <th >Date</th>
                                <th>Name</th>
                                <th>Mobile No</th>
                                <th>Application</th>
                                <th>Service Type</th>
                                <th>Ack. No</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Balance &#x20B9;</th>
                                <th>Change Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($StatusDetails as $data)
                            <tr>
                                <td   >
                                    {{ $n++ }}
                                </td>
                                <td   >{{ $data->Received_Date }}</td>
                                <td   >{{ $data->Name }}</td>
                                <td   >{{ $data->Mobile_No }}</td>
                                <td   >{{ $data->Application }}</td>
                                <td   >
                                    <select name="ChangeStatus" id="ChangeStatus" class="form-control-sm form-control" wire:change="UpdateServiceType('{{$data->Id}}','{{$data->Application_Type}}',$event.target.value)">
                                        <option value="{{ $data->Application_Type }}">{{ $data->Application_Type }}</option>
                                        @foreach ($SubServices as $item)
                                            <option value="{{$item->Name}}">{{$item->Name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td   >{{ $data->Ack_No }}</td>
                                <td   >{{ $data->Total_Amount }}</td>
                                <td   >{{ $data->Amount_Paid }}</td>

                                <td   >{{ $data->Balance }}</td>
                                <td   >
                                    <select name="ChangeStatus" id="ChangeStatus" class="form-control-sm form-control" wire:change="UpdateStatus('{{$data->Id}}','{{$data->Status}}',$event.target.value)">
                                        <option value="{{ $data->Status }}">{{ $data->Status }}</option>
                                        @foreach ($status as $status_list)
                                            <option value="{{$status_list->Status}}">{{$status_list->Status}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td   >
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
                                                        href='/digital/cyber/open_app/{{ $data->Id }}'>Open</a>
                                                </li>
                                                <li><a class="dropdown-item "
                                                        href='/digital/cyber/edit_app/{{ $data->Id }}'>Edit</a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            @endif --}}






            {{-- Applicaiton Insight --}}
            <div class="dashboard-insight">
                <div class="right-menu-section">
                    <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                    <div class="sec-data">
                        <p class="section-heading">Prime Service</p>
                        <p class="section-value">Service Name</p>
                        <p class="section-pre-values">Application Count </p>
                    </div>
                </div>
                <div class="right-menu-section">
                    <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                    <div class="sec-data">
                        <p class="section-heading">Montly Revenue</p>
                        <p class="section-value">Total Amount</p>
                        <p class="section-pre-values">Balance Due</p>
                    </div>
                </div>
                <div class="right-menu-section">
                    <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                    <div class="sec-data">
                        <p class="section-heading">Delivered</p>
                        <p class="section-value">Total</p>
                        <p class="section-pre-values">This Month</p>
                    </div>
                </div>
                <div class="right-menu-section">
                    <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                    <div class="sec-data">
                        <p class="section-heading">Pending</p>
                        <p class="section-value">Total </p>
                        <p class="section-pre-values">This Month</span></p>
                    </div>
                </div>

            </div>
            <div class="row"></div>
            {{-- Application Book Marks BookMarks --}}
            @if (count($bookmarks)>0)
            <div class="data-table-header">
                <p class="heading">Bookmarks for {{$Serv_Name}} </p>
            </div>
            <div class="row"></div>
            <div class="border">
                <div class="bookmark-container">

                    @foreach($bookmarks as $bookmark)
                    <a href="{{ $bookmark->Hyperlink }}" target="_blank" class="bookmark">
                        <img class="b-img" src="../{{$bookmark->Thumbnail}}" alt="Bookmark Icon">
                        <p class="b-name" >{{$bookmark->Name}}</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

</div>
