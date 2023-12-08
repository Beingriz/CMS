<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">User Top Bar</h4>

                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('SuccessMsg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('SuccessUpdate'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('SuccessUpdate') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('Error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('Error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Digital Cyber</a></li>
                        <li class="breadcrumb-item active">UserTopBar</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('app_home') }}">Application</a></li>
            <li class="breadcrumb-item"><a href="{{ url('app_form') }}">New Application</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    {{-- ---------------------------------------------------------------------------------------------------- --}}

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update User Top Bar</h4>
                    <p class="card-title-desc">Updating the User View Page top bar</p>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ $Id }}</label>
                        </div>
                    </div>
                    <!-- end row -->
                    <form wire:submit.prevent="Save">

                        <div class="row mb-3">
                            <label for="Company_Name" class="col-sm-2 col-form-label">Company Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Company Name"
                                    wire:model="Company_Name" id="Company_Name">
                                <span class="error">
                                    @error('Company_Name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="Address" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Address" wire:model="Address"
                                    id="Address">
                                <span class="error">
                                    @error('Address')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="Phone_No" class="col-sm-2 col-form-label">Phone No</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Phone No" wire:model="Phone_No"
                                    id="Phone_No">
                                <span class="error">
                                    @error('Phone_No')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="Time_From" class="col-sm-2 col-form-label">Time From</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Time From"
                                    wire:model="Time_From" id="Time_From">
                                <span class="error">
                                    @error('Time_From')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="Time_To" class="col-sm-2 col-form-label">Time To</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Time To" wire:model="Time_To"
                                    id="Time_To">
                                <span class="error">
                                    @error('Time_To')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="Facebook" class="col-sm-2 col-form-label">Facebook</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Facebook"
                                    wire:model="Facebook" id="Facebook">
                                <span class="error">
                                    @error('Facebook')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="Twitter" class="col-sm-2 col-form-label">Twitter</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Twitter"
                                    wire:model="Twitter" id="Twitter">
                                <span class="error">
                                    @error('Twitter')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="Instagram" class="col-sm-2 col-form-label">Instagram</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Instagram"
                                    wire:model="Instagram" id="Instagram">
                                <span class="error">
                                    @error('Instagram')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="LinkedIn" class="col-sm-2 col-form-label">LinkedIn</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="LinkedIn"
                                    wire:model="LinkedIn" id="LinkedIn">
                                <span class="error">
                                    @error('LinkedIn')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="Youtube" class="col-sm-2 col-form-label">Youtube</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Youtube"
                                    wire:model="Youtube" id="Youtube">
                                <span class="error">
                                    @error('Youtube')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="form-data-buttons"> {{-- Buttons --}}
                            <div class="row">
                                <div class="col-100">
                                    @if ($Update == 0)
                                        <button type="submit" value="submit" name="submit"
                                            class="btn btn-primary btn-rounded btn-sm">Save</button>
                                        <a href="#" wire:click.prevent="ResetFields()"
                                            class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    @elseif($Update == 1)
                                        <a href="#" wire:click.prevent="Update()"
                                            class="btn btn-success btn-rounded btn-sm">Update</button>
                                            <a href="#" wire:click.prevent="ResetFields()"
                                                class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    @endif

                                    <a href='admin_home' class="btn btn-rounded btn-sm">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->


        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Desktop View Header & Footer Details</h5>
                </div>
                <div class="row">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone No</th>
                                        <th>Email</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Eidt</th>
                                        <th>Select</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Records as $key)
                                        <tr @if ($key->Selected == 'Yes') class="table-success" @endif>
                                            <td>{{ $key['Company_Name'] }}</td>
                                            <td>{{ $key['Address'] }}</td>
                                            <td>{{ $key['Phone_No'] }}</td>
                                            <td>{{ $key['Email_Id'] }}</td>
                                            <td>{{ $key['Time_From'] }}</td>
                                            <td>{{ $key['Time_To'] }}</td>
                                            <td>
                                                <div class="btn-group-vertical" role="group"
                                                    aria-label="Vertical button group">
                                                    <div class="btn-group" role="group">
                                                        <button id="btnGroupVerticalDrop1" type="button"
                                                            class="btn btn-light dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Action <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="btnGroupVerticalDrop1" style="">
                                                            <a class="dropdown-item"
                                                                href="{{ route('edit.header', $key->Id) }}"
                                                                title="Edit Application" id="editData">Edit</a>

                                                            <a class="dropdown-item"
                                                                href="{{ route('select.aboutus', $key->Id) }}"
                                                                id="SelectData" title="Select Record">Select</a>

                                                            <a class="dropdown-item"
                                                                href="{{ route('delete.aboutus', $key->Id) }}"
                                                                title="Delete Application" id="delete">Delete</a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </td>

                                            <td><a class="btn btn-primary btn-rounded btn-sm" href="#"
                                                    onclick="confirm('Do you want to Edit {{ $key->Company_Name }} ?') || event.stopImmediatePropagation()"
                                                    wire:click.prevent="Edit('{{ $key->Id }}')">Edit</a></td>
                                            <td><a class="btn btn-success btn-rounded btn-sm" href="#"
                                                    onclick="confirm('Do you want to Select {{ $key->Company_Name }} ?') || event.stopImmediatePropagation()"
                                                    wire:click.prevent="Select('{{ $key->Id }}')">Select</a></td>

                                        </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
