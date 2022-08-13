<div>
    <form class="app-search d-none d-lg-block" action="{{route('global_search',$Search)}}">
        <div class="position-relative d-flex">
            <input type="text" class="form-control" placeholder="Search..." wire:model="Search" required >
            <span class="ri-search-line"></span>
            {{-- <a href="{{route('global_search',$Search)}}" class="btn btn-light btn-sm waves-effect waves-light" >Search</a> --}}
            <button class="btn btn-light font-size-15" type="submit"><i class="mdi mdi-database-search-outline" ></i></button>
        </div>
    </form>
</div>
