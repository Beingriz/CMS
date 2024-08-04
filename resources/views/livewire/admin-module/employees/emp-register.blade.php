<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Employee Registration</h4>

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
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Digital Cyber</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('new.application') }}">New Form</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('Dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Credit') }}">Credit</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Debit') }}">Debit</a></li>
        </ol>
    </div>{{-- End of Page Title --}}

    <div class="row">
        <div class="col-lg-5">{{-- Start of Form Column --}}
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <h5>Registration</h5>
                    <h5><a href="{{ route('emp.register') }}" title="Click here for New Transaction">New Employee</a></h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Emp Id</label>
                        <div class="col-sm-8">
                            <label for="example-text-input" class="col-sm-4 col-form-label">{{ $Id }}</label>
                        </div>
                    </div>
                    <form wire:submit.prevent="Save">
                        @csrf
                        {{-- Branch --}}
                        <div class="row mb-3">
                            <label for="Branch" class="col-sm-4 col-form-label">Branch</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="Branch" wire:model="Branch" name="Particular">
                                    <option value="">---Select---</option>
                                    @foreach ($Branches as $branch)
                                        <option value="{{ $branch->branch_id }}">
                                            {{ $branch->name }}, {{ $branch->address }}</option>
                                    @endforeach
                                </select>
                                <span class="error">@error('Branch'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        {{-- Name --}}
                        <div class="row mb-3">
                            <label for="name" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" id="name" name="name" wire:model.lazy="Name"
                                    class="form-control" placeholder="employee name" />
                                <span class="error">@error('Name'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        {{-- Father Name --}}
                        <div class="row mb-3">
                            <label for="father_name" class="col-sm-4 col-form-label">Father Name</label>
                            <div class="col-sm-8">
                                <input type="text" id="father_name" name="father_name" wire:model.lazy="Father_Name"
                                     class="form-control"  placeholder="father name"/>
                                <span class="error">@error('Father_Name'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        {{-- Gender --}}
                        <div class="row mb-3">
                            <label for="gender" class="col-sm-4 col-form-label">Gender</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="gender" wire:model.lazy="Gender" name="Particular">
                                    <option value="">---Select---</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <span class="error">@error('Gender'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        {{-- DOB --}}
                        <div class="row mb-3">
                            <label for="dob" class="col-sm-4 col-form-label">DOB</label>
                            <div class="col-sm-8">
                                <input type="date" id="dob" name="dob" wire:model.lazy="DOB"
                                    value="{{ date('Y-m-d') }}" class="form-control" />
                                <span class="error">@error('DOB'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        {{-- Mobile --}}
                        <div class="row mb-3">
                            <label for="mobile_no" class="col-sm-4 col-form-label">Mobile No</label>
                            <div class="col-sm-8">
                                <input type="number" id="mobile_no" name="mobile_no" wire:model.lazy="Mobile_No"
                                     class="form-control" placeholder="mobile number"/>
                                <span class="error">@error('Mobile_No'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        {{-- Email Id --}}
                        <div class="row mb-3">
                            <label for="email_id" class="col-sm-4 col-form-label">Email Id</label>
                            <div class="col-sm-8">
                                <input type="email" id="email_id" name="email_id" wire:model.lazy="Email_Id"
                                     class="form-control" placeholder="email id"/>
                                <span class="error">@error('Email_Id'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="row mb-3">
                            <label for="address" class="col-sm-4 col-form-label">Address</label>
                            <div class="col-sm-8">
                                <textarea id="address" wire:model.lazy="Address" name="Address" class="form-control"
                                    placeholder="employee current address" rows="3"></textarea>
                                <span class="error">@error('Address'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        {{-- Emp Role --}}
                        <div class="row mb-3">
                            <label for="role" class="col-sm-4 col-form-label">Emp Role</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="role" wire:model="Role" name="role">
                                    <option value="">---Select---</option>
                                    <option value="admin">Admin</option>
                                    <option value="branch admin">Branch Admin</option>
                                    <option value="operator">Operator</option>
                                </select>
                                <span class="error">@error('Role'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        {{-- Qualification --}}
                        <div class="row mb-3">
                            <label for="Qualification" class="col-sm-4 col-form-label">Qualification</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="Qualification" wire:model="Qualification"
                                    name="Qualification">
                                    <option value="">---Select---</option>
                                    <option value="SSLC">SSLC</option>
                                    <option value="PUC">PUC</option>
                                    <option value="Graduation">Graduation</option>
                                    <option value="Post Graduation">Post Graduation</option>
                                </select>
                                <span class="error">@error('Qualification'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        {{-- Experience --}}
                        <div class="row mb-3">
                            <label for="Experience" class="col-sm-4 col-form-label">Experience</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="Experience" wire:model.lazy="Experience" name="Experience">
                                    <option value="">---Select---</option>
                                    <option value="Fresher">Fresher</option>
                                    <option value="1 year">1 year</option>
                                    <option value="2 year">2 year</option>
                                    <option value="3 year & above">3 year & above</option>
                                </select>
                                <span class="error">@error('Experience'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        {{-- Qualification Certificate --}}
                        <div class="row mb-3">
                            <label for="Qualification_Doc" class="col-sm-4 col-form-label">Education Cert.</label>
                            <div class="col-sm-8">
                                <div class="md-form">
                                    <input type="file" id="Qualification_Doc" wire:model="Qualification_Doc"
                                        name="Qualification_Doc" class="form-control" accept="application/pdf">
                                    <span class="error">@error('Qualification_Doc'){{ $message }}@enderror</span>
                                </div>
                            </div>
                        </div>

                        {{-- Resume --}}
                        <div class="row mb-3">
                            <label for="Resume_Doc" class="col-sm-4 col-form-label">Resume file</label>
                            <div class="col-sm-8">
                                <div class="md-form">
                                    <input type="file" id="Resume_Doc" wire:model="Resume_Doc"
                                        name="Resume_Doc" class="form-control" accept="application/pdf">
                                    <span class="error">@error('Resume_Doc'){{ $message }}@enderror</span>
                                </div>
                            </div>
                        </div>

                        {{-- Profile Image --}}
                        <div class="row mb-3">
                            <label for="Profile_Img" class="col-sm-4 col-form-label">Profile Image</label>
                            <div class="col-sm-8">
                                <div class="md-form">
                                    <input type="file" wire:model="Profile_Img"
                                        name="Profile_Img" class="form-control" accept="image/*">
                                    <span class="error">@error('Profile_Img'){{ $message }}@enderror</span>
                                </div>
                            </div>
                        </div>

                        {{-- Preview --}}
                        <div wire:loading wire:target="Profile_Img">Uploading...</div>
                        @if (!is_null($Profile_Img))
                            <div class="row">
                                <div class="col-45">
                                    <img class="col-75" src="{{ $Profile_Img->temporaryUrl() }}" alt="profile image" />
                                </div>
                            </div>
                        @elseif(!is_null($Old_Profile_Img))
                            <div class="row">
                                <div class="col-45">
                                    <img class="col-75" src="{{ url('storage/' . $Old_Profile_Img) }}" alt="existing image" />
                                </div>
                            </div>
                        @endif

                        <div class="form-data-buttons">{{-- Buttons --}}
                            <div class="row">
                                <div class="col-100">
                                    @if ($update == 0)
                                        <button type="submit" value="submit" name="Save" class="btn btn-primary btn-rounded btn-sm">Save</button>
                                        <a href="{{ route('emp.register') }}" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    @elseif($update == 1)
                                        <a href="#" class="btn btn-success btn-rounded btn-sm"
                                            wire:click.prevent="Update('{{ $transaction_id }}')">Update</a>
                                        <a href="{{ route('emp.register') }}" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    @endif
                                    <a href="{{ route('admin.home') }}" class="btn btn-warning btn-rounded btn-sm">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>{{-- End of Form Column --}}


        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <h5>Employee Register</h5>
                </div>
                <div class="card-body">
                    @if (session('SuccessMsg'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('SuccessMsg') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('Error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('Error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="form-label" for="paginate">Show Pages</label>
                            </div>
                            <div class="col-sm-3">
                                <select name="datatable_length" wire:model="paginate" class="custom-select custom-select-sm form-control form-control-sm form-select form-select-sm">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label class="form-label" for="filterby">Filter By</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" wire:model="filterby" class="form-control form-control-sm" placeholder="Filter">
                            </div>
                        </div>

                    </div>

                    @if (count($employeeData) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>SL.No</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Role</th>
                                        <th>Branch</th>
                                        <th>Profile</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($employeeData as $data)
                                        <tr>
                                            <td>{{ $employeeData->firstItem() + $loop->index }}</td>
                                            <td>{{ $data->Name}},{{  $data->Username }}</td>
                                            <td>{{ $data->Mobile_No }}</td>
                                            <td>{{ $data->Role }}</td>
                                            <td>{{ $data->Branch }}</td>
                                            <td><img class="avatar-sm"
                                                src="{{ !empty($data->Profile_Img) ? asset('storage/' . $data->Profile_Img) : url('storage/no_image.jpg') }}">
                                            </td>
                                            <td>
                                                <a href="{{ route('edit.employee', $data->Id) }}" title="Edit" class="btn btn-sm btn-primary font-size-15" id="update"><i class="mdi mdi-circle-edit-outline"></i></a>
                                                <a href="{{ route('delete.employee', $data->Id) }}" title="Delete" class="btn btn-sm btn-danger font-size-15" id="delete"><i class="mdi mdi-trash-can"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11" class="text-center">
                                                <img class="avatar-xl" alt="No Result" src="{{ asset('storage/no_result.png') }}">
                                                <p>No Result Found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <p class="card-text"><small class="text-muted">Last Entry at {{ $lastRecTime }} </small></p>
                    @endif

                    <div class="row no-gutters align-items-center mt-3">
                        <div class="col-md-8">
                            <p class="text-muted">Showing {{ count($employeeData) }} of {{ $employeeData->total() }} entries</p>
                        </div>
                        <div class="col-md-4">
                            <span class="pagination pagination-rounded float-end">
                                {{ $employeeData->links() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
