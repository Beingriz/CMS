<div> {{-- Livewire Starts. --}}
    <div class="row">{{-- Messags / Notification Row--}}
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Application Form</h4>

                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('SuccessMsg')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('SuccessUpdate'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{session('SuccessUpdate')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif



                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Update</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('new_application')}}">New Form</a></li>
            <li class="breadcrumb-item"><a href="{{route('update_application')}}">Update</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    <div class="row">{{--Mobile No Field Row --}}
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><strong class="text-info">{{$C_Name}}</strong>  Application </h4>
                </div>
                <div class="card-body">
                    <form action="">
                        @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                            <label class="form-label" for="progress-basicpill-phoneno-input">Phone No</label>
                                <input type="number" class="form-control" placeholder="Mobile Number" id="progress-basicpill-phoneno-input" wire:model.debounce.600ms="Mobile_No">
                                @error('Mobile_No') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <a href="#" class="btn btn-primary waves-effect waves-light" wire:click="Search('{{$Mobile_No}}')">Search</a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>{{-- End of Row Mobile No . --}}

    <div class="row">{{-- Start of Search Result Row. --}}
        @if($Records_Show == 'Enable')
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{$AppliedServices->total()}}  Records for {{$C_Mob}} of {{$C_Name}}</h5>
                </div>
            <div class="row no-gutters align-items-center">
                    <div class="col-md-8">
                        <div class="card-body">

                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                            <p class="card-text"><small class="text-muted">Last Application Applied  {{$lastMobRecTime}}</small></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if (!empty($Client_Image))
                    <img class="rounded-circle avatar-lg"  src="{{$Client_Image->temporaryUrl() }}" alt="Client Profile">
                    @else
                    <img class="rounded-circle avatar-lg" src="{{ (!empty($Old_Profile_Image))?url('storage/'.$Old_Profile_Image):url('storage/no_image.jpg')}} " alt="Card image cap">
                    @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12" >
                        <table id="datatable" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"role="grid" aria-describedby="datatable_info">
                        <thead class="table-light">
                            <tr>
                                <div class="d-flex flex-wrap gap-2">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <label class="form-label" for="paginate">Show Pages</label>
                                        </div>
                                        <div class="col-sm-5">
                                            <select name="datatable_length"  wire:model="paginate" aria-controls="datatable" class="custom-select custom-select-sm form-control form-control-sm form-select form-select-sm">
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="form-label" for="paginate">Filter By</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input  type="text"  wire:model="filterby" class="form-control form-control-sm" placeholder="Filter">
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>R.Date</th>
                                <th>Name</th>
                                <th>Service</th>
                                <th>Ack. No</th>
                                <th>Doc. No</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                            <tbody>

                                @foreach ($AppliedServices as $key)
                                <tr>
                                <tr class='{{$key->Class}}' >
                                    <td>{{$AppliedServices->firstItem()+$loop->index}}</td>
                                    <td>{{$key->Received_Date}}</td>
                                    <td>{{$key->Name}}</td>
                                    <td>{{$key->Application , $key->Application_Type}}</td>
                                    @if (!empty($key->Ack_No))
                                    <td>{{$key->Ack_No}}
                                    </td>
                                    @else
                                    <td>Not Available</td>
                                    @endif
                                    @if (!empty($key->Document_No))
                                    <td>{{$key->Document_No}}</td>
                                    @else
                                    <td>Not Available</td>
                                    @endif
                                    <td>{{$key->Status}}</td>
                                    <?php
                                    $Id = $key->Id
                                    ?>
                                    <td>
                                        <a href="{{route('edit_application',$Id)}}" class="btn btn-sm btn-primary font-size-15" id="update"><i class="mdi mdi-book-open-page-variant" ></i></a>
                                        <a href="#" class="btn btn-sm btn-danger font-size-15" id="delete"><i class="mdi mdi-delete-outline" ></i></a>
                                        <a href="#" class="btn btn-sm btn-primary font-size-15" id="open"><i class="mdi mdi-book-open-page-variant" ></i></a>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-8">
                            <p class="text-muted">Showing {{count($AppliedServices)}} of {{$AppliedServices->total()}} entries</p>
                            </div>
                            <div class="col-md-4">
                                <span class=" pagination pagination-rounded float-end" >
                                    {{$AppliedServices->links()}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    </div>{{-- End of Search Result Row . --}}



</div> {{-- End of Livewire. --}}
