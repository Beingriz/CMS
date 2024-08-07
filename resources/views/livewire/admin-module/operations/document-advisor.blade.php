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
            <li class="breadcrumb-item"><a href="{{ url('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('app_home') }}">Application</a></li>
            <li class="breadcrumb-item"><a href="{{ url('app_form') }}">New Application</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    {{-- ---------------------------------------------------------------------------------------------------- --}}
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> Document Advisor</h4>
                    <p class="card-title-desc">Add Documents</p>

                    <!-- end row -->
                    <form wire:submit.prevent="SaveDocument()">
                        @csrf

                        {{-- Select Type --}}
                        <div class="row mb-3">
                            <label for="MainserviceId" class="col-sm-4 col-form-label">Select Service</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="MainserviceId" wire:model="MainserviceId" name="MainserviceId"  {{ $readonly }}         >                         <option value="" selected>Select Service </option>
                                    <option value="">---Select---</option>
                                    @foreach ($MainServices as $service)
                                        <option value="{{ $service->Id }}" selected>{{ $service->Name }}</option>
                                    @endforeach
                                </select>
                                <span class="error">@error('MainserviceId'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        @if (!is_null($MainserviceId))
                        {{-- Select Type --}}
                        <div class="row mb-3">
                            <label for="SubService" class="col-sm-4 col-form-label">Service Type</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="Main_Services" wire:model="SubService" name="SubService" {{ $readonly }} >
                                    <option value="" selected>---Select---</option>
                                    @foreach ($Subservices as $service)
                                        <option value="{{ $service->Id }}" selected>{{ $service->Name }}</option>
                                    @endforeach
                                </select>
                                <span class="error">@error('SubService'){{ $message }}@enderror</span>
                            </div>
                        </div>
                        @endif

                        @if (!is_null($SubService))
                        {{-- Select Type --}}
                        <div class="row mb-3">
                            <table id="datatable"
                            class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" role="grid"
                            aria-describedby="datatable_info">
                            <thead class="table-dark">
                                    <tr>
                                        <th>Selling Price</th>
                                        <th>Govt Fee</th>
                                        <th>Profit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>&#x20B9;{{ $UnitPrice }}</td>
                                        <td>&#x20B9;{{ $ServiceFee }}</td>
                                        <td>&#x20B9;{{ $Margin }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                        @endif
                    </form>
                    </div>
                </div>

        @if ($Existing_Documents && count($Existing_Documents) > 0)
        <div class="col-lg-5">
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
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($Existing_Documents as $doc)
                                    <tr>
                                        <td>{{ $Existing_Documents->firstItem() + $loop->index }}</td>
                                        <td>{{ $doc->Name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No Document Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-8">
                                <p class="text-muted">Showing {{ count($Existing_Documents) }} of
                                    {{ $Existing_Documents->total() }} entries</p>
                            </div>
                            <div class="col-md-4">
                                <span class="pagination pagination-rounded float-end">
                                    {{ $Existing_Documents->links() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

