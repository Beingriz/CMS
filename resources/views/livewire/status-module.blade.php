<div>
    <div class="form-container">
        <div class="form-header">
            <p class="heading">Status Module</p>
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
                    <div class="row"> {{--Transaction ID--}}
                        <div class="col-45">
                            <label class="label" for="Transaction_Id">Status Id</label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <label class="label" for="Transaction_Id">{{$ST_Id}}</label>
                        </div>
                    </div>
                    <div class="row"> {{--Bookmark For--}}
                        <div class="col-45">
                            <label class="label" for="Statusfor">Status for</label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <select class="form-control" id="Statusfor" wire:model="Relation" name="Relation" wire:change="Change(event.target.value)">
                                <option value="">---Select---</option>
                                <option value="General">General</option>
                                @foreach ($MainServices as $item)
                                    <option value="{{$item->Name}}">{{$item->Name}}</option>
                                @endforeach

                            </select>
                            <span class="error">@error('Relation'){{$message}}@enderror</span>
                        </div>
                    </div>
                    @if($Update == 1)
                    <div class="row"> {{--Change Relation--}}
                        <div class="col-45">
                            <label class="label" for="ChangeRelation">Change Relation</label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <select class="form-control" id="ChangeRelation" wire:model="ChangeRelation" name="ChangeRelation" >
                                <option value="">---Select---</option>
                                @foreach ($MainServices as $item)
                                    <option value="{{$item->Name}}">{{$item->Name}}</option>
                                @endforeach

                            </select>
                            <span class="error">@error('ChangeRelation'){{$message}}@enderror</span>
                        </div>
                    </div>
                    @endif
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

                    <div class="row"> {{--Link--}}
                        <div class="col-45">
                            <label class="label" for="Order">order by</label> <span
                                class="important">*</span>
                        </div>
                        <div class="col-55">
                            <select class="form-control" id="Order" wire:model="Order" name="Order" >
                                <option value="">---Select---</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                           </select>
                            <span class="error">@error('Order'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="row"> {{--Thumbnail--}}
                        <div class="col-45">
                            <label for="Thumbnail">Thumbnail</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input type="file"  wire:model="Thumbnail" name="Thumbnail" class="form-control" id="Thumbnail{{ $iteration }}"  accept="image/*">
                                <span class="error">@error('Thumbnail'){{$message}}@enderror</span>
                            </div>
                        </div>
                    </div>
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
                            <img class="col-75" src="{{ $Old_Thumbnail}}"" alt="Existing Thumbnail" />
                        </div>
                    </div>
                    @endif
                    <div class="form-data-buttons"> {{--Buttons--}}
                        <div class="row">
                            <div class="col-100">
                                @if ($Update==0)
                                    <button type="submit" value="submit" name="submit"
                                    class="btn btn-primary btn-rounded btn-sm">Save</button>
                                    <a href="#" wire:click.prevent="ResetFields()" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                @elseif($Update==1)
                                    <a  href="#" wire:click.prevent="Update()"  class="btn btn-success btn-rounded btn-sm">Update</button>
                                        <a href="#" wire:click.prevent="ResetFields()" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                @endif

                                <a href='admin_home' class="btn btn-rounded btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="form-data">

                    @if (count($Existing_st)>0)
                        <div class="row"> {{--Category List--}}
                                <div class="md-form">
                                    <span class="info">{{$Existing_st->total()}} Status Found for  </span>
                                    <p class="heading2">{{$Relation}} Category</p>
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
                                            @foreach ($Existing_st as $key)
                                            <tr>
                                                <td style="width: 10%">{{$n++}}</td>
                                                <td style="width: 35%">{{$key->Status}}</td>
                                                <td style="width: 15%"><img src="{{$key->Thumbnail}}" alt="Icon"></td>
                                                <td style="width: 10%">
                                                    <a href="#" onclick="confirm('Do you want to Edit {{$key->Status}} Status?') || event.stopImmediatePropagation()" wire:click.prevent="Edit('{{$key->ST_Id}}')" class="btn btn-sm btn-rounded" >Edit</a></td>
                                                <td style="width: 10%">
                                                    <a href="#" onclick="confirm('Are you sure? You want to Delete {{$key->Status}} Status Permanently?')|| event.stopImmediatePropagation()" wire:click.prevent="Delete('{{$key->ST_Id}}')" class="btn btn-sm   btn-danger btn-rounded" >Delete</a>

                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <span>{{$Existing_st->links()}}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    </div>
</div>
