<div class="col-lg-12">
    <div class="row"> {{-- Start of Search Result Details Row --}}
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">{{$StatusDetails->total()}} Search Result found. </h4>
                        <h4 class="card-title">Service : {{ !is_null($Sub_Serv_Name) ?  $Sub_Serv_Name : 'All'}} {{$StatusDetails->total()}} </h4>
                    </div>

                    <div class="filter-bar">
                        <div class="d-flex justify-content-between align-content-center mb-2">
                            <div class="d-flex">
                                <div>
                                    <div class="d-flex align-items-center ml-4">
                                        <label for="paginate" class="text-nowrap mr-2 mb-0">Per Page</label>
                                        <select wire:model="paginate" name="paginate" id="paginate" class="form-control form-control-sm">
                                            <option value="5" selected>5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
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

                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th >Date</th>
                                    <th>Name</th>
                                    <th>Mobile No</th>
                                    <th>Application</th>
                                    <th>Service Type</th>
                                    <th>Ack. No</th>
                                    <th>Doc. No</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th>Change Status</th>
                                    <th>Action</th>
                                    <th>Updated</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse( $StatusDetails as $data )
                                <tr>
                                    <td>{{ $n++ }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->Received_Date)->diffForHumans() }}</td>
                                    <td>{{ $data->Name }}</td>
                                    <td>{{ $data->Mobile_No }}</td>
                                    <td>{{ $data->Application }}</td>
                                    <td>
                                        <select name="ChangeSType" id="ChangeSType" class="form-control-sm form-control" wire:change="UpdateServiceType('{{$data->Id}}','{{$data->Application_Type}}',$event.target.value,'{{$data->Status}}')">
                                            <option selected>{{ $data->Application_Type }}</option>
                                            @foreach ($SubServices as $item)
                                                <option value="{{$item->Name}}">{{$item->Name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>{{ $data->Ack_No }}</td>
                                    <td>{{ $data->Document_No }}</td>
                                    <td>{{ $data->Total_Amount }}</td>
                                    <td>{{ $data->Amount_Paid }}</td>

                                    <td>{{ $data->Balance }}</td>
                                    <td>
                                        <select name="ChangeStatus" id="ChangeStatus" class="form-control-sm form-control" wire:change="UpdateStatus('{{$data->Id}}','{{$data->Status}}',$event.target.value,'{{$data->Application_Type}}')">
                                            <option selected>{{ $data->Status }}</option>
                                            @foreach ($status as $item)
                                                <option value="{{$item->Status}}">{{$item->Status}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>

                                        <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupVerticalDrop1" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                                    <a class="dropdown-item" title="View  Application" href='/digital/cyber/open_app/{{ $data->Id }}'>Open</a>
                                                    <a class="dropdown-item" title="Edit Application" id="update"href={{ route('edit_application',$data->Id) }}>Edit</a>
                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                    <td>{{\Carbon\Carbon::parse( $data->updated_at)->diffForHumans()}}</td>

                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="11">
                                            <img class=" avatar-xl" alt="No Result" src="{{asset('storage/no_result.png')}}">
                                            <p>No Result Found</p>
                                        </td>
                                    </tr>
                                @endforelse()
                            </tbody>

                        </table>
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-8">
                            <p class="text-muted">Showing {{count($StatusDetails)}} of {{$StatusDetails->total()}} entries</p>
                            </div>
                            <div class="col-md-4">
                                <span class=" pagination pagination-rounded float-end" >
                                    {{$StatusDetails->links()}}
                                </span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

