<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
              <div class="card text-black" style="border-radius: 25px;">
                <div class="card-body p-md-5">
                  <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7 order-2 order-lg-1">

                      <p class="text-center h1 fw-bold">Sign up</p>
                      <p class="text-center">Unlock the Digital Universe Sign Up for Exclusive Access to the Cyber Portal!</p>

                      <form class="mx-1 mx-md-4" wire:submit.prevent="Register">

                        <div class="row mb-3">
                            <label for="name" class="col-sm-5 col-form-label">Name </label>
                            <div class="col-sm-7">
                                <input class="form-control" type="text" placeholder="Your Name"  wire:model="name" id="name">
                                <span class="text-danger">@error('name'){{$message}}@enderror</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="username" class="col-sm-5 col-form-label">Username</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="text" placeholder="Username"  wire:model="username" id="username">
                                <span class="text-danger">@error('username'){{$message}}@enderror</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-5 col-form-label">Email </label>
                            <div class="col-sm-7">
                                <input class="form-control" type="email" placeholder="Enter your Email Id"  wire:model="email" id="email">
                                <span class="text-danger">@error('email'){{$message}}@enderror</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="mobile_no" class="col-sm-5 col-form-label">Phone No</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="number" placeholder="Enter your Mobile No"  wire:model="mobile_no" id="mobile_no">
                                <span class="text-danger">@error('mobile_no'){{$message}}@enderror</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-sm-5 col-form-label">Password</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="password" placeholder="Password"  wire:model="password" id="password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="confirmpassword" class="col-sm-5 col-form-label">Confirm Password</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="password" placeholder="Confirm Password"  wire:model="password_confirmation" id="confirmpassword">
                                <span class="text-danger">@error('password'){{$message}}@enderror</span>
                            </div>
                        </div>


                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-0">
                              <label class="form-check-label" for="form2Example3">
                                already have an account?
                              </label>
                            </div>
                            <a href="{{route('login')}}" class="text-body">click here to Login</a>


                          </div>
                          <a class="text-primary" href="{{route('home')}}">Home Page</a>
                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                          <button type="submit" class="btn btn-primary btn-lg">Register</button>
                        </div>


                      </form>

                    </div>
                    <div class="col-md-10 col-lg-4 col-xl-4 d-flex align-items-center order-1 order-lg-2">

                      <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                        class="img-fluid" alt="Sample image">

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
</div>
