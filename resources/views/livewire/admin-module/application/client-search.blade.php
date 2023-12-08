<div>
    <form action="{{ url('register_user_form') }}" method="POST" wire:submit.prevent="submit">
        @csrf
        <div class="form-data">
            <div class="row">
                <div class="col-45">
                    <label class="label" for="Mobile_No">Mobile Number</label>

                </div>
                <div class="col-45">
                    <div class="md-form">
                        <input type="number" id="Mobile_No" name="Mobile_No" class="form-control"
                            placeholder="Phone Number" wire:model.debounce.500ms="Mobile_No" onkeydown="mobile(this)" />
                        @error('Mobile_No')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        @if (session('SuccessMsg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('SuccessMsg') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (count($SearchResult) >= 0 && count($RegisteredClient) >= 1)
            <div class="form-data">

                <div class="table-information">
                    @if (count($SearchResult) == 0)
                        <span class="info-text">No Application Applied</span>
                    @else
                        <span class="info-text">{{ $SearchResults->total() }} Applications Found </span>
                    @endif
                </div>
                <!-- Name -->
                <div class="row">
                    <div class="col-45">
                        <label class="label" for="Name">Apply New Serivce</label>
                    </div>
                    <div class="col-55">
                        <div class="md-form">
                            <a href="./app_form" class="btn btn-rounded btn-primary btn-sm">Service Form</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- Form --}}
        <div class="form-data-container">
            @if (count($RegisteredClient) == 0 || $Form_View == 1)
                <div class="form-data">
                    <!-- Name -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" for="Name">Name</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input type="text" id="Name" name="Name" class="form-control"
                                    placeholder="Applicant Name" wire:model.lazy="name" />
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" for="Email_ID">Email ID</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input type="text" id="Email_ID" name="Email_ID" class="form-control"
                                    placeholder="Email_ID" wire:model="Email_ID" />
                                @error('Email_ID')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- DOB -->
                    <div class="row">
                        <!-- Material input -->
                        <div class="col-45">
                            <label for="DOB">DOB</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input type="date" id="DOB" name="DOB" class="form-control"
                                    wire:model="dob">
                                @error('dob')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!--Applicaiton Type -->
                    <div class="row">
                        <div class="col-45">
                            <label class="label" for="Client_Type">Client Type </label> <span
                                class="important">*</span>
                        </div>
                        <div class="col-55">
                            <select class="form-control" id="Client_Type" name="Client_Type" wire:model="Client_Type">
                                <option value="">--Client Type--</option>
                                <option value="Regular">Regular</option>
                                <option value="Rare">Rare</option>
                            </select>
                            @error('SubSelected')
                                <span class="error">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>
                    <!-- Address -->
                    <div class="row">
                        <!-- Material input -->
                        <div class="col-45">
                            <label for="Address">Address</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <textarea type="number" id="Address" name="Address" class="form-control" placeholder="Address"
                                    wire:model.lazy="address"></textarea>
                                @error('address')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row"> {{-- Thumbnail --}}
                        <div class="col-45">
                            <label for="Profile_Image">Profile Image</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <input type="file" wire:model="Profile_Image" name="Profile_Image"
                                    class="form-control" id="Profile_Image{{ $iteration }}" accept="image/*">
                                <span class="error">
                                    @error('Profile_Image')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>
                    <div wire:loading wire:target="Profile_Image">Uploading...</div>
                    @if (!is_Null($Profile_Image))
                        <div class="row">
                            <div class="col-45">
                                <img class="col-75" src="{{ $Profile_Image->temporaryUrl() }}""
                                    alt="Profile_Image" />
                            </div>
                        </div>
                    @elseif(!is_Null($Old_Profile_Image))
                        <div class="row">
                            <div class="col-45">
                                <img class="col-75" src="{{ $Old_Profile_Image }}"" alt="Existing Profile_Image" />
                            </div>
                        </div>
                    @endif



                    <div class="form-data-buttons">
                        <!-- Submitt Buttom -->

                        <div class="row">
                            <div class="col-100">
                                @if ($Form_View == 0)
                                    <button type="submit" value="submit" name="submit"
                                        class="btn btn-primary btn-rounded btn-sm">Register </button>
                                @elseif ($Form_View == 1)
                                    @foreach ($RegisteredClient as $data)
                                        <a href="" class="btn btn-success btn-rounded btn-sm"
                                            wire:click.prevent ="UpdateClientDetails('{{ $data->Id }}')"
                                            onclick="confirm('Are you sure you want to Update the Details?') || event.stopImmediatePropagation()">Update</a>
                                    @endforeach
                                @endif


                                <a href="./client_registration" class="btn btn-rounded btn-sm">Cancel</a>
                            </div>
                        </div>

                    </div>
                </div>
            @endif
            {{-- View --}}
            @if (count($SearchResult) >= 0 && count($RegisteredClient) >= 1)
                <div class="form-data">
                    <!-- Name -->
                    @foreach ($RegisteredClient as $data)
                        {{-- Profile Image --}}
                        <div class="row">
                            <div class="col-45">
                                <label class="label" for="Profile">Profile </label>
                            </div>
                            <div class="col-55">
                                <div class="row">
                                    <div class="col-55">
                                        <img class="profile_image" src="{{ $data->Profile_Image }}"
                                            alt="Profile" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Profile Details --}}
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Client_Id</th>
                                        <th>Name</th>
                                        <th>DOB</th>
                                        <th>Mobile No</th>
                                        <th>Type</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($SearchResults as $data) --}}
                                    <tr>
                                        <td class="show">{{ $data->Id }}</td>
                                        <td class="show">{{ $data->Name }}</td>
                                        <td class="show">{{ $data->DOB }}</td>
                                        <td class="show">{{ $data->Mobile_No }}</td>
                                        <td class="show">{{ $data->Client_Type }}</td>
                                        <td class="show">{{ $data->Address }}</td>
                                        <td class="show">
                                            <a href="" class="btn btn-primary btn-rounded btn-sm"
                                                wire:click.prevent ="EditClientDetails('{{ $data->Id }}')"
                                                onclick="confirm('Are you sure you want to Edit Client Details?') || event.stopImmediatePropagation()">Edit</a>
                                        </td>
                                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
        </div>
        @endif


        @if ($Form_View == 0)
            <div class="form-data">
                <div class="right-menu">
                    <p class="heading2">Client Insight</p>
                    <div class="form-insight-section">
                        <img src="./photo_gallery\insight.jpg" alt="">
                        <div class="form-sec-data">
                            <p class="section-heading">Registered Clients</p>
                            <p class="section-value">
                                @if (count($RegisteredClient) > 0)
                                    {{ count($RegisteredClient) }}
                                @endif

                            </p>
                            <p class="section-pre-values">Yesterday<span></span></p>
                        </div>
                    </div>
                    <div class="form-insight-section">
                        <img src="./photo_gallery\insight-2.png" alt="">
                        <div class="form-sec-data">
                            <p class="section-heading">Reveniue From Registered Clients</p>
                            <p class="section-value">{{ $Reg_Rev }}</p>
                            <p class="section-value"> Yesterday &#x20B9; <span style="color:green"></span>/-</p>
                        </div>
                    </div>
                    <div class="form-insight-section">
                        <img src="./photo_gallery\insight-3.png" alt="">
                        <div class="form-sec-data">
                            <p class="section-heading">UnRegistered Clients</p>
                            <p class="section-value"><span style="color:red">{{ $UnReg_Rev }}</span> <br> Revenue
                                from Unregistered Clients</p>
                            <p class="section-pre-values">Yesterday Earned &#x20B9; <span></span> By </p>

                        </div>
                    </div>
                </div>

            </div>
        @endif
</div>
</form>



@if (count($SearchResults) >= 1)
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Client_Id</th>
                    <th>Name</th>
                    <th>Application</th>
                    <th>Mobile No</th>
                    <th>Amount &#x20B9;</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($SearchResults as $data)
                    <tr>
                        <td class="show">{{ $n++ }}</td>
                        <td class="show">{{ $data->Client_Id }}</td>
                        <td class="show">{{ $data->Name }}</td>
                        <td class="show">{{ $data->Application_Type }}</td>
                        <td class="show">{{ $data->Mobile_No }}</td>
                        <td class="show">{{ $data->Amount_Paid }}</td>
                        <td class="show">

                            @if (count($RegisteredClient) > 0)
                                <a class="btn btn-sm btn-success " href="./edit_app/{{ $data->Id }}">Update</a>
                            @else
                                <a class="btn btn-sm btn-success "
                                    wire:click.prevent ="Register('{{ $data->Client_Id }}')"
                                    onclick="confirm('Are you sure you want to Register this Client Permanently?') || event.stopImmediatePropagation()"href="#">Register</a>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $SearchResults->links() }}
    </div>
@endif
</div>
