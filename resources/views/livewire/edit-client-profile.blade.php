<div>{{-- Start of Livewire --}}

    <div class="row">{{-- Messags / Notification Row--}}
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Application Details of <span class="text-primary">{{$Name}}</span> </h4>
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
                @if (session('Error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session('Error')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('new_application')}}">Application</a></li>
                        <li class="breadcrumb-item active">Update</li>
                        <li class="breadcrumb-item active">ID: </li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

     <div class="row"> {{-- Start of Services Row --}}
        <a href="#" class="col-xl-3 col-md-10" wire:click.prevent="ShowApplicatins('{{$Mobile_No}}')">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">

                        {{-- <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fas fa-edit"></i></i>
                            </span>
                        </div> --}}
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-primary font-size-20 mb-2">{{$Name}}</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5>Applied {{$count_app}}</h5>
                                    <p class="mb-2 text-truncate">Deleted {{$app_deleted}} Applications</p>
                                </div>
                            </div>
                        </div>

                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{ (!empty($old_profile_image))?url('storage/'.$old_profile_image):url('storage/no_image.jpg')}}" alt="Generic placeholder image">


                    </div>
                </div>
            </div>
        </a>

        <a href="#" class="col-xl-3 col-md-10" >
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">

                        {{-- <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fas fa-edit"></i></i>
                            </span>
                        </div> --}}
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-warning font-size-20 mb-2">Applications Deliverd</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5>Delivered : {{$app_delivered}}</h5>
                                    <p class="mb-2 text-truncate">Pending {{$app_pending}}</p>
                                </div>
                            </div>
                        </div>

                        {{-- <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{ (!empty($item->Thumbnail))?url('storage/Admin/Services/Thumbnail'.$item->Thumbnail):url('storage/no_image.jpg')}}" alt="Generic placeholder image"> --}}
                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{url('storage/delivered.png')}}" alt="Delivered">

                    </div>
                </div>
            </div>
        </a>

        <a href="#" class="col-xl-3 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">

                        {{-- <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fas fa-edit"></i></i>
                            </span>
                        </div> --}}
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-info font-size-20 mb-2">Revenue Earned</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5>Payble &#x20B9; {{$total}}/-</h5>
                                    <p class="mb-2 text-truncate">Balance <span> &#x20B9;{{$balance}}</span></p></p>
                                </div>
                            </div>
                        </div>
                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{url('storage/revenue_2.png')}}" alt="Generic placeholder image">


                    </div>
                </div>
            </div>
        </a>

        <a href="#" class="col-xl-3 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">

                        {{-- <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fas fa-edit"></i></i>
                            </span>
                        </div> --}}
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-danger font-size-20 mb-2">Balance Due</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5>Payble &#x20B9; {{$total}}/-</h5>
                                    <p class="mb-2 text-truncate">Balance <span> &#x20B9;{{$balance}}</span></p></p>
                                </div>
                            </div>
                        </div>

                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{ (!empty($Profile_Image))?url('storage/'.$Profile_Image):url('storage/balance.png')}}" alt="Generic placeholder image">

                    </div>
                </div>
            </div>
        </a>


    </div> {{-- End of Row --}}

    <div class="col-md-12 col-xl-5">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header justify-content-between d-flex">
                        <h6 class="my-1 mt-0">Edit Profile</h6>
                        <h6 class="my-1 mt-0">{{$Name}}</h6>
                    </div>
                    <div class="card-body">

                        <div>
                            <form wire:submit.prevent="UpdateProfile()">
                                @csrf
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Id  : {{$Client_Id}} </strong> </li>
                                </ul>
                            {{-- Name --}}
                            <div class="row mb-3">
                                <label for="name" class="col-sm-3 col-form-label">Name </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text"  wire:model.lazy="Name"placeholder="Name" id="name">
                                    <span class="error">@error('Name'){{$message}}@enderror</span>
                                </div>
                            </div>
                            {{-- Relative Name --}}
                            <div class="row mb-3">
                                <label for="name" class="col-sm-3 col-form-label">Relative Name </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text"  wire:model.lazy="Relative_Name"placeholder="Relative_Name" id="name">
                                    <span class="error">@error('Relative_Name'){{$message}}@enderror</span>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="row mb-3">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text"  wire:model.lazy="Email"placeholder="Email" id="email">
                                    <span class="error">@error('Email'){{$message}}@enderror</span>
                                </div>
                            </div>
                            {{-- Mobile Number --}}
                            <div class="row mb-3">
                                <label for="mobile_no" class="col-sm-3 col-form-label">Mobile No</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="number"  wire:model.lazy="Mobile_No"placeholder="Mobile Number" id="Mobile_No">
                                    <span class="error">@error('Mobile_No'){{$message}}@enderror</span>
                                </div>
                            </div>
                            {{-- DOB --}}
                            <div class="row mb-3">
                                <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="date"  wire:model="Dob" id="dob">
                                    <span class="error">@error('Dob'){{$message}}@enderror</span>
                                </div>
                            </div>
                            {{-- Gender --}}
                            <div class="row mb-3">
                                <label for="dob" class="col-sm-3 col-form-label">Gender</label>
                                <div class="col-sm-9">
                                    <select wire:model="Gender" name="Gender" id="Gender">
                                        <option selected value="{{$Gender}}">{{$Gender}}</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <span class="error">@error('Gender'){{$message}}@enderror</span>
                                </div>
                            </div>
                            {{-- Address --}}
                            <div class="row mb-3">
                                <label for="address" class="col-sm-3 col-form-label">Address</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" type="number" wire:model.lazy="Address" id="dob"></textarea>
                                    <span class="error">@error('Address'){{$message}}@enderror</span>
                                </div>
                            </div>
                            {{-- Profile Image --}}
                            <div class="row mb-3">
                                <label for="Profile_Image" class="col-sm-3 col-form-label">Profile Icon</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="file"  wire:model="Profile_Image"placeholder="Name" id="profile_image">
                                </div>
                            </div>
                            {{-- Preview Profile Image --}}
                            @if (!is_Null($Profile_Image))
                            <div class="row mb-3">
                                <label for="Profile_Image" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <div wire:loading wire:target="profile_image">Uploading...</div>
                                    <img class=" rounded avatar-lg" src="{{ $Profile_Image->temporaryUrl() }}" alt="" />
                                    </div>
                            </div>
                            @elseif (!is_Null($old_profile_image))
                            <div class="row mb-3">
                                <label for="profile_image" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <img class=" rounded avatar-lg" src="{{asset('storage/'.$old_profile_image) }}" alt="" />
                                    </div>
                            </div>
                            @endif

                                </div>
                            </div>
                            <div class="card-body">
                                <a href="#" wire:click="UpdateProfile('{{$Client_Id}}')" class="btn btn-success btn-rounded waves-effect waves-light">Update Profile</a>
                                <a href="#" wire:click="ResetFields('{{$Client_Id}}')" class="btn btn-light btn-rounded waves-effect">Reset</a>
                            </div>


                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

    </div>
</div>{{-- End of Livewire --}}
