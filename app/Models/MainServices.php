<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainServices extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    public $table = 'services';


    // defining relation :  1 to Many relation :  1 Main Services has many Applicaitons.
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    // defining relation :  1 to Many relation : 1 Main Services has many Subservices
    public function subServices()
    {
        return $this->hasMany(SubServices::class);
    }
    // defining relation :  1 to Many relation : 1 Main Services has many Subservices
    public function documents()
    {
        return $this->hasMany(DocumentList::class);
    }


}
