<div>
    <form class="app-search d-none d-lg-block" wire:submit.prevent="Search">
        @csrf
        <div class="position-relative d-flex align-items-center">
            <!-- Search Input -->
            <div class="w-150">
                <input type="text" class="form-control" placeholder="Search ..." wire:model="Search" required>
                <!-- Error Message -->
                @error('Search')
                <small class="text-white mt-1 d-block">{{ $message }}</small>
                @enderror
            </div>
            <!-- Search Button -->
            <button class="btn btn-light font-size-15 ms-2" type="submit">
                <i class="mdi mdi-database-search-outline"></i>
            </button>
        </div>
    </form>
</div>
