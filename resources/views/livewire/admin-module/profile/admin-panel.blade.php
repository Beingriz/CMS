<div>
    @if ($ProfileView == 1)
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Profile Details</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $profiledata->username }}</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <center>
                        <img class="rounded avatar-lg" src="{{ asset('/storage/' . $profiledata->profile_image) }}"
                            alt="Card image cap">
                    </center>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Username : {{ $profiledata->username }}</li>
                    <li class="list-group-item">Name : {{ $profiledata->name }}</li>
                    <li class="list-group-item">Email : {{ $profiledata->email }}</li>
                    <li class="list-group-item">Mobile No : {{ $profiledata->mobile_no }}</li>
                    <li class="list-group-item">DOB : {{ $profiledata->dob }}</li>
                    <li class="list-group-item">Address : {{ $profiledata->address }}</li>
                </ul>
                <div class="card-body">
                    <a href="" wire:click.prevent="EditProfile()"
                        class="btn btn-info btn-rounded waves-effect waves-light">Edit Profile</a>
                </div>

            </div>
        </div>
    @endif {{-- End of Profile View --}}


    @if ($ProfileEdit == 1)
        <div class="col-md-12 col-xl-5">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="my-1 mt-0">Edit Profile</h4>
                            <div>
                                <form wire:submit.prevent="UpdateProfile()">
                                    @csrf
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Username :
                                                {{ $profiledata->username }}</strong> </li>
                                    </ul>
                                    {{-- Name --}}
                                    <div class="row mb-3">
                                        <label for="name" class="col-sm-3 col-form-label">Name </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text"
                                                wire:model.lazy="name"placeholder="Name" id="name">
                                            <span class="error">
                                                @error('name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="row mb-3">
                                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text"
                                                wire:model.lazy="email"placeholder="Name" id="email">
                                            <span class="error">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    {{-- Mobile Number --}}
                                    <div class="row mb-3">
                                        <label for="mobile_no" class="col-sm-3 col-form-label">Mobile No</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="number"
                                                wire:model="mobile_no"placeholder="Mobile Number" id="mobile_no">
                                            <span class="error">
                                                @error('mobile_no')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    {{-- DOB --}}
                                    <div class="row mb-3">
                                        <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="date"
                                                wire:model="dob"placeholder="Name" id="dob">
                                            <span class="error">
                                                @error('dob')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    {{-- Address --}}
                                    <div class="row mb-3">
                                        <label for="address" class="col-sm-3 col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" type="number" wire:model.lazy="address" id="dob"></textarea>
                                            <span class="error">
                                                @error('address')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    {{-- Profile Image --}}
                                    <div class="row mb-3">
                                        <label for="profile_image" class="col-sm-3 col-form-label">Profile Icon</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file"
                                                wire:model="profile_image"placeholder="Name" id="profile_image">
                                        </div>
                                    </div>
                                    {{-- Preview Profile Image --}}
                                    @if (!is_Null($profile_image))
                                        <div class="row mb-3">
                                            <label for="profile_image" class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-9">
                                                <div wire:loading wire:target="profile_image">Uploading...</div>
                                                <img class=" rounded avatar-lg"
                                                    src="{{ $profile_image->temporaryUrl() }}" alt="" />
                                            </div>
                                        </div>
                                    @elseif (!is_Null($old_profile_image))
                                        <div class="row mb-3">
                                            <label for="profile_image" class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-9">
                                                <img class=" rounded avatar-lg"
                                                    src="{{ asset('storage/' . $old_profile_image) }}" alt="" />
                                            </div>
                                        </div>
                                    @endif

                            </div>
                        </div>
                        <div class="card-body">
                            <a href="#" wire:click="UpdateProfile()"
                                class="btn btn-info btn-rounded waves-effect waves-light">Update Profile</a>
                            <a href="#" wire:click="Back()"
                                class="btn btn-light btn-rounded waves-effect">Back</a>
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
