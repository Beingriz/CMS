<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">About Us</h4>

                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('SuccessMsg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('SuccessUpdate'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('SuccessUpdate') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('Error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('Error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Digital Cyber</a></li>
                        <li class="breadcrumb-item active">About Us</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ url('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.about_us') }}">New About-Us</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}


    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">About Us</h4>
                    <p class="card-title-desc">Short Description about Company</p>
                    <div class="row mb-2">
                        <div class="col-sm-10">
                            <label for="example-text-input" class="col-sm-6 col-form-label">{{ $Id }}</label>
                        </div>
                    </div>
                    <!-- end row -->
                    <form wire:submit.prevent="Save">

                        <div class="row mb-3">
                            <label for="Tittle" class="col-sm-3 col-form-label">Tittle </label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" placeholder="Tittle Name" wire:model="Tittle"
                                    id="Tittle">
                                <span class="error">
                                    @error('Tittle')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="Description" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="10" placeholder="Description" wire:model="Description" id="Description"></textarea>
                                <span class="error">
                                    @error('Description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->

                        {{-- Profile Image --}}
                        <div class="row mb-3">
                            <label for="Image" class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" id="Image{$Iteration}"
                                    accept="image/jpeg, image/png" wire:model="Image" id="Image">
                                <span class="error">
                                    @error('Image')
                                        {{ $message }}
                                    @enderror
                                </span>

                            </div>
                        </div>
                        {{-- Preview Profile Image --}}
                        @if (!is_Null($Image))
                            <div class="row mb-3">
                                <label for="Image" class="col-sm-3 col-form-label"></label>
                                <div class="col-lg-8">
                                    <div wire:loading wire:target="Image">Uploading...</div>
                                    <img class=" rounded avatar-lg" id="Image{$Iteration}"
                                        src="{{ $Image->temporaryUrl() }}" alt="Image" />
                                </div>
                            </div>
                        @elseif(!is_Null($Old_Image))
                            <div class="row mb-3">
                                <label for="Image" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <img class=" rounded avatar-lg" src="{{ asset('storage/' . $Old_Image) }}"
                                        alt="" />
                                </div>
                            </div>
                        @endif

                        <div class="form-data-buttons"> {{-- Buttons --}}
                            <div class="row">
                                <div class="col-100">
                                    @if ($Update == 0)
                                        <button type="submit" value="submit" name="submit"
                                            class="btn btn-primary btn-rounded btn-sm">Save</button>
                                        <a href="#" wire:click.prevent="ResetFields()"
                                            class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    @elseif($Update == 1)
                                        <a href="#" wire:click.prevent="Update()"
                                            class="btn btn-success btn-rounded btn-sm">Update</button>
                                            <a href="#" wire:click.prevent="ResetFields()"
                                                class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    @endif
                                    <a href="" class="btn btn-rounded btn-sm">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">About Us</h5>
                </div>
                <div class="row">
                    <div class="card-body">
                        <div class="table-responsive">
                            <p>User Display Slidebar Images for Advertising puropose</p>
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sl_No</th>
                                        <th>Tittle</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Records as $key)
                                        <tr @if ($key->Selected == 'Yes') class="table-success" @endif>
                                            <td>{{ $Sl++ }}</td>
                                            <td>{{ $key['Tittle'] }}</td>
                                            <td>{{ $key['Description'] }}</td>
                                            <td>
                                                <img class="avatar-sm" src="{{ url('storage/' . $key->Image) }}"
                                                    alt="Banner">
                                            </td>
                                            </td>

                                            <td>
                                                <div class="btn-group-vertical" role="group"
                                                    aria-label="Vertical button group">
                                                    <div class="btn-group" role="group">
                                                        <button id="btnGroupVerticalDrop1" type="button"
                                                            class="btn btn-light dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Action <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="btnGroupVerticalDrop1" style="">
                                                            <a class="dropdown-item"
                                                                href="{{ route('edit.aboutus', $key->Id) }}"
                                                                title="Edit Application" id="editData">Edit</a>

                                                            <a class="dropdown-item"
                                                                href="{{ route('select.aboutus', $key->Id) }}"
                                                                id="SelectData" title="Select Record">Select</a>

                                                            <a class="dropdown-item"
                                                                href="{{ route('delete.aboutus', $key->Id) }}"
                                                                title="Delete Application" id="delete">Delete</a>
                                                        </div>
                                                    </div>

                                                </div>

                                            </td>











                                            {{-- <a  class="btn btn-primary btn-rounded btn-sm" href="#" onclick="confirm('Do you want to Edit {{$key->Company_Name}} ?') || event.stopImmediatePropagation()" wire:click.prevent="Edit('{{$key->Id}}')">Edit</a></td> --}}
                                        </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
