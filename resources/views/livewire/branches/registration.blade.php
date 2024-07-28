<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Branch Registration</h4>

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
                        <li class="breadcrumb-item active">Bookmarks</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ url('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('app_home') }}">Application</a></li>
            <li class="breadcrumb-item"><a href="{{ url('app_form') }}">New Application</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    {{-- ---------------------------------------------------------------------------------------------------- --}}
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between"">
                    <h5>New Branch</h5>
                    <h5><a href="{{ route('branch_register') }}" title="Click here for New Transaction">Create New</a></h5>
                </div>
                <div class="card-body">

                    <p class="card-title-desc">Welcome to Branch Registration</p>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Branch Id</label>
                        <label for="example-text-input" class="col-sm-7 col-form-label">{{ $Br_Id }}</label>

                    </div>
                    <!-- end row -->
                    <form wire:submit.prevent="Save">
                        @csrf

                        <div class="row mb-3">
                            <label for="Name" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" placeholder="Branch Name" wire:model="Name"
                                    id="Name">
                                <span class="error"> @error('Name') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="example-url-input" class="col-sm-4 col-form-label">Address</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" type="text" wire:model="Address"
                                    placeholder="Address" rows="3" cols="5" id="example-url-input"></textarea>
                                <span class="error"> @error('Address') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="googlemap" class="col-sm-4 col-form-label">Google Map Link</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" placeholder="Google Map Link" wire:model="MapLink"
                                    id="MapLink">
                                <span class="error"> @error('MapLink') {{ $message }} @enderror </span>
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

                                    <a href='{{ route('admin.home') }}'
                                        class="btn  btn-warning btn-rounded btn-sm ">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->

    @if (count($Existing_branches) > 0)
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">#{{ $Existing_branches->total() }} Branches Available</h5>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <table id="datatable"
                        class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline text-wrap"role="grid"
                        aria-describedby="datatable_info">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Link</th>
                                <th>Applicants</th>
                                <th>Employess</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Existing_branches as $key)
                                <tr>
                                    <td>{{ $Existing_branches->firstItem() + $loop->index }}</td>
                                    <td>{{ $key->name }}</td>
                                    <td class="text-wrap">{{ $key->address }}</td>
                                    <td class="text-wrap">{{ $key->google_map_link }}</td>
                                    <td>{{ $key->user_count }}</td>
                                    <td>{{ $key->employee_count }}</td>

                                    <td>
                                        <a href="{{ route('edit.branch', $key->branch_id) }}"
                                            class="btn btn-sm btn-primary font-size-15" id="editData"><i
                                                class="mdi mdi-circle-edit-outline"></i></a>

                                        <a href ="{{ route('delete.branch', $key->branch_id) }}"class="btn btn-sm btn-danger font-size-15"
                                            id="delete"><i class="mdi mdi-delete-alert-outline"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-8">
                            <p class="text-muted">Showing {{ count($Existing_branches) }} of
                                {{ $Existing_branches->total() }} entries</p>
                        </div>
                        <div class="col-md-4">
                            <span class=" pagination pagination-rounded float-end">
                                {{ $Existing_branches->links() }}
                            </span>


                        </div>
                        <p class="card-text"><small class="text-muted">Last Bookmarked
                                {{ $created }}</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
</div>
