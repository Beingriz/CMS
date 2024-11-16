<?php

namespace App\Http\Livewire\AdminModule\Operations;

use App\Models\Bookmark;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HeaderBookmarks extends Component
{
    public $categories = [];

    public function mount()
    {
        // Fetch bookmarks grouped by category with limits
        $this->categories = DB::table('bookmark')
            ->select('Relation as category', 'Name', 'Hyperlink', 'Thumbnail')
            ->orderBy('Relation')
            ->get()
            ->groupBy('category')
            ->take(10) // Limit to 5 categories
            ->map(function ($bookmarks) {
                return $bookmarks->take(5); // Limit to 5 bookmarks per category
            });
    }
    public function render()
    {
        return view('livewire.admin-module.operations.header-bookmarks',[
            'categories' => $this->categories
        ]);
    }
}
