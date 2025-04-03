<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Credit Source Management</h4>

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
                        <li class="breadcrumb-item active"><a href="{{ route('new.application') }}">New Form</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('Dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('add_services') }}">Services</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Credit') }}">Credit</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}
    <div class="row">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded">
                <div class="card-header d-flex align-items-center justify-content-between bg-gradient-dark text-white p-3">
                    <h5 class="mb-0 fw-bold">📜 Credit Ledger</h5>
                    <a href="{{ route('CreditSource') }}" class="btn btn-sm btn-light fw-bold shadow-sm px-3" title="Add New Credit Source">
                        ➕ New Entry
                    </a>
                </div>

                <div class="card-body p-4">
                    <form wire:submit.prevent="Save">
                        @csrf
                        @if (!empty($Type))
                            <h6 class="text-uppercase text-primary fw-bold mb-3">{{ $Type }}</h6>
                        @endif

                        <!-- 🔹 Credit ID -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">🔢 Credit ID</label>
                            <p class="text-muted">{{ $CS_Id }}</p>
                        </div>

                        <!-- 🔹 Category Selection -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">📂 Select Category</label>
                            <select name="Type" id="type" wire:model="Type" wire:change="Change($event.target.value)" class="form-control">
                                <option value="" selected>Select Category</option>
                                <option value="Main Category">Main Category</option>
                                <option value="Sub Category">Sub Category</option>
                            </select>
                            <span class="text-danger fw-bold">
                                @error('Type') {{ $message }} @enderror
                            </span>
                        </div>

                        <!-- 🔹 Main Category Fields -->
                        @if ($Type == 'Main Category')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">🏷️ Category Name</label>
                                <input type="text" wire:model="Name" name="CategoryName" class="form-control" placeholder="Enter Category Name">
                                <span class="text-danger fw-bold">@error('Name') {{ $message }} @enderror</span>
                            </div>

                            <!-- 🔹 Thumbnail Upload -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">🖼️ Thumbnail</label>
                                <input type="file" id="Thumbnail{{ $iteration }}" wire:model="Image" accept=".jpg,.png" class="form-control">
                                <span class="text-danger fw-bold">@error('Image') {{ $message }} @enderror</span>
                            </div>

                            <div wire:loading wire:target="Image" class="text-muted">Uploading...</div>

                            <!-- 🔹 Image Preview -->
                            <div class="mb-3">
                                @if (!is_Null($Image))
                                    <img class="img-fluid rounded shadow" src="{{ $Image->temporaryUrl() }}">
                                @elseif(!is_null($OldImage))
                                    <img class="img-fluid rounded shadow" src="{{ !empty($OldImage) ? url('storage/' . $OldImage) : url('storage/no_image.jpg') }}">
                                @endif
                            </div>
                        @endif

                        <!-- 🔹 Sub Category Fields -->
                        @if ($Type == 'Sub Category')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">📋 Select Main Category</label>
                                <select name="CategoryList" id="CategoryList" wire:model="CategoryList" wire:change="ResetList($event.target.value)" class="form-control">
                                    <option value="" selected>Select Main Category</option>
                                    @foreach ($Categorys as $Category)
                                        <option value="{{ $Category->Name }}">{{ $Category->Name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger fw-bold">@error('CategoryList') {{ $message }} @enderror</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">🏷️ Sub Category Name</label>
                                <input type="text" id="Source_Name" wire:model.lazy="SubCategoryName" name="Source_Name" class="form-control" placeholder="Enter Sub Category Name">
                                <span class="text-danger fw-bold">@error('SubCategoryName') {{ $message }} @enderror</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">💰 Unit Price</label>
                                <input type="number" id="Unit_Price" wire:model="Unit_Price" name="Unit_Price" class="form-control" placeholder="Enter Price">
                                <span class="text-danger fw-bold">@error('Unit_Price') {{ $message }} @enderror</span>
                            </div>
                        @endif

                        <!-- 🔹 Action Buttons -->
                        <div class="d-flex justify-content-center gap-2">
                            @if ($Update == 0)
                                <button type="submit" class="btn btn-primary btn-sm shadow-sm">💾 Save</button>

                                <a href="#"
                                   wire:click.prevent="{{ $Type == 'Main Category' ? 'ResetMainFields' : 'ResetSubFields' }}()"
                                   class="btn btn-info btn-sm shadow-sm">
                                   🔄 Reset
                                </a>

                                <a href="{{ route('admin.home') }}" class="btn btn-warning btn-sm shadow-sm">❌ Cancel</a>

                            @elseif ($Update == 1)
                                <a href="#" wire:click.prevent="UpdateMain('{{ $CS_Id }}')" class="btn btn-success btn-sm shadow-sm">✅ Update</a>
                                <a href="{{ route('CreditSource') }}" class="btn btn-info btn-sm shadow-sm">🔄 Reset</a>
                                <a href="{{ route('admin.home') }}" class="btn btn-warning btn-sm shadow-sm">❌ Cancel</a>

                            @elseif ($Update == 2)
                                <a href="#" wire:click.prevent="UpdateSub('{{ $CS_Id }}')" class="btn btn-success btn-sm shadow-sm">✅ Update</a>
                                <a href="{{ route('CreditSource') }}" class="btn btn-info btn-sm shadow-sm">🔄 Reset</a>
                                <a href="{{ route('admin.home') }}" class="btn btn-warning btn-sm shadow-sm">❌ Cancel</a>
                            @endif
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between"">
                    <h5>Existing Category</h5>
                    <h5><a href="{{ route('CreditSource') }}" title="Click here for New Credit Source">New Entry</a>
                    </h5>
                </div>
                <div class="card-body">
                    @if (!empty($Type))
                        <p class="heading2">{{ $Type }}</p>
                    @endif
                    @if ($Type == 'Main Category')
                        <span class="info-text">{{ $exist_main_categories->total() }} Main Categories List </span>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Name</th>
                                        <th>Thumbnail</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($exist_main_categories as $key)
                                        <tr>
                                            <td>{{ $exist_main_categories->firstItem() + $loop->index }}</td>
                                            <td>{{ $key->Name }}</td>
                                            <td>
                                                <img class="avatar-sm" src="{{ url('storage/' . $key->Thumbnail) }}"
                                                    alt="Icon">
                                            </td>
                                            </td>
                                            <td>
                                                <a id="editRecord" funName="editMain" recId="{{ $key->Id }}" title="Edit Main Category"
                                                    class="btn btn-sm btn-primary font-size-15" ><i
                                                        class="mdi mdi-circle-edit-outline"></i></a>
                                                <a id="deleteRecord" funName="deleteMain" recId="{{ $key->Id }}" title="Delete Main Category"
                                                    class="btn btn-sm btn-danger font-size-15" ><i
                                                        class=" mdi mdi-trash-can"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <span>{{ $exist_main_categories->links() }}</span>
                        </div>
                    @endif

                    @if ($Type == 'Sub Category' && Count($exist_categories) > 0)
                        <span class="info-text">{{ count($exist_categories) }} Sub Categories Found for </span>
                        <p class="heading2">{{ $CategoryList }}</p>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Category Name</th>
                                        <th>Price</th>
                                        <th>Revenue</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($exist_categories as $key)
                                        <tr>
                                            <td>{{ $exist_categories->firstItem() + $loop->index }}</td>
                                            <td>{{ $key->Source }}</td>
                                            <td>{{ $key->Unit_Price }}</td>
                                            <td>{{ $key->Total_Revenue }}</td>
                                            <td>
                                                <a id="editRecord" funName="editSub" recId="{{ $key->Id }}" title="Edit Sub Category"
                                                    class="btn btn-sm btn-primary font-size-15" ><i
                                                        class="mdi mdi-circle-edit-outline"></i></a>
                                                <a id="deleteRecord" funName="deleteSub" recId="{{ $key->Id }}" title="Delete Sub Category"
                                                    class="btn btn-sm btn-danger font-size-15" ><i
                                                        class=" mdi mdi-trash-can"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <span>{{ $exist_categories->links() }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
