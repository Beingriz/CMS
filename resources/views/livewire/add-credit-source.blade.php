<div>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Credit Ledger</h4>

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
                            <li class="breadcrumb-item active"><a href="{{route('new.application')}}">New Form</a></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>{{-- End of Row --}}

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('add_services')}}">Services</a></li>
                <li class="breadcrumb-item"><a href="{{route('Credit')}}">Credit</a></li>
            </ol>
        </div>{{-- End of Page Tittle --}}
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header d-sm-flex align-items-center justify-content-between"">
                        <h5>Credit Ledger</h5>
                        <h5><a href="{{route('CreditSource')}}" title="Click here for New Credit Source">New Entry</a></h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="Save">
                            @csrf
                        @if (!empty($Type))
                        <p class="heading2">{{$Type}}</p>
                        @endif

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Credit Id</label>
                            <div class="col-sm-8">
                                <label for="example-text-input" class="col-sm-4 col-form-label">{{$CS_Id}}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-search-input" class="col-sm-4 col-form-label">Category</label>
                            <div class="col-sm-8">
                                <select name="Type" id="type" wire:model="Type" wire:change="Change($event.target.value)" class="form-control">
                                    <option value="" selected>Select Category</option>
                                    <option value="Main Category">Main Category</option>
                                    <option value="Sub Category">Sub Category</option>
                                </select>
                                <span class="error">@error('Type'){{$message}}@enderror</span>
                            </div>
                        </div>

                        @if ($Type =='Main Category') {{--Main Category Fields--}}
                            <div class="row mb-3">
                                <label for="Date" class="col-sm-4 col-form-label">Name</label>
                                <div class="col-sm-8">
                                    <input type="text"  wire:model="Name"  name="CategoryName" class="form-control"
                                    placeholder="Category Name" >
                                <span class="error">@error('Name'){{$message}}@enderror</span>
                                </div>
                            </div>

                            {{$pos}}
                            <div class="row mb-3">
                                <label for="example-search-input" class="col-sm-4 col-form-label">Thumbnail</label>
                                <div class="col-sm-8">
                                    <div class="md-form">
                                        <input type="file" id="Thumbnail{{ $iteration }}"  wire:model="Image" accept=".jpg,.png" name="Thumbnail" class="form-control"
                                        placeholder="Select Thumbnail" >
                                    <span class="error">@error('Image'){{$message}}@enderror</span>
                                    </div>
                                </div>
                            </div>

                            <div wire:loading wire:target="Image">Uploading...</div>
                            <div class="row">

                                <div class="col-55">
                                    @if (!is_Null($Image))
                                    <div class="md-form">
                                        <img class="col-75" src="{{ $Image->temporaryUrl() }}">
                                    </div>
                                    @elseif(!is_null($OldImage) )
                                    <div class="md-form">
                                        <img class="col-75" src="{{!empty($OldImage)?url('storage/'.$OldImage):url('storage/no_image.jpg') }}">
                                    </div>
                                    @endif
                                </div>


                            </div>
                        @endif

                        @if ($Type =='Sub Category') {{--Sub Category Fields--}}

                            <div class="row mb-3">
                                <label for="Date" class="col-sm-4 col-form-label">Category's List</label>
                                <div class="col-sm-8">
                                    <select name="CategoryList" id="CategoryList" wire:model="CategoryList"  wire:change="ResetList($event.target.value)" class="form-control">
                                        <option value="" selected>Select Main Category</option>
                                        @foreach ($Categorys as $Category)
                                            <option value="{{$Category->Name}}">{{$Category->Name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error">@error('CategoryList'){{$message}}@enderror</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Date" class="col-sm-4 col-form-label">Sub Category Name</label>
                                <div class="col-sm-8">
                                    <input type="text"  id="Source_Name" wire:model.lazy="SubCategoryName"  name="Source_Name" class="form-control"
                                    placeholder="Sub Category Name" >
                                    <span class="error">@error('SubCategoryName'){{$message}}@enderror</span>
                                </div>
                            </div>

                            <div class="row mb-3">{{--Unit Price--}}
                                <label for="Date" class="col-sm-4 col-form-label">Unit Price</label>
                                <div class="col-sm-8">
                                    <input type="number" id="Unit_Price" wire:model="Unit_Price"  name="Unit_Price" class="form-control"
                                    placeholder="Price">
                                <span class="error">@error('Unit_Price'){{$message}}@enderror</span>
                                </div>
                            </div>
                        @endif
                        <div class="form-data-buttons"> {{--Buttons--}}
                            <div class="row">
                                <div class="col-100">
                                @if ($Update == 0)
                                    <button type="submit" value="submit" name="submit"
                                    class="btn btn-primary btn-rounded btn-sm">Save</button>
                                    @if ($Type =='Main Category')
                                        <a href='#' wire:click.prevent="ResetMainFields()" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    @elseif ($Type =='Sub Category')
                                        <a href='#' wire:click.prevent="ResetSubFields()" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    @endif
                                    <a href="{{route('dashboard')}}" class="btn btn-rounded btn-warning btn-sm">Cancel</a>
                                @elseif($Update == 1)
                                    <a href='#' wire:click.prevent="UpdateMain('{{$CS_Id}}')" class="btn btn-success btn-rounded btn-sm">Update</a>
                                    <a href="{{route('CreditSource')}}"  class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    <a href="{{route('dashboard')}}" class="btn btn-rounded btn-warning btn-sm">Cancel</a>
                                @elseif($Update == 2)
                                    <a href='#' wire:click.prevent="UpdateSub('{{$CS_Id}}')" class="btn btn-success btn-rounded btn-sm">Update</a>
                                    <a href="{{route('CreditSource')}}"  class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    <a href="{{route('dashboard')}}" class="btn btn-rounded btn-warning btn-sm">Cancel</a>
                                @endif
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header d-sm-flex align-items-center justify-content-between"">
                        <h5>Existing Category</h5>
                        <h5><a href="{{route('CreditSource')}}" title="Click here for New Credit Source">New Entry</a></h5>
                    </div>
                    <div class="card-body">
                        @if (!empty($Type))
                        <p class="heading2">{{$Type}}</p>
                        @endif
                        @if ($Type == 'Main Category')
                        <span class="info-text">{{$exist_main_categories->total()}} Main  Categories List </span>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Name</th>
                                        <th>Thumbnail</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($exist_main_categories as $key)
                                        <tr>
                                            <td>{{$exist_main_categories->firstItem()+$loop->index}}</td>
                                            <td>{{$key->Name}}</td>
                                            <td>
                                                <img class="avatar-sm"  src="{{url('storage/'.$key->Thumbnail)}}" alt="Icon"></td>
                                            </td>
                                            <td>
                                                <a href="{{route('edit.mainsource',$key->Id)}}" title="Edit" class="btn btn-sm btn-primary font-size-15" id="editData"><i class="mdi mdi-circle-edit-outline" ></i></a>
                                                <a href="{{route('delete.mainsource',$key->Id)}}" title="Delete" class="btn btn-sm btn-danger font-size-15" id="delete"><i class=" mdi mdi-trash-can"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                                <span>{{$exist_main_categories->links()}}</span>
                            </div>
                        @endif

                        @if ($Type == 'Sub Category' && Count($exist_categories)>0)
                            <span class="info-text">{{count($exist_categories)}}  Sub Categories Found for </span><p class="heading2">{{$CategoryList}}</p>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Category Name</th>
                                        <th>Price</th>
                                        <th>Revenue</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($exist_categories as $key)
                                        <tr>
                                            <td>{{$exist_categories->firstItem()+$loop->index}}</td>
                                            <td>{{$key->Source}}</td>
                                            <td>{{$key->Unit_Price}}</td>
                                            <td>{{$key->Total_Revenue}}</td>
                                            <td>
                                                <a href="{{route('edit.subsource',$key->Id)}}" title="Edit" class="btn btn-sm btn-primary font-size-15" id="editData"><i class="mdi mdi-circle-edit-outline" ></i></a>
                                                <a href="{{route('delete.subsource',$key->Id)}}" title="Delete" class="btn btn-sm btn-danger font-size-15" id="delete"><i class=" mdi mdi-trash-can"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                                <span>{{$exist_categories->links()}}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </form>
</div>

