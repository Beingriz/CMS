<div>
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="text-primary fw-bold">Welcome, {{ Auth::user()->name }} 👋</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('services') }}">Services</a></li>
                        <li class="breadcrumb-item active">Application</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @foreach (['SuccessMsg' => 'success', 'SuccessUpdate' => 'warning', 'Error' => 'danger'] as $msg => $type)
        @if(session($msg))
            <div class="alert alert-{{ $type }} alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-{{ $type == 'success' ? 'check-circle' : ($type == 'warning' ? 'exclamation-triangle' : 'x-circle') }} me-2"></i>
                {{ session($msg) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endforeach

    <!-- Application Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-1 rounded">
                <div class="card-header bg-light">
                    <h4 class="text-secondary">Apply for {{ $mainServiceName }} | {{ $ServiceName }}</h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="ApplyNow">
                        @csrf

                        <div class="row g-3">
                            <!-- Application ID -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Application ID</label>
                                <input type="text" class="form-control" value="{{ $App_Id }}" readonly>
                            </div>
                            <!-- Application ID -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Service Fee</label>
                                <input type="text" class="form-control" value="{{ $Amount }}" readonly>
                            </div>

                            <!-- Branch Selection -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Select Branch</label>
                                <select class="form-select" wire:model="Branch">
                                    <option value="">-- Select Branch --</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->branch_id }}" @if($branch->branch_id == Auth::user()->Branch_Id) selected @endif>
                                            {{ $branch->address }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('Branch') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Personal Information -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Your Name</label>
                                <input type="text" class="form-control" wire:model.lazy="Name" placeholder="Enter Your Name">
                                @error('Name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone No</label>
                                <input type="text" class="form-control" wire:model.lazy="PhoneNo" placeholder="Mobile No">
                                @error('Mobile_no') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Father's Name</label>
                                <input type="text" class="form-control" wire:model.lazy="FatherName" placeholder="Father's Name">
                                @error('FatherName') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Date of Birth</label>
                                <input type="date" class="form-control" wire:model.lazy="Dob">
                                @error('Dob') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Message</label>
                                <textarea class="form-control" wire:model.lazy="Description" placeholder="Additional message"></textarea>
                                @error('Description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- File Upload -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Upload Attachment</label>
                                <input type="file" class="form-control" wire:model="File" accept=".jpg,.png,.pdf,.docx">
                                <small class="text-muted">Allowed formats: .jpg, .png, .pdf, .docx (Max: 2MB)</small>
                                @error('File') <small class="text-danger">{{ $message }}</small> @enderror
                                <div wire:loading wire:target="File" class="text-info mt-2">Uploading... ⏳</div>
                            </div>

                            <!-- Display Selected File -->
                            @if ($File)
                                <div class="col-md-12">
                                    @if (in_array($File->getClientOriginalExtension(), ['jpg', 'png']))
                                        <img src="{{ $File->temporaryUrl() }}" alt="Preview" width="100" class="mt-2 rounded shadow">
                                    @endif
                                    <button type="button" class="btn btn-danger btn-sm mt-2" wire:click="clearFile">Clear File</button>
                                </div>
                            @endif
                        </div>


                        @if(!is_null($File))
                        <!-- Consent Checkbox (Trigger Modal) -->
                        <div class="mb-4 form-check">
                         <input type="checkbox" class="form-check-input" id="read" wire:model="Read_Consent" wire:click="prepareConsent" data-bs-toggle="modal" data-bs-target="#consentModal" @if($disabled) disabled @endif>
                         <label class="form-check-label" for="read">I agree to the terms and conditions</label>
                         @error('Read_Consent') <small class="text-danger">{{ $message }}</small> @enderror{{ $Recived }}
                         @endif

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <button type="submit" class="btn btn-primary btn-rounded" @if($isProcessing) disabled @endif>
                                {{ $isProcessing ? 'Processing...' : 'Apply Now' }}
                            </button>
                            <button type="button" wire:click.prevent="ResetFields" class="btn btn-secondary btn-rounded">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Digital Consent Modal -->
        <div class="modal fade" id="consentModal" tabindex="-1" aria-labelledby="consentModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="consentModalLabel">Digital Consent</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ $ConsentMatter }}</p><br>
                        <p>By clicking "Sign Digitally", you agree to our terms and conditions.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" wire:click="SignDigitally">Sign Digitally</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Required Documents Section -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="text-secondary">Required Documents</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse ($documents as $doc)
                            <li class="list-group-item">{{ $doc['Name'] }}</li>
                        @empty
                            <li class="list-group-item text-muted">No Documents Required</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
