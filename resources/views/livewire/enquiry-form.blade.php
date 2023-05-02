<div>




    {{-- Enquiry Form Content Start --}}
        <div class="container-fluid bg-light overflow-hidden my-5 px-lg-0">
            <div class="container quote px-lg-0">
                <div class="row g-0 mx-lg-0">
                    <div class="col-lg-6 ps-lg-0" style="min-height: 400px;">
                        <div class="position-relative h-100">
                            <img class="position-absolute img-fluid w-100 h-100" src="{{asset('frontend/assets/img/quote.jpg')}}" style="object-fit: cover;" alt="">
                        </div>
                    </div>

                    <div class="col-lg-6 quote-text py-5 wow fadeIn" data-wow-delay="0.5s">
                        <div class="p-lg-5 pe-lg-0">
                            <div class="section-title text-start">
                                <h1 class="display-5 mb-4">Free Consultation</h1>
                            </div>
                            <p class="mb-4 pb-2">Customer Focus: We at Digital Cyber puts the customer first, providing personalized attention and care to ensure that all customer needs are met.</p>
                            <form wire:submit.prevent="Save">
                                {{-- @csrf --}}
                                <div class="row g-3">
                                    <div class="col-12 col-sm-6">
                                        <input type="text" class="form-control border-0" id="Name" placeholder="Your Name" wire:model.lazy="Name" name="Name" style="height: 55px;">
                                        @error('Name') <span class="text-danger">{{ $message }}</span> @enderror                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <input type="email" class="form-control border-0" placeholder="Your Email" wire:model="Email" name="Email" style="height: 55px;">
                                        @error('Email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <input type="number" class="form-control border-0" placeholder="Your Mobile" wire:model="Phone_No" name="Phone_No" style="height: 55px;">
                                        @error('Phone_No') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <select class="form-select border-0" style="height: 55px;" wire:model.lazy="Service" name="Service">
                                            <option selected="">Select A Service</option>
                                            @foreach ($services as $item )
                                            <option value="{{$item['Name']}}">{{$item['Name']}}</option>
                                            @endforeach
                                        </select>
                                        @error('Service') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control border-0" placeholder="{{$Msg_template}}" wire:model="Message" cols="10" rows="10"></textarea>
                                        @error('Message') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        {{-- <button type="submit" value="submit" name="submit" --}}
                                        {{-- class="btn btn-primary btn-rounded btn-sm">Add Service</button> --}}
                                        <button class="btn btn-primary w-100 py-3" type="submit" name="submit" value="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    {{-- Content End --}}
</div>
