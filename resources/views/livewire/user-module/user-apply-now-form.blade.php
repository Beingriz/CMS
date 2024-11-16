<div>
    {{-- The whole world belongs to you. --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Welcome {{ Auth::user()->name }}<span class="text-primary"></span> </h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('services') }}">Services</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('history', Auth::user()->mobile_no) }}">My History</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Application</h4>

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
                        <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
                        <li class="breadcrumb-item active">Application</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('user.home', Auth::user()->id) }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('service.list') }}">Services</a></li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Applying for {{ $mainServiceName }} | {{ $ServiceName }}</h4>
                    <p class="card-title-desc">The application for the above service is considered once the verification is completed. </p>

                    <!-- Application Id -->
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Application Id</label>
                        <div class="col-sm-10">
                            <label for="example-text-input" class="col-sm-10 col-form-label">{{ $App_Id }}</label>
                        </div>
                    </div>

                    <!-- Branch Selection -->
                    <div class="row mb-3">
                        <label for="branch" class="col-sm-2 col-form-label">Select Branch</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="branch" wire:model="Branch" name="Branch">
                                <option value="">--Select Branch--</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->branch_id  }}"
                                        @if($branch->branch_id == Auth::user()->Branch_Id) selected @endif>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="error">
                                @error('Branch')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>

                    <form wire:submit.prevent="ApplyNow">
                        @csrf

                        <!-- Service Category -->
                        <div class="row mb-3">
                            <label for="Category_Type" class="col-sm-2 col-form-label">Service for</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="Category_Type" wire:model="Category_Type" name="Category_Type">
                                    <option value="{{ $mainServiceName }}">{{ $mainServiceName }}</option>
                                </select>
                                <span class="error">
                                    @error('Category_Type')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <!-- Service Type and Amount -->
                        <div class="row mb-3">
                            <label for="Service_Type" class="col-sm-2 col-form-label">Service Type</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="Service_Type" wire:model="Service_Type" name="Service_Type">
                                    <option value="{{ $ServiceName }}">{{ $ServiceName }}</option>
                                </select>
                                <span class="error">
                                    @error('Service_Type')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <label for="Amount" class="col-sm-2 col-form-label">Amount</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" disabled placeholder="Amount Payable" wire:model.lazy="Amount" id="Amount">
                            </div>
                            <p class="card-text"><small class="text-muted">The Total Amount Payable for this Service is Agreed by you once verification is completed.</small></p>
                        </div>

                        <!-- Personal Information -->
                        <div class="row mb-3">
                            <label for="Name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Your Name" wire:model.lazy="Name" id="Name">
                                <span class="error">
                                    @error('Name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- Personal Information -->
                        <div class="row mb-3">
                            <label for="Dob" class="col-sm-2 col-form-label">DOB</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="date" placeholder="Your Name" wire:model.lazy="Dob" id="Dob">
                                <span class="error">
                                    @error('Dob')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <!-- Additional Fields: Father Name, Date of Birth, Phone Number, Description -->
                        <!-- Add other form fields here similarly -->

                        <!-- File Upload -->
                        <div class="row mb-3">
                            <label for="File" class="col-sm-2 col-form-label">Attachment</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="file" wire:model="File" id="File" accept="image/*">
                                <p class="card-text"><small class="text-muted">Select .jpg or .png format only</small></p>
                                <span class="error">
                                    @error('File')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div wire:loading wire:target="File">Uploading...</div>

                        <!-- Consent Terms -->
                        <div class="row mb-3">
                            <label for="read" class="col-sm-2 col-form-label">Consent</label>
                            <div class="col-sm-10">
                                <input type="checkbox" id="read" switch="primary" {{ $disabled }} wire:model="Read_Consent">
                                <label for="read" data-on-label="Yes" data-off-label="No"></label>
                                <span class="error">
                                    @error('Read_Consent')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <!-- Submit and Reset Buttons -->
                        <div class="form-data-buttons">
                            <div class="row">
                                <div class="col-100">
                                    <button type="submit" value="submit" name="submit" class="btn btn-primary btn-rounded btn-sm">Apply Now</button>
                                    <a href="" wire:click.prevent="ResetFields" class="btn btn-warning btn-rounded btn-sm">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Consent Details -->
        @if ($Read_Consent == 1)
            <div class="col-lg-6" id="Consent">
                <div class="card card-body">
                    <h3 class="card-title">Consent for Sharing Document</h3>
                    <p class="card-text">
                        {{ $Name }} C/o {{ $FatherName }} <br>
                        {{ $Address }} <br>
                        {{ $PhoneNo }} <br><br>
                        {{ $ConsentMatter }} <br>
                        {{ $Name }} <br>
                        <p>Digitally Signed by {{ $Name }} on </p> {{ $signature }}
                    </p>
                    @if ($Signed)
                        <a href="#" class="btn btn-success" wire:click.prevent="CompleteApplication">Completed</a>
                    @else
                        <a href="#" class="btn btn-primary" wire:click.prevent="UploadSignature">Submit Signature</a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
