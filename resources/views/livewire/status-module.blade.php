<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Status</h4>

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
                        <li class="breadcrumb-item active">Status</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('new.application')}}">New Application</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> Status</h4>
                    <p class="card-title-desc">Add New Status</p>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Status Id</label>
                        <div class="col-sm-9">
                            <label for="example-text-input" >{{$Id}}</label>
                        </div>
                    </div>
                    <!-- end row -->
                    <form wire:submit.prevent="Save">
                        @csrf
                    <div class="row mb-3">
                        <label for="example-search-input" class="col-sm-3 col-form-label">Status for</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="Statusfor" wire:model="Relation" name="Relation" wire:change="Change(event.target.value)">
                                <option value="">---Select---</option>
                                <option value="General">General</option>
                                <option value="Callback">Callback</option>
                                @foreach ($MainServices as $item)
                                    <option value="{{$item->Name}}">{{$item->Name}}</option>
                                @endforeach

                            </select>
                            <span class="error">@error('Relation'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <!-- end row -->

                    @if($Update == 1)
                    <div class="row mb-3"> {{--Change Relation--}}
                        <label for="example-email-input" class="col-sm-3 col-form-label">Change Relation</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="ChangeRelation" wire:model="ChangeRelation" name="ChangeRelation" >
                                <option value="">---Select---</option>
                                @foreach ($MainServices as $item)
                                    <option value="{{$item->Name}}">{{$item->Name}}</option>
                                @endforeach

                            </select>
                            <span class="error">@error('ChangeRelation'){{$message}}@enderror</span>
                        </div>Thumbnail
                    </div>
                    @endif
                    <div class="row mb-3">
                        <label for="Name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" placeholder="Status Name"  wire:model="Name" id="Name">
                            <span class="error">@error('Name'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="Name" class="col-sm-3 col-form-label">order by</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="Order" wire:model="Order" name="Order" >
                                <option value="">---Select---</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                           </select>
                            <span class="error">@error('Order'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="example-tel-input" class="col-sm-3 col-form-label">Thumbnail</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="file" wire:model="Thumbnail" id="Thumbnail{{ $iteration }}">
                            <span class="error">@error('Thumbnail'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <!-- end row -->

                    <div wire:loading wire:target="Thumbnail">Uploading...</div>
                    @if (!is_Null($Thumbnail))
                        <div class="row">
                            <div class="col-45">
                                <img class="col-75" src="{{ $Thumbnail->temporaryUrl() }}"" alt="Thumbnail" />
                            </div>
                        </div>

                    @elseif(!is_Null($Old_Thumbnail))
                    <div class="row">
                        <div class="col-45">
                            <img class="col-75" src="{{ url('storage/'.$Old_Thumbnail) }}"" alt="Existing Thumbnail" />
                        </div>
                    </div>
                    @endif
                    <div class="form-data-buttons"> {{--Buttons--}}
                        <div class="row">
                            <div class="col-100">
                                @if ($Update==0)
                                    <button type="submit" value="submit" name="submit"
                                    class="btn btn-primary btn-rounded btn-sm">Save</button>
                                    <a href="{{route('new.status')}}" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                @elseif($Update==1)
                                    <a  href="#" wire:click.prevent="Update()"  class="btn btn-success btn-rounded btn-sm">Update</button>
                                    <a href="{{route('new.status')}}" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                @endif

                                <a href="{{route('dashboard')}}" class="btn btn-rounded btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                    </form>
            </div>
            </div>
        </div> <!-- end col -->


            @if (count($Existing_st)>0)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">#{{$Existing_st->total()}}  Status for {{$Relation}} Category</h5>
                    </div>

                    <div class="row">
                        <div class="col-lg-12" >
                            <table id="datatable" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"role="grid" aria-describedby="datatable_info">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Count</th>
                                    <th>Amount</th>
                                    <th>Thumnnail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($Existing_st as $key)
                                    <tr>
                                        <td>{{$Existing_st->firstItem()+$loop->index}}</td>
                                        <td>{{$key->Status}}</td>
                                        <td>{{$key->Total_Count}}</td>
                                        <td>{{$key->Total_Amount}}</td>
                                        <td>
                                            <img class="avatar-sm"  src="{{asset('storage/'.$key->Thumbnail)}}" alt=""></td>
                                        <td>
                                            <a href="{{route('edit.status',$key->Id)}}" title="Edit" class="btn btn-sm btn-primary font-size-15" id="editData"><i class="mdi mdi-circle-edit-outline" ></i></a>
                                            <a href="{{route('delete.status',$key->Id)}}" title="Delete" class="btn btn-sm btn-danger font-size-15" id="delete"><i class=" mdi mdi-trash-can"></i></a>
                                            <a href="#"  wire:click.prevent = "ViewStatus('{{$key->Status}}')"title="View List" class="btn btn-sm btn-info font-size-15" ><i class="mdi mdi-view-grid-plus"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                <p class="text-muted">Showing {{count($Existing_st)}} of {{$Existing_st->total()}} entries</p>
                                </div>
                                <div class="col-md-4">
                                    <span class=" pagination pagination-rounded float-end" >
                                        {{$Existing_st->links()}}
                                    </span>


                                </div>
                                <p class="card-text"><small class="text-muted">Last status {{$created}}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
    </div>
@if ($list)
<div class="row"> {{-- Start of Search Result Details Row --}}
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title"> Search Result found. </h4>
                    {{-- <h4 class="card-title">Status : {{ !is_null($Status) ?  $Status : 'All'}} {{$StatusCount}} </h4> --}}
                </div>



                <div class="table-responsive">
                    <table class="table table-bordered mb-0">

                        <thead class="table-light">
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
                                <th>Profile</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( $records as $data )
                            <tr>
                                <td>{{$records->firstItem()+$loop->index }}</td>
                                <td><input type="checkbox" name="checked" id="checked" value="{{$data->Id}}" wire:model="Checked"></td>

                                <td>{{ $data->Received_Date }}</td>
                                <td>{{ $data->Name }}</td>
                                <td>{{ $data->Mobile_No }}</td>
                                <td>{{ $data->Application}}</td>
                                <td>{{$data->Application_Type}}</td>
                                <td>{{ $data->Ack_No }}</td>
                                <td>{{ $data->Document_No }}</td>
                                <td>


                                <select  wire:change="UpdateStatus('{{$data->Id}}',event.target.value)" name="bystatus" id="bystatus" class="form-control form-control-sm">
                                <option selected="">{{ $data->Status }}</option>
                                    @foreach ($status_list as $status)
                                    <option value="{{ $status->Status }} ">{{ $status->Status }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>  <img src="{{ (!empty($data['Applicant_Image']))?url('storage/'.$data['Applicant_Image']):url('storage/no_image.jpg')}} " alt="avatar-4" class="rounded-circle avatar-md"></td>

                                <td>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupVerticalDrop1" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Edit<i class="mdi mdi-square-edit-outline"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                                <a class="dropdown-item btn-primary" id="update" title="Edit Applicaiton" href="{{route('edit_application',$data->Id)}}">Edit</a>
                                        </div>
                                    </div>
                                </td>

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
                        <p class="text-muted">Showing {{count($records)}} of {{$records->total()}} entries</p>
                        </div>
                        <div class="col-md-4">
                            <span class=" pagination pagination-rounded float-end" >
                                {{$records->links()}}
                            </span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endif



<div>
