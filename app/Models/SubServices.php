<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubServices extends Model
{
    use HasFactory;
    protected $guarded;
    protected $connection = 'mysql';

    public $table = 'sub_service_list';

    // defining relation :  Many to 1 relation :  many sub services belong to only one main service
    public function mainServices()
    {
        return $this->belongsTo(MainServices::class);
    }
     // defining relation :  1 to Many relation : 1 Main Services has many Subservices
     public function documents()
     {
         return $this->hasMany(DocumentList::class);
     }

}
