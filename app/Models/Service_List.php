<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_List extends Model
{
    use HasFactory;
    protected $guarded;
    public $table="service_list";
}
