<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Details  for {{$search}} </h4>

                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('SuccessMsg')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('SuccessUpdate'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{session('SuccessUpdate')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('Error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session('Error')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Digital Cyber</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('new_application')}}">New Form</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('add_services')}}">Services</a></li>
            <li class="breadcrumb-item"><a href="{{url('add_status')}}">Status</a></li>
            <li class="breadcrumb-item"><a href="{{route('update_application')}}">Update</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}
    <div class="row">{{-- Start of Insight Row --}}
        <div class="col-xl-3 col-md-10" >
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">

                        {{-- <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fas fa-edit"></i></i>
                            </span>
                        </div> --}}
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-primary font-size-20 mb-2">Services</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5>Applied {{$Service_Count}}</h5>
                                    <p class="mb-2 text-truncate">Pending {{$Pending_App}} Applications</p>
                                </div>
                            </div>
                        </div>
                        <img class="rounded avatar-md" src="{{asset('storage/no_image.jpg')}}" alt="no_image" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">

                        {{-- <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fas fa-edit"></i></i>
                            </span>
                        </div> --}}
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-info font-size-20 mb-2">Delivery Report</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5>{{$Delivered}} Delivered</h5>
                                    <p class="mb-2 text-truncate">{{$Pending_App}} Under Process</span></p></p>
                                </div>
                            </div>
                        </div>
                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{url('storage/no_image.jpg')}}" alt="Generic placeholder image">


                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-success font-size-20 mb-2">Revenue</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5>Amount &#x20B9;{{$Revenue}}/-</h5>
                                    <p class="mb-2 text-truncate text-danger">Balance <span> &#x20B9;{{$Balance}}</span></p></p>
                                </div>
                            </div>
                        </div>

                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{ url('storage/no_image.jpg')}}" alt="Insight">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">

                        {{-- <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fas fa-edit"></i></i>
                            </span>
                        </div> --}}
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-danger font-size-20 mb-2">Balance Due</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5>Payble &#x20B9; {{$Balance}}/-</h5>
                                    <p class="mb-2 text-truncate">Received <span> &#x20B9;{{$Revenue}}</span></p></p>
                                </div>
                            </div>
                        </div>

                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{ url('storage/no_image.jpg')}}" alt="Insight">

                    </div>
                </div>
            </div>
        </div>
        @if (($Search_Count) == 0)
        <div class="header" style="text-align:center">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="mdi mdi-block-helper me-2"></i>
                Sorry No Service Record Available for {{$search}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <br>
        @elseif (count($Registered)==0)
        <div class="header" style="text-align:center">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="mdi mdi-alert-outline me-2"></i>
                Unregistered Client!. Please Register.. {{$search}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
            <br>
        @endif

        @if (count($Registered)>0)
            @if ($Registered_Count>1)
            <p >
                <h5 class="text-muted">{{$Registered_Count}} Registered Clients Available for Search Result of : {{$search}}</h5>
            </p>

            @endif
            <div class="col-lg-12">{{-- Registered Client Table --}}
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Registered Client Details for search result of <span class="text-primary"><strong>{{($Name)}}</strong></span> </h4>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Relative_Name</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>Profile</th>
                                        <th>Registered</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Registered as $item)
                                    <tr>
                                        <td>{{$n++}}</td>
                                        <td>{{$item['Id']}}</td>
                                        <td>{{$item['Name']}}</td>
                                        @if (is_null($item['Relative_Name']))
                                        <td>Not Available</td>
                                        @else
                                        <td>{{$item['Relative_Name']}}</td>
                                        @endif
                                        @if (is_null($item['DOB']))
                                        <td>Not Available</td>
                                        @else
                                        <td>{{$item['DOB']}}</td>
                                        @endif



                                        @if (is_null($item['Gender']))
                                        <td>Not Available</td>
                                        @else
                                        <td>{{$item['Gender']}}</td>
                                        @endif
                                        <td>{{$item['Mobile_No']}}</td>
                                        @if (is_null($item['Address']))
                                        <td>Not Available</td>
                                        @else
                                        <td>{{$item['Address']}}</td>
                                        @endif
                                        <td>  <img src="{{ (!empty($Old_Profile_Image))?url('storage/'.$$item['Profile_Image']):url('storage/no_image.jpg')}} " alt="avatar-4" class="rounded-circle avatar-md">
                                        <td>{{ \Carbon\Carbon::parse($item['created_at'])->diffForHumans() }}</td>

                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary font-size-15" id="update"><i class="mdi mdi-account-arrow-left-outline" ></i></a>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            @endif
    </div>
    @if ($Search_Count>0)
        <div class="header"  style="text-align: center">
            <h4>{{$Search_Count}} Search Result Found</h4>
        </div>
        <div class="row">{{-- Start of Balance Details Row --}}
            @if (count($Balance_Collection)>0)
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Bordered Table</h4>
                            <p class="card-title-desc">Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p>

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">

                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Description</th>
                                            <th>Total</th>
                                            <th>Amount Paid</th>
                                            <th>Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Balance_Collection as $item)
                                        <tr>
                                            <td style="width:10%">{{$item['Id']}}</td>
                                            <td style="width:40%">{{$item['Description']}}</td>
                                            <td style="width:10%">&#x20B9; {{$item['Total_Amount']}}</td>
                                            <td style="width:10%">&#x20B9; {{$item['Amount_Paid']}}</td>
                                            <td style="width:10%">&#x20B9; {{$item['Balance']}}</td>
                                            <td style="width:20%">
                                                <a  href="#" onclick="confirm('Do you Want to Clear the Balance of &#x20B9;{{$item['Balance']}}? ') || event.stopImmediatePropagation()" wire:click.prevent="ClearBalanceDue('{{$item['Id']}}','{{$item['Client_Id']}}')" >Clear Balance</a>
                                                <br>
                                                <a  href="#" wire:click.prevent="MoveRecycle('{{$item['Id']}}','{{$item['Client_Id']}}')" >Move to Recycle</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <div class="header" style="text-align:center">
                                            <span class="important"> Balance Due Found for This ID : {{$item->Id}} Records!. Total Balance Due : &#x20B9;{{$Balance_Collection->sum('Balance') }}</span>
                                        </div>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="row"> {{-- Start of Search Result Details Row --}}
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Search Result</h4>
                        <div class="filter-bar">
                            <div class="d-flex justify-content-between align-content-center mb-2">
                                <div class="d-flex">
                                    <div>
                                        <div class="d-flex align-items-center ml-4">
                                            @if ($Checked)
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupVerticalDrop2" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Cheched ({{count($Checked)}})<i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                                    <li><a class="dropdown-item" onclick="confirm('Are you sure you want to Move these records to Recycle Bin?') || event.stopImmediatePropagation()" wire:click="MultipleDelete()">Delete</a>
                                                    </li>
                                                </div>
                                            </div>
                                            @endif

                                            <label for="paginate" class="text-nowrap mr-2 mb-0">Per Page</label>
                                            <select wire:model="paginate" name="paginate" id="paginate" class="form-control form-control-sm">
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                            </select>
                                            <div class="row"></div>
                                            <label for="filterby" class="text-nowrap mr-2 mb-0">Sort By</label>
                                            <input  type="text"  wire:model="filterby" class="form-control form-control-sm" placeholder="Filter">
                                            <div class="row"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">

                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Delete</th>
                                        <th >Received</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th >Application</th>
                                        <th >Services</th>
                                        <th>Ref No</th>
                                        <th >Document</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($search_data as $data)
                                    <tr>
                                        <td>{{$search_data->firstItem()+$loop->index }}</td>
                                        <td><input type="checkbox" name="checked" id="checked" value="{{$data->Id}}" wire:model="Checked"></td>

                                        <td>{{ $data->Received_Date }}</td>
                                        <td>{{ $data->Name }}</td>
                                        <td>{{ $data->Mobile_No }}</td>
                                        <td>{{ $data->Application}}</td>
                                        <td>{{$data->Application_Type}}</td>
                                        <td>{{ $data->Ack_No }}</td>
                                        <td>{{ $data->Document_No }}</td>
                                        <td>{{ $data->Status }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupVerticalDrop1" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    @if ($data->Registered == 'No')
                                                        Register <i class="mdi mdi-shield-account"></i>
                                                        @elseif($data->Registered == 'Yes')
                                                        Edit    <i class="mdi mdi-square-edit-outline"></i>
                                                        @endif

                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">

                                                    @if ($data->Registered == 'No')
                                                    <li><a class="dropdown-item" title="Registration"  onclick="confirm('Are you sure you want Register. Mr /Mrs : {{$data->Name}} , for  Mobile No : {{$data->Mobile_No}} ?') || event.stopImmediatePropagation()" wire:click="Register('{{$data->Id}}')" >Register</a>
                                                    </li>
                                                    @endif
                                                    <a class="dropdown-item" title="View Applicaiton" href="#">View</a>
                                                    <a class="dropdown-item btn-primary" id="update" title="Edit Applicaiton" href="{{route('edit_application',$data->Id)}}">Edit</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>

                            </table>
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                <p class="text-muted">Showing {{count($search_data)}} of {{$search_data->total()}} entries</p>
                                </div>
                                <div class="col-md-4">
                                    <span class=" pagination pagination-rounded float-end" >
                                        {{$search_data->links()}}
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endif


</div>
