<div>
    <div class="page-content mt-0">
        <div class="container-fluid">
            @if($ProfileView == 1)
            <div class="col-md-6 col-xl-3">

                <div class="card">
                    <div class="card-body">
                        <h4 class="my-1 mt-0">{{$profiledata->name}} Profile</h4>
                        <center>
                            <img class="rounded-circle avatar-xl" src="{{$profiledata->profile_image}}" alt="Card image cap">
                        </center>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Username  : {{$profiledata->username}}</li>                        <li class="list-group-item">Name      : {{$profiledata->name}}</li>
                        <li class="list-group-item">Email     : {{$profiledata->email}}</li>
                        <li class="list-group-item">Mobile No : {{$profiledata->mobile_no}}</li>
                        <li class="list-group-item">DOB       : {{$profiledata->dob}}</li>
                        <li class="list-group-item">Address  : {{$profiledata->address}}</li>
                    </ul>
                    <div class="card-body">
                        <a href="" wire:click.prevent="EditProfile()" class="btn btn-info btn-rounded waves-effect waves-light">Edit Profile</a>
                    </div>

                </div>
            </div>
            @endif {{-- End of Profile View --}}


            @if($ProfileEdit == 1)
            <div class="col-md-12 col-xl-5">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="my-1 mt-0">Edit Profile</h4>
                                <div>
                                    <form wire:submit.prevent="UpdateProfile()">
                                        @csrf
                                    {{-- Name --}}
                                    <div class="row mb-3">
                                        <label for="name" class="col-sm-3 col-form-label">Name </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text"  wire:model="name"placeholder="Name" id="name">
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="row mb-3">
                                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text"  wire:model="email"placeholder="Name" id="email">
                                        </div>
                                    </div>
                                    {{-- Mobile Number --}}
                                    <div class="row mb-3">
                                        <label for="mobile_no" class="col-sm-3 col-form-label">Mobile No</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="number"  wire:model="mobile_no"placeholder="Mobile Number" id="mobile_no">
                                        </div>
                                    </div>
                                    {{-- DOB --}}
                                    <div class="row mb-3">
                                        <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="date"  wire:model="dob"placeholder="Name" id="dob">
                                        </div>
                                    </div>
                                    {{-- Address --}}
                                    <div class="row mb-3">
                                        <label for="dob" class="col-sm-3 col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" type="number"  wire:model="address" id="dob"></textarea>
                                        </div>
                                    </div>
                                    {{-- Profile Image --}}
                                    <div class="row mb-3">
                                        <label for="profile_image" class="col-sm-3 col-form-label">Profile Icon</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file"  wire:model="profile_image"placeholder="Name" id="profile_image">
                                        </div>
                                    </div>
                                    {{-- Preview Profile Image --}}
                                    @if (!is_Null($profile_image))
                                    <div class="row mb-3">
                                        <label for="profile_image" class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <div wire:loading wire:target="profile_image">Uploading...</div>
                                            <img class=" rounded avatar-lg" src="{{ $profile_image->temporaryUrl() }}" alt="" />
                                            </div>
                                    </div>
                                    @elseif (!is_Null($old_profile_image))
                                    <div class="row mb-3">
                                        <label for="profile_image" class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <img class=" rounded avatar-lg" src="{{ $old_profile_image }}" alt="" />
                                            </div>
                                    </div>
                                    @endif

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a href="#" wire:click="UpdateProfile()" class="btn btn-info btn-rounded waves-effect waves-light">Update Profile</a>
                                        <a href="#" wire:click="Back()" class="btn btn-light btn-rounded waves-effect">Back</a>
                                    </div>


                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                </div>
                @endif

            </div>
        </div>
    </div></div>
