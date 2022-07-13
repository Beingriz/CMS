<div>
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Home Slide Page</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">{{$profiledata->username}}</a></li>
                <li class="breadcrumb-item active">Update Slide Banner</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-5">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div>
                                @csrf
                                    @if (session('SuccessMsg'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="mdi mdi-check-all me-2"></i>
                                        {{session('SuccessMsg')}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><br>
                                    </div>
                                    @endif
                                    @if (session('Error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="mdi mdi-block-helper me-2"></i>
                                        {{session('Error')}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif
                                    {{-- Title --}}
                                    <div class="row mb-3">
                                        <label for="title" class="col-sm-3 col-form-label">Tittle </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text"  wire:model="title"placeholder="Title" id="title">
                                            <span class="error">@error('title'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    {{-- Short Description --}}
                                    <div class="row mb-3">
                                        <label for="short_desc" class="col-sm-3 col-form-label">Description </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" type="text"  wire:model="short_desc"placeholder="Short Description" id="short_desc"></textarea>
                                            <span class="error">@error('short_desc'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    {{-- Video URL --}}
                                    <div class="row mb-3">
                                        <label for="video_url" class="col-sm-3 col-form-label">Video URL </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text"  wire:model="video_url"placeholder="Video URL" id="video_url">
                                            <span class="error">@error('video_url'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    {{-- Slid Image --}}
                                    <div class="row mb-3">
                                        <label for="slide_image" class="col-sm-3 col-form-label">Slide Icon</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file"  wire:model="slide_image" id="slide_image">
                                        </div>
                                    </div>
                                    {{-- Preview Profile Image --}}
                                    @if (!is_Null($slide_image))
                                    <div class="row mb-3">
                                        <label for="slide_image" class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <div wire:loading wire:target="slide_image">Uploading...</div>
                                            <img class=" rounded avatar-lg" src="{{ $slide_image->temporaryUrl() }}" alt="" />
                                            </div>
                                    </div>
                                    @elseif (!is_Null($old_slide_image))
                                    <div class="row mb-3">
                                        <label for="slide_image" class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <img class=" rounded avatar-lg" src="{{asset('storage/'.$old_slide_image) }}" alt="" />
                                            </div>
                                    </div>
                                    @endif
                            </div>
                            <div class="card-body">
                                <a href="#" wire:click="UpdateSlide('1')" class="btn btn-info btn-rounded waves-effect waves-light">Update Slide</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Home Slide</h4>
                    <p class="card-title-desc"></p>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <caption>List of users</caption>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tittle</th>
                                    <th>Short Desc.</th>
                                    <th>Video URL</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($home_slide as $data )


                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{$data['title']}}</td>
                                    <td>{{$data['short_desc']}}</td>
                                    <td>{{$data['video_url']}}</td>

                                    <td>
                                       <a href="#" wire:click.prevet="Fetch('{{$data['id']}}')" class="btn btn-primary btn-rounded waves-effect waves-light">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end col -->

</div><!-- end livewire  -->


