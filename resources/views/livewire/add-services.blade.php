<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Services Module</h4>

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
                        <li class="breadcrumb-item active">New Services</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('app_home')}}">Application</a></li>
            <li class="breadcrumb-item"><a href="{{url('app_form')}}">New Application</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Services Section</h4>
                <p class="card-title-desc">Add New Services</p>
                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Service Id</label>
                    <div class="col-sm-10">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{$Service_Id}}</label>
                    </div>
                </div>
                <!-- end row -->
                <form wire:submit.prevent="Save">
                    @csrf
                <div class="row mb-3">
                    <label for="example-search-input" class="col-sm-2 col-form-label">Catogory</label>                    <div class="col-sm-10">
                        <select class="form-control" id="Category_Type" wire:model="Category_Type" name="Category_Type">
                            <option value="">---Select---</option>
                            <option value="Main">Main Services</option>
                            <option value="Sub">Sub Services</option>
                        </select>
                        <span class="error">@error('Category_Type'){{$message}}@enderror</span>                    </div>
                </div>
                <!-- end row -->

                @if ($Category_Type == 'Main')
                    <div class="row mb-3">
                        <label for="Name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Bookmark Name"  wire:model="Name" id="Name">
                            <span class="error">@error('Name'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="example-url-input" class="col-sm-2 col-form-label">Service Type</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="Service_Type" wire:model="Service_Type" name="Service_Type">
                                <option value="">---Select---</option>
                                <option value="Public">Public</option>
                                <option value="Private">Private</option>
                            </select>
                            <span class="error">@error('Service_Type'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="example-tel-input" class="col-sm-2 col-form-label">Description<</label>
                        <div class="col-sm-10">
                            <textarea id="Description" wire:model="Description" name="Description" class="form-control"
                                placeholder="Service Description" rows="3" maxlength="150" resize="none"></textarea>
                                        <span class="error">@error('Description'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="example-tel-input" class="col-sm-2 col-form-label">Details<</label>
                        <div class="col-sm-10">
                            <textarea id="Details" wire:model="Details" name="Details" class="form-control"
                                            placeholder="Details" rows="3" resize="none"></textarea>
                                        <span class="error">@error('Details'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="example-tel-input" class="col-sm-2 col-form-label">Features<</label>
                        <div class="col-sm-10">
                            <textarea id="Features" wire:model="Features" name="Features" class="form-control"
                                placeholder="Features" rows="3" resize="none"></textarea>
                                        <span class="error">@error('Features'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="example-tel-input" class="col-sm-2 col-form-label">Specifications<</label>
                        <div class="col-sm-10">
                            <textarea id="Specification" wire:model="Specification" name="Specification" class="form-control"
                                            placeholder="Specification" rows="3" resize="none"></textarea>
                                        <span class="error">@error('Specification'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="example-tel-input" class="col-sm-2 col-form-label">Order<</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="Order_By" wire:model="Order_By" name="Order_By">
                                <option value="">---Select---</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                            <span class="error">@error('Order_By'){{$message}}@enderror</span>
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
                                class="btn btn-primary btn-rounded btn-sm">Add Service</button>
                            @elseif($Update==1)
                                <button type="submit" value="submit" name="submit"
                                class="btn btn-primary btn-rounded btn-sm">Update Service</button>
                            @endif
                            <a href="#" wire:click.prevent="ResetFields()" class="btn btn-warning btn-rounded btn-sm">Reset</a>
                            <a href='admin_home' class="btn btn-rounded btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                    </form>
                @endif
                @if($Category_Type == 'Sub')






            </div>
        </div>
    </div> <!-- end col -->


    <div class="form-container">
       <form wire:submit.prevent="Save">
            @csrf
            <div class="form-data-container">
                {{--Form Data 1--}}
                <div class="form-data">


                    @if ($Category_Type == 'Main')




                        <div class="row"> {{--Thumbnail--}}
                            <div class="col-45">
                                <label for="Thumbnail">Thumbnail</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="file" id="Thumbnail" wire:model="Thumbnail" name="Thumbnail" class="form-control" accept="image/*">
                                    <span class="error">@error('Thumbnail'){{$message}}@enderror</span>
                                </div>
                            </div>
                        </div>
                            <div wire:loading wire:target="Thumbnail">Uploading...</div>
                            @if ($Thumbnail)
                                <div class="row">
                                    <div class="col-45">
                                        <img class="col-75" src="{{ $Thumbnail->temporaryUrl() }}"" alt="Thumbnail" />
                                    </div>
                                </div>

                            @elseif($Old_Thumbnail)
                            <div class="row">
                                <div class="col-45">
                                    <img class="col-75" src="{{ $Old_Thumbnail}}"" alt="Existing Thumbnail" />
                                </div>
                            </div>
                            @endif
                            <div class="form-data-buttons"> {{--Buttons--}}
                                <div class="row">
                                    <div class="col-100">
                                        @if ($Update==0)
                                            <button type="submit" value="submit" name="submit"
                                            class="btn btn-primary btn-rounded btn-sm">Add Service</button>
                                        @elseif($Update==1)
                                            <button type="submit" value="submit" name="submit"
                                            class="btn btn-primary btn-rounded btn-sm">Update Service</button>
                                        @endif
                                        <a href="#" wire:click.prevent="ResetFields()" class="btn btn-warning btn-rounded btn-sm">Reset</a>
                                        <a href='admin_home' class="btn btn-rounded btn-sm">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                    @if($Category_Type == 'Sub')

                        <div class="row"> {{--Main Services List--}}
                            <div class="col-45">
                                <label class="label" for="Main_Services">Main Services</label>
                                <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <select class="form-control" id="Main_Services" wire:model="Main_ServiceId" name="Main_Services">
                                    <option value="">---Select---</option>
                                    @foreach ($MainServices as $item)
                                        <option value="{{$item->Id}}">{{$item->Name}}</option>
                                    @endforeach

                                </select>
                                <span class="error">@error('Main_Services'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="row"> {{--Name--}}
                            <div class="col-45">
                                <label for="Amount_Paid">Name</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="text" id="paid" wire:model="Name" name="Name" class="form-control"
                                        placeholder="Enter Name" >
                                    <span class="error">@error('Name'){{$message}}@enderror</span>
                                </div>
                            </div>
                        </div>

                        <div class="row"> {{--Service_Type--}}
                            <div class="col-45">
                                <label class="label" for="Service_Type">Service Type</label>
                                <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <select class="form-control" id="Service_Type" wire:model="Service_Type" name="Service_Type">
                                    <option value="">---Select---</option>
                                    <option value="Public">Public</option>
                                    <option value="Private">Private</option>
                                </select>
                                <span class="error">@error('Service_Type'){{$message}}@enderror</span>
                            </div>
                        </div>

                        <div class="row"> {{--Description--}}
                            <div class="col-45">
                                <label class="label" for="Description">Description</label> <span
                                    class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <textarea id="Description" wire:model="Description" name="Description" class="form-control"
                                        placeholder="Service Description" rows="3" maxlength="150" resize="none"></textarea>
                                    <span class="error">@error('Description'){{$message}}@enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="row"> {{--Unit Price--}}
                            <div class="col-45">
                                <label class="label" for="Unit_Price">Unit Price</label> <span
                                    class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="number" id="Unit_Price" wire:model="Unit_Price" name="Name" class="form-control"
                                        placeholder="Set Unit Price" >
                                    <span class="error">@error('Unit_Price'){{$message}}@enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="row"> {{--Thumbnail--}}
                            <div class="col-45">
                                <label for="Thumbnail">Thumbnail</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="file" id="Thumbnail" wire:model="Thumbnail" name="Thumbnail" class="form-control" accept="image/*">
                                    <span class="error">@error('Thumbnail'){{$message}}@enderror</span>
                                </div>
                            </div>
                        </div>
                        <div wire:loading wire:target="Thumbnail">Uploading...</div>
                        @if (!is_null($Thumbnail))
                            <div class="row">
                                <div class="col-45">
                                    <img class="col-75" src="{{ $Thumbnail->temporaryUrl() }}"" alt="Thumbnail" />
                                </div>
                            </div>
                        @elseif(!is_null($Old_Thumbnail))
                            <div class="row">
                                <div class="col-45">
                                    <img class="col-75" src="{{ $Old_Thumbnail}}"" alt="Existing Thumbnail" />
                                </div>
                            </div>
                        @endif


                            <div class="form-data-buttons"> {{--Buttons--}}
                                <div class="row">
                                    <div class="col-100">
                                        @if ($Update==0)
                                            <a href="#" wire:click.prevent="SaveSubService()" class="btn btn-primary btn-rounded btn-sm">Add Sub Service</a>
                                        @elseif ($Update==1)
                                            <a href="#" wire:click.prevent="SaveSubService()" class="btn btn-primary btn-rounded btn-sm">Update Sub Service</a>
                                        @endif
                                        <a href="#" wire:click.prevent="ResetFields()" class="btn btn-rounded  btn-warning btn-sm">Reset</a>
                                        <a href="{{ url('/') }}" class="btn btn-rounded btn-sm">Cancel</a>
                                    </div>
                                </div>
                            </div>
                    @endif

                </div>
                <div class="form-data">

                    @if (count($Existing_Sevices)>0)
                        <div class="row"> {{--Category List--}}
                                <div class="md-form">
                                    <span class="heading2">{{$Existing_Sevices->total()}} Existing Services Available  </span>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Document Name</th>
                                                <th>Thumbnail</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($Existing_Sevices as $key)
                                            <tr>
                                                <td style="width: 10%">{{$n++}}</td>
                                                <td style="width: 35%">{{$key->Name}}</td>
                                                <td style="width: 15%"><img src="{{$key->Thumbnail}}" alt="Icon"></td>
                                                <td style="width: 10%">
                                                    <a href="#" onclick="confirm('Do you want to Edit {{$key->Name}} Service?') || event.stopImmediatePropagation()" wire:click.prevent="EditMainservice('{{$key->Id}}')" class="btn btn-sm btn-rounded" >Edit</a>
                                                    <a href="#" onclick="confirm('Do you Delete {{$key->Name}} Service Permanently?')|| event.stopImmediatePropagation()" wire:click.prevent="Delete('{{$key->Id}}')" class="btn btn-sm   btn-danger btn-rounded" >Delete</a>

                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <span>{{$Existing_Sevices->links()}}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    </div>
</div>
