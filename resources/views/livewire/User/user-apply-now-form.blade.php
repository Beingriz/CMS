<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Application</h4>

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
                        <li class="breadcrumb-item">{{Auth::user()->name}}</li>
                        <li class="breadcrumb-item active">Application</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('user.home',Auth::user()->id)}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('service.list')}}">Services</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}



    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Application for {{$ServiceName}}</h4>
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
                                    <option value="{{$ServiceName}}">{{$ServiceName}}</option>
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
                    <div class="row mb-3">
                        <label for="PhoneNo" class="col-sm-2 col-form-label">Mobile No</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" placeholder="Your Mobile No"  wire:model="PhoneNo" id="Dob">
                            <span class="error">@error('PhoneNo'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <!-- end row -->

                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="Description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea id="Description" wire:model="Description" name="Description" class="form-control"
                                placeholder="Hey! {{$Name}}!, Give your Message on what your applying for, our team will healp you soon." rows="3" id="Description"></textarea>
                                        <span class="error">@error('Description'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <!-- end row -->
                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="File" class="col-sm-2 col-form-label">Aadhar Copy</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file"   wire:model="File" id="File" accept="image/*">
                            <span class="error">@error('File'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div wire:loading wire:target="File">Uploading...</div>
                        @if (!is_Null($File))

                            <div class="row mb-3">
                                <label for="FilePreview" class="col-sm-2 col-form-label">Preview</label>
                                <div class="col-md-6">
                                    <img class="rounded me-2" alt="200x200" width="200" src="{{ $File->temporaryUrl() }}" data-holder-rendered="true">
                                </div>
                            </div>


                        <div class="row"> {{-- buttons Row  --}}
                            <div class="col-lg-6">
                                <h5 class="font-size-14 mb-3">Terms & Conditions</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <p class="text-muted"> Sharing Consent</p>
                                    <input type="checkbox" id="read" switch="primary" {{$disabled}} wire:model="Read_Consent">
                                    <label for="read" data-on-label="Yes" data-off-label="No" ></label>
                                    <p class="text-muted">{{$Recived}}</p>
                                    <span class="error">@error('Read_Consent'){{$message}}@enderror</span>

                                </div>
                            </div>
                        </div> {{-- End of Row --}}
                        @endif
                    <div class="form-data-buttons"> {{--Buttons--}}
                        <div class="row">
                            <div class="col-100">
                                <button type="submit" value="submit" name="submit"
                                class="btn btn-primary btn-rounded btn-sm">Apply Now</button>

                            <a href="" wire:click.prevent="ResetFields" class="btn btn-warning btn-rounded btn-sm">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div> <!-- end col -->

        {{-- Consent Details --}}
        @if ($Read_Consent==1)
        <div class="col-md-6" id="Consent">
            <div class="card card-body">
                <h3 class="card-title">Consent for Sharing Document</h3>
                <p class="card-text">
                {{$Name}}
                C/o {{$FatherName}}
                <br>
                {{$Address}}
                <br>
                {{$PhoneNo}}
                <br>
                <br>
                {{$ConsentMatter}}
                <br>
                {{$Name}}
                <br>
                <p>Digitally Signed by {{$Name}}on </p> {{$signature}}
                </p>
                @if ($Signed)
                <a href="#" wire:click.prevent="Sign"  class="btn btn-primary waves-effect waves-light">Sign Digitally</a>
                @endif
            </div>
        </div>
        @endif

        {{-- Consent Details End--}}

    </div>
</div>

