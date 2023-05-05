<div>
    {{-- The whole world belongs to you. --}}
    <div class="row">{{-- Messags / Notification Row--}}
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Welcome {{Auth::user()->name}}<span class="text-primary"></span> </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('services')}}">Services</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('history',Auth::user()->mobile_no)}}">My History</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

     <div class="row"> {{-- Start of Services Row --}}
        <div href="#" class="col-xl-3 col-md-10" >
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">

                        {{-- <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fas fa-edit"></i></i>
                            </span>
                        </div> --}}
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-primary font-size-20 mb-2">{{$name}}</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5>Applied Total</h5>
                                    <p class="mb-2 text-truncate">Deleted  Applications</p>
                                </div>
                            </div>
                        </div>

                        {{-- <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{ (!empty($old_profile_image))?url('storage/'.$old_profile_image):url('storage/no_image.jpg')}}" alt="Generic placeholder image"> --}}


                    </div>
                </div>
            </div>
        </div>

        <div href="#" class="col-xl-3 col-md-10" >
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">

                        {{-- <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fas fa-edit"></i></i>
                            </span>
                        </div> --}}
                        {{-- <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-warning font-size-20 mb-2">Applications Deliverd</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <a href="" wire:click.prevent="Show('Delivered to Client')"> <h5>Delivered : {{$App_Delivered}}</h5></a>

                                    <div class="d-flex justify-content-between">
                                        <a href="#" wire:click.prevent="Show('Received')"><p class="mb-2 text-truncate">Pending {{$Pedning_App}}</p></a>
                                        <a href="#" wire:click.prevent="Show('All')"><p class="mb-2 text-truncate">Other {{$Rest_App}}</p></a>

                                    </div>

                                </div>
                            </div>
                        </div> --}}

                        {{-- <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{ (!empty($item->Thumbnail))?url('storage/Admin/Services/Thumbnail'.$item->Thumbnail):url('storage/no_image.jpg')}}" alt="Generic placeholder image"> --}}
                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{url('storage/delivered.png')}}" alt="Delivered">

                    </div>
                </div>
            </div>
        </div>





    </div> {{-- End of Row --}}

</div>
