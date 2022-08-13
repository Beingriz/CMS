<?php

namespace App\Http\Livewire;

use App\Models\Application;
use Livewire\Component;

class GlobalSearchBar extends Component
{
    public $Search_key;
    public $Search='';


    public function render()
    {
        return view('livewire.global-search-bar');
    }
}
