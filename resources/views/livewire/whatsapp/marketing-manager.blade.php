<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Whatsapp Marketing Bulk Message Sender</h4>

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
                        <li class="breadcrumb-item active">Marketing</li>
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
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between"">
                    <h5>Send Messages</h5>
                    <h5><a href="{{ route('whatsapp.marketing') }}" title="Click here for New Template">Refresh</a></h5>
                </div>
                <div class="card-body">

                    <p class="card-title-desc">Session </p>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Session Id</label>
                        <label for="example-text-input" class="col-sm-7 col-form-label">Seesion ID</label>

                    </div>
                    <!-- end row -->
                    <form wire:submit.prevent="Preview">
                        @csrf
                        <div class="row mb-3">
                            <label for="Name" class="col-sm-4 col-form-label">Service</label>
                            <div class="col-sm-8">
                                <select class="form-select" wire:model="selectedService">
                                    <option selected="">Select Service</option>
                                    @foreach ($main_service as $service)
                                        <option value="{{ $service->Id }}">{{ $service->Name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedService')<span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="Name" class="col-sm-4 col-form-label">Service Type</label>
                            <div class="col-sm-8">
                                <select class="form-select" wire:model="selectedServiceType">
                                <option selected="">Select Service</option>
                                @foreach ($sub_service as $service)
                                    <option value="{{ $service->Name }} "> {{ $service->Name }}</option>
                                @endforeach
                            </select>
                            @error('selectedServiceType')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="example-url-input" class="col-sm-4 col-form-label">Templates</label>
                            <div class="col-sm-8">
                                <select class="form-select" wire:model="selectedTemplateId">
                                <option selected="">Select Template</option>
                                @foreach ($templates as $template)
                                    <option value="{{ $template->id }} ">{{ ucwords(str_replace('_', ' ', $template->template_name)) }}</option>
                                @endforeach
                            </select>
                            @error('selectedTemplateId')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="googlemap" class="col-sm-4 col-form-label">Media Url</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" placeholder="Media Url (Optional)" wire:model="media_url"
                                    id="media_url">
                                <span class="error"> @error('media_url') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="form-data-buttons"> {{-- Buttons --}}
                            <div class="row">
                                <div class="col-100">
                                    @if ($unhide)
                                    <button type="submit" value="submit" name="submit"
                                    class="btn btn-primary btn-rounded btn-sm">Preview</button>
                                    @endif

                                        <a href="#" wire:click.prevent="resetInputs()"
                                            class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    <a href='{{ route('admin.home') }}'
                                        class="btn  btn-warning btn-rounded btn-sm ">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->

        {{-- -----------------Session at Glance------------------ --}}
        @if ($isPreview)
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between"">
                    <h5>Preview</h5>
                </div>
                <div class="card-body">

                    <p class="card-title-desc">Session </p>
                    <form wire:submit.prevent="sendBulkMessages">
                        @csrf
                        <!-- start row -->
                        <div class="row mb-0">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Service</label>
                            <label for="example-text-input" class="col-sm-7 col-form-label text-black">{{ $serviceName }}</label>
                        </div>
                        <!-- end row -->
                        <!-- start row -->
                        <div class="row mb-0">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Service Type</label>
                            <label for="example-text-input" class="col-sm-7 col-form-label text-black">{{ $selectedServiceType }}</label>
                        </div>
                        <!-- end row -->
                        <!-- start row -->
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Template Name</label>
                            <label for="example-text-input" class="col-sm-7 col-form-label text-black">{{ ucwords(str_replace('_', ' ', $templateName)) }}</label>
                        </div>
                        <!-- end row -->
                        <!-- start row -->
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Template Body</label>
                            <label for="example-text-input" class="col-sm-7 col-form-label text-black">{{ $templateBody }}</label>
                        </div>
                        <!-- end row -->
                        <!-- start row -->
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Total Recepients</label>
                            <label for="example-text-input" class="col-sm-7 col-form-label text-black">{{ $totalClients }}</label>
                        </div>
                        <!-- end row -->
                        <!-- start row -->
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Messeging Cost</label>
                            <label for="example-text-input" class="col-sm-7 col-form-label text-danger">&#8377;{{ intval($totalClients * 0.415) }}/- only.</label>
                        </div>
                        <!-- end row -->

                        <div class="form-data-buttons"> {{-- Buttons --}}
                            <div class="row">
                                <div class="col-100">
                                        <button type="submit" value="submit" name="submit"
                                            class="btn btn-success btn-rounded btn-sm">Send</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
        @endif
    </div>



</div>
