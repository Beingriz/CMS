<div>
    {{-- Bookmark Menu Start --}}
    <div class="dropdown dropdown-mega d-none d-lg-block ms-2">
        <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
            aria-haspopup="false" aria-expanded="false">
            Bookmarks
            <i class="mdi mdi-chevron-down"></i>
        </button>
        <div class="dropdown-menu dropdown-megamenu">
            <div class="row">
                @foreach ($categories as $category => $bookmarks)
                    <div class="col-md-2"> <!-- Changed to col-md-2 for 5 columns -->
                        <h5 class="category-title text-uppercase">{{ $category }}</h5>
                        <ul class="list-unstyled megamenu-list">
                            @foreach ($bookmarks as $bookmark)
                                <li class="mb-2">
                                    <a href="{{ $bookmark->Hyperlink }}" target="_blank" class="d-flex align-items-center">
                                        <img
                                            class="rounded-circle header-profile-user me-2"
                                            src="{{ asset('storage/' . $bookmark->Thumbnail) }}"
                                            alt="{{ $bookmark->Name }}"
                                            style="width: 40px; height: 40px; object-fit: cover;"
                                        >
                                        <span>{{ $bookmark->Name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- Bookmark Menu End --}}
</div>
