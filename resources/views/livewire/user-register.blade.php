<div>
    <div class="vh-100 d-flex justify-content-center align-items-center" style="background-color: #f3f4f6;">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card shadow-lg" style="border-radius: 25px;">
                        <div class="row g-0">
                            <!-- Left Side: Authentication Image (Loaded Statically) -->
                            <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-4" style="background: linear-gradient(135deg, #4e54c8, #8f94fb); border-top-left-radius: 25px; border-bottom-left-radius: 25px;">
                                <img src="{{ asset('storage/images/register_auth.jpg') }}" class="img-fluid" alt="Authentication Image">
                            </div>


                            <!-- Right Side: Form -->
                            <div class="col-lg-7">
                                <div class="card-body p-5">
                                    <h2 class="text-center fw-bold mb-4">Sign Up</h2>
                                    <p class="text-center mb-5">Unlock the Digital Universe – Sign Up for Exclusive Access to the Cyber Portal!</p>

                                    <form wire:submit.prevent="Register">
                                        <!-- Name -->
                                        <div class="mb-3 row">
                                            <label for="name" class="col-sm-4 col-form-label">Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="name" placeholder="Enter your name" wire:model="name" class="form-control">
                                                <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                                            </div>
                                        </div>

                                        <!-- Username -->
                                        <div class="mb-3 row">
                                            <label for="username" class="col-sm-4 col-form-label">Username</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="username" placeholder="Choose a username" wire:model="username" class="form-control">
                                                <span class="text-danger">@error('username') {{ $message }} @enderror</span>
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="mb-3 row">
                                            <label for="email" class="col-sm-4 col-form-label">Email</label>
                                            <div class="col-sm-8">
                                                <input type="email" id="email" placeholder="Enter your email" wire:model="email" class="form-control">
                                                <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                                            </div>
                                        </div>

                                        <!-- Phone Number -->
                                        <div class="mb-3 row">
                                            <label for="mobile_no" class="col-sm-4 col-form-label">Phone No</label>
                                            <div class="col-sm-8">
                                                <input type="number" id="mobile_no" placeholder="Enter your phone number" wire:model="mobile_no" class="form-control">
                                                <span class="text-danger">@error('mobile_no') {{ $message }} @enderror</span>
                                            </div>
                                        </div>

                                        <!-- Branch Selection -->
                                        <div class="mb-3 row">
                                            <label for="Branch" class="col-sm-4 col-form-label">Nearest Branch</label>
                                            <div class="col-sm-8">
                                                <select id="Branch" wire:model="Branch" class="form-control">
                                                    <option value="">--- Select Branch ---</option>
                                                    @foreach ($Branches as $branch)
                                                        <option value="{{ $branch->branch_id }}">{{ $branch->name }}, {{ $branch->address }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">@error('Branch') {{ $message }} @enderror</span>
                                            </div>
                                        </div>

                                        <!-- Password -->
                                        <div class="mb-3 row">
                                            <label for="password" class="col-sm-4 col-form-label">Password</label>
                                            <div class="col-sm-8">
                                                <input type="password" id="password" placeholder="Create a password" wire:model="password" class="form-control">
                                            </div>
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="mb-3 row">
                                            <label for="confirmpassword" class="col-sm-4 col-form-label">Confirm Password</label>
                                            <div class="col-sm-8">
                                                <input type="password" id="confirmpassword" placeholder="Confirm password" wire:model="password_confirmation" class="form-control">
                                                <span class="text-danger">@error('password') {{ $message }} @enderror</span>
                                            </div>
                                        </div>

                                        <!-- Already Have an Account -->
                                        <div class="d-flex justify-content-between mb-4">
                                            <label>Already have an account?</label>
                                            <a href="{{ route('login') }}" class="text-primary">Click here to Login</a>
                                        </div>

                                        <!-- Home Page Link -->
                                        <div class="text-center mb-4">
                                            <a href="{{ route('home') }}" class="text-secondary">Go to Home Page</a>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-lg px-5">Register</button>
                                        </div>
                                    </form>

                                </div> <!-- End of Card Body -->
                            </div> <!-- End of Right Side -->
                        </div> <!-- End of Row -->
                    </div> <!-- End of Card -->
                </div> <!-- End of Col -->
            </div> <!-- End of Row -->
        </div> <!-- End of Container -->
    </div>

</div>
