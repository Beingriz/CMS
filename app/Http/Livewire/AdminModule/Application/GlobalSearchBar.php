<?php

namespace App\Http\Livewire\AdminModule\Application;

use App\Models\Application;
use Livewire\Component;

class GlobalSearchBar extends Component
{
    public $Search_key;
    public $Search = '';
    protected $rules = [
        'Search' => 'required | min:5',
    ];
    protected $message = [
        'Search' => 'Please Enter to Search'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function Search()
    {
        $this->validate();
        return redirect()->route('global_search', $this->Search);
    }

    public function render()
    {
        return view('livewire.admin-module.application.global-search-bar');
    }
}
