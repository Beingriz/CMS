<div>
    <form class="d-flex input-group w-auto"  action="{{ URL('../search') }}/{{$Search}}" >
        <input type="search" class="form-control" name="search"  wire:model="Search" placeholder="Search" aria-label="Search" required  />
        <button class="btn btn-outline-primary" type="submit" wire data-mdb-ripple-color="dark">
            Search
        </button>

    </form></div>
