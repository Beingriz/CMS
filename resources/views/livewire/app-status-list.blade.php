<div>
    <div class="table-container">
        <div class="data-table-header">
            <!-- <img src=" img/income.png" alt="Application_image" class="header-image"> -->
            <p class="heading">{{$ChangeStatus}} Applications</p>
        </div>
        <div class="table-information">
                <span class="info-text"> {{$sl_no}} Applications {{$ChangeStatus}}  as on {{ date("d-m-Y") }}</span>
                <br><span>Total Revenue of &#x20B9; {{$total_revenue}} Generated</span>
                <br><span>Balance Due of &#x20B9; {{$Balance}} To be Received</span>
                <br><span class="info-text">Applications Found {{$sl_no}}</span>
                <br>
                @if (session('SuccessMsg'))
                <span class="dynamic-Success">{{session('SuccessMsg')}}</span>
                @endif
                <br>

                    <div class="filter-bar">
                        <div class="d-flex justify-content-between align-content-center mb-2">
                            <div class="d-flex">
                                <div>
                                    <div class="d-flex align-items-center ml-4">
                                        @if ($Checked_Id)
                                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <div class="btn-group btn-group-sm btn-rounded" role="group">
                                                <button id="btnGroupDrop1" type="button"
                                                    class="btn btn-danger btn-sm dropdown-toggle" data-mdb-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Cheched ({{count($Checked_Id)}})
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <li><a class=" dropdown-item" onclick="confirm('Are you sure you want to Move these records to Recycle Bin?') || event.stopImmediatePropagation()" wire:click="MultipleDelete()">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row"></div>


                                        @endif
                                        @if (count($Checked_Id)>0)
                                        <label for="date" class="text-nowrap mr-2 mb-0">Change Status of {{count($Checked_Id)}} Applications to</label>

                                        <select class="form-control form-control-sm" id="multiplestatusupdate" name="multiplestatusupdate" wire:change="MultipleStatusUpdate($event.target.value)">
                                            <option value="">---Select Status---</option>
                                            @foreach($StatusLists as $status)
                                            <option value="{{ $status->Status }}">
                                                {{  $status->Status }}</option>
                                            @endforeach
                                        </select>
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
                                        <label for="date" class="text-nowrap mr-2 mb-0">Change Staus</label>

                                        <select class="form-control form-control-sm" id="Status" name="Status" wire:model="ChangeStatus">
                                            <option value="">---Select Status---</option>
                                            @foreach($StatusLists as $status)
                                            <option value="{{ $status->Status }}">
                                                {{  $status->Status }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
         </div>

        @if (session('Error'))
        <span class="error">{{session('Error')}}</span>
        @endif
        <table>
            <thead>
                <tr>
                    <th >Sl.No</th>
                    <th >Check</th>
                    <th>Name</th>
                    <th>Mobile No</th>
                    <th>Application</th>
                    <th>Service Type</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Balance &#x20B9;</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($app_list as $data)
                <tr>
                    <td class="show">
                        {{ $n++ }}
                    </td>
                    <td><input type="checkbox" name="checked" id="checked" value="{{$data->Id}}" wire:model="Checked_Id"></td>
                    <td class="show">{{ $data->Name }}</td>
                    <td class="show">{{ $data->Mobile_No }}</td>
                    <td class="show">{{ $data->Application }}</td>
                    <td class="show">{{ $data->Application_Type }}</td>
                    <td class="show">{{ $data->Status }}</td>
                    <td class="show">{{ $data->Total_Amount }}</td>
                    <td class="show">{{ $data->Amount_Paid }}</td>
                    <td class="show">{{ $data->Balance }}</td>
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
                                            href='/digital/cyber/open_app/{{ $data->Id }}'>Open</a>
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
            {{$app_list->links()}}
        </span>
    </div>
</div>
