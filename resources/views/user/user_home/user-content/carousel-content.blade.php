
    <!-- Carousel Start -->
    <div class="container-fluid p-0 pb-5">
        <div class="owl-carousel header-carousel position-relative">
            {{-- 1 --}}
            @foreach ($carousel as $item)
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{asset('storage/'.$item->Image)}}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(53, 53, 53, .7);">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-8 text-center">
                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">Welcome To {{$CompanyName}}</h5>
                                <h1 class="display-3 text-white animated slideInDown mb-4">{{$item['Tittle']}}</h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">{{$item['Description']}}</p>
                                <a href="{{$item['Button1_Link']}}" target="_blank_" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">{{$item['Button1_Name']}}</a>
                                <a href="{{$item['Button2_Link']}}" target="_blank_" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Get Callback</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
<!-- Carousel End -->
