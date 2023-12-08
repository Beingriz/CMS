<div>

    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Change Password</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $profiledata->username }}</a></li>
                <li class="breadcrumb-item active">Change Password</li>
            </ol>
        </div>
    </div>

    <div class="col-md-12 col-xl-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div>
                                @csrf
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Username : {{ $profiledata->username }}</strong>
                                    </li>
                                </ul>
                                @if (session('SuccessMsg'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="mdi mdi-check-all me-2"></i>
                                        {{ session('SuccessMsg') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button><br>

                                        <a href="{{ route('admin.logout') }}" class="text-muted">Do you want to
                                            Re-Login?</a>
                                    </div>
                                @endif

                                @if (session('Error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="mdi mdi-block-helper me-2"></i>
                                        {{ session('Error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                {{-- Old Password --}}
                                <div class="row mb-3">
                                    <label for="old_password" class="col-sm-3 col-form-label">Name </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="password"
                                            wire:model.lazy="old_password"placeholder="Old Password" id="old_passowrd">
                                        <span class="error">
                                            @error('old_password')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                {{-- New Password --}}
                                <div class="row mb-3">
                                    <label for="new_password" class="col-sm-3 col-form-label">Name </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="password"
                                            wire:model="new_password"placeholder="New Password" id="new_passowrd">
                                        <span class="error">
                                            @error('new_password')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                {{-- Confirim Password --}}
                                <div class="row mb-3">
                                    <label for="confirm_password" class="col-sm-3 col-form-label">Name </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="password"
                                            wire:model="confirm_password"placeholder="Confirm Password"
                                            id="confirm_passowrd">
                                        <span class="error">
                                            @error('confirm_password')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <a href="#" wire:click="ChangePassword()"
                                    class="btn btn-info btn-rounded waves-effect waves-light">Change Password</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end col -->

</div><!-- end livewire  -->
