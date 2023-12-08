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
}
