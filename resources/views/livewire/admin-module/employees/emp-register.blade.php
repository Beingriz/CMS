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
        <div class="col-lg-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Employee Registration</h5>
                    <a href="{{ route('emp.register') }}" class="btn btn-light btn-sm">New Employee</a>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="Save">
                        @csrf

                        <!-- Branch -->
                        <div class="mb-3">
                            <label class="form-label">Branch</label>
                            <select class="form-select" wire:model="Branch">
                                <option value="">---Select---</option>
                                @foreach ($Branches as $branch)
                                    <option value="{{ $branch->branch_id }}">{{ $branch->name }}, {{ $branch->address }}</option>
                                @endforeach
                            </select>
                            @error('Branch') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Name & Father's Name -->
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" placeholder="Employee Name" wire:model.lazy="Name">
                            @error('Name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Father's Name</label>
                            <input type="text" class="form-control" placeholder="Father's Name" wire:model.lazy="Father_Name">
                            @error('Father_Name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Gender & DOB -->
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select class="form-select" wire:model.lazy="Gender">
                                <option value="">---Select---</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @error('Gender') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">DOB</label>
                            <input type="date" class="form-control" wire:model.lazy="DOB">
                            @error('DOB') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Mobile & Email -->
                        <div class="mb-3">
                            <label class="form-label">Mobile No</label>
                            <input type="number" class="form-control" placeholder="Mobile Number" wire:model.lazy="Mobile_No">
                            @error('Mobile_No') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Id</label>
                            <input type="email" class="form-control" placeholder="Email ID" wire:model.lazy="Email_Id">
                            @error('Email_Id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" rows="3" placeholder="Employee Current Address" wire:model.lazy="Address"></textarea>
                            @error('Address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label class="form-label">Emp Role</label>
                            <select class="form-select" wire:model="Role">
                                <option value="">---Select---</option>
                                <option value="admin">Admin</option>
                                <option value="branch admin">Branch Admin</option>
                                <option value="operator">Operator</option>
                            </select>
                            @error('Role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Qualification & Experience -->
                        <div class="mb-3">
                            <label class="form-label">Qualification</label>
                            <select class="form-select" wire:model="Qualification">
                                <option value="">---Select---</option>
                                <option value="SSLC">SSLC</option>
                                <option value="PUC">PUC</option>
                                <option value="Graduation">Graduation</option>
                                <option value="Post Graduation">Post Graduation</option>
                            </select>
                            @error('Qualification') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Experience</label>
                            <select class="form-select" wire:model.lazy="Experience">
                                <option value="">---Select---</option>
                                <option value="Fresher">Fresher</option>
                                <option value="1 year">1 year</option>
                                <option value="2 year">2 year</option>
                                <option value="3 year & above">3 year & above</option>
                            </select>
                            @error('Experience') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <!-- Qualification Certificate -->
                        <div class="mb-3">
                            <label class="form-label">Education Certificate</label>
                            <input type="file" class="form-control" wire:model="Qualification_Doc" accept="image/*,application/pdf">
                            @error('Qualification_Doc') <span class="text-danger">{{ $message }}</span> @enderror

                        </div>

                        <!-- Resume File -->
                        <div class="mb-3">
                            <label class="form-label">Resume File</label>
                            <input type="file" class="form-control" wire:model="Resume_Doc" accept="application/pdf">
                            @error('Resume_Doc') <span class="text-danger">{{ $message }}</span> @enderror

                        </div>

                        <!-- Profile Image -->
                        <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" class="form-control" wire:model="Profile_Img" accept="image/*">
                            @error('Profile_Img') <span class="text-danger">{{ $message }}</span> @enderror

                            <!-- Profile Image Preview -->
                            <div class="mt-2">
                                @if ($Profile_Img)
                                    <img src="{{ $Profile_Img->temporaryUrl() }}" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                @elseif ($Old_Profile_Img)
                                    <img src="{{ asset('storage/' . $Old_Profile_Img) }}" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('storage/no_image.jpg') }}" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                @endif
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            @if ($update == 0)
                                <button type="submit" class="btn btn-primary w-100"><i class="mdi mdi-content-save"></i>
                                    Save</button>
                            @elseif($update == 1)
                                <button wire:click.prevent="Update('{{ $Id }}')" class="btn btn-success w-100"><i class="mdi mdi-content-save"></i>
                                    Update</button>
                            @endif
                            <a href="{{ route('emp.register') }}" class="btn btn-info w-100">
                                <i class="mdi mdi-refresh"></i> Reset
                            </a>
                            <a href="{{ route('admin.home') }}" class="btn btn-warning w-100">
                                <i class="mdi mdi-arrow-left"></i> Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-lg-7">
            <div class="card shadow-lg">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h5 class="mb-0">Employee Register</h5>
                </div>

                <div class="card-body">
                    <!-- Pagination & Filter Options -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                        <div class="row w-100">
                            <div class="col-md-6 d-flex align-items-center">
                                <label class="me-2">Show</label>
                                <select wire:model="paginate" class="form-select form-select-sm w-auto">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                                <label class="ms-2">entries</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" wire:model="filterby" class="form-control form-control-sm" placeholder="Search Employee...">
                            </div>
                        </div>
                    </div>

                    @if (count($employeeData) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Mobile</th>
                                        <th>Role</th>
                                        <th>Branch</th>
                                        <th>Profile</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employeeData as $index => $data)
                                        <tr>
                                            <td>{{ $employeeData->firstItem() + $index }}</td>
                                            <td>{{ $data->Name }}</td>
                                            <td>{{ $data->Username }}</td>
                                            <td>{{ $data->Mobile_No }}</td>
                                            <td>{{ ucwords($data->Role) }}</td>
                                            <td>{{ $data->branch->name }}, {{ $data->branch->address }}</td>
                                            <td>
                                                <img class="rounded img-thumbnail"
                                                     src="{{ $data->Profile_Img ? asset('storage/' . $data->Profile_Img) : url('storage/no_image.jpg') }}"
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <a id="editRecord" funName="edit" recId="{{ $data->Id }}"
                                                    class="btn btn-primary btn-sm"
                                                    title="Edit">
                                                     <i class="mdi mdi-circle-edit-outline"></i>
                                                 </a>
                                                 <a id="deleteRecord" funName="delete" recId="{{ $data->Id }}"
                                                    class="btn btn-danger btn-sm"
                                                    title="Delete">
                                                     <i class="mdi mdi-trash-can"></i>
                                                 </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <p class="text-muted text-end mt-2">
                            <small>Last Entry: {{ $lastRecTime }}</small>
                        </p>
                    @else
                        <div class="text-center p-4">
                            <img src="{{ asset('storage/no_result.png') }}" class="img-fluid" style="max-width: 150px;" alt="No Result">
                            <p class="mt-2 text-muted">No Employees Found</p>
                        </div>
                    @endif

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="text-muted mb-0">Showing {{ count($employeeData) }} of {{ $employeeData->total() }} entries</p>
                        <nav>
                            {{ $employeeData->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
