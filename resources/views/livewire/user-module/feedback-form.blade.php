<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Feedback</h4>

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
                        <li class="breadcrumb-item active">Feedback Form</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('user.home', Auth::user()->id) }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('service.list') }}">Services</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}



    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="row ">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h4 class="card-title text-center fw-bold text-primary">Feedback Form</h4>
                    <p class="text-center text-muted">We value your feedback! 🚀</p>

                    {{-- Application ID --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Application ID</label>
                        <div class="form-control bg-light">{{ $FB_Id }}</div>
                    </div>

                    {{-- Feedback Form --}}
                    <form wire:submit.prevent="Feedback">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="Name" class="form-label fw-semibold">Your Name</label>
                            <input type="text" id="Name" class="form-control"
                                placeholder="Enter your name" wire:model="Name">
                            @error('Name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- Message --}}
                        <div class="mb-3">
                            <label for="Description" class="form-label fw-semibold">Your Feedback</label>
                            <textarea id="Description" wire:model="Message" name="Description"
                                class="form-control" placeholder="Share your thoughts with us..."
                                rows="5"></textarea>
                            @error('Message') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-send"></i> Submit Feedback
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
