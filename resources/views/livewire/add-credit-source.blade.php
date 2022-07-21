<div>
    <div class="form-container">
        <div class="form-header">
            <p class="heading">Credit Source Module</p>
        </div>
        @if (session('SuccessUpdate'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{session('SuccessUpdate')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if (session('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{session('Error')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if (session('SuccessMsg'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{session('SuccessMsg')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <form wire:submit.prevent="Save">
            @csrf
            <div class="form-data-container">
                {{--Form Data 1--}}
                <div class="form-data">
                    @if (!empty($Type))
                    <p class="heading2">{{$Type}}</p>
                    @endif

                    <div class="row"> {{--Credit Source ID--}}
                        <div class="col-45">
                            <label class="label" for="Transaction_Id">Credit Source ID</label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <label class="label" for="Transaction_Id">{{$CS_Id}}</label>
                        </div>
                    </div>


                    <div class="row"> {{--Select Type--}}
                        <div class="col-45">
                            <label for="Source_Name">Select Category</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <select name="Type" id="type" wire:model="Type" wire:change="Change($event.target.value)" class="form-control">
                                    <option value="" selected>Select Category</option>
                                    <option value="Main Category">Main Category</option>
                                    <option value="Sub Category">Sub Category</option>
                                </select>
                                <span class="error">@error('Type'){{$message}}@enderror</span>
                            </div>
                        </div>

                    </div>
                    @if ($Type =='Main Category') {{--Main Category Fields--}}
                        <div class="row"> {{--Category Name--}}
                            <div class="col-45">
                                <label for="CategoryName">Category Name</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <input type="text"  wire:model="Name"  name="CategoryName" class="form-control"
                                        placeholder="Category Name" >
                                    <span class="error">@error('Name'){{$message}}@enderror</span>
                                </div>
                            </div>
                        </div>
                        {{$pos}}
                        <div class="row"> {{--Thumbnail--}}
                            <div class="col-45">
                                <label for="Thumbnail">Thumbnail</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
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
                                    <img class="col-75" src="./{{ $OldImage }}">
                                </div>
                                @endif
                            </div>


                        </div>
                    @endif

                    @if ($Type =='Sub Category') {{--Sub Category Fields--}}
                    <div class="row"> {{--Category List--}}
                        <div class="col-45">
                            <label for="CategoryList">Category's List</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <select name="CategoryList" id="CategoryList" wire:model="CategoryList"  wire:change="ResetList($event.target.value)" class="form-control">
                                    <option value="" selected>Select Main Category</option>
                                    @foreach ($Categorys as $Category)
                                        <option value="{{$Category->Name}}">{{$Category->Name}}</option>
                                    @endforeach
                                </select>
                                <span class="error">@error('CategoryList'){{$message}}@enderror</span>
                            </div>
                        </div>

                    </div>


                    <div class="row"> {{--Name--}}
                        <div class="col-45">
                            <label for="Source_Name">Sub Category Name</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input type="text"  id="Source_Name" wire:model="SubCategoryName"  name="Source_Name" class="form-control"
                                    placeholder="Sub Category Name" >
                                <span class="error">@error('SubCategoryName'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row"> {{--Unit Price--}}
                        <div class="col-45">
                            <label for="Unit_Price">Unit Price</label> <span class="important">*</span>
                        </div>
                        <div class="col-25">
                            <div class="md-form">
                                <input type="number" id="Unit_Price" wire:model="Unit_Price"  name="Unit_Price" class="form-control"
                                    placeholder="Price">
                                <span class="error">@error('Unit_Price'){{$message}}@enderror</span>
                            </div>
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
                                <a href='admin_home' class="btn btn-rounded btn-sm">Cancel</a>
                            @elseif($Update == 1)
                                <a href='#' wire:click.prevent="UpdateMain('{{$CS_Id}}')" class="btn btn-success btn-rounded btn-sm">Update</a>
                                <a href='#' wire:click.prevent="ResetMainFields()" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                <a href='admin_home' class="btn btn-rounded btn-sm">Cancel</a>
                            @elseif($Update == 2)
                                <a href='#' wire:click.prevent="UpdateSub('{{$CS_Id}}')" class="btn btn-success btn-rounded btn-sm">Update</a>
                                <a href='#' wire:click.prevent="ResetSubFields()" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                <a href='admin_home' class="btn btn-rounded btn-sm">Cancel</a>
                            @endif
                            </div>


                        </div>
                    </div>
                </div>

                <div class="form-data">
                    @if (!empty($Type))
                    <p class="heading2">{{$Type}}</p>
                    @endif

                    <div class="row">
                        {{-- Sub Category List Table --}}
                    @if ($Type == 'Main Category')
                        <div class="row"> {{--Category List--}}
                                <div class="md-form">
                                    <span class="info-text">{{$exist_main_categories->total()}} Main  Categories List </span>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Name</th>
                                                <th>Thumbnail</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($exist_main_categories as $key)
                                            <tr>
                                                <td style="width: 10%">{{$n++}}</td>
                                                <td style="width: 25%">{{$key->Name}}</td>
                                                <td style="width: 10%"><img src="./{{$key->Thumbnail}}" alt=""> </td>
                                                <td style="width: 10%"><a  onclick="confirm('Do you want to Edit {{$key->Name}} ?') || event.stopImmediatePropagation()" wire:click.prevent="EditMain('{{$key->Id}}')" class="btn btn-sm btn-rounded" >Edit</a></td>
                                                <td style="width: 10%"><a  onclick="confirm('Do you want to Delete {{$key->Name}} Source?') || event.stopImmediatePropagation()" wire:click.prevent="DeleteMain('{{$key->Id}}')" class="btn btn-danger btn-sm btn-rounded" >Delete</a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <span>{{$exist_main_categories->links()}}</span>
                            </div>
                        </div>
                    @endif
                        {{-- Sub Category List Table --}}
                    @if ($Type == 'Sub Category' && Count($exist_categories)>0)
                        <div class="row"> {{--Category List--}}
                                <div class="md-form">
                                    <span class="info-text">{{count($exist_categories)}}  Sub Categories Found for </span><p class="heading2">{{$CategoryList}}</p>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Category Name</th>
                                                <th>Price</th>
                                                <th>Revenue</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($exist_categories as $key)
                                            @while (count($exist_categories)>0)
                                            <tr>
                                                <td style="width: 10%">{{$n++}}
                                                    @if(count($exist_categories)==count($exist_categories))
                                                    @break
                                                    @endif
                                                </td>@endwhile
                                                <td style="width: 25%">{{$key->Source}}</td>
                                                <td style="width: 10%">{{$key->Unit_Price}}</td>
                                                <td style="width: 10%">{{$key->Total_Revenue}}</td>
                                                <td style="width: 10%"><a  onclick="confirm('Do you want to Edit {{$key->Source}} Source?') || event.stopImmediatePropagation()" wire:click.prevent="EditSub('{{$key->Id}}')" class="btn btn-sm btn-rounded" >Edit</a></td>
                                                <td style="width: 10%"><a  onclick="confirm('Do you want to Delete  {{$key->Source}} Source?') || event.stopImmediatePropagation()" wire:click.prevent="DeleteSub('{{$key->Id}}')" class="btn btn-danger  btn-sm btn-rounded" >Delete</a></td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                            </div>

                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

