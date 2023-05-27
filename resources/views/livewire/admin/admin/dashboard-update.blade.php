<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="row">
        {{-- For User Data records --}}
        @if ($User)
        @foreach ($records as $item)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-sm-flex align-items-center justify-content-between"">
                        <h5 class="card-title {{$item->role=='admin' ? 'text-info text-bold' : '' }}">{{$item->name}}: {{$item->role}}</h5>
                        <h5 class="card-title {{$item->role=='admin' ? 'text-info text-bold' : '' }}">{{$item->Client_Id }}</h5>
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-3">
                            <img class="img-thumbnail rounded-circle avatar-xl" alt="100x100" src="{{!empty($item->profile_image)?asset('storage/'.$item->profile_image):url('storage/no_image.jpg')}}" data-holder-rendered="true">
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <h5 class="card-title">Email : {{$item->email }}</h5>

                                <h5 class="card-title">Mobile : {{$item->mobile_no }}</h5>
                                <h5 class="card-title">Username : {{$item->username  }}</h5>
                                @if($item->role == 'user')
                                    <a href=""  data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-sm btn-rounded btn-primary"  data-bs-original-title="Change Use role to User" aria-label="Info" wire:click.prevent="UpdateAdmin('{{$item->id}}')">Admin</a>
                                    <a href="{{route('global_search',$item->mobile_no)}}"  data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-sm btn-rounded btn-info"  data-bs-original-title="Get Insight Details" aria-label="Info" >Get Details</a>
                                    <a href="{{route('wa.great',$item->mobile_no)}}"  data-bs-placement="top" data-bs-toggle="tooltip"  class="btn btn-sm btn-rounded btn-info"  data-bs-original-title="Get Insight Details" aria-label="Info" >Whatsapp</a>
                                @elseif($item->role == 'admin' && Auth::user()->id !=  $item->id)
                                    <a href=""  data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-sm btn-rounded btn-primary"  data-bs-original-title="Change Use role to User" aria-label="Info" wire:click.prevent="UpdateUser('{{$item->id}}')">User</a>
                                @endif
                                <p class="card-text"><small class="text-muted">Registered : {{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}} ago</small></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <p class="card-text">Address : {{$item->address }}</p>

                                <p class="card-text"><small class="text-muted">Updated : {{\Carbon\Carbon::parse($item->updated_at)->diffForHumans()}} ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{$records->links()}}

        {{-- For Apply now Data records --}}
        @elseif($Orders)
        @foreach ($records as $item)
            <div class="col-lg-6">
                <div class="card">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-3">
                            <img class="img-thumbnail rounded-circle avatar-xl" alt="100x100" src="{{asset('storage/no_image.jpg')}}" data-holder-rendered="true">
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <h5 class="card-title">{{$item->Name}}</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <h5 class="card-title">{{$item->Name}}</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{$records->links()}}

        {{-- For Callback Data records --}}
        @elseif($Callback)
         @foreach ($records as $item)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-sm-flex align-items-center justify-content-between"">
                        <h5 class="card-title ">{{$item->Name}}</h5>
                        <h5 class="card-title ">{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</h5>
                        <h5 class="card-title">{{$item->Client_Id }}</h5>
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-3">
                            <img class="img-thumbnail rounded-circle avatar-xl" alt="100x100" src="{{!empty($item->Profile_Image)?asset('storage/'.$item->Profile_Image):url('storage/no_image.jpg')}}" data-holder-rendered="true">
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <h5 class="card-title">Service : {{$item->Service }}</h5>

                                <h5 class="card-title">Type : {{$item->Service_Type }}</h5>
                                <h5 class="card-title">Status : {{$item->Status  }}</h5>
                                    <a href="{{route('update.cb.status',[$item->Id,$item->Client_Id,$item->Name])}}"  data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-sm btn-rounded btn-primary"  data-bs-original-title="Change Use role to User" aria-label="Info">Status</a>

                                    <a href="{{route('global_search',$item->Mobile_No)}}"  data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-sm btn-rounded btn-info"  data-bs-original-title="Get {{$item->Name}} Details" aria-label="Info" >Details</a>

                                    <a href="{{route('wa.callback',[$item->Mobile_No,$item->Name, $item->Service,$item->Service_Type])}}"  data-bs-placement="top" data-bs-toggle="tooltip"  class="btn btn-sm btn-rounded btn-success"  data-bs-original-title="Send Whatsapp Message" aria-label="Info" >Whatsapp</a>

                                    <a href="tel:+91{{$item->Mobile_No}}"  data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-sm btn-rounded btn-warning"  data-bs-original-title="Call {{$item->Name}}" aria-label="Info" >Call</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <h5 class="card-title">Phone No : {{$item->Mobile_No }}</h5>

                                <p class="card-text">Message : {{$item->Message }}</p>

                                <p class="card-text"><small class="text-muted">Updated : {{\Carbon\Carbon::parse($item->updated_at)->diffForHumans()}} ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{$records->links()}}

        {{-- For Appliaitons Data records --}}
        @else
        @foreach ($records as $item)
            <div class="col-lg-6">
                <div class="card">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-3">
                            <img class="img-thumbnail rounded-circle avatar-xl" alt="100x100" src="{{asset('storage/no_image.jpg')}}" data-holder-rendered="true">
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <h5 class="card-title">{{$item->Name}}</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <h5 class="card-title">{{$item->Name}}</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{$records->links()}}

        @endif

    </div>
</div>
