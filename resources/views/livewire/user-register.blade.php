
        <div class="vh-100 d-flex justify-content-center align-items-center" style="background-color: #f3f4f6;">
            <div class="container">
                <div style="height: 80vh;"class="row d-flex justify-content-center">
                    <div class="col-lg-10 col-xl-9">
                    <div class="card shadow-lg" style="border-radius: 25px;">
                        <div class="row g-0">
                            <!-- Left: Image -->
                            <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-4"
                                style="background: linear-gradient(135deg, #4e54c8, #8f94fb); border-radius: 25px 0 0 25px;">
                                <img src="{{ asset('storage/images/register_auth.jpg') }}" class="img-fluid" alt="Auth Image">
                            </div>

                            <!-- Right Side: Form -->
                            <div class="col-lg-7">
                                <div class="card-body p-5">
                                    <h2 class="text-center fw-bold mb-4">Sign Up</h2>
                                    <p class="text-center mb-4">Unlock the Digital Universe – Sign Up for Exclusive Access to the Cyber Portal!</p>

                                    <form wire:submit.prevent="Register">

                                        <!-- Name -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" id="name" placeholder="Enter your name" wire:model="name" class="form-control">
                                            <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <div class="input-group">
                                                <input type="text" id="username" class="form-control" placeholder="Choose a username"
                                                    wire:model.lazy="username" onkeypress="return event.key !== ' '"
                                                    oninput="this.value = this.value.replace(/\s+/g, '')">
                                                <span class="input-group-text" data-bs-toggle="modal" data-bs-target="#usernameRulesModal">
                                                    <i class="fas fa-info-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <span class="text-danger">@error('username') {{ $message }} @enderror</span>
                                            @if ($usernameAvailable !== null)
                                                <span class="text-{{ $usernameAvailable ? 'success' : 'danger' }}">
                                                    {{ $usernameAvailable ? '✅ Username available' : '❌ Username already taken' }}
                                                </span>
                                            @endif
                                        </div>
                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" id="email" placeholder="Enter your email" wire:model.lazy="email" class="form-control">
                                            <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                                        </div>

                                        <!-- Phone Number -->
                                        <div class="mb-3">
                                            <label for="mobile_no" class="form-label">Phone No</label>
                                            <input type="number" id="mobile_no" placeholder="Enter your phone number" wire:model.lazy="mobile_no" class="form-control">
                                            <span class="text-danger">@error('mobile_no') {{ $message }} @enderror</span>
                                        </div>

                                        <!-- Branch Selection -->
                                        <div class="mb-3">
                                            <label for="Branch" class="form-label">Nearest Branch</label>
                                            <select id="Branch" wire:model="Branch" class="form-control">
                                                <option value="">--- Select Branch ---</option>
                                                @foreach ($Branches as $branch)
                                                    <option value="{{ $branch->branch_id }}">{{ $branch->name }}, {{ $branch->address }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">@error('Branch') {{ $message }} @enderror</span>
                                        </div>

                                        <!-- Password -->
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" id="password" class="form-control" placeholder="Create a password" wire:model.lazy="password">
                                                <span class="input-group-text" data-bs-toggle="modal" data-bs-target="#passwordRulesModal">
                                                    <i class="fas fa-info-circle text-primary"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="mb-3">
                                            <label for="confirmpassword" class="form-label">Confirm Password</label>
                                            <input type="password" id="confirmpassword" class="form-control" placeholder="Confirm password" wire:model.lazy="password_confirmation">
                                            <span class="text-danger">@error('password') {{ $message }} @enderror</span>
                                        </div>

                                    <!-- Links Section -->
                            <div class="mb-4 text-center">
                                <p class="mb-2 fs-6 text-muted">
                                    Already have an account?
                                    <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none hover-underline">Login</a>
                                </p>
                                <p>
                                    <a href="{{ route('home') }}" class="text-secondary fw-medium text-decoration-none" style="transition: color 0.3s;">
                                        ← Back to Home
                                    </a>
                                </p>
                            </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold shadow-sm"
                                style="transition: transform 0.2s, background-color 0.3s;">
                                🚀 Create Account
                            </button>
                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>


<!-- Username Rules Modal -->
<div class="modal fade" id="usernameRulesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Username Rules</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>✔ 4-15 characters long</li>
                    <li>✔ Only letters, numbers, and underscores (_) allowed</li>
                    <li>❌ No spaces or special characters</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Password Rules Modal -->
<div class="modal fade" id="passwordRulesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Password Rules</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>✔ At least 8 characters long</li>
                    <li>✔ Must contain uppercase, lowercase, number, and special character</li>
                    <li>❌ Cannot be common or easy to guess</li>
                </ul>
            </div>
        </div>
    </div>
</div>
