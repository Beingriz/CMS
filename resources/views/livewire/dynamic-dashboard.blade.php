<div >
    <div class="data-table-header">
        <p class="heading"> {{$ServName}}  Dashboard | Services Board</p>
    </div>
    <div class="row"></div>
        <div class="border">
            @foreach ($SubServices as $item)
                <section class="dashboard">
                    <a href="#" class="section" wire:click.prevent="ChangeService('{{$item->Name}}')">
                        <div class="dynamic-sec-header">
                            <div class="dynamc-sec-icon">
                                <img src="../{{$item->Thumbnail}}" alt="">
                            </div>
                            <div class="dynamic-sec-info">
                                <div class="dynamic-sec-heading">
                                    <p>{{$item->Name}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="sec-footer">
                            <p class="dynamic-sec-footer" style="color: green">{{$item->Total_Count}}</p>
                        </div>
                    </a>
            @endforeach
                </section>
        </div>
            <div class="row"></div>
            @if (session('SuccessMsg'))
                <span class="dynamic-success">{{session('SuccessMsg')}}</span>
            @endif
                <div class="row"></div>

            <div class="dynamic-table-header">
                <p class="dynamic-heading"> Status of {{$Serv_Name}} , {{$Sub_Serv_Name}} | Status Board</p>
            </div>

            @if ($temp_count>0)
                <div class="border">
                    @foreach ($status as $item)
                    <section class="dashboard" >
                        <a href="#" class="section" wire:click.prevent="ShowDetails('{{$item->Status}}')">
                            <div class="dynamic-sec-header">
                                <div class="dynamc-sec-icon">
                                    <img src="../{{$item->Thumbnail}}" alt="">
                                </div>
                                <div class="dynamic-sec-info">
                                    <div class="dynamic-sec-heading">
                                        <p>{{$item->Status}}</p>
                                    </div>

                                </div>
                            </div>
                            <div class="dynamic-sec-footer">
                                <p class="dynamic-sec-footer">{{$item->Temp_Count}}</p>
                            </div>
                        </a>
                        @endforeach
                    </section>
                </div>
            @endif

            @if ($count>0)
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
                                <td class="show">
                                    {{ $n++ }}
                                </td>
                                <td class="show">{{ $data->Received_Date }}</td>
                                <td class="show">{{ $data->Name }}</td>
                                <td class="show">{{ $data->Mobile_No }}</td>
                                <td class="show">{{ $data->Application }}</td>
                                <td class="show">
                                    <select name="ChangeStatus" id="ChangeStatus" class="form-control-sm form-control" wire:change="UpdateServiceType('{{$data->Id}}','{{$data->Application_Type}}',$event.target.value)">
                                        <option value="{{ $data->Application_Type }}">{{ $data->Application_Type }}</option>
                                        @foreach ($SubServices as $item)
                                            <option value="{{$item->Name}}">{{$item->Name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="show">{{ $data->Ack_No }}</td>
                                <td class="show">{{ $data->Total_Amount }}</td>
                                <td class="show">{{ $data->Amount_Paid }}</td>

                                <td class="show">{{ $data->Balance }}</td>
                                <td class="show">
                                    <select name="ChangeStatus" id="ChangeStatus" class="form-control-sm form-control" wire:change="UpdateStatus('{{$data->Id}}','{{$data->Status}}',$event.target.value)">
                                        <option value="{{ $data->Status }}">{{ $data->Status }}</option>
                                        @foreach ($status as $status_list)
                                            <option value="{{$status_list->Status}}">{{$status_list->Status}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="show">
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
            @endif
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
