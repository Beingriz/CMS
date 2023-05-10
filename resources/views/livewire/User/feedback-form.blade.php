<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Feedback</h4>

                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('SuccessMsg')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('SuccessUpdate'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{session('SuccessUpdate')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('Error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session('Error')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">{{Auth::user()->name}}</li>
                        <li class="breadcrumb-item active">Feedback Form</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('user.home',Auth::user()->id)}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('service.list')}}">Services</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}



    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Feedback Form</h4>
                    <p class="card-title-desc"></p>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Application Id</label>
                        <div class="col-sm-10">
                            <label for="example-text-input" class="col-sm-10 col-form-label">{{$FB_Id}}</label>
                        </div>
                    </div>
                    <!-- end row -->
                    <form wire:submit.prevent="Feedback">
                        @csrf


                    <div class="row mb-3">
                        <label for="Name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Your Name"  wire:model="Name" id="Name">
                            <span class="error">@error('Name'){{$message}}@enderror</span>
                        </div>
                    </div>

                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="Description" class="col-sm-2 col-form-label">Message</label>
                        <div class="col-sm-10">
                            <textarea id="Description" wire:model="Message" name="Description" class="form-control"
                                placeholder="Hey! {{$Name}}!, Feedback is the gift that keeps on giving, helping us to grow and thrive in all aspects of life." rows="7" id="Description"></textarea>
                                        <span class="error">@error('Message'){{$message}}@enderror</span>
                        </div>
                    </div>

                    <div class="form-data-buttons"> {{--Buttons--}}
                        <div class="row">
                            <div class="col-100 text-align-center">
                                <button type="submit" value="submit" name="submit"
                                class="btn btn-primary btn-rounded btn-sm">Submit</button>

                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div> <!-- end col -->


        {{-- Consent Details End--}}

    </div>
</div>

