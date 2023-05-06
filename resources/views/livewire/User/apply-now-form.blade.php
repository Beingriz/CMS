<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Application for </h4>
                    <p class="card-title-desc">Description</p>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Application Id</label>
                        <div class="col-sm-10">
                            <label for="example-text-input" class="col-sm-10 col-form-label">{{$App_Id}}</label>
                        </div>
                    </div>
                    <!-- end row -->
                    <form wire:submit.prevent="ApplyNow">
                        @csrf

                    <div class="row mb-3">
                        <label for="example-search-input" class="col-sm-2 col-form-label">Service for</label>                    <div class="col-sm-10">
                            <select class="form-control" id="Category_Type" wire:model="Category_Type" name="Category_Type">
                                <option value="{{$mainServiceName}}">{{$mainServiceName}}</option>

                            </select>
                            <span class="error">@error('Category_Type'){{$message}}@enderror</span>                    </div>
                    </div>
                    <!-- end row -->
                        <div class="row mb-3">
                            <label for="example-url-input" class="col-sm-2 col-form-label">Service Type</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="Service_Type" wire:model="Service_Type" name="Service_Type">
                                    <option selected value="{{$ServiceName}}">{{$ServiceName}}</option>
                                    @foreach ($subServices as $item)
                                    <option value="{{$item['Name']}}">{{$item['Name']}}</option>
                                    @endforeach
                                </select>
                                <span class="error">@error('Service_Type'){{$message}}@enderror</span>
                            </div>
                        </div>

                    <div class="row mb-3">
                        <label for="Name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Your Name"  wire:model="Name" id="Name">
                            <span class="error">@error('Name'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="FatherName" class="col-sm-2 col-form-label">Father Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Your Father Name"  wire:model="FatherName" id="FatherName">
                            <span class="error">@error('FatherName'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="Dob" class="col-sm-2 col-form-label">Date of Birth</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="date"   wire:model="Dob" id="Dob">
                            <span class="error">@error('Dob'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <!-- end row -->

                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="Description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea id="Description" wire:model="Description" name="Description" class="form-control"
                                placeholder="Service Description" rows="3" id="Description"></textarea>
                                        <span class="error">@error('Description'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <!-- end row -->
                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="File" class="col-sm-2 col-form-label">File</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file"   wire:model="File" id="File" accept="image/*">
                            <span class="error">@error('File'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div wire:loading wire:target="File">Uploading...</div>
                        @if (!is_Null($File))
                            <div class="row">
                                <div class="col-45">
                                    <img class="col-75" src="{{ $File->temporaryUrl() }}"" alt="Thumbnail" />
                                </div>
                            </div>
                        @endif
                    <div class="form-data-buttons"> {{--Buttons--}}
                        <div class="row">
                            <div class="col-100">
                                <button type="submit" value="submit" name="submit"
                                class="btn btn-primary btn-rounded btn-sm">Add Service</button>

                            <a href="#" wire:click.prevent="ResetFields()" class="btn btn-warning btn-rounded btn-sm">Reset</a>
                            <a href='admin_home' class="btn btn-rounded btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>
