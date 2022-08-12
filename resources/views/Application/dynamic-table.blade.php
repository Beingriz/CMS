<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{$Serv_Name}} Applied for {{$Sub_Serv_Name}} List</h4>

            <div class="table-responsive">
                <table class="table mb-0">

                    <thead class="table-light">
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
                            <td>{{ $n++ }}</td>
                            <td>{{ $data->Received_Date }}</td>
                            <td>{{ $data->Name }}</td>
                            <td>{{ $data->Mobile_No }}</td>
                            <td>{{ $data->Application }}</td>
                            <td>
                                <select name="ChangeStatus" id="ChangeStatus" class="form-control-sm form-control" wire:change="UpdateServiceType('{{$data->Id}}','{{$data->Application_Type}}',$event.target.value)">
                                    <option value="{{ $data->Application_Type }}">{{ $data->Application_Type }}</option>
                                    @foreach ($SubServices as $item)
                                        <option value="{{$item->Name}}">{{$item->Name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>{{ $data->Ack_No }}</td>
                            <td>{{ $data->Total_Amount }}</td>
                            <td>{{ $data->Amount_Paid }}</td>

                            <td>{{ $data->Balance }}</td>
                            <td>
                                <select name="ChangeStatus" id="ChangeStatus" class="form-control-sm form-control" wire:change="UpdateStatus('{{$data->Id}}','{{$data->Status}}',$event.target.value)">
                                    <option value="{{ $data->Status }}">{{ $data->Status }}</option>
                                    @foreach ($status as $status_list)
                                        <option value="{{$status_list->Status}}">{{$status_list->Status}}</option>
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
                        </tr>
                        @endforeach
                        {{-- @endif --}}
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

