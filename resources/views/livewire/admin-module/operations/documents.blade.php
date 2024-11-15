<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Document Advisore</h4>

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
                        <li class="breadcrumb-item active">Document Advisor</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Application</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    {{-- ---------------------------------------------------------------------------------------------------- --}}
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between"">
                    <h5 class="card-title">Add Documents</h5>
                    <h5 class="card-title"><a href="{{ route('add.document') }}"
                            title="Click here for New Transaction">New</a></h5>
                </div>
                <div class="card-body">
                    <p class="card-title-desc">Add Documents for each service </p>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Document ID</label>
                        <label for="example-text-input" class="col-sm-3 col-form-label">{{ $Doc_Id }}</label>
                    </div>
                    <!-- end row -->
                    <form wire:submit.prevent="SaveDocument()">
                        @csrf

                        {{-- Select Type --}}
                        <div class="row mb-3">
                            <label for="MainserviceId" class="col-sm-4 col-form-label">Select Service</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="MainserviceId" wire:model="MainserviceId" name="MainserviceId"  {{ $readonly }}         >                         <option value="" selected>Select Service </option>
                                    @foreach ($MainServices as $service)
                                        <option value="{{ $service->Id }}" selected>{{ $service->Name }}</option>
                                    @endforeach
                                </select>
                                <span class="error">@error('MainserviceId'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        @if (!is_null($Subservices))
                        {{-- Select Type --}}
                        <div class="row mb-3">
                            <label for="SubService" class="col-sm-4 col-form-label">Service Type</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="Main_Services" wire:model.lazy="SubService" name="SubService" {{ $readonly }} >
                                    <option value="" selected>---Select---</option>
                                    @foreach ($Subservices as $service)
                                        <option value="{{ $service->Id }}" selected>{{ $service->Name }}</option>
                                    @endforeach
                                </select>
                                <span class="error">@error('SubService'){{ $message }}@enderror</span>
                            </div>
                        </div>
                        @endif

                        {{--  --}}
                        <div class="row mb-3">
                            <label for="Name" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="text" placeholder="Doc Name" wire:model.lazy="Document_Name"
                                    id="Document_Name">
                                <span class="error">@error('Document_Name'){{ $message }}@enderror</span>
                            </div>
                            <div class="col-0">
                                @if(!$update)
                                <div class="md-form">
                                    <a href="#" wire:click.prevent="AddNewText({{ $i }})" name="add"
                                        class="btn btn-primary btn-rounded btn-sm">Add</a>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{--  --}}
                        @foreach ($NewTextBox as $item => $value)
                        <div class="row mb-3">
                            <label for="Document_Names" class="col-sm-4 col-form-label">Document : {{ $n++ }} </label>
                            <div class="col-sm-7">
                                <input class="form-control" type="text" placeholder="Enter Document  Name" wire:model="Document_Names.{{ $value }}"
                                    id="Document_Names">
                                <span class="error">@error('Document_Names'){{ $message }}@enderror</span>
                            </div>
                            <div class="col-0">
                                <div class="md-form">
                                    <a href="#" wire:click.prevent="Remove('{{ $value }}')" name="add"
                                        class="btn btn-danger btn-rounded btn-sm">Remove</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="form-data-buttons"> {{-- Buttons --}}
                            <div class="row">
                                <div class="col-100">
                                    <div class="col-100">
                                        @if (!$update)
                                            <button type="submit" value="submit" name="submit"
                                                class="btn btn-primary btn-rounded btn-sm">Save</button>
                                            <a href="#" wire:click.prevent="ResetFields()"
                                                class="btn btn-info btn-rounded btn-sm">Reset</a>
                                        @elseif($update)
                                            <a href="#" wire:click.prevent="Update()"
                                                class="btn btn-success btn-rounded btn-sm">Update</button>
                                                <a href="{{ route('add.document') }}"
                                                    class="btn btn-info btn-rounded btn-sm">Reset</a>
                                        @endif

                                        <a href='{{ route('admin.home') }}'
                                            class="btn  btn-warning btn-rounded btn-sm ">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        @if ($Existing_Documents && count($Existing_Documents) > 0)
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ count($Existing_Documents) }} Documents Available</h5>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <table id="datatable"
                            class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" role="grid"
                            aria-describedby="datatable_info">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Document Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($Existing_Documents as $doc)
                                    <tr>
                                        <td>{{ $Existing_Documents->firstItem() + $loop->index }}</td>
                                        <td>{{ $doc->Name }}</td>
                                        <td>
                                            <a href="{{ route('edit.doc', $doc->Id) }}"
                                                class="btn btn-sm btn-primary font-size-15" id="editData"><i
                                                    class="mdi mdi-circle-edit-outline"></i></a>

                                            <a href ="{{ route('delete.doc', $doc->Id) }}" class="btn btn-sm btn-danger font-size-15"
                                                id="delete"><i class="mdi mdi-delete-alert-outline"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No Document Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <p class="card-text"><small class="text-bold">Last document added at {{ $lastRecTime }} </small></p>

                        <div class="row no-gutters align-items-center">
                            <div class="col-md-8">
                                <p class="text-muted">Showing {{ count($Existing_Documents) }} of
                                    {{ $Existing_Documents->total() }} entries</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
</div>

