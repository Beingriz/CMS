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
            <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                {{ session($msg) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endforeach

    <!-- Application Form -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow border-1 -mb-2 rounded">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4 text-secondary">Apply for {{ $mainServiceName }} | {{ $ServiceName }}</h4>

                    <form wire:submit.prevent="ApplyNow">
                        @csrf

                        <!-- Application ID -->
                        <div class="mb-3">
                            <label for="App_Id" class="form-label fw-semibold">Application ID</label>
                            <input type="text" class="form-control" id="App_Id" value="{{ $App_Id }}" readonly>
                        </div>

                        <!-- Branch Selection -->
                        <div class="mb-3">
                            <label for="branch" class="form-label fw-semibold">Select Branch</label>
                            <select class="form-select" id="branch" wire:model="Branch">
                                <option value="">-- Select Branch --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->branch_id }}"
                                        @if($branch->branch_id == Auth::user()->Branch_Id) selected @endif>
                                        {{ $branch->address }}
                                    </option>
                                @endforeach
                            </select>
                            @error('Branch') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Service Info (Category & Amount) -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="Category_Type" class="form-label fw-semibold">Service Category</label>
                                <input type="text" class="form-control" id="Category_Type" value="{{ $mainServiceName }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="Amount" class="form-label fw-semibold">Amount</label>
                                <input type="text" class="form-control" id="Amount" wire:model="Amount" readonly placeholder="Amount Payable">
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="mb-3">
                            <label for="Name" class="form-label fw-semibold">Your Name</label>
                            <input type="text" class="form-control" id="Name" wire:model.lazy="Name" placeholder="Enter Your Name">
                            @error('Name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="FatherName" class="form-label fw-semibold">Father's Name</label>
                            <input type="text" class="form-control" id="FatherName" wire:model.lazy="FatherName" placeholder="Father's Name">
                            @error('FatherName') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Dob" class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" class="form-control" id="Dob" wire:model.lazy="Dob">
                            @error('Dob') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Message" class="form-label fw-semibold">Message</label>
                            <textarea class="form-control" id="Message" wire:model.lazy="Description" placeholder="Additional message"></textarea>
                            @error('Description') <small class="text-danger">{{ $Description }}</small> @enderror
                        </div>

                        <!-- Upload File -->
                        <div class="mb-3">
                            <label for="File" class="form-label fw-semibold">Upload Attachment</label>
                            <input type="file" class="form-control" id="File" wire:model="File" accept=".jpg,.png,.pdf,.docx">
                            <small class="text-muted">Allowed formats: .jpg, .png, .pdf, .docx (Max: 2MB)</small>
                            @error('File') <small class="text-danger">{{ $message }}</small> @enderror

                            <!-- Upload Feedback -->
                            <div wire:loading wire:target="File" class="text-info mt-2">Uploading... ⏳</div>
                        </div>

                        @if(!is_null($File))
                       <!-- Consent Checkbox (Trigger Modal) -->
                       <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="read" wire:model="Read_Consent" wire:click="prepareConsent" data-bs-toggle="modal" data-bs-target="#consentModal" @if($disabled) disabled @endif>
                        <label class="form-check-label" for="read">I agree to the terms and conditions</label>
                        @error('Read_Consent') <small class="text-danger">{{ $message }}</small> @enderror{{ $Recived }}
                        @endif
                        {{ $File }}
                         <!-- File Info (if uploaded) -->
                    @if ($File)
                    <div class="mt-3">
                        <strong>Selected File:</strong> {{ $File->getClientOriginalName() }}

                        <!-- Image Preview -->
                        @if (in_array($File->getClientOriginalExtension(), ['jpg', 'png']))
                            <img src="{{ $File->temporaryUrl() }}" alt="Preview" width="100" class="mt-2">
                        @endif

                        <!-- Clear Button -->
                        <button type="button" class="btn btn-danger btn-sm mt-2" wire:click="clearFile">Clear File</button>
                    </div>
                @endif
                    </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3">
                            <button type="submit" class="btn btn-primary btn-rounded" @if($isProcessing) disabled @endif>
                                {{ $isProcessing ? 'Processing...' : 'Apply Now' }}
                            </button>

                            <button type="button" wire:click.prevent="ResetFields" class="btn btn-secondary btn-rounded">Reset</button>
                            <br>
                        </div>
                    </form>
                </div>
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
</div> <div>
    <script>
        document.getElementById('read').addEventListener('change', function(event) {
            if (!event.target.files.length) {
                Livewire.emit('clearFile');
            }
        });
    </script>
</div>

</div>


